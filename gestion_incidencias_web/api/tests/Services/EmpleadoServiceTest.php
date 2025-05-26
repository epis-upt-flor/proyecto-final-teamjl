<?php
    declare(strict_types=1);

    namespace Tests\Services;

    use PHPUnit\Framework\TestCase;
    use App\Core\Auth;
    use App\Services\EmpleadoService;

    final class EmpleadoServiceTest extends TestCase
    {
        public static function setUpBeforeClass(): void
        {
            Auth::init();
        }

        public function testLoginRawWithInvalidCredentials(): void
        {
            $result = EmpleadoService::loginRaw('no_existo@correo.com', 'clave_incorrecta');
            $this->assertNull($result, 'loginRaw debería devolver null para credenciales inválidas');
        }

        public function testLoginRawWithValidCredentials(): void
        {
            // Creamos un empleado de prueba
            $uniqueEmail = 'login.emp+' . uniqid() . '@ejemplo.com';
            $password    = 'LoginTest!45';
            $createdId   = EmpleadoService::registerRaw(
                'LoginName',
                'LoginLast',
                '87654321',
                $uniqueEmail,
                $password
            );
            $this->assertIsInt($createdId);

            // Ahora debe poder hacer login con esas credenciales
            $resp = EmpleadoService::loginRaw($uniqueEmail, $password);
            $this->assertIsArray($resp, 'loginRaw debería devolver un array para credenciales válidas');
            $this->assertArrayHasKey('id', $resp);
            $this->assertArrayHasKey('token', $resp);
            $this->assertArrayHasKey('role', $resp);
            $this->assertSame('empleado', $resp['role']);
        }

        public function testRegisterRawReturnsNewId(): void
        {
            $uniqueEmail = 'test.emp+' . uniqid() . '@ejemplo.com';
            $password    = 'PassTest!23';

            $newId = EmpleadoService::registerRaw(
                'TestNombre',
                'TestApellido',
                '12345678',
                $uniqueEmail,
                $password
            );

            $this->assertIsInt($newId, 'registerRaw debe devolver un entero como nuevo ID');
            $this->assertGreaterThan(0, $newId, 'El ID devuelto debe ser mayor que 0');
        }
    }
?>
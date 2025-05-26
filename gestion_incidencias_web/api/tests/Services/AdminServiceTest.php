<?php
    use PHPUnit\Framework\TestCase;
    use App\Services\AdminService;
    use App\Repositories\AdminRepository;
    use App\Core\Database;

    final class AdminServiceTest extends TestCase
    {
        public function testLoginConCredencialesInvalidasDevuelveNull(): void
        {
            $result = AdminService::login('noexiste@x.com','badpass');
            $this->assertNull($result);
        }

        public function testRegisterRawDevuelveEnteroId(): void
        {
            // Genera un email único para evitar colisiones de la restricción UNIQUE
            $email  = 'admin.test+' . uniqid() . '@example.com';
            $id = AdminService::registerRaw('Test','User',$email,'pwd1234');
            $this->assertIsInt($id, 'registerRaw debe devolver un entero');
            $this->assertGreaterThan(0, $id, 'El ID devuelto debe ser mayor que 0');
        }
    }
?>
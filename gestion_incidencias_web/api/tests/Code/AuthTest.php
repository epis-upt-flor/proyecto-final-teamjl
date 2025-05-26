<?php
    use PHPUnit\Framework\TestCase;
    use App\Core\Auth;

    final class AuthTest extends TestCase
    {
        public static function setUpBeforeClass(): void
        {
            Auth::init();
        }

        public function testGenerarYVerificarToken(): void
        {
            $data = ['id'=>42,'role'=>'administrador','email'=>'a@b.com'];
            $jwt  = Auth::generarToken($data, 60);

            $decoded = Auth::verificarToken($jwt);
            $this->assertSame(42, $decoded['id']);
            $this->assertSame('administrador', $decoded['role']);
        }

        public function testTokenExpiradoLanzaExcepcion(): void
        {
            $this->expectException(\Exception::class);
            $jwt = Auth::generarToken(['id'=>1], -10);
            Auth::verificarToken($jwt);
        }
    }
?>
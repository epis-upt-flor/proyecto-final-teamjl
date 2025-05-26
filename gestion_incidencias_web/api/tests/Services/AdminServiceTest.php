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
            $id = AdminService::registerRaw('Test','User','test.user@example.com','pwd1234');
            $this->assertIsInt($id);
            $this->assertGreaterThan(0, $id);
        }
    }
?>
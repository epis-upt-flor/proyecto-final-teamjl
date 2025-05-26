<?php
    use PHPUnit\Framework\TestCase;
    use App\Services\ReporteService;

    final class ReporteServiceTest extends TestCase
    {
        public function testObtenerResumenTieneClavesEsperadas(): void
        {
            $res = ReporteService::obtenerResumen();
            $this->assertArrayHasKey('por_estado', $res);
            $this->assertArrayHasKey('por_tipo', $res);
            $this->assertIsArray($res['por_estado']);
            $this->assertIsArray($res['por_tipo']);
        }
    }
?>
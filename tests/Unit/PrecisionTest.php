<?php declare(strict_types=1);

namespace UsmanZahid\MoneyUtils\Tests\Unit;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../vendor/autoload.php';

class PrecisionTest extends TestCase {
    public function testPrecisionCanBeSetAt2(): void {
        uz_set_precision(2);

        global $UZ_ROUNDING_PRECISION;

        $this->assertSame(2, $UZ_ROUNDING_PRECISION);
    }

    public function testPrecisionCanBeSetAt3(): void {
        uz_set_precision(3);

        global $UZ_ROUNDING_PRECISION;

        $this->assertSame(3, $UZ_ROUNDING_PRECISION);
    }

    public function testPrecisionCanBeSetAt4(): void {
        uz_set_precision(4);

        global $UZ_ROUNDING_PRECISION;

        $this->assertSame(4, $UZ_ROUNDING_PRECISION);
    }

    public function testPrecisionCanBeSetAt5(): void {
        uz_set_precision(5);

        global $UZ_ROUNDING_PRECISION;

        $this->assertSame(5, $UZ_ROUNDING_PRECISION);
    }

    public function testPrecisionCanBeSetAt6(): void {
        uz_set_precision(6);

        global $UZ_ROUNDING_PRECISION;

        $this->assertSame(6, $UZ_ROUNDING_PRECISION);
    }
}

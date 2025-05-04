<?php declare(strict_types=1);

namespace UsmanZahid\MoneyUtils\Tests\Unit;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../vendor/autoload.php';

class PercentTest extends TestCase {
    protected function setUp(): void {
        uz_set_precision(2);
    }

    public function testPercentOf(): void {
        $result = uz_percent_of('200', '10');
        $this->assertSame("20.00", $result);

        $result = uz_percent_of('1000', '5');
        $this->assertSame("50.00", $result);

        $result = uz_percent_of('150', '0');
        $this->assertSame("0.00", $result);

        $result = uz_percent_of('200.55', '5');
        $this->assertSame("10.03", $result);
    }

    public function testPercentRatio(): void {
        $result = uz_percent_ratio('20', '200');
        $this->assertSame("10.00", $result);

        $result = uz_percent_ratio('50', '1000');
        $this->assertSame("5.00", $result);

        $result = uz_percent_ratio('10', '50');
        $this->assertSame("20.00", $result);

        // Test division by zero (expected exception)
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot divide by zero in percent ratio.');
        uz_percent_ratio('10', '0');
    }

    public function testPercentIncrease(): void {
        $result = uz_percent_increase('200', '10');
        $this->assertSame("220.00", $result);

        $result = uz_percent_increase('1000', '5');
        $this->assertSame("1050.00", $result);

        $result = uz_percent_increase('150', '0');
        $this->assertSame("150.00", $result);

        $result = uz_percent_increase('200.55', '5');
        $this->assertSame("210.58", $result);
    }

    public function testPercentDecrease(): void {
        $result = uz_percent_decrease('200', '10');
        $this->assertSame("180.00", $result);

        $result = uz_percent_decrease('1000', '5');
        $this->assertSame("950.00", $result);

        $result = uz_percent_decrease('150', '0');
        $this->assertSame("150.00", $result);

        $result = uz_percent_decrease('200.55', '5');
        $this->assertSame("190.52", $result);
    }
}

<?php declare(strict_types=1);

namespace UsmanZahid\MoneyUtils\Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../vendor/autoload.php';

class MathTest extends TestCase {
    protected function setUp(): void {
        uz_set_precision(2);
    }

    public function testAddCaseOne() {
        $a = "1.00";
        $b = "1.00";
        $result = uz_add($a, $b);
        $this->assertSame("2.00", $result);
    }

    public function testAddCaseNegative() {
        $a = "-1.00";
        $b = "1.00";
        $result = uz_add($a, $b);
        $this->assertSame("0.00", $result);
    }

    public function testAddCaseWithZero() {
        $a = "0.00";
        $b = "5.25";
        $result = uz_add($a, $b);
        $this->assertSame("5.25", $result);
    }

    public function testSubCaseOne() {
        $a = "2.02";
        $b = "0.02";
        $result = uz_sub($a, $b);
        $this->assertSame("2.00", $result);
    }

    public function testSubCaseNegativeResult() {
        $a = "1.00";
        $b = "2.50";
        $result = uz_sub($a, $b);
        $this->assertSame("-1.50", $result);
    }

    public function testMulCaseOne() {
        $a = "2.50";
        $b = "4.00";
        $result = uz_mul($a, $b);
        $this->assertSame("10.00", $result);
    }

    public function testMulCaseWithZero() {
        $a = "0.00";
        $b = "100.00";
        $result = uz_mul($a, $b);
        $this->assertSame("0.00", $result);
    }

    public function testMulCaseWithNegative() {
        $a = "-2.50";
        $b = "4.00";
        $result = uz_mul($a, $b);
        $this->assertSame("-10.00", $result);
    }

    public function testDivCaseOne() {
        $a = "10.00";
        $b = "4.00";
        $result = uz_div($a, $b);
        $this->assertSame("2.50", $result);
    }

    public function testDivCaseZeroDivisor() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Division by zero.');
        uz_div("10.00", "0.00");
    }

    public function testDivCaseNegative() {
        $a = "10.00";
        $b = "-4.00";
        $result = uz_div($a, $b);
        $this->assertSame("-2.50", $result);
    }

    public function testRoundCaseOne() {
        $a = "2.005";
        $result = uz_round($a);
        $this->assertSame("2.01", $result);
    }

    public function testRoundCaseZero() {
        $a = "0.000";
        $result = uz_round($a);
        $this->assertSame("0.00", $result);
    }

    public function testRoundCaseNegative() {
        $a = "-2.005";
        $result = uz_round($a);
        $this->assertSame("-2.01", $result);
    }

    public function testMaxCase() {
        $result = uz_max("1.00", "2.00", "3.00", "0.50");
        $this->assertSame("3.00", $result);
    }

    public function testMinCase() {
        $result = uz_min("1.00", "2.00", "3.00", "0.50");
        $this->assertSame("0.50", $result);
    }

    public function testAverageCase() {
        $result = uz_average("1.00", "2.00", "3.00");
        $this->assertSame("2.00", $result);
    }

    public function testAverageSingleValue() {
        $result = uz_average("10.00");
        $this->assertSame("10.00", $result);
    }

    public function testAverageNoValues() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('At least one amount is required to calculate average.');
        uz_average();
    }

    public function testSumCase() {
        $result = uz_sum("1.00", "2.00", "3.00");
        $this->assertSame("6.00", $result);
    }

    public function testSumNoValues() {
        $sum = uz_sum();

        $this->assertSame("0.00", $sum);
    }

    public function testAbsoluteCase() {
        $result = uz_absolute("-10.00");
        $this->assertSame("10.00", $result);
    }

    public function testNegateCase() {
        $result = uz_negate("10.00");
        $this->assertSame("-10.00", $result);
    }

    public function testNegateCaseNegative() {
        $result = uz_negate("-10.00");
        $this->assertSame("10.00", $result);
    }
}

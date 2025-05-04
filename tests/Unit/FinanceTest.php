<?php declare(strict_types=1);

namespace UsmanZahid\MoneyUtils\Tests\Unit;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../vendor/autoload.php';

class FinanceTest extends TestCase {
    protected function setUp(): void {
        uz_set_precision(2);
    }

    public function testTaxCalculationCase1(): void {
        $amount = "100";
        $taxType = 'percentage';
        $taxAmount = "10.00";

        $taxBreakdown = uz_tax($amount, $taxType, $taxAmount);

        $this->assertSame("100.00", $taxBreakdown['amount']);
        $this->assertSame("10.00", $taxBreakdown['tax']);
        $this->assertSame("110.00", $taxBreakdown['after_tax']);
    }

    public function testTaxCalculationCase2(): void {
        $amount = "200.00";
        $taxType = 'rate';
        $taxAmount = "0.15";

        $taxBreakdown = uz_tax($amount, $taxType, $taxAmount);

        $this->assertSame("200.00", $taxBreakdown['amount']);
        $this->assertSame("30.00", $taxBreakdown['tax']);
        $this->assertSame("230.00", $taxBreakdown['after_tax']);
    }

    public function testTaxCalculationCase3(): void {
        $amount = "150.00";
        $taxType = 'fixed';
        $taxAmount = "20.00";

        $taxBreakdown = uz_tax($amount, $taxType, $taxAmount);

        $this->assertSame("150.00", $taxBreakdown['amount']);
        $this->assertSame("20.00", $taxBreakdown['tax']);
        $this->assertSame("170.00", $taxBreakdown['after_tax']);
    }

    public function testTaxCalculationInvalidType(): void {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid tax type given!');

        $amount = "100";
        $taxType = "invalid";
        $taxAmount = "10.00";

        uz_tax($amount, $taxType, $taxAmount);
    }

    public function testDiscountCalculationCase1(): void {
        $amount = "200";
        $discountType = 'percentage';
        $discountAmount = "15.00";

        $discountBreakdown = uz_discount($amount, $discountType, $discountAmount);

        $this->assertSame("200.00", $discountBreakdown['amount']);
        $this->assertSame("30.00", $discountBreakdown['discount']);
        $this->assertSame("170.00", $discountBreakdown['after_discount']);
    }

    public function testDiscountCalculationCase2(): void {
        $amount = "300.00";
        $discountType = 'rate';
        $discountAmount = "0.20";

        $discountBreakdown = uz_discount($amount, $discountType, $discountAmount);

        $this->assertSame("300.00", $discountBreakdown['amount']);
        $this->assertSame("60.00", $discountBreakdown['discount']);
        $this->assertSame("240.00", $discountBreakdown['after_discount']);
    }

    public function testDiscountCalculationCase3(): void {
        // Fixed discount amount example
        $amount = "150.00";
        $discountType = 'fixed';
        $discountAmount = "30.00";

        $discountBreakdown = uz_discount($amount, $discountType, $discountAmount);

        $this->assertSame("150.00", $discountBreakdown['amount']);
        $this->assertSame("30.00", $discountBreakdown['discount']);
        $this->assertSame("120.00", $discountBreakdown['after_discount']);
    }

    public function testDiscountCalculationInvalidType(): void {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid discount type given!');

        $amount = "100";
        $discountType = "invalid";
        $discountAmount = "10.00";

        uz_discount($amount, $discountType, $discountAmount);
    }

    public function testSplitCase1(): void {
        $amount = "10.00";
        $parts = 2;

        $result = uz_split($amount, $parts);

        $this->assertCount(2, $result);
        $this->assertSame("5.00", $result[0]);
        $this->assertSame("5.00", $result[1]);
    }

    public function testSplitCase2(): void {
        $amount = "10.03";
        $parts = 3;

        $result = uz_split($amount, $parts);

        $this->assertCount(3, $result);
        $this->assertSame("3.35", $result[0]);
        $this->assertSame("3.34", $result[1]);
        $this->assertSame("3.34", $result[2]);
    }

    public function testSplitCase3(): void {
        // Split with an odd decimal
        $amount = "5.55";
        $parts = 4;

        $result = uz_split($amount, $parts);

        $this->assertCount(4, $result);
        $this->assertSame("1.39", $result[0]);
        $this->assertSame("1.39", $result[1]);
        $this->assertSame("1.39", $result[2]);
        $this->assertSame("1.38", $result[3]);
    }

    public function testSplitInvalidParts(): void {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Number of parts must be greater than zero.');

        $amount = "10.00";
        $parts = 0;

        uz_split($amount, $parts);
    }
}

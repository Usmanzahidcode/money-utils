<?php

namespace UsmanZahid\MoneyUtils\Tests;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/utils.php';

class MainTest extends TestCase {
    public function testSubCaseOne() {
        $a = "2.02";
        $b = "0.02";

        $result = uz_sub($a, $b);
        $this->assertEquals("2.00", $result);
    }

    public function testAddCaseOne() {
        $a = "1.00";
        $b = "1.00";

        $result = uz_add($a, $b);
        $this->assertEquals("2.00", $result);
    }

    public function testMulCaseOne() {
        $a = "2.50";
        $b = "4.00";

        $result = uz_mul($a, $b);
        $this->assertEquals("10.00", $result);
    }

    public function testDivCaseOne() {
        $a = "10.00";
        $b = "4.00";

        $result = uz_div($a, $b);
        $this->assertEquals("2.50", $result);
    }

    public function testRoundCaseOne() {
        $a = "2.005";

        $result = uz_round($a);
        $this->assertEquals("2.01", $result);
    }
}

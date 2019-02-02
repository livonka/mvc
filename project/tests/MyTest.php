<?php
declare(strict_types = 1);
use PHPUnit\Framework\TestCase;

require_once(__DIR__.'/../index.php');

final class AverageFunctionTest extends TestCase
{
    public function testGoodAverageFourParams(): void
    {
        $this->assertEquals("four", average_string("zero nine five two"));
    }

    public function testGoodAverageOneParam(): void
    {
        $this->assertEquals("five", average_string("five"));
    }

    public function testGoodAverageOnlyZeroValues(): void
    {
        $this->assertEquals("zero", average_string("zero zero zero zero zero"));
    }

    public function testGoodAverageEmptyInput(): void
    {
        $this->assertEquals("n/a", average_string(""));
    }

}
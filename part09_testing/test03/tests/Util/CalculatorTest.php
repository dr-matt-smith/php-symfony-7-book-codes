<?php
namespace App\Tests\Util;

use App\Util\Calculator;
use PHPUnit\Framework\TestCase;
use App\Exception\UnknownCurrencyException;

class CalculatorTest extends TestCase
{
    public function testCanCreateObject()
    {
        // Arrange
        $calculator = new Calculator();

        // Act

        // Assert
        $this->assertNotNull($calculator);
    }

    public function testAddOneAndOne()
    {
        // Arrange
        $calculator = new Calculator();
        $num1 = 1;
        $num2 = 1;
        $expectedResult = 2;

        // Act
        $result = $calculator->add($num1, $num2);

        // Assert
        $this->assertSame($expectedResult, $result);
    }

    public static function additionProvider()
    {
        return [
            ['one and one is two' => 1, 1, 2],
            ['two and two is four' => 2, 2, 4],
            ['test zero does not change total' => 0, 1, 1],
        ];
    }

    /**
     * @dataProvider additionProvider
     */
    public function testAdditionsWithProvider(int $num1, int $num2, int $expectedResult)
    {
        // Arrange
        $calculator = new Calculator();

        // Act
        $result = $calculator->add($num1, $num2);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testDivideOneAndOne()
    {
        // Arrange
        $calculator = new Calculator();
        $num1 = 1;
        $num2 = 1;
        $expectedResult = 1;

        // Act
        $result = $calculator->divide($num1, $num2);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testDivideOneAndZero()
    {
        // Arrange
        $calculator = new Calculator();
        $num1 = 1;
        $num2 = 0;
        $expectedResult = 1;

        // Expect exception - BEFORE you Act!
        $this->expectException(\InvalidArgumentException::class);

        // Act
        $result = $calculator->divide($num1, $num2);

        // Assert - FAIL - should not get here!
        $this->fail("Expected exception {\InvalidArgumentException::class} not thrown");
    }

    public function testInvalidCurrencyException()
    {
        // Arrange
        $calculator = new Calculator();
        $currency = 'I am not euro';

        // Expect exception - BEFORE you Act!
        $this->expectException(UnknownCurrencyException::class);

        // Act
        // ... code here to trigger exception to be thrown ...
        $calculator->euroOnlyExchange($currency);

        // Assert - FAIL - should not get here!
        $this->fail("Expected exception {\Exception} not thrown");
    }
}
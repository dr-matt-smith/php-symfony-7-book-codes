<?php
namespace App\Tests\Util;

use App\Util\Calculator;
use PHPUnit\Framework\TestCase;

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
            ['bad data should fail' => 0, 1, 2],
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



}
<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CalculatorWebTest extends WebTestCase
{
    public function testCanVisitCalculatorPage()
    {
        // Arrange
        $url = '/calculator';
        $httpMethod = 'GET';
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        // Assert
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testFormReferenceNotNull()
    {
        // Arrange
        $url = '/calculator';
        $httpMethod = 'GET';
        $client = static::createClient();
        $crawler = $client->request($httpMethod, $url);

        // Act
        $buttonName = 'calc_submit';
        $buttonCrawlerNode = $crawler->selectButton($buttonName);
        $form = $buttonCrawlerNode->form();

        // Assert
        $this->assertNotNull($form);
    }

    public function testVisitResultPageAfterFormSubmission()
    {
        // Arrange
        $url = '/calculator';
        $httpMethod = 'GET';
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request($httpMethod, $url);
        $expectedTextInDestination = 'Calc RESULT';
        $routeNameDestination = 'app_calculator_process';
        $cssSelector = 'h1';
        $buttonName = 'calc_submit';

        // Act
        $buttonCrawlerNode = $crawler->selectButton($buttonName);
        $form = $buttonCrawlerNode->form();

        // submit the form
        $client->submit($form);

        // Assert
        $this->assertSelectorTextContains($cssSelector, $expectedTextInDestination);
        $this->assertRouteSame($routeNameDestination);
    }

    public function testSubmitOneAddTwoAndValuesConfirmed()
    {
        $url = '/calculator';
        $httpMethod = 'GET';
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'calc_submit';
        $operand1 = 1;
        $operand2 = 2;
        $operator = 'add';

        // Act
        $buttonCrawlerNode = $crawler->selectButton($buttonName);
        $form = $buttonCrawlerNode->form();

        $form['num1'] = $operand1;
        $form['num2'] = $operand2;
        $form['operator'] = $operator;

        // submit the form & get content
        $crawler = $client->submit($form);
        $content = $client->getResponse()->getContent();

        // Assert
        $this->assertStringContainsString(
            "n1 = $operand1",
            $content
        );
        $this->assertStringContainsString(
            "n2 = $operand2",
            $content
        );
        $this->assertStringContainsString(
            "operator = $operator",
            $content
        );
    }


    /**
     * @dataProvider calculatorProvider
     */
    public function testSubmitValuesAndCorrectResult(int $operator1, int $operator2, string $operator, float $expectedResult)
    {
        $url = '/calculator';
        $httpMethod = 'GET';
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'calc_submit';

        // Act
        $buttonCrawlerNode = $crawler->selectButton($buttonName);
        $form = $buttonCrawlerNode->form();

        $form['num1'] = $operator1;
        $form['num2'] = $operator2;
        $form['operator'] = $operator;

        // submit the form & get content
        $crawler = $client->submit($form);
        $content = $client->getResponse()->getContent();

        // Assert
        $this->assertStringContainsString(
            "n1 = $operator1",
            $content
        );
        $this->assertStringContainsString(
            "n2 = $operator2",
            $content
        );
        $this->assertStringContainsString(
            "operator = $operator",
            $content
        );

        $this->assertStringContainsString(
            "answer = $expectedResult",
            $content
        );
    }


    public function calculatorProvider(): array
    {
        return [
            ['1 and 1 is 2' => 1, 1, 'add', 2],
            ['2 and 2 is 4' => 2, 2, 'add', 4],
            ['10 divided by 5 is 2' => 10, 2, 'divide', 5],
            ['10 minus 2 is 8' => 10, 2, 'subtract', 8],
            ['10 divided by 10 is 1' => 10, 10, 'divide', 1],
        ];
    }

//    public function testSelectSetValuesSubmitInOneGo()
//    {
//        // Arrange
//        $url = '/calc';
//        $httpMethod = 'GET';
//        $client = static::createClient();
//        $client->followRedirects();
//        $buttonName = 'calc_submit';
//        $operand1 = 1;
//        $operand2 = 2;
//        $operator = 'add';
//
//        // Act
//        $client->submit(
//            $client->request($httpMethod, $url)
//                ->selectButton($buttonName)
//                ->form([
//                    'num1'  => $operand1,
//                    'num2'  => $operand2,
//                    'operator'  => $operator,
//                ])
//        );
//        $content = $client->getResponse()->getContent();
//
//        // Assert
//        $this->assertStringContainsString(
//            "n1 = $operand1",
//            $content
//        );
//        $this->assertStringContainsString(
//            "n2 = $operand2",
//            $content
//        );
//        $this->assertStringContainsString(
//            "operator = $operator",
//            $content
//        );
//    }
}

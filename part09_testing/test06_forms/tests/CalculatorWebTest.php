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
        $crawler = $client->request($httpMethod, $url);
        $expectedTextInDestination = 'Calc RESULT';
        $routeNameDesintation = 'app_calculator_process';
        $cssSelector = 'h1';
        $buttonName = 'calc_submit';

        // Act
        $buttonCrawlerNode = $crawler->selectButton($buttonName);
        $form = $buttonCrawlerNode->form();

        // submit the form
        $client->submit($form);

        // Assert
        $this->assertSelectorTextContains($cssSelector, $expectedTextInDestination);
        $this->assertRouteSame($routeNameDesintation);
    }

    public function testSubmitOneAddTwoAndValuesConfirmed()
    {
        // Arrange
        $url = '/calculator';
        $httpMethod = 'GET';
        $client = static::createClient();
        $crawler = $client->request($httpMethod, $url);
        $buttonName = 'calc_submit';
        $operator1 = 1;
        $operator2 = 2;
        $operand = 'add';

        // Act
        $buttonCrawlerNode = $crawler->selectButton($buttonName);
        $form = $buttonCrawlerNode->form();

        $form['num1'] = $operator1;
        $form['num2'] = $operator2;
        $form['operator'] = $operand;

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
            "operator = $operand",
            $content
        );
    }
}

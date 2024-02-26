<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\DomCrawler\Crawler;

class HomePageTest extends WebTestCase
{
    public function testHomepageResponseCodeOkay()
    {
        // Arrange
        $url = '/';
        $httpMethod = 'GET';
        $client = static::createClient();

        // Act
        $client->request($httpMethod, $url);
//
//        $statusCode = $client->getResponse()->getStatusCode();
//
//        // Assert
//        $this->assertSame(Response::HTTP_OK, $statusCode);
//
//        // alternative method
        // Assert
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testHomepageRouteName()
    {
        // Arrange
        $url = '/';
        $httpMethod = 'GET';
        $client = static::createClient();

        // ACt
        $client->request($httpMethod, $url);

        // Assert
        $homepageRoute = 'app_default';
        $this->assertRouteSame($homepageRoute);
    }

    public function testHomepageContentEqualsHelloWorld(): void
    {
        // Arrange
        $url = '/';
        $httpMethod = 'GET';
        $client = static::createClient();
        $searchText = 'Hello World';
        $cssSelector = 'h1';

        // Act
        $crawler = $client->request($httpMethod, $url);

        // Assert
        $this->assertSelectorTextContains($cssSelector, $searchText);
        $this->assertSelectorTextSame($cssSelector, $searchText);
    }

    public function testHomepageContentContainsHello(): void
    {
        // Arrange
        $url = '/';
        $httpMethod = 'GET';
        $client = static::createClient();
        $searchText = 'Hello';
        $cssSelector = 'h1';

        // Act
        $crawler = $client->request($httpMethod, $url);

        // Assert
        $this->assertSelectorTextContains($cssSelector, $searchText);
//        $this->assertSelectorTextSame($cssSelector, $searchText);
    }

    public function testHomepageH1ContentContainsHelloWorldIgnoreCase()
    {
        // Arrange
        $url = '/';
        $httpMethod = 'GET';
        $client = static::createClient();
        $searchText = 'heLLo worLD';
        $cssSelector = 'h1';

        // Act
        $crawler = $client->request($httpMethod, $url);
        $crawler = $crawler->filter($cssSelector); // filter for just 'h1' nodes
        $content = $client->getResponse()->getContent();

        // Assert
        $this->assertStringContainsStringIgnoringCase($searchText, $content);
    }

    public function testHomepageContainsApples(): void
    {
        // Arrange
        $url = '/';
        $httpMethod = 'GET';
        $client = static::createClient();
        $searchText1 = 'apples';
        $cssSelector = 'li';

        // Act
        $crawler = $client->request($httpMethod, $url);

        // Assert
        $this->assertSelectorTextContains($cssSelector, $searchText1);
    }

    public function testHomepageContainsApplesAndLemons(): void
    {
        // Arrange
        $url = '/';
        $httpMethod = 'GET';
        $client = static::createClient();
        $searchText1 = 'apples';
        $searchText2 = 'lemons';
        $cssSelector = 'li';

        // Act
        $crawler = $client->request($httpMethod, $url);

        // Assert
        $this->assertAnySelectorTextContains($cssSelector, $searchText1);
        $this->assertAnySelectorTextContains($cssSelector, $searchText2);
    }

    public function testHomepageContainsLemons(): void
    {
        // Arrange
        $url = '/';
        $httpMethod = 'GET';
        $client = static::createClient();
        $searchText2 = 'lemons';
        $cssSelector = 'ul li';

        // Act
        $crawler = $client->request($httpMethod, $url);

        // Assert
//        $this->assertSelectorTextContains($cssSelector, $searchText2);
        $this->assertAnySelectorTextContains($cssSelector, $searchText2);

        $nodes = $crawler->filter($cssSelector)->each(fn(Crawler $node) => $node->text());
        $this->assertContains($searchText2, $nodes);
    }

    /**
     * @dataProvider basicPagesTextProvider
     */
    public function testPublicPagesContainBasicText(string $url, string $cssSelector, string $searchText)
    {
        // Arrange
        $httpMethod = 'GET';
        $client = static::createClient();

        // Act
        $crawler = $client->request($httpMethod, $url);
        $crawler = $crawler->filter($cssSelector); // filter nodes
        $content = $client->getResponse()->getContent();

        // Assert
        $this->assertStringContainsStringIgnoringCase($searchText, $content);
    }

    public function basicPagesTextProvider(): array
    {
        return [
            ['home page hello world heading' => '/', 'h1', 'hello WORLD'],
            ['home page hello world content' => '/', 'p', 'hello WORLD'],
        ];
    }

    /**
     * @dataProvider fruitsListItemsProvider
     */
    public function testHomePageListContents(string $routeName, string $url, string $cssSelector, string $searchText)
    {
        // Arrange
        $httpMethod = 'GET';
        $client = static::createClient();

        // Act
        $crawler = $client->request($httpMethod, $url);

        // Assert
        $this->assertAnySelectorTextContains($cssSelector, $searchText);
        $this->assertRouteSame($routeName);

    }

    public function fruitsListItemsProvider(): array
    {
        return [
            ['apples' => 'app_default', '/', 'ul li', 'apples'],
            ['grapes' => 'app_default', '/', 'ul li', 'grapes'],
            ['lemons' => 'app_default', '/', 'ul li', 'lemons'],
        ];
    }
}

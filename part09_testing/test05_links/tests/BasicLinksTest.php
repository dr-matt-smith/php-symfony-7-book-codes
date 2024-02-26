<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class BasicLinksTest extends WebTestCase
{
    private Crawler $crawler;
    private KernelBrowser $client;

    private function createClientAndCrawler(string $url, string $httpMethod = 'GET', bool $followRedirects = true): void
    {
        $this->client = static::createClient();
        if($followRedirects){
            $this->client->followRedirects();
        }

        $this->crawler = $this->client->request($httpMethod, $url);
    }

    public function testHomePageLinkToAboutPage()
    {
        // Arrange
        $url = '/';
        $httpMethod = 'GET';
        $client = static::createClient();
        $client->followRedirects();
        $linkText = 'about';

        $routeNameDestination = 'app_default_about';
        $cssSelectorDestination = 'p';
        $searchTextDestination = 'About this great website!';

        // Act
        $crawler = $client->request($httpMethod, $url);
        $link = $crawler->selectLink($linkText)->link();
        $client->click($link);

        // Assert
        $this->assertAnySelectorTextContains($cssSelectorDestination, $searchTextDestination);
        $this->assertRouteSame($routeNameDestination);
    }

    public function testHomePageLinkToAboutPageShorter()
    {
        // pre-Arrange
        $url = '/';
        $this->createClientAndCrawler($url);

        // Arrange
        $linkText = 'about';
        $routeNameDestination = 'app_default_about';
        $cssSelectorDestination = 'p';
        $searchTextDestination = 'About this great website!';

        // Act
        $link = $this->crawler->selectLink($linkText)->link();
        $this->client->click($link);

        // Assert
        $this->assertAnySelectorTextContains($cssSelectorDestination, $searchTextDestination);
        $this->assertRouteSame($routeNameDestination);
    }
}

<?php

namespace tests\Billeterie\BilleterieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        //test fonctionnel
        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Billetterie du musée du Louvre', $crawler->filter('#header h1')->text());
    }

}

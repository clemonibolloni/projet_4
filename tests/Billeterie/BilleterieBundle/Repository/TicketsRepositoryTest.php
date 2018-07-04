<?php

namespace tests\Billeterie\BilleterieBundle\Repository;

use Billeterie\BilleterieBundle\Repository\TicketsRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class TicketsRepositoryTest extends WebTestCase
{

    public function testCountTicket($em)
    {

        $TicketsRepository = new TicketsRepository($em);

        $result = $TicketsRepository->countTicket();

        $this->assertEquals(1000, $result);

    }
}
<?php

namespace tests\Billeterie\BilleterieBundle\Repository;

use Billeterie\BilleterieBundle\BilleteriePrixDuBillet\BilleteriePrixDuBillet;
use Billeterie\BilleterieBundle\Entity\Reservations;
use Billeterie\BilleterieBundle\Entity\Tickets;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BilleteriePrixDuBilletTest extends WebTestCase
{
    public function testPrixParRapportAge()

        //test unitaire
    {
        $BilleteriePrixDuBillet = new BilleteriePrixDuBillet();

        $reservations = new Reservations();

        $tickets = new Tickets();

        $tickets->setDateDeNaissance(new \DateTime('1990-09-06'));

        $reservations->addTicket($tickets);

        $result = $BilleteriePrixDuBillet->prixDuBillet($reservations);
        //veuillez ajouter le prix en centimes pour Stripe
        $this->assertEquals(1600, $result);
        
    }

}
<?php

namespace Billeterie\BilleterieBundle\BilleteriePrixDuBillet;

class BilleteriePrixDuBillet
{
    public function prixDuBillet($reservations)
    {

        $created_tickets = $reservations->getTickets();
        foreach ($created_tickets as $ticket) {
            $prix = 16;
            $ticket_year = $ticket->getAnneeNaissance();
            $year_now = intval(date('Y'));
            $ticket_age = $year_now - $ticket_year;

            if ($ticket_age >= 4 && $ticket_age <= 12) {
                $prix = 8;
            } else if ($ticket_age < 4) {
                $prix = 0;
            } else if ($ticket_age >= 60) {
                $prix = 12;
            }

            if ($prix > 10 && $ticket->getTarifReduit()) {
                $prix = 10;
            }

            $ticket->setPrix($prix);

        }
            //mon prix total
        $total = 0;
        $tickets = $reservations->getTickets();
        foreach ($tickets as $ticket) {
            $total = $total + $ticket->getPrix();
        }
    // je convertis le prix en centimes pour stripe
        $dollars = str_replace('$', '', $total);
        $total = bcmul($dollars, 100);

        return $total;

    }
}
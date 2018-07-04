<?php

namespace Billeterie\BilleterieBundle\Controller;


use Billeterie\BilleterieBundle\BilleterieBundle;
use Billeterie\BilleterieBundle\Form\MultiTicketsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Billeterie\BilleterieBundle\Form\ReservationsType;
use Billeterie\BilleterieBundle\Entity\Tickets;
use Billeterie\BilleterieBundle\Entity\Reservations;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {

        $reservations = new Reservations();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ReservationsType::class, $reservations);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($reservations);

            $session = new Session();
            $session->set('CurrentReservations', $reservations);

            return $this->redirectToRoute('billeterie_information');

        }

        $formView = $form->createView();


        return $this->render('BilleterieBundle:Default:index.html.twig', array(
            'form' => $formView
        ));

    }


    public function informationAction(Request $request)
    {

        $tickets = new Tickets();

        $session = new Session();
        $reservations = $session->get('CurrentReservations');

        $reservations->addTicket($tickets);

        $em = $this->getDoctrine()->getManager();
        $count = $em->getRepository(Tickets::class)
                    ->countTicket();

        if ($count == false) {
            return $this->redirectToRoute('billeterie_error');
        }

        $form = $this->createForm(MultiTicketsType::class, $reservations);

        $tickets->setReservation($reservations);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $prixservice = $this->container->get('billeterie.prixdubillet');

            $total = $prixservice->prixDuBillet($reservations);

            $tickets = $reservations->getTickets();

            $session = new Session();
            $session->set('CurrentPrice', $total);
            $session->set('CurrentTicket', $tickets);

            $em = $this->getDoctrine()->getManager();
            $em->persist($reservations);

            $em->flush();
            return $this->redirectToRoute('billeterie_paiement');
        }

        $formView = $form->createView();

        return $this->render('BilleterieBundle:Default:information.html.twig', array(
            'form' => $formView
        ));

    }

    public function paiementAction()
    {

        $session = new Session();
        $total = $session->get('CurrentPrice');

        $tickets = $session->get('CurrentTicket');

        \Stripe\Stripe::setApiKey("sk_test_mEBAVp5DcMQtwDV9XUorNx6L");

        if (isset($_POST['stripeToken']) && !empty($_POST['stripeToken'])) {
            \Stripe\Charge::create(array(
                "amount" => $total,
                "currency" => "eur",
                "source" => $_POST['stripeToken'], // obtained with Stripe.js
                "description" => "Ticket pour le musée du Louvre"
            ));

            $reservations = $session->get('CurrentReservations');

            $total = number_format(($total / 100), 2, '.', ' ');

            //génére un code aléatoir de chiffre et de lettre pour le ticket à envoyer
            $characts = 'abcdefghijklmnopqrstuvwxyz';
            $characts .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $characts .= '1234567890';
            $code_aleatoire = '';

            for ($i = 0; $i < 10; $i++) {
                $code_aleatoire .= $characts[rand() % strlen($characts)];
            }


            $message = \Swift_Message::newInstance()
                ->setSubject('Validation de votre Ticket')
                ->setFrom(array('clement.jaouen@gmail.com' => 'Musée du Louvre'))
                ->setTo($reservations->getMail())
                ->setCharset('utf-8')
                ->setContentType('text/html')
                ->setBody($this->renderView('BilleterieBundle:Default:mailvalidation.html.twig', array(
                    'type' => $reservations->getType(),
                    'date' => $reservations->getDateDeVisite(),
                    'total' => $total,
                    'code' => $code_aleatoire,
                    'tickets' => $tickets)));

            $this->get('mailer')->send($message);

            return $this->redirectToRoute('billeterie_commande');
        }

        $total = number_format(($total / 100), 2, '.', ' ');

        return $this->render('BilleterieBundle:Default:paiement.html.twig', array(

            'total' => $total));
    }

    public function commandeAction()
    {
        $session = new Session();
        $total = $session->get('CurrentPrice');
        $reservations = $session->get('CurrentReservations');
        $tickets = $session->get('CurrentTicket');

        $total = number_format(($total / 100), 2, '.', ' ');

        return $this->render('BilleterieBundle:Default:commande.html.twig', array(
            'type' => $reservations->getType(),
            'date' => $reservations->getDateDeVisite(),
            'mail' => $reservations->getMail(),
            'tickets' => $tickets,
            'total' => $total));

    }

    public function errorAction()
    {

        return $this->render('BilleterieBundle:Default:error.html.twig');

    }
}

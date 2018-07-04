<?php

namespace Billeterie\BilleterieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Reservations
 *
 * @ORM\Table(name="reservations")
 * @ORM\Entity(repositoryClass="Billeterie\BilleterieBundle\Repository\ReservationsRepository")
 */
class Reservations
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Billeterie\BilleterieBundle\Entity\Tickets", mappedBy="reservation", cascade={"persist"})
     */
    private $tickets;

    /**
     * @var datetime
     *
     * @ORM\Column(name="date_de_visite", type="datetime")
     *
     *
     * @Assert\GreaterThanOrEqual("today")
     *
     * )
     */
    private $dateDeVisite;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     *
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     *
     *
     */
    private $type;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateDeVisite
     *
     * @param \DateTime $dateDeVisite
     *
     * @return Reservations
     */
    public function setDateDeVisite($dateDeVisite)
    {
        $this->dateDeVisite = $dateDeVisite;

        return $this;
    }

    /**
     * Get dateDeVisite
     *
     * @return \DateTime
     */
    public function getDateDeVisite()
    {
        return $this->dateDeVisite;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Reservations
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Reservations
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    /**
    * @param ArrayCollection $tickets
    *
    * @return Reservations
    */
    public function setTickets(ArrayCollection $tickets)
    {
        $this->tickets = $tickets;

        return $this;
    }

    /**
     * Add ticket
     *
     * @param \Billeterie\BilleterieBundle\Entity\Tickets $ticket
     *
     * @return Reservations
     */
    public function addTicket(\Billeterie\BilleterieBundle\Entity\Tickets $ticket)
    {
        $this->tickets[] = $ticket;

        $ticket->setReservation($this);

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \Billeterie\BilleterieBundle\Entity\Tickets $ticket
     */
    public function removeTicket(\Billeterie\BilleterieBundle\Entity\Tickets $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }
}

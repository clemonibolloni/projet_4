<?php

namespace Billeterie\BilleterieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Tickets
 *
 * @ORM\Table(name="tickets")
 * @ORM\Entity(repositoryClass="Billeterie\BilleterieBundle\Repository\TicketsRepository")
 */
class Tickets
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
     * @ORM\ManyToOne(targetEntity="Billeterie\BilleterieBundle\Entity\Reservations", inversedBy="tickets", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $reservation;

    /**
     * @var bool
     *
     * @ORM\Column(name="tarif_reduit", type="boolean")
     */
    private $tarifReduit = false;


    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=100)
     *
     * *
     * @Assert\NotBlank(message="le nom est obligatoire")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=100)
     *
     * *
     * @Assert\NotBlank(message="le prénom est obligatoire")
     */
    private $prenom;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date_de_naissance", type="datetime")
     *
     *
     * @Assert\LessThan("today")
     */

    private $dateDeNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=100)
     *
     * *
     * @Assert\NotBlank(message="le pays est obligatoire")
     */
    private $pays;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     *
     *
     */
    private $prix;


    /**
     * Constructor
     */
    public function __construct()
    {
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
     * Set prix
     *
     * @param integer $prix
     *
     * @return Tickets
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return integer
     */
    public function getPrix()
    {
        return $this->prix;
    }


    /**
     * Set tarifReduit
     *
     * @param boolean $tarifReduit
     *
     * @return Tickets
     */
    public function setTarifReduit($tarifReduit)
    {
        $this->tarifReduit = $tarifReduit;

        return $this;
    }

    /**
     * Get tarifReduit
     *
     * @return boolean
     */
    public function getTarifReduit()
    {
        return $this->tarifReduit;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Tickets
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Tickets
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set dateDeNaissance
     *
     * @param \DateTime $dateDeNaissance
     *
     * @return Tickets
     */
    public function setDateDeNaissance($dateDeNaissance)
    {
        $this->dateDeNaissance = $dateDeNaissance;

        return $this;
    }

    /**
     * Get dateDeNaissance
     *
     * @return \DateTime
     */
    public function getDateDeNaissance()
    {
        return $this->dateDeNaissance;
    }

    /**
     * Get Annee Naussance
     *
     * @return \Year
     */
    public function getAnneeNaissance()
    {
        return $this->dateDeNaissance->format('Y');
    }

    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return Tickets
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set reservation
     *
     * @param \Billeterie\BilleterieBundle\Entity\Reservations $reservation
     *
     * @return Tickets
     */
    public function setReservation(\Billeterie\BilleterieBundle\Entity\Reservations $reservation = null)
    {
        $this->reservation = $reservation;

        return $this;
    }

    /**
     * Get reservation
     *
     * @return \Billeterie\BilleterieBundle\Entity\Reservations
     */
    public function getReservation()
    {
        return $this->reservation;
    }
}

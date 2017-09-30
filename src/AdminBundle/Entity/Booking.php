<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Booking
 *
 * @ORM\Table(name="BOOKING", indexes={@ORM\Index(name="fk_BOOKING_EVENTS1_idx", columns={"EVENTS_id"}), @ORM\Index(name="fk_BOOKING_QOUIQUI1_idx", columns={"QOUIQUI_id"}), @ORM\Index(name="FK_hotel_booking", columns={"hotel_id"})})
 * @ORM\Entity
 */
class Booking
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="statu", type="boolean", nullable=true)
     */
    private $statu;

    /**
     * @var \Events
     *
     * @ORM\ManyToOne(targetEntity="Events")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="EVENTS_id", referencedColumnName="id")
     * })
     */
    private $events;

    /**
     * @var \Qouiqui
     *
     * @ORM\ManyToOne(targetEntity="Qouiqui")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="QOUIQUI_id", referencedColumnName="id")
     * })
     */
    private $qouiqui;

    /**
     * @var \Hotel
     *
     * @ORM\ManyToOne(targetEntity="Hotel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="hotel_id", referencedColumnName="id")
     * })
     */
    private $hotel;


    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="fos_user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="string", length=1024, nullable=true)
     */
    private $data;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu_depart", type="string", length=1024, nullable=true)
     */
    private $lieuDepart;

    /**
     * @var datetime
     *
     * @ORM\Column(name="lieu_retour", type="datetime", length=1024, nullable=true)
     */
    private $lieuRetour;

    /**
     * @var string
     *
     * @ORM\Column(name="date_retour", type="string", length=1024, nullable=true)
     */
    private $dateRetour;

    /**
     * @var datetime
     *
     * @ORM\Column(name="date_de_prise", type="datetime", length=1024, nullable=true)
     */
    private $datePrise;


    /**
     * Set LieuDepart
     *
     * @param datetime $lieu_depart
     *
     * @return Booking
     */
    public function setLieuDepart($lieuDepart)
    {
        $this->lieuDepart = $lieuDepart;

        return $this;
    }

    /**
     * Get LieuDepart
     *
     * @return datetime
     */
    public function getLieuDepart()
    {
        return $this->LieuDepart;
    }

    /**
     * Set lieuRetour
     *
     * @param datetime $lien_retour
     *
     * @return Booking
     */
    public function setLienRetour($lieuRetour)
    {
        $this->lieuRetour = $lieuRetour;

        return $this;
    }
    /**
     * Get lieuRetour
     *
     * @return datetime
     */
    public function getLieuRetour()
    {
        return $this->lieuRetour;
    }
    /**
     * Set dateRetour
     *
     * @param datetime $dataRetour
     *
     * @return Booking
     */
    public function setDateRetour($dataRetour)
    {
        $this->dateRetour = $dataRetour;
        return $this;
    }
    /**
     * Get dateRetour
     *
     * @return datetime
     */
    public function getDateRetour()
    {
        return $this->dateRetour;
    }

    /**
     * Set date_de_prise
     *
     * @param datetime $data_de_prise
     *
     * @return Booking
     */
    public function setDatePrise($datePrise)
    {
        $this->DatePrise = $datePrise;

        return $this;
    }

    /**
     * Get date_de_prise
     *
     * @return datetime
     */
    public function getDateDePrise()
    {
        return $this->datePrise;
    }

    /**
     * Set data
     *
     * @param string $data
     *
     * @return Booking
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Booking
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set statu
     *
     * @param boolean $statu
     *
     * @return Booking
     */
    public function setStatu($statu)
    {
        $this->statu = $statu;

        return $this;
    }

    /**
     * Get statu
     *
     * @return boolean
     */
    public function getStatu()
    {
        return $this->statu;
    }

    /**
     * Set events
     *
     * @param \AdminBundle\Entity\Events $events
     *
     * @return Booking
     */
    public function setEvents(\AdminBundle\Entity\Events $events = null)
    {
        $this->events = $events;

        return $this;
    }

    /**
     * Get events
     *
     * @return \AdminBundle\Entity\Events
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Set qouiqui
     *
     * @param \AdminBundle\Entity\Qouiqui $qouiqui
     *
     * @return Booking
     */
    public function setQouiqui(\AdminBundle\Entity\Qouiqui $qouiqui = null)
    {
        $this->qouiqui = $qouiqui;

        return $this;
    }

    /**
     * Get qouiqui
     *
     * @return \AdminBundle\Entity\Qouiqui
     */
    public function getQouiqui()
    {
        return $this->qouiqui;
    }

    /**
     * Set hotel
     *
     * @param \AdminBundle\Entity\Hotel $hotel
     *
     * @return Booking
     */
    public function setHotel(\AdminBundle\Entity\Hotel $hotel = null)
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**
     * Get hotel
     *
     * @return \AdminBundle\Entity\Hotel
     */
    public function getHotel()
    {
        return $this->hotel;
    }

    /**
     * Set user
     *
     * @param \AdminBundle\Entity\User $user
     *
     * @return Qouiqui
     */
    public function setUser(\AdminBundle\Entity\User $user = null)
    {
        $this->user= $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AdminBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}

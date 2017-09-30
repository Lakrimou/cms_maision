<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Events
 *
 * @ORM\Table(name="EVENTS", indexes={@ORM\Index(name="fk_EVENTS_QVILLE1_idx", columns={"QVILLE_id"})})
 * @ORM\Entity(repositoryClass="AdminBundle\Entity\EventsRepository")
 */
class Events
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
     * @var string
     *
     * @ORM\Column(name="event_name", type="string", length=45, nullable=false)
     */
    private $eventName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_start", type="datetime", nullable=true)
     */
    private $dateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_end", type="datetime", nullable=true)
     */
    private $dateEnd;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=45, nullable=true)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="statu", type="string", length=45, nullable=true)
     */
    private $statu;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="string", length=4000, nullable=true)
     */
    private $details;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=45, nullable=true)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="org_by", type="string", length=45, nullable=true)
     */
    private $orgBy;

    /**
     * @var integer
     *
     * @ORM\Column(name="views", type="bigint", nullable=true)
     */
    private $views;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

//    /**
//     * @var \Qville
//     *
//     * @ORM\ManyToOne(targetEntity="Qville")
//     * @ORM\JoinColumns({
//     *   @ORM\JoinColumn(name="QVILLE_id", referencedColumnName="id")
//     * })
//     */
//    private $qville;

    /**
     * @var \Qville
     *
     * @ORM\ManyToOne(targetEntity="Qville", inversedBy="eventss")
     * @ORM\JoinColumn(name="QVILLE_id", referencedColumnName="id")
     */
    private $qville;

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
     * Set eventName
     *
     * @param string $eventName
     *
     * @return Events
     */
    public function setEventName($eventName)
    {
        $this->eventName = $eventName;

        return $this;
    }

    /**
     * Get eventName
     *
     * @return string
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * Set date_start
     *
     * @param string dateStart
     *
     * @return Events
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get date_start
     *
     * @return string
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set date_end
     *
     * @param string dateEnd
     *
     * @return Events
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get date_End
     *
     * @return string
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Events
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set statu
     *
     * @param string $statu
     *
     * @return Events
     */
    public function setStatu($statu)
    {
        $this->statu = $statu;

        return $this;
    }

    /**
     * Get statu
     *
     * @return string
     */
    public function getStatu()
    {
        return $this->statu;
    }

    /**
     * Set details
     *
     * @param string $details
     *
     * @return Events
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return Events
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set orgBy
     *
     * @param string $orgBy
     *
     * @return Events
     */
    public function setOrgBy($orgBy)
    {
        $this->orgBy = $orgBy;

        return $this;
    }

    /**
     * Get orgBy
     *
     * @return string
     */
    public function getOrgBy()
    {
        return $this->orgBy;
    }

    /**
     * Set views
     *
     * @param integer $views
     *
     * @return Events
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return integer
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Events
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set qville
     *
     * @param \AdminBundle\Entity\Qville $qville
     *
     * @return Events
     */
    public function setQville(\AdminBundle\Entity\Qville $qville = null)
    {
        $this->qville = $qville;

        return $this;
    }

    /**
     * Get qville
     *
     * @return \AdminBundle\Entity\Qville
     */
    public function getQville()
    {
        return $this->qville;
    }
}

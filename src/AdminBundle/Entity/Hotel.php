<?php
/**
 * Created by PhpStorm.
 * User: Hatem
 * Date: 15/05/2017
 * Time: 12:06
 */

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Events
 *
 * @ORM\Table(name="hotel", indexes={@ORM\Index(name="FK1_qouiqui_hotel", columns={"qouiqui_id"})})
 * @ORM\Entity(repositoryClass="AdminBundle\Entity\HotelRepository")
 */
class Hotel
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
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @var \Qouiqui
     *
     * @ORM\ManyToOne(targetEntity="Qouiqui", inversedBy="hotels")
     * @ORM\JoinColumn(name="qouiqui_id", referencedColumnName="id")
     */
    private $qouiqui;


    /**
     * @var string
     *
     * @ORM\Column(name="description_room", type="text", length=65535, nullable=true)
     */
    private $descriptionRoom;


    /**
     * @var string
     *
     * @ORM\Column(name="about", type="text", length=100, nullable=true)
     */
    private $about;


    /**
     * @var string
     *
     * @ORM\Column(name="horaires", type="text", length=100, nullable=true)
     */
    private $horaires;


    /**
     * @var string
     *
     * @ORM\Column(name="description_services", type="text", length=65535, nullable=true)
     */
    private $descriptionServices;

    /**
 * @var string
 *
 * @ORM\Column(name="description_news", type="text", length=65535, nullable=true)
 */
    private $descriptionNews;

    /**
     * @var string
     *
     * @ORM\Column(name="description_events", type="text", length=65535, nullable=true)
     */
    private $descriptionEvents;

    /**
     * Set qouiqui
     *
     * @param \AdminBundle\Entity\Qouiqui $qouiqui
     *
     * @return Hotel
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
     * Set description_room
     *
     * @param string $descriptionRoom
     *
     * @return Hotel
     */
    public function setDescriptionRoom($descriptionRoom)
    {
        $this->descriptionRoom = $descriptionRoom;

        return $this;
    }

    /**
     * Get description_room
     *
     * @return string
     */
    public function getDescriptionRoom()
    {
        return $this->descriptionRoom;
    }

    /**
     * Set descriptionServices
     *
     * @param string $descriptionServices
     *
     * @return Hotel
     */
    public function setDescriptionServices($descriptionServices)
    {
        $this->descriptionServices = $descriptionServices;

        return $this;
    }

    /**
     * Get descriptionServices
     *
     * @return string
     */
    public function getDescriptionServices()
    {
        return $this->descriptionServices;
    }

    /**
     * Set description_news
     *
     * @param string $descriptionNews
     *
     * @return Hotel
     */
    public function setDescriptionNews($descriptionNews)
    {
        $this->descriptionNews = $descriptionNews;

        return $this;
    }

    /**
     * Get description_news
     *
     * @return string
     */
    public function getDescriptionNews()
    {
        return $this->descriptionNews;
    }

    /**
     * Set description_events
     *
     * @param string $descriptionEvents
     *
     * @return Hotel
     */
    public function setDescriptionEvents($descriptionEvents)
    {
        $this->descriptionEvents = $descriptionEvents;

        return $this;
    }

    /**
     * Get description_events
     *
     * @return string
     */
    public function getDescriptionEvents()
    {
        return $this->descriptionEvents;
    }

    /**
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * @param string $about
     */
    public function setAbout($about)
    {
        $this->about = $about;
    }

    /**
     * @return string
     */
    public function getHoraires()
    {
        return $this->horaires;
    }

    /**
     * @param string $horaires
     */
    public function setHoraires($horaires)
    {
        $this->horaires = $horaires;
    }


}
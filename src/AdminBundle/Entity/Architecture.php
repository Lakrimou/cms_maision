<?php
/**
 * Created by PhpStorm.
 * User: Ameni
 * Date: 19/07/2017
 * Time: 16:03
 */

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Architecture
 *
 * @ORM\Table(name="Architecture", indexes={@ORM\Index(name="FK1_qouiqui_car", columns={"qouiqui_id"}), @ORM\Index(name="FK_AUTOMOBILE_Mark", columns={"mark"})})
 * @ORM\Entity
 */
class Architecture
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
     * @var \Qouiqui
     *
     * @ORM\ManyToOne(targetEntity="Qouiqui")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="qouiqui_id", referencedColumnName="id")
     * })
     */
    private $qouiqui;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", nullable=true)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="client", type="text", nullable=true)
     */
    private $client;
    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="text", nullable=true)
     */
    private $adress;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /** @ORM\Column(name="date_creation", type="datetime") */
    private $dateCreation;
    /**
 * @var string
 *
 * @ORM\Column(name="reference", type="text", nullable=true)
 */
    private $reference;
    /**
     * @var string
     *
     * @ORM\Column(name="surface", type="text", nullable=true)
     */
    private $surface;
    /**
     * @var integer
     *
     * @ORM\Column(name="index_principale_image", type="integer", nullable=true)
     */
    private $indexPrincipaleImage ;
    public function __construct()
    {
        $this->indexPrincipaleImage=0;
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
     * Set qouiqui
     *
     * @param \AdminBundle\Entity\Qouiqui $qouiqui
     *
     * @return Automobile
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
     * Set name
     *
     * @param string $name
     *
     * @return Architecture
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set description
     *
     * @param string $description
     *
     * @return Architecture
     */
    public function setDescription($description)
    {
        $this->description= $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateCreation
     *
     * @param datetime $dateCreation
     *
     * @return Architecture
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation= $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return datetime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }
    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Architecture
     */
    public function setReference($reference)
    {
        $this->reference= $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }
    /**
     * Set indexPrincipaleImage
     *
     * @param integer $indexPrincipaleImage
     *
     * @return Architecture
     */
    public function setIndexPrincipaleImage($indexPrincipaleImage)
    {
        $this->indexPrincipaleImage = $indexPrincipaleImage;

        return $this;
    }

    /**
     * Get indexPrincipaleImage
     *
     * @return integer
     */
    public function getIndexPrincipaleImage()
    {
        return $this->indexPrincipaleImage;
    }
    /**
     * Set client
     *
     * @param string $client
     *
     * @return Architecture
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return string
     */
    public function getclient()
    {
        return $this->client;
    }
    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return Architecture
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }
    /**
     * Set surface
     *
     * @param string $surface
     *
     * @return Architecture
     */
    public function setSurface($surface)
    {
        $this->surface= $surface;

        return $this;
    }

    /**
     * Get surface
     *
     * @return string
     */
    public function getSurface()
    {
        return $this->surface;
    }

}
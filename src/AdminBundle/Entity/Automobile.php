<?php
namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Automobile
 *
 * @ORM\Table(name="AUTOMOBILE", indexes={@ORM\Index(name="FK1_qouiqui_car", columns={"qouiqui_id"}), @ORM\Index(name="FK_AUTOMOBILE_Mark", columns={"mark"})})
 * @ORM\Entity
 */
class Automobile
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
     * @var integer
     *
     * @ORM\Column(name="index_principale_image", type="integer", nullable=true)
     */
    private $indexPrincipaleImage ;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="text", length=65535, nullable=true)
     */
    private $reference;

    /**
     * @var integer
     *
     * @ORM\Column(name="model_year", type="integer", nullable=false)
     */
    private $modelYear;



    /**
     * @var float
     *
     * @ORM\Column(name="mileage", type="float", precision=10, scale=0, nullable=false)
     */
    private $mileage;

    /**
     * @var string
     *
     * @ORM\Column(name="energy", type="string", length=127, nullable=false)
     */
    private $energy;

    /**
     * @var float
     *
     * @ORM\Column(name="kiloW", type="float", precision=10, scale=0, nullable=false)
     */
    private $kilow;

    /**
     * @var integer
     *
     * @ORM\Column(name="fiscal_power", type="integer", nullable=false)
     */
    private $fiscalPower;

    /**
     * @var string
     *
     * @ORM\Column(name="boite", type="string", length=50, nullable=false)
     */
    private $boite;

    /**
     * @var integer
     *
     * @ORM\Column(name="porte", type="integer", nullable=false)
     */
    private $porte;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="text", length=65535, nullable=false)
     */
    private $details;

    /**
     * @var string
     *
     * @ORM\Column(name="images", type="text", nullable=true)
     */
    private $images;

    /**
     * @var string
     *
     * @ORM\Column(name="other", type="text", length=65535, nullable=true)
     */
    private $other;

    /**
     * @var boolean
     *
     * @ORM\Column(name="statut", type="boolean", nullable=true)
     */
    private $statut;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=true)
     */
    private $price;

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
     * @var \Model
     *
     * @ORM\ManyToOne(targetEntity="Model")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="model", referencedColumnName="id")
     * })
     */
    private $model;


    /** @ORM\Column(name="date_ajout", type="datetime", nullable=true ) */

    private $dateCreation;

    public function __construct()
    {
        $this->indexPrincipaleImage=0;
        $this->dateCreation=new \DateTime();
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
     * Set indexPrincipaleImage
     *
     * @param integer $indexPrincipaleImage
     *
     * @return Automobile
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
     * Set reference
     *
     * @param string $reference
     *
     * @return Automobile
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

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
     * Set modelYear
     *
     * @param integer $modelYear
     *
     * @return Automobile
     */
    public function setModelYear($modelYear)
    {
        $this->modelYear = $modelYear;

        return $this;
    }

    /**
     * Get modelYear
     *
     * @return integer
     */
    public function getModelYear()
    {
        return $this->modelYear;
    }



    /**
     * Set mileage
     *
     * @param float $mileage
     *
     * @return Automobile
     */
    public function setMileage($mileage)
    {
        $this->mileage = $mileage;

        return $this;
    }

    /**
     * Get mileage
     *
     * @return float
     */
    public function getMileage()
    {
        return $this->mileage;
    }

    /**
     * Set energy
     *
     * @param string $energy
     *
     * @return Automobile
     */
    public function setEnergy($energy)
    {
        $this->energy = $energy;

        return $this;
    }

    /**
     * Get energy
     *
     * @return string
     */
    public function getEnergy()
    {
        return $this->energy;
    }

    /**
     * Set kilow
     *
     * @param float $kilow
     *
     * @return Automobile
     */
    public function setKilow($kilow)
    {
        $this->kilow = $kilow;

        return $this;
    }

    /**
     * Get kilow
     *
     * @return float
     */
    public function getKilow()
    {
        return $this->kilow;
    }

    /**
     * Set fiscalPower
     *
     * @param integer $fiscalPower
     *
     * @return Automobile
     */
    public function setFiscalPower($fiscalPower)
    {
        $this->fiscalPower = $fiscalPower;

        return $this;
    }

    /**
     * Get fiscalPower
     *
     * @return integer
     */
    public function getFiscalPower()
    {
        return $this->fiscalPower;
    }

    /**
     * Set boite
     *
     * @param string $boite
     *
     * @return Automobile
     */
    public function setBoite($boite)
    {
        $this->boite = $boite;

        return $this;
    }

    /**
     * Get boite
     *
     * @return string
     */
    public function getBoite()
    {
        return $this->boite;
    }

    /**
     * Set porte
     *
     * @param integer $porte
     *
     * @return Automobile
     */
    public function setPorte($porte)
    {
        $this->porte = $porte;

        return $this;
    }

    /**
     * Get porte
     *
     * @return integer
     */
    public function getPorte()
    {
        return $this->porte;
    }

    /**
     * Set details
     *
     * @param string $details
     *
     * @return Automobile
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
     * Set images
     *
     * @param string $images
     *
     * @return Automobile
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return string
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set other
     *
     * @param string $other
     *
     * @return Automobile
     */
    public function setOther($other)
    {
        $this->other = $other;

        return $this;
    }

    /**
     * Get other
     *
     * @return string
     */
    public function getOther()
    {
        return $this->other;
    }

    /**
     * Set statut
     *
     * @param boolean $statut
     *
     * @return Automobile
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return boolean
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Automobile
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
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
     * Set Model
     *
     * @param \AdminBundle\Entity\Model $model
     *
     * @return Automobile
     */
    public function setModel(\AdminBundle\Entity\Model $model = null)
    {
        $this->model= $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return \AdminBundle\Entity\Model
     */
    public function getModel()
    {
        return $this->model;
    }
    /**
     * Set dateCreation
     *
     * @param datetime $dateCreation
     *
     * @return Automobile
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


}








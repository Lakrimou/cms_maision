<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pays
 *
 * @ORM\Table(name="DepannageVehicule", indexes={@ORM\Index(name="FK_DepannageVehicule_quoiqui", columns={"qouiqui"})})
 * @ORM\Entity
 */
class DepannageVehicule
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Qouiqui
     *
     * @ORM\ManyToOne(targetEntity="Qouiqui")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="qouiqui", referencedColumnName="id")
     * })
     */
    private $qouiqui;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string",nullable=true)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAjoute", type="datetime",nullable=true)
     */
    private $dateAjoute;

    /**
     * @var string
     *
     * @ORM\Column(name="dateDeb", type="string",nullable=true)
     */
    private $dateDeb;

    /**
     * @var string
     *
     * @ORM\Column(name="dateFin", type="string",nullable=true)
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", nullable=true)
     */
    private $photo;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", nullable=true)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text",nullable=true)
     */
    private $description;

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
     * @return Immobiliair
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
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getDateDeb()
    {
        return $this->dateDeb;
    }

    /**
     * @param string $dateDeb
     */
    public function setDateDeb($dateDeb)
    {
        $this->dateDeb = $dateDeb;
    }

    /**
     * @return string
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param string $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return \DateTime
     */
    public function getDateAjoute()
    {
        return $this->dateAjoute;
    }

    /**
     * @param \DateTime $dateAjoute
     */
    public function setDateAjoute($dateAjoute)
    {
        $this->dateAjoute = $dateAjoute;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    public $photoArr = array();

    /**
     * @return array
     */
    public function getPhotoArr()
    {
        return $this->photoArr;
    }

    /**
     * @param array $photoArr
     */
    public function setPhotoArr($photoArr)
    {
        $this->photoArr = $photoArr;
    }

}

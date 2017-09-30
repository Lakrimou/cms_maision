<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModECommerce
 *
 * @ORM\Table(name="mod_ecommerce", indexes={@ORM\Index(name="FK_ecommerce_qouiqui", columns={"qouiqui_id"})})
 * @ORM\Entity
 */
class ModECommerce
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
     * @ORM\Column(name="section", type="string", length=50, nullable=false)
     */
    private $section;


    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="text", length=65535, nullable=false)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=255, nullable=false)
     */
    private $marque;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255, nullable=false)
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="sous_categorie", type="string", length=255, nullable=false)
     */
    private $sousCategorie;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float",nullable=false)
     */
    private $prix;

    /**
     * @var integer
     *
     * @ORM\Column(name="stock", type="integer",nullable=false)
     */
    private $stock;

    /**
     * @var string
     *
     * @ORM\Column(name="date_deb", type="string",nullable=false)
     */
    private $dateDeb;

    /**
     * @var string
     *
     * @ORM\Column(name="date_fin", type="string",nullable=false)
     */
    private $dateFin;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_n", type="float", nullable=false)
     */
    private $prixN;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="text", length=65535, nullable=false)
     */
    private $data;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="offre", type="integer", nullable=false)
     */
    private $offre = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreate", type="datetime", nullable=false)
     */
    private $datecreate = 'CURRENT_TIMESTAMP';

    /**
     * @var \Qouiqui
     *
     * @ORM\ManyToOne(targetEntity="Qouiqui", inversedBy="ECommerce")
     * @ORM\JoinColumn(name="quoiqui_id", referencedColumnName="id")
     */
    private $qouiqui;

    public function __construct()
    {
        $this->datecreate = new \DateTime();
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
     * Set section
     *
     * @param string $section
     *
     * @return ModECommerce
     */
    public function setSection($section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set data
     *
     * @param string $data
     *
     * @return ModECommerce
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
     * Set status
     *
     * @param boolean $status
     *
     * @return ModECommerce
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set datecreate
     *
     * @param \DateTime $datecreate
     *
     * @return ModECommerce
     */
    public function setDatecreate($datecreate)
    {
        $this->datecreate = $datecreate;

        return $this;
    }

    /**
     * Get datecreate
     *
     * @return \DateTime
     */
    public function getDatecreate()
    {
        return $this->datecreate;
    }

    /**
     * Set qouiqui
     *
     * @param \AdminBundle\Entity\Qouiqui $qouiqui
     *
     * @return ModECommerce
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

    /**
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
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
     * @return string
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * @param string $marque
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;
    }
    private $photoArray=array();

    /**
     * @return array
     */
    public function getPhotoArray()
    {
        return $this->photoArray;
    }

    /**
     * @param array $photoArray
     */
    public function setPhotoArray($photoArray)
    {
        $this->photoArray = $photoArray;
    }

    /**
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param string $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    /**
     * @return string
     */
    public function getSousCategorie()
    {
        return $this->sousCategorie;
    }

    /**
     * @param string $sousCategorie
     */
    public function setSousCategorie($sousCategorie)
    {
        $this->sousCategorie = $sousCategorie;
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
     * @return float
     */
    public function getPrixN()
    {
        return $this->prixN;
    }

    /**
     * @param float $prixN
     */
    public function setPrixN($prixN)
    {
        $this->prixN = $prixN;
    }

    /**
     * @return bool
     */
    public function isOffre()
    {
        return $this->offre;
    }

    /**
     * @param bool $offre
     */
    public function setOffre($offre)
    {
        $this->offre = $offre;
    }


}

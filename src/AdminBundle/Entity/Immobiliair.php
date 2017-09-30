<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Immobiliair
 *
 * @ORM\Table(name="IMMOBILIAIR", indexes={@ORM\Index(name="FK_IMMOBILIAIR_QOUIQUI", columns={"qouiqui"})})
 * @ORM\Entity
 */
class Immobiliair
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
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=50, nullable=true)
     */
    private $adresse;

    /**
     * @var integer
     *
     * @ORM\Column(name="geo_lat", type="integer", nullable=true)
     */
    private $geoLat;

    /**
     * @var integer
     *
     * @ORM\Column(name="geo_long", type="integer", nullable=true)
     */
    private $geoLong;

    /**
     * @var string
     *
     * @ORM\Column(name="statu", type="string", length=15, nullable=true)
     */
    private $statu;

    /**
     * @var integer
     *
     * @ORM\Column(name="cuisine_equipee", type="integer", nullable=true)
     */
    private $cuisineEquipee;

    /**
     * @var integer
     *
     * @ORM\Column(name="sallon", type="integer", nullable=true)
     */
    private $sallon;

    /**
     * @var integer
     *
     * @ORM\Column(name="suits", type="integer", nullable=true)
     */
    private $suits;

    /**
     * @var integer
     *
     * @ORM\Column(name="salle_de_bain", type="integer", nullable=true)
     */
    private $salleDeBain;

    /**
     * @var integer
     *
     * @ORM\Column(name="ascenseur", type="integer", nullable=true)
     */
    private $ascenseur;

    /**
     * @var integer
     *
     * @ORM\Column(name="archive", type="integer", nullable=true)
     */
    private $archive;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", nullable=true)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="prefix", type="string", nullable=true)
     */
    private $prefix;

    /**
     * @var text
     *
     * @ORM\Column(name="equipment", type="text", nullable=true)
     */
    private $equipment;

    /**
     * @var text
     *
     * @ORM\Column(name="titre", type="text", nullable=true)
     */
    private $titre;

    /**
     * @var integer
     *
     * @ORM\Column(name="details", type="string", length=400, nullable=true)
     */
    private $details;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Immobiliair
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set prefix
     *
     * @param string prefix
     *
     * @return Immobiliair
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }


    /**
     * Set titre
     *
     * @param string $adresse
     *
     * @return Immobiliair
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }


    /**
     * Set geoLat
     *
     * @param integer $geoLat
     *
     * @return Immobiliair
     */
    public function setGeoLat($geoLat)
    {
        $this->geoLat = $geoLat;

        return $this;
    }

    /**
     * Get geoLat
     *
     * @return integer
     */
    public function getGeoLat()
    {
        return $this->geoLat;
    }

    /**
     * Set geoLong
     *
     * @param integer $geoLong
     *
     * @return Immobiliair
     */
    public function setGeoLong($geoLong)
    {
        $this->geoLong = $geoLong;

        return $this;
    }

    /**
     * Get geoLong
     *
     * @return integer
     */
    public function getGeoLong()
    {
        return $this->geoLong;
    }

    /**
     * Set statu
     *
     * @param integer $statu
     *
     * @return Immobiliair
     */
    public function setStatu($statu)
    {
        $this->statu = $statu;

        return $this;
    }

    /**
     * Get statu
     *
     * @return integer
     */
    public function getStatu()
    {
        return $this->statu;
    }
    /**
     * Set prix
     *
     * @param integer $prix
     *
     * @return Immobiliair
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
     * Set cuisineEquipee
     *
     * @param integer $cuisineEquipee
     *
     * @return Immobiliair
     */
    public function setCuisineEquipee($cuisineEquipee)
    {
        $this->cuisineEquipee = $cuisineEquipee;

        return $this;
    }

    /**
     * Get cuisineEquipee
     *
     * @return integer
     */
    public function getCuisineEquipee()
    {
        return $this->cuisineEquipee;
    }

    /**
     * Set sallon
     *
     * @param integer $sallon
     *
     * @return Immobiliair
     */
    public function setSallon($sallon)
    {
        $this->sallon = $sallon;

        return $this;
    }

    /**
     * Get sallon
     *
     * @return integer
     */
    public function getSallon()
    {
        return $this->sallon;
    }

    /**
     * Set suits
     *
     * @param integer $suits
     *
     * @return Immobiliair
     */
    public function setSuits($suits)
    {
        $this->suits = $suits;

        return $this;
    }

    /**
     * Get suits
     *
     * @return integer
     */
    public function getSuits()
    {
        return $this->suits;
    }

    /**
     * Set salleDeBain
     *
     * @param integer $salleDeBain
     *
     * @return Immobiliair
     */
    public function setSalleDeBain($salleDeBain)
    {
        $this->salleDeBain = $salleDeBain;

        return $this;
    }

    /**
     * Get salleDeBain
     *
     * @return integer
     */
    public function getSalleDeBain()
    {
        return $this->salleDeBain;
    }

    /**
     * Set ascenseur
     *
     * @param integer $ascenseur
     *
     * @return Immobiliair
     */
    public function setAscenseur($ascenseur)
    {
        $this->ascenseur = $ascenseur;

        return $this;
    }

    /**
     * Get ascenseur
     *
     * @return integer
     */
    public function getAscenseur()
    {
        return $this->ascenseur;
    }

    /**
     * Set archive
     *
     * @param integer $archive
     *
     * @return Immobiliair
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;

        return $this;
    }

    /**
     * Get archive
     *
     * @return integer
     */
    public function getArchive()
    {
        return $this->archive;
    }

    /**
     * Set equipment
     *
     * @param text $equipment
     *
     * @return Immobiliair
     */
    public function setEquipment($equipment)
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * Get equipment
     *
     * @return text
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * Set details
     *
     * @param integer $details
     *
     * @return Immobiliair
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return integer
     */
    public function getDetails()
    {
        return $this->details;
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
}

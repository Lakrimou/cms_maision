<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Locationvoiture
 *
 * @ORM\Table(name="locationVoiture", indexes={@ORM\Index(name="FK_locationVoiture_QOUIQUI", columns={"quoiqui_id"}), @ORM\Index(name="FK_locationVoiture_Model", columns={"model_id"})})
 * @ORM\Entity
 */
class LocationVoiture
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
     * @ORM\Column(name="serie", type="string", length=50, nullable=false)
     */
    private $serie;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_place", type="integer", nullable=true)
     */
    private $nbrPlace;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_jour", type="float", precision=10, scale=0, nullable=true)
     */
    private $prixJour;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=50, nullable=true)
     */
    private $statut;

    /**
     * @var string
     *
     * @ORM\Column(name="tarif", type="text", nullable=true)
     */
    private $tarif;

    /**
     * @var integer
     *
     * @ORM\Column(name="porte", type="integer", nullable=true)
     */
    private $porte;

    /**
     * @var string
     *
     * @ORM\Column(name="energy", type="string", length=50, nullable=true)
     */
    private $energy;

    /**
     * @var integer
     *
     * @ORM\Column(name="model_year", type="integer", nullable=true)
     */
    private $modelYear;

    /**
     * @var float
     *
     * @ORM\Column(name="kiloW", type="float", precision=10, scale=0, nullable=true)
     */
    private $kilow;

    /**
     * @var integer
     *
     * @ORM\Column(name="fiscal_power", type="integer", nullable=true)
     */
    private $fiscalPower;

    /**
     * @var float
     *
     * @ORM\Column(name="mileage", type="float", precision=10, scale=0, nullable=true)
     */
    private $mileage;

    /**
     * @var integer
     *
     * @ORM\Column(name="petitValises", type="integer", nullable=true)
     */
    private $petitvalises;

    /**
     * @var integer
     *
     * @ORM\Column(name="grandvalises", type="integer", nullable=true)
     */
    private $grandvalises;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="boite", type="string", length=50, nullable=true)
     */
    private $boite;

    /**
     * @var integer
     *
     * @ORM\Column(name="conducteur", type="integer", nullable=true)
     */
    private $conducteur;

    /**
     * @var integer
     *
     * @ORM\Column(name="sieges", type="integer", nullable=true)
     */
    private $sieges;

    /**
     * @var integer
     *
     * @ORM\Column(name="aire", type="integer", nullable=true)
     */
    private $aire;

//    /**
//     * @var \DateTime
//     *
//     * @ORM\Column(name="dateprise", type="datetime", nullable=true)
//     */
//    private $dateprise;

//    /**
//     * @var string
//     *
//     * @ORM\Column(name="lieuprise", type="string", length=50, nullable=true)
//     */
//    private $lieuprise;

//    /**
//     * @var \DateTime
//     *
//     * @ORM\Column(name="dateremise", type="datetime", nullable=true)
//     */
//    private $dateremise;

//    /**
//     * @var string
//     *
//     * @ORM\Column(name="lieuremise", type="string", length=50, nullable=true)
//     */
//    private $lieuremise;

    /**
     * @var integer
     *
     * @ORM\Column(name="gps", type="integer", nullable=true)
     */
    private $gps;

    /**
     * @var \Model
     *
     * @ORM\ManyToOne(targetEntity="Model")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     * })
     */
    private $model;

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
     * @return \Qouiqui
     */
    public function getQouiqui()
    {
        return $this->qouiqui;
    }

    /**
     * @param \Qouiqui $qouiqui
     */
    public function setQouiqui($qouiqui)
    {
        $this->qouiqui = $qouiqui;
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
     * Set serie
     *
     * @param string $serie
     *
     * @return Locationvoiture
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get serie
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set nbrPlace
     *
     * @param integer $nbrPlace
     *
     * @return Locationvoiture
     */
    public function setNbrPlace($nbrPlace)
    {
        $this->nbrPlace = $nbrPlace;

        return $this;
    }

    /**
     * Get nbrPlace
     *
     * @return integer
     */
    public function getNbrPlace()
    {
        return $this->nbrPlace;
    }

    /**
     * Set prixJour
     *
     * @param float $prixJour
     *
     * @return Locationvoiture
     */
    public function setPrixJour($prixJour)
    {
        $this->prixJour = $prixJour;

        return $this;
    }

    /**
     * Get prixJour
     *
     * @return float
     */
    public function getPrixJour()
    {
        return $this->prixJour;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Locationvoiture
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set tarif
     *
     * @param string $tarif
     *
     * @return Locationvoiture
     */
    public function setTarif($tarif)
    {
        $this->tarif = $tarif;

        return $this;
    }

    /**
     * Get tarif
     *
     * @return string
     */
    public function getTarif()
    {
        return $this->tarif;
    }

    /**
     * Set porte
     *
     * @param integer $porte
     *
     * @return Locationvoiture
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
     * Set energy
     *
     * @param string $energy
     *
     * @return Locationvoiture
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
     * Set modelYear
     *
     * @param integer $modelYear
     *
     * @return Locationvoiture
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
     * Set kilow
     *
     * @param float $kilow
     *
     * @return Locationvoiture
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
     * @return Locationvoiture
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
     * Set mileage
     *
     * @param float $mileage
     *
     * @return Locationvoiture
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
     * Set petitvalises
     *
     * @param integer $petitvalises
     *
     * @return Locationvoiture
     */
    public function setPetitvalises($petitvalises)
    {
        $this->petitvalises = $petitvalises;

        return $this;
    }

    /**
     * Get petitvalises
     *
     * @return integer
     */
    public function getPetitvalises()
    {
        return $this->petitvalises;
    }

    /**
     * Set grandvalises
     *
     * @param integer $grandvalises
     *
     * @return Locationvoiture
     */
    public function setGrandvalises($grandvalises)
    {
        $this->grandvalises = $grandvalises;

        return $this;
    }

    /**
     * Get grandvalises
     *
     * @return integer
     */
    public function getGrandvalises()
    {
        return $this->grandvalises;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Locationvoiture
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     * Set boite
     *
     * @param string $boite
     *
     * @return Locationvoiture
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
     * Set conducteur
     *
     * @param integer $conducteur
     *
     * @return Locationvoiture
     */
    public function setConducteur($conducteur)
    {
        $this->conducteur = $conducteur;

        return $this;
    }

    /**
     * Get conducteur
     *
     * @return integer
     */
    public function getConducteur()
    {
        return $this->conducteur;
    }

    /**
     * Set sieges
     *
     * @param integer $sieges
     *
     * @return Locationvoiture
     */
    public function setSieges($sieges)
    {
        $this->sieges = $sieges;

        return $this;
    }

    /**
     * Get sieges
     *
     * @return integer
     */
    public function getSieges()
    {
        return $this->sieges;
    }

    /**
     * Set aire
     *
     * @param integer $aire
     *
     * @return Locationvoiture
     */
    public function setAire($aire)
    {
        $this->aire = $aire;

        return $this;
    }

    /**
     * Get aire
     *
     * @return integer
     */
    public function getAire()
    {
        return $this->aire;
    }

//    /**
//     * Set dateprise
//     *
//     * @param \DateTime $dateprise
//     *
//     * @return Locationvoiture
//     */
//    public function setDateprise($dateprise)
//    {
//        $this->dateprise = $dateprise;
//
//        return $this;
//    }
//
//    /**
//     * Get dateprise
//     *
//     * @return \DateTime
//     */
//    public function getDateprise()
//    {
//        return $this->dateprise;
//    }

//    /**
//     * Set lieuprise
//     *
//     * @param string $lieuprise
//     *
//     * @return Locationvoiture
//     */
//    public function setLieuprise($lieuprise)
//    {
//        $this->lieuprise = $lieuprise;
//
//        return $this;
//    }
//
//    /**
//     * Get lieuprise
//     *
//     * @return string
//     */
//    public function getLieuprise()
//    {
//        return $this->lieuprise;
//    }

//    /**
//     * Set dateremise
//     *
//     * @param \DateTime $dateremise
//     *
//     * @return Locationvoiture
//     */
//    public function setDateremise($dateremise)
//    {
//        $this->dateremise = $dateremise;
//
//        return $this;
//    }
//
//    /**
//     * Get dateremise
//     *
//     * @return \DateTime
//     */
//    public function getDateremise()
//    {
//        return $this->dateremise;
//    }

//    /**
//     * Set lieuremise
//     *
//     * @param string $lieuremise
//     *
//     * @return Locationvoiture
//     */
//    public function setLieuremise($lieuremise)
//    {
//        $this->lieuremise = $lieuremise;
//
//        return $this;
//    }
//
//    /**
//     * Get lieuremise
//     *
//     * @return string
//     */
//    public function getLieuremise()
//    {
//        return $this->lieuremise;
//    }

    /**
     * Set gps
     *
     * @param integer $gps
     *
     * @return Locationvoiture
     */
    public function setGps($gps)
    {
        $this->gps = $gps;

        return $this;
    }

    /**
     * Get gps
     *
     * @return integer
     */
    public function getGps()
    {
        return $this->gps;
    }

    /**
     * Set model
     *
     * @param \AdminBundle\Entity\Model $model
     *
     * @return Locationvoiture
     */
    public function setModel(\AdminBundle\Entity\Model $model = null)
    {
        $this->model = $model;

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

}

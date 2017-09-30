<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgenceVoyage
 *
 * @ORM\Table(name="agence_voyage", indexes={@ORM\Index(name="fk_qouiqui", columns={"qouiqui_id"})})
 * @ORM\Entity
 */
class AgenceVoyage
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
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=true)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="service", type="string", length=50, nullable=true)
     */
    private $service;

    /**
     * @var string
     *
     * @ORM\Column(name="offre_name", type="string", length=50, nullable=true)
     */
    private $offreName;

    /**
     * @var string
     *
     * @ORM\Column(name="depart_place", type="string", length=50, nullable=true)
     */
    private $departPlace;

    /**
     * @var string
     *
     * @ORM\Column(name="retour_place", type="string", length=50, nullable=true)
     */
    private $retourPlace;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_depart", type="string", nullable=true)
     */
    private $dateDepart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_retour", type="string", nullable=true)
     */
    private $dateRetour;

    /**
     * @var string
     *
     * @ORM\Column(name="cabine", type="string", length=50, nullable=true)
     */
    private $cabine;

    /**
     * @var string
     *
     * @ORM\Column(name="nbr_escale", type="string", length=50, nullable=true)
     */
    private $nbrEscale;

    /**
     * @var string
     *
     * @ORM\Column(name="boat_plane_model", type="string", length=50, nullable=true)
     */
    private $boatPlaneModel;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;

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
     * @param float $prix
     *
     * @return AgenceVoyage
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set service
     *
     * @param string $service
     *
     * @return AgenceVoyage
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return AgenceVoyage
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * Set offreName
     *
     * @param string $offreName
     *
     * @return AgenceVoyage
     */
    public function setOffreName($offreName)
    {
        $this->offreName = $offreName;

        return $this;
    }

    /**
     * Get offreName
     *
     * @return string
     */
    public function getOffreName()
    {
        return $this->offreName;
    }

    /**
     * Set departPlace
     *
     * @param string $departPlace
     *
     * @return AgenceVoyage
     */
    public function setDepartPlace($departPlace)
    {
        $this->departPlace = $departPlace;

        return $this;
    }

    /**
     * Get departPlace
     *
     * @return string
     */
    public function getDepartPlace()
    {
        return $this->departPlace;
    }

    /**
     * Set retourPlace
     *
     * @param string $retourPlace
     *
     * @return AgenceVoyage
     */
    public function setRetourPlace($retourPlace)
    {
        $this->retourPlace = $retourPlace;

        return $this;
    }

    /**
     * Get retourPlace
     *
     * @return string
     */
    public function getRetourPlace()
    {
        return $this->retourPlace;
    }

    /**
     * Set dateDepart
     *
     * @param \DateTime $dateDepart
     *
     * @return AgenceVoyage
     */
    public function setDateDepart($dateDepart)
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    /**
     * Get dateDepart
     *
     * @return \DateTime
     */
    public function getDateDepart()
    {
        return $this->dateDepart;
    }

    /**
     * Set dateRetour
     *
     * @param \DateTime $dateRetour
     *
     * @return AgenceVoyage
     */
    public function setDateRetour($dateRetour)
    {
        $this->dateRetour = $dateRetour;

        return $this;
    }

    /**
     * Get dateRetour
     *
     * @return \DateTime
     */
    public function getDateRetour()
    {
        return $this->dateRetour;
    }

    /**
     * Set cabine
     *
     * @param string $cabine
     *
     * @return AgenceVoyage
     */
    public function setCabine($cabine)
    {
        $this->cabine = $cabine;

        return $this;
    }

    /**
     * Get cabine
     *
     * @return string
     */
    public function getCabine()
    {
        return $this->cabine;
    }

    /**
     * Set nbrEscale
     *
     * @param string $nbrEscale
     *
     * @return AgenceVoyage
     */
    public function setNbrEscale($nbrEscale)
    {
        $this->nbrEscale = $nbrEscale;

        return $this;
    }

    /**
     * Get nbrEscale
     *
     * @return string
     */
    public function getNbrEscale()
    {
        return $this->nbrEscale;
    }

    /**
     * Set boatPlaneModel
     *
     * @param string $boatPlaneModel
     *
     * @return AgenceVoyage
     */
    public function setBoatPlaneModel($boatPlaneModel)
    {
        $this->boatPlaneModel = $boatPlaneModel;

        return $this;
    }

    /**
     * Get boatPlaneModel
     *
     * @return string
     */
    public function getBoatPlaneModel()
    {
        return $this->boatPlaneModel;
    }

    /**
     * Set qouiqui
     *
     * @param \AdminBundle\Entity\Qouiqui $qouiqui
     *
     * @return AgenceVoyage
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

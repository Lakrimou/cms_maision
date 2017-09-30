<?php
/**
 * Created by PhpStorm.
 * User: POSTE 7
 * Date: 11/07/2017
 * Time: 16:46
 */

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModECommerce
 *
 * @ORM\Table(name="centre_formation", indexes={@ORM\Index(name="FK_cformation_qouiqui", columns={"qouiqui_id"})})
 * @ORM\Entity
 */
class CentreFormation
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
     * @ORM\JoinColumn(name="QOUIQUI_id", referencedColumnName="id")
     */
    private $qouiqui;

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }
    /**
     * @param string $date
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="string", length=1024, nullable=true)
     */
    private $data;

    /**
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param string $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="string", length=1024, nullable=true)
     */
    private $prix;
    /**
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getTitresection()
    {
        return $this->titresection;
    }

    /**
     * @param string $titresection
     */
    public function setTitresection($titresection)
    {
        $this->titresection = $titresection;
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
     * @param string $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="section", type="string", length=50, nullable=false)
     */
    private $section;
    /**
     * @var string
     *
     * @ORM\Column(name="titre_section", type="string", length=50, nullable=false)
     */
    private $titresection;
    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=1024, nullable=true)
     */
    private $date;

    /**
     * @return string
     */
    public function getTraineur()
    {
        return $this->traineur;
    }

    /**
     * @param string $traineur
     */
    public function setTraineur($traineur)
    {
        $this->traineur = $traineur;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;
    /**
     * @var string
     *
     * @ORM\Column(name="traineur", type="string", length=255, nullable=false)
     */
    private $traineur;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
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
     * @return CentreFormation
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
<?php
/**
 * Created by PhpStorm.
 * User: POSTE 7
 * Date: 15/05/2017
 * Time: 12:05
 */

namespace AdminBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 *Spa
 *
 * @ORM\Table(name="spa", indexes={@ORM\Index(name="fk_qouiqui_idx", columns={"QOUIQUI_id"})})
 *@ORM\Entity
 */
class Spa
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
     * @ORM\Column(name="designation", type="string", length=255, nullable=false)
     */
    private $designation;
    /**
     * @var string
     *
     * @ORM\Column(name="sdesignation", type="string", length=255, nullable=false)
     */
    private $sdesignation;
    /**
     * @var string
     *
     * @ORM\Column(name="data", type="text", length=65535, nullable=false)
     */
    private $data;
    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="string", length=255, nullable=true)
     */
    private $prix;
    /**
     * @return string
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * @param string $couleur
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }
    /**
 * Set qouiqui
 *
 * @param \AdminBundle\Entity\Qouiqui $qouiqui
 *
 * @return Spa
 */
    public function setQouiqui (\AdminBundle\Entity\Qouiqui $qouiqui = null) {
        $this->qouiqui = $qouiqui;

        return $this;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="couleur", type="string", nullable=true)
     */
    private $couleur;
    /**
     * Get qouiqui
     *
     * @return \AdminBundle\Entity\Qouiqui
     */
    public function getQouiqui() {
        return $this->qouiqui;
    }

    /**
     * Set section
     *
     * @param string $section
     *
     * @return Spa
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
     * @return Spa
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
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * @param string $designation
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    /**
     * @return string
     */
    public function getSdesignation()
    {
        return $this->sdesignation;
    }

    /**
     * @param string $sdesignation
     */
    public function setSdesignation($sdesignation)
    {
        $this->sdesignation = $sdesignation;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }
    /**
     * Set prix
     *
     * @param string $prix
     *
     * @return Spa
     */
    public function setPrix($prix) {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix() {
        return $this->prix;
    }



}
<?php

namespace AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Qouiqui
 *
 * @ORM\Table(name="QOUIQUI", indexes={@ORM\Index(name="fk_QOUIQUI_fos_user1_idx", columns={"fos_user_id"})})
 * @ORM\Entity(repositoryClass="AdminBundle\Entity\QouiquiRepository")
 */
class Qouiqui
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
     * @ORM\Column(name="sociaux", type="string", length=80, nullable=false)
     */
    private $sociaux;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=80, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="string", length=80, nullable=false)
     */
    private $details;

    /**
     * @var etat
     *
     * @ORM\Column(name="etat", type="integer", length=1, nullable=false)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="statu", type="string", length=1, nullable=false)
     */
    private $statu;

    /**
     * @var statu
     *
     * @ORM\Column(name="first_name", type="string", length=1, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=45, nullable=false)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="address1", type="string", length=200, nullable=true)
     */
    private $address1;

    /**
     * @var string
     *
     * @ORM\Column(name="adress2", type="string", length=100, nullable=true)
     */
    private $adress2;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=45, nullable=true)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=45, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="phone2", type="string", length=45, nullable=true)
     */
    private $phone2;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=100, nullable=true)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="geo_lat", type="string", length=45, nullable=true)
     */
    private $geoLat;

    /**
     * @var string
     *
     * @ORM\Column(name="geo_long", type="string", length=45, nullable=true)
     */
    private $geoLong;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="string", length=1024, nullable=true)
     */
    private $data;

    /**
     * @var string
     *
     * @ORM\Column(name="video", type="string", length=100, nullable=true)
     */
    private $video;

    /**
     * @var string
     *
     * @ORM\Column(name="opening", type="string", length=800, nullable=true)
     */
    private $opening;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;


    /**
     * @var integer
     *
     * @ORM\Column(name="isview", type="integer", length=2, nullable=true)
     */
    private $isview;


    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="fos_user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $qvilles
     * @ORM\OneToMany(targetEntity="Qville", cascade={"all"} , fetch="EAGER" ,mappedBy="qouiqui")
     */
    public $qvilles;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $ngns
     * @ORM\OneToMany(targetEntity="Ngn", cascade={"all"}, fetch="EAGER" ,mappedBy="qouiqui")
     */
    public $ngns;


    /**
     * @var string
     *
     * @ORM\Column(name="numRegistre", type="string", length=40, nullable=true)
     */
    private $numRegistre;

    /**
     * @var string
     *
     * @ORM\Column(name="numPatente", type="string", length=40, nullable=true)
     */
    private $numPatente;


    /**
     * @var string
     *
     * @ORM\Column(name="shortDescription", type="string", length=160, nullable=true)
     */
    private $shortDescription;


    public function __construct()
    {
        $this->ngns = new ArrayCollection();
        $this->qvilles = new ArrayCollection();

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
     * Set statu
     *
     * @param integer $statu
     *
     * @return Statu
     */
    public function setStatu($statu)
    {
        $this->slug = $statu;

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
     * Set etat
     *
     * @param integer $etat
     *
     * @return Etat
     */
    public function setEtat($etat)
    {
        $this->slug = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return integer
     */
    public function getEtat()
    {
        return $this->etat;
    }


    /**
     * Set data
     *
     * @param string $data
     *
     * @return Immobiliair
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
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Qouiqui
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }


    /**
     * Get sociaux
     *
     * @return integer
     */
    public function getSociaux()
    {
        return $this->sociaux;
    }

    /**
     * Set sociaux
     *
     * @param string $sociaux
     *
     * @return Sociaux
     */
    public function setSociaux($sociaux)
    {
        $this->sociaux = $sociaux;

        return $this;
    }


    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Qouiqui
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Qouiqui
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set address1
     *
     * @param string $address1
     *
     * @return Qouiqui
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get address1
     *
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set adress2
     *
     * @param string $adress2
     *
     * @return Qouiqui
     */
    public function setAdress2($adress2)
    {
        $this->adress2 = $adress2;

        return $this;
    }

    /**
     * Get adress2
     *
     * @return string
     */
    public function getAdress2()
    {
        return $this->adress2;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return Qouiqui
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return Qouiqui
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Qouiqui
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set phone2
     *
     * @param string $phone2
     *
     * @return Qouiqui
     */
    public function setPhone2($phone2)
    {
        $this->phone2 = $phone2;

        return $this;
    }

    /**
     * Get phone2
     *
     * @return string
     */
    public function getPhone2()
    {
        return $this->phone2;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Qouiqui
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set geoLat
     *
     * @param string $geoLat
     *
     * @return Qouiqui
     */
    public function setGeoLat($geoLat)
    {
        $this->geoLat = $geoLat;

        return $this;
    }

    /**
     * Get geoLat
     *
     * @return string
     */
    public function getGeoLat()
    {
        return $this->geoLat;
    }

    /**
     * Set geoLong
     *
     * @param string $geoLong
     *
     * @return Qouiqui
     */
    public function setGeoLong($geoLong)
    {
        $this->geoLong = $geoLong;

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
     * Set details
     *
     * @param string $details
     *
     * @return Qouiqui
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get geoLong
     *
     * @return string
     */
    public function getGeoLong()
    {
        return $this->geoLong;
    }

    /**
     * Set opening
     *
     * @param string $opening
     *
     * @return Qouiqui
     */
    public function setOpening($opening)
    {
        $this->opening = $opening;

        return $this;
    }

    /**
     * Get opening
     *
     * @return string
     */
    public function getOpening()
    {
        return $this->opening;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Qouiqui
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set user
     *
     * @param \AdminBundle\Entity\User $user
     *
     * @return Qouiqui
     */
    public function setUser(\AdminBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AdminBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getIsview()
    {
        return $this->isview;
    }

    /**
     * @param int $isview
     */
    public function setIsview($isview)
    {
        $this->isview = $isview;
    }


    /**
     * Get ngns
     *
     * @return \AdminBundle\Entity\Ngn
     */
    public function getNgns()
    {
        return $this->ngns;
    }


    /**
     * Add ngn
     *
     * @param \AdminBundle\Entity\Ngn $ngn
     * @return Qouiqui
     */
    public function addNgn(\AdminBundle\Entity\Ngn $Qville)
    {
        $this->qvilles[] = $Qville;

        return $this;
    }

    /**
     * Remove ngn
     *
     * @param \AdminBundle\Entity\Ngn $ngn
     */
    public function removeNgn(\AdminBundle\Entity\Ngn $Qville)
    {
        $this->qvilles->removeElement($Qville);
    }

    /**
     * Get qvilles
     *
     * @return \AdminBundle\Entity\Ngn
     */
    public function getQville()
    {
        return $this->qvilles;
    }


    /**
     * Add ngn
     *
     * @param \AdminBundle\Entity\Ngn $ngn
     * @return Qouiqui
     */
    public function addQville(\AdminBundle\Entity\Ngn $Qville)
    {
        $this->qvilles[] = $Qville;

        return $this;
    }

    /**
     * Remove ngn
     *
     * @param \AdminBundle\Entity\Ngn $ngn
     */
    public function removeQville(\AdminBundle\Entity\Ngn $ngn)
    {
        $this->ngns->removeElement($ngn);
    }


    public function __toString()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param string $video
     */
    public function setVideo($video)
    {
        $this->video = $video;
    }

    /**
     * @return string
     */
    public function getNumRegistre()
    {
        return $this->numRegistre;
    }

    /**
     * @param string $numRegistre
     */
    public function setNumRegistre($numRegistre)
    {
        $this->numRegistre = $numRegistre;
    }

    /**
     * @return string
     */
    public function getNumPatente()
    {
        return $this->numPatente;
    }

    /**
     * @param string $numPatente
     */
    public function setNumPatente($numPatente)
    {
        $this->numPatente = $numPatente;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }



}

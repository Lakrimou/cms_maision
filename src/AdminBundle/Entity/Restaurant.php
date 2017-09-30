<?php
namespace AdminBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Restaurant
 *
 * @ORM\Table(name="restaurant", indexes={@ORM\Index(name="FK1_qouiqui_restaurant", columns={"qouiqui_id"})})
 * @ORM\Entity
 */
class Restaurant
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
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @var \Qouiqui
     *
     * @ORM\ManyToOne(targetEntity="Qouiqui")
     * @ORM\JoinColumn(name="qouiqui_id", referencedColumnName="id")
     */
    private $qouiqui;

    /**
     * Set qouiqui
     *
     * @param \AdminBundle\Entity\Qouiqui $qouiqui
     *
     * @return Hotel
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
     * @var string
     *
     * @ORM\Column(name="nom", type="text", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", nullable=true)
     */
    private $prix;

    /**
     * @var text
     *
     * @ORM\Column(name="contenu", type="text",length=65535, nullable=true)
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string",length=255, nullable=true)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string",length=255, nullable=true)
     */
    private $category;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ajouter", type="datetime",nullable=true)
     */
    private $dateAjouter;

    /**
     * @var string
     *
     * @ORM\Column(name="about", type="text", length=65535, nullable=true)
     */
    private $about;

    /**
     * @var string
     *
     * @ORM\Column(name="galerie", type="text", length=65535, nullable=true)
     */
    private $galerie;

    /**
     * @var string
     *
     * @ORM\Column(name="video", type="text", length=65535, nullable=true)
     */
    private $video;

    /**
     * @var string
     *
     * @ORM\Column(name="menu", type="text", length=65535, nullable=true)
     */
    private $menu;

    /**
     * @var string
     *
     * @ORM\Column(name="team", type="text", length=65535, nullable=true)
     */
    private $team;

    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="text", length=65535, nullable=true)
     */
    private $contact;


    /**
     * @var string
     *
     * @ORM\Column(name="welcome", type="text", length=65535, nullable=true)
     */
    private $welcome;


    /**
     * Set welcome
     *
     * @param string $welcome
     *
     * @return Restaurant
     */
    public function setWelcome($welcome)
    {
        $this->welcome = $welcome;

        return $this;
    }

    /**
     * Get welcome
     *
     * @return string
     */
    public function getWelcome()
    {
        return $this->welcome;
    }

    /**
     * Set about
     *
     * @param string $about
     *
     * @return Restaurant
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Set galerie
     *
     * @param string $galerie
     *
     * @return Restaurant
     */
    public function setGalerie($galerie)
    {
        $this->galerie = $galerie;

        return $this;
    }

    /**
     * Get galerie
     *
     * @return string
     */
    public function getGalerie()
    {
        return $this->galerie;
    }

    /**
     * Set video
     *
     * @param string $video
     *
     * @return Restaurant
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set menu
     *
     * @param string $menu
     *
     * @return Restaurant
     */
    public function setMenu($menu)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return string
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set team
     *
     * @param string $team
     *
     * @return Restaurant
     */
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get menu
     *
     * @return string
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set contact
     *
     * @param string $contact
     *
     * @return Restaurant
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
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
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * @param string $contenu
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
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
    public function getDateAjouter()
    {
        return $this->dateAjouter;
    }

    /**
     * @param \DateTime $dateAjouter
     */
    public function setDateAjouter($dateAjouter)
    {
        $this->dateAjouter = $dateAjouter;
    }


    public function __construct()
    {
        $this->dateAjouter= new \DateTime();
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
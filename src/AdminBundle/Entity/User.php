<?php
// src/AdminBundle/Entity/User.php

namespace AdminBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_naissance", type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(name="adress", type="string", length=1024, nullable=true)
     */
    private $adress;

    /**
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(name="phone_number", type="string", length=255, nullable=true)
     */
    private $phoneNumber;


    /** @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) */
    protected $facebook_id;
    /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
    protected $facebook_access_token;
    /** @ORM\Column(name="google_id", type="string", length=255, nullable=true) */
    protected $google_id;
    /** @ORM\Column(name="google_access_token", type="string", length=255, nullable=true) */
    protected $google_access_token;


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     *
     * @param \String $id
     *
     * @return User
     */
    public function setId($id)
    {
        $this->prenom = $id;
        return $this;
    }

    /**
     * return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param \String $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return User
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * @param string $adress
     * return User
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;
        return $this;
    }

    /**
     * return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * @param string $image
     * return User
     *
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $phoneNumber
     * return User
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set google_id
     *
     * @param string $google_id
     *
     * @return User
     */

    public function setGoogleId($google_id)
    {
        $this->google_id = $google_id;
        return $this;
    }


    /**
     * Set facebook_id
     *
     * @param string $facebook_id
     *
     * @return User
     */

    public function setFacebookId($facebook_id)
    {
        $this->facebook_id = $facebook_id;
        return $this;
    }

    /**
     * return string
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

}

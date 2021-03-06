<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @ORM\Table(name="CAR", indexes={@ORM\Index(name="FK1_qouiqui_car", columns={"qouiqui_id"})})
 * @ORM\Entity
 */
class Car
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
     * @var \DateTime
     *
     * @ORM\Column(name="model_year", type="date", nullable=false)
     */
    private $modelYear;

    /**
     * @var string
     *
     * @ORM\Column(name="mark", type="string", length=127, nullable=false)
     */
    private $mark;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=127, nullable=false)
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="mileage", type="string", length=127, nullable=false)
     */
    private $mileage;

    /**
     * @var integer
     *
     * @ORM\Column(name="energy", type="integer", nullable=false)
     */
    private $energy;

    /**
     * @var string
     *
     * @ORM\Column(name="fiscal_power", type="string", length=127, nullable=false)
     */
    private $fiscalPower;

    /**
     * @var string
     *
     * @ORM\Column(name="images", type="string", length=127, nullable=false)
     */
    private $images;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="text", length=65535, nullable=false)
     */
    private $details;

    /**
     * @var string
     *
     * @ORM\Column(name="other", type="text", length=65535, nullable=false)
     */
    private $other;

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
     * Set modelYear
     *
     * @param \DateTime $modelYear
     *
     * @return Car
     */
    public function setModelYear($modelYear)
    {
        $this->modelYear = $modelYear;

        return $this;
    }

    /**
     * Get modelYear
     *
     * @return \DateTime
     */
    public function getModelYear()
    {
        return $this->modelYear;
    }

    /**
     * Set mark
     *
     * @param string $mark
     *
     * @return Car
     */
    public function setMark($mark)
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * Get mark
     *
     * @return string
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return Car
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set mileage
     *
     * @param string $mileage
     *
     * @return Car
     */
    public function setMileage($mileage)
    {
        $this->mileage = $mileage;

        return $this;
    }

    /**
     * Get mileage
     *
     * @return string
     */
    public function getMileage()
    {
        return $this->mileage;
    }

    /**
     * Set energy
     *
     * @param integer $energy
     *
     * @return Car
     */
    public function setEnergy($energy)
    {
        $this->energy = $energy;

        return $this;
    }

    /**
     * Get energy
     *
     * @return integer
     */
    public function getEnergy()
    {
        return $this->energy;
    }

    /**
     * Set fiscalPower
     *
     * @param string $fiscalPower
     *
     * @return Car
     */
    public function setFiscalPower($fiscalPower)
    {
        $this->fiscalPower = $fiscalPower;

        return $this;
    }

    /**
     * Get fiscalPower
     *
     * @return string
     */
    public function getFiscalPower()
    {
        return $this->fiscalPower;
    }

    /**
     * Set images
     *
     * @param string $images
     *
     * @return Car
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return string
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set details
     *
     * @param string $details
     *
     * @return Car
     */
    public function setDetails($details)
    {
        $this->details = $details;

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
     * Set other
     *
     * @param string $other
     *
     * @return Car
     */
    public function setOther($other)
    {
        $this->other = $other;

        return $this;
    }

    /**
     * Get other
     *
     * @return string
     */
    public function getOther()
    {
        return $this->other;
    }

    /**
     * Set qouiqui
     *
     * @param \AdminBundle\Entity\Qouiqui $qouiqui
     *
     * @return Car
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

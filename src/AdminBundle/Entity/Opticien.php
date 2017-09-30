<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 */
class Opticien
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
     * @var \Qouiqui
     *
     * @ORM\ManyToOne(targetEntity="Qouiqui")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="qouiqui", referencedColumnName="id")
     * })
     */
    private $qouiqui;
    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="text", nullable=true)
     */
    private $reference;
    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=true)
     */
    private $price;
    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;
    /**
     * @var \ModelOptician
     *
     * @ORM\ManyToOne(targetEntity="ModelOptician")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="model", referencedColumnName="id")
     * })
     */
    private $model;



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
     * @return Opticien
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
     * Set price
     *
     * @param float $price
     *
     * @return Opticien
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }
    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Opticien
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }
    /**
     * Set Model
     *
     * @param \AdminBundle\Entity\ModelOptician $model
     *
     * @return Opticien
     */
    public function setModel(\AdminBundle\Entity\ModelOptician $model = null)
    {
        $this->model= $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return \AdminBundle\Entity\ModelOptician
     */
    public function getModel()
    {
        return $this->model;
    }
    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Opticien
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

}

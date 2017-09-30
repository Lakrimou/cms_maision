<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lentils
 *
 *
 * @ORM\Entity
 */
class Lentils extends Opticien
{

    /**
     * @var float
     *
     * @ORM\Column(name="sphere", type="float", precision=10, scale=0, nullable=true)
     */
    private $sphere = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="diameter", type="float", precision=10, scale=0, nullable=true)
     */
    private $diameter = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="ray", type="float", precision=10, scale=0, nullable=true)
     */
    private $ray = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="addition", type="float", precision=10, scale=0, nullable=true)
     */
    private $addition = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="near", type="boolean", nullable=true)
     */
    private $near = '0';



    /**
     * @var integer
     *
     * @ORM\Column(name="number_lentils", type="integer", nullable=true)
     */
    private $numberLentils = '0';









    /**
     * Set sphere
     *
     * @param float $sphere
     *
     * @return Lentils
     */
    public function setSphere($sphere)
    {
        $this->sphere = $sphere;

        return $this;
    }

    /**
     * Get sphere
     *
     * @return float
     */
    public function getSphere()
    {
        return $this->sphere;
    }

    /**
     * Set diameter
     *
     * @param float $diameter
     *
     * @return Lentils
     */
    public function setDiameter($diameter)
    {
        $this->diameter = $diameter;

        return $this;
    }

    /**
     * Get diameter
     *
     * @return float
     */
    public function getDiameter()
    {
        return $this->diameter;
    }

    /**
     * Set ray
     *
     * @param float $ray
     *
     * @return Lentils
     */
    public function setRay($ray)
    {
        $this->ray = $ray;

        return $this;
    }

    /**
     * Get ray
     *
     * @return float
     */
    public function getRay()
    {
        return $this->ray;
    }

    /**
     * Set addition
     *
     * @param float $addition
     *
     * @return Lentils
     */
    public function setAddition($addition)
    {
        $this->addition = $addition;

        return $this;
    }

    /**
     * Get addition
     *
     * @return float
     */
    public function getAddition()
    {
        return $this->addition;
    }

    /**
     * Set near
     *
     * @param boolean $near
     *
     * @return Lentils
     */
    public function setNear($near)
    {
        $this->near = $near;

        return $this;
    }

    /**
     * Get near
     *
     * @return boolean
     */
    public function getNear()
    {
        return $this->near;
    }



    /**
     * Set numberLentils
     *
     * @param integer $numberLentils
     *
     * @return Lentils
     */
    public function setNumberLentils($numberLentils)
    {
        $this->numberLentils = $numberLentils;

        return $this;
    }

    /**
     * Get numberLentils
     *
     * @return integer
     */
    public function getNumberLentils()
    {
        return $this->numberLentils;
    }


}

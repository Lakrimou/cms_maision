<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Model
 *
 * @ORM\Table(name="Model", indexes={@ORM\Index(name="FK_Model_Mark", columns={"mark"})})
 * @ORM\Entity
 */
class Model
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
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name = '0';

    /**
     * @var \Mark
     *
     * @ORM\ManyToOne(targetEntity="Mark")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mark", referencedColumnName="id")
     * })
     */
    private $mark;



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
     * Set name
     *
     * @param string $name
     *
     * @return Model
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set mark
     *
     * @param \AdminBundle\Entity\Mark $mark
     *
     * @return Model
     */
    public function setMark(\AdminBundle\Entity\Mark $mark = null)
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * Get mark
     *
     * @return \AdminBundle\Entity\Mark
     */
    public function getMark()
    {
        return $this->mark;
    }
    public function __toString()
    {
        return $this->getName();
    }
}

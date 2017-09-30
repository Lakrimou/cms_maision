<?php
/**
 * Created by PhpStorm.
 * User: Ameni
 * Date: 06/09/2017
 * Time: 18:17
 */

namespace AdminBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * Model
 *
 * @ORM\Table(name="model_lentils", indexes={@ORM\Index(name="FK__Mark_lentils", columns={"mark"})})
 * @ORM\Entity
 */
class ModelOptician
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name = '0';

    /**
     * @var \Mark
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\MarksOptician")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mark", referencedColumnName="id")
     * })
     */
    private $mark;
    /**
     * @var string
     *
     * @ORM\Column(name="type_product", type="string", length=50, nullable=false)
     */
    private $typeProduct = 'Lentils';


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
     * @return ModelOptician
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
     * @param \AdminBundle\Entity\MarksOptician $mark
     *
     * @return ModelOptician
     */
    public function setMark(\AdminBundle\Entity\MarksOptician $mark = null)
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * Get mark
     *
     * @return \AdminBundle\Entity\MarksOptician
     */
    public function getMark()
    {
        return $this->mark;
    }
    public function __toString()
    {
        return $this->getName();
    }
    /**
     * Set typeProduct
     *
     * @param string $typeProduct
     *
     * @return ModelOptician
     */
    public function setTypeProduct ($typeProduct)
    {
        $this->typeProduct = $typeProduct;

        return $this;
    }

    /**
     * Get typeProduct
     *
     * @return string
     */
    public function getTypeProduct()
    {
        return $this->typeProduct;
    }

}
<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ngn
 * @ORM\Entity
 * @ORM\Table(name="NGN", indexes={@ORM\Index(name="fk_NGN_QOUIQUI1_idx", columns={"QOUIQUI_id"}), @ORM\Index(name="fk_NGN_SCATEGORY1_idx", columns={"SCATEGORY_id"}), @ORM\Index(name="fk_NGN_CATEGORY1_idx", columns={"CATEGORY_id"})})
 */
class Ngn
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
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CATEGORY_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var \Qouiqui
     *
     * @ORM\ManyToOne(targetEntity="Qouiqui", inversedBy="ngns" , cascade={"persist"})
     * @ORM\JoinColumn(name="QOUIQUI_id", referencedColumnName="id")
     */
    private $qouiqui;

    /**
     * @var \Scategory
     *
     * @ORM\ManyToOne(targetEntity="Scategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="SCATEGORY_id", referencedColumnName="id")
     * })
     */
    private $scategory;



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
     * Set category
     *
     * @param \AdminBundle\Entity\Category $category
     *
     * @return Ngn
     */
    public function setCategory(\AdminBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AdminBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set qouiqui
     *
     * @param \AdminBundle\Entity\Qouiqui $qouiqui
     *
     * @return Ngn
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
     * Set scategory
     *
     * @param \AdminBundle\Entity\Scategory $scategory
     *
     * @return Ngn
     */
    public function setScategory(\AdminBundle\Entity\Scategory $scategory = null)
    {
        $this->scategory = $scategory;

        return $this;
    }

    /**
     * Get scategory
     *
     * @return \AdminBundle\Entity\Scategory
     */
    public function getScategory()
    {
        return $this->scategory;
    }



}

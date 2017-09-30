<?php
/**
 * Created by PhpStorm.
 * User: Ameni
 * Date: 07/09/2017
 * Time: 14:00
 */

namespace AdminBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * Glass
 *
 * @ORM\Table(name="glass")
 * @ORM\Entity
 */
class Glass
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
     * @OneToOne(targetEntity="MountingType")
     * @JoinColumn(name="mounting_type", referencedColumnName="id")
     */
    private $typeMounting;
    /**
     * @var array
     *
     * @ORM\Column(name="type", type="array")
     */
    private $type;
    /**
     * @var array
     *
     * @ORM\Column(name="range", type="array")
     */
    private $range;
    /**
     * @var array
     *
     * @ORM\Column(name="thinning", type="array")
     */
    private $thinning;
    /**
     * @var array
     *
     * @ORM\Column(name="treatment", type="array")
     */
    private $treatment;
    public function __construct()

{
    $this->range=new ArrayCollection();
    $this->type=new ArrayCollection();
    $this->thinning=new ArrayCollection();
    $this->treatment=new ArrayCollection();
}
}
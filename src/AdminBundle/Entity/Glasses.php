<?php
/**
 * Created by PhpStorm.
 * User: Ameni
 * Date: 07/09/2017
 * Time: 13:05
 */

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Glasses
 *
 *
 * @ORM\Entity
 */
class Glasses extends Opticien
{
    /**
     * @var string
     *
     * @ORM\Column(name="descriptionColors", type="text", length=65535, nullable=false)
     */
    private $descriptionColors;
    /**
     * @var string
     *
     * @ORM\Column(name="style", type="string", length=50, nullable=false)
     */
    private $style;
    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=50, nullable=false)
     */
    private $gender;

    /**
     * @ORM\Embedded(class = "Dimentions")
     */
    private $dimentions;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;
    /**
     * @var string
     *
     * @ORM\Column(name="material", type="string", length=50, nullable=false)
     */
    private $material;
    /**
     * @var float
     *
     * @ORM\Column(name="weight", type="float", precision=10, scale=0, nullable=true)
     */
    private $weight;
    /**
     * @var string
     *
     * @ORM\Column(name="recommandedFace", type="string", length=50, nullable=false)
     */
    private $recommandedFace;
    /**
     * @ORM\ManyToOne(targetEntity="MountingType")
     * @ORM\JoinColumn(name="mounting_type", referencedColumnName="id")
     */
    private $mountingType;
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;


}
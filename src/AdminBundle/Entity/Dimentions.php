<?php
/**
 * Created by PhpStorm.
 * User: Ameni
 * Date: 07/09/2017
 * Time: 13:18
 */

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Dimentions
{
    /**
     * @var float
     *
     * @ORM\Column(name="bridge", type="float", precision=10, scale=0, nullable=true)
     */
    private $bridge;
    /**
     * @var float
     *
     * @ORM\Column(name="glassDiameter", type="float", precision=10, scale=0, nullable=true)
     */
    private $glassDiameter;
    /**
     * @var float
     *
     * @ORM\Column(name="mountingWidth", type="float", precision=10, scale=0, nullable=true)
     */
    private $mountingWidth;
}
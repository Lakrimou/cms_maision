<?php
/**
 * Created by PhpStorm.
 * User: Ameni
 * Date: 07/09/2017
 * Time: 13:58
 */

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * MountingType
 *
 * @ORM\Table(name="mounting_type")
 * @ORM\Entity
 */
class MountingType
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
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;



}
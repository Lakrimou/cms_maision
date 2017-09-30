<?php
/**
 * Created by PhpStorm.
 * User: Hatem
 * Date: 15/05/2017
 * Time: 12:06
 */

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Imprimerie
 *
 * @ORM\Table(name="Imprimerie", indexes={@ORM\Index(name="FK_Imprimerie_QOUIQUI", columns={"qouiqui_id"})})
 * @ORM\Entity
 */
class Imprimerie
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
     * @var \Qouiqui
     * @ORM\ManyToOne(targetEntity="Qouiqui",)
     * @ORM\JoinColumn(name="qouiqui_id", referencedColumnName="id")
     */
    private $qouiqui;

    /**
     * Get id
     *
     * @return integer
     */

    public function getId() {
        return $this->id;
    }

    /**
     * Set qouiqui
     *
     * @param \AdminBundle\Entity\Qouiqui $qouiqui
     *
     * @return Theme
     */
    public function setQouiqui($qouiqui)
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
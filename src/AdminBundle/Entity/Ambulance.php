<?php
/**
 * Created by PhpStorm.
 * User: POSTE 7
 * Date: 19/05/2017
 * Time: 15:28
 */

namespace AdminBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
*Ambulance
*
 * @ORM\Table(name="ambulance", indexes={@ORM\Index(name="fk_ambu_qouiqui_idx", columns={"QOUIQUI_id"})})
 *@ORM\Entity
*/
class Ambulance
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
     *
     * @ORM\ManyToOne(targetEntity="Qouiqui")
     * @ORM\JoinColumn(name="QOUIQUI_id", referencedColumnName="id")
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
     * @return Ambulance
     */
    public function setQouiqui (\AdminBundle\Entity\Qouiqui $qouiqui = null) {
        $this->qouiqui = $qouiqui;

        return $this;
    }

    /**
     * Get qouiqui
     *
     * @return \AdminBundle\Entity\Qouiqui
     */
    public function getQouiqui() {
        return $this->qouiqui;
    }
}
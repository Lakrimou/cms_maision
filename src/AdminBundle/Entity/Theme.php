<?php
/**
 * Created by PhpStorm.
 * User: POSTE 7
 * Date: 15/05/2017
 * Time: 12:06
 */

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="theme", indexes={@ORM\Index(name="fk1_qouiqui_idx", columns={"QOUIQUI_id"})})
 * @ORM\Entity
 */
class Theme
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
     * @var string
     *
     * @ORM\Column(name="data", type="string", length=1024, nullable=true)
     */
    private $data;
    /**
     * @var string
     *
     * @ORM\Column(name="event", type="string", length=1024, nullable=true)
     */
    private $event;

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
     * Set data
     *
     * @param string $data
     *
     * @return Theme
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set qouiqui
     *
     * @param \AdminBundle\Entity\Qouiqui $qouiqui
     *
     * @return Theme
     */
    public function setQouiqui(\AdminBundle\Entity\Qouiqui $qouiqui = null)
    {
        $this->qouiqui = $qouiqui;

        return $this;
    }

    /**
     * Get docteur
     *
     * @return \AdminBundle\Entity\Qouiqui
     */
    public function getQouiqui()
    {
        return $this->qouiqui;
    }


    /**
     * Set event
     *
     * @param string $event
     *
     * @return Theme
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }
}
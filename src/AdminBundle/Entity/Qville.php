<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Qville
 *
 * @ORM\Table(name="QVILLE", indexes={@ORM\Index(name="fk_QVILLE_QOUIQUI1_idx", columns={"QOUIQUI_id"}), @ORM\Index(name="fk_QVILLE_VILLE1_idx", columns={"VILLE_id"})})
 * @ORM\Entity(repositoryClass="AdminBundle\Entity\QvilleRepository")
 */
class Qville
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
     * @ORM\ManyToOne(targetEntity="Qouiqui", inversedBy="qvilles")
     * @ORM\JoinColumn(name="QOUIQUI_id", referencedColumnName="id")
     */
    private $qouiqui;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $eventss
     * @ORM\OneToMany(targetEntity="Events", cascade={"all"}, fetch="EAGER" ,mappedBy="qville")
     */
    public $eventss;

    /**
     * @var \Ville
     *
     * @ORM\ManyToOne(targetEntity="Ville")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="VILLE_id", referencedColumnName="id")
     * })
     */
    private $ville;


    /**
     * @var \Delegation
     *
     * @ORM\ManyToOne(targetEntity="Delegation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="delegation_id", referencedColumnName="id")
     * })
     */
    private $delegation;


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
     * Set qouiqui
     *
     * @param \AdminBundle\Entity\Qouiqui $qouiqui
     *
     * @return Qville
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
     *
     */
    public function getQouiqui()
    {
        return $this->qouiqui;
    }

    /**
     * Set ville
     *
     * @param \AdminBundle\Entity\Ville $ville
     *
     * @return Qville
     */
    public function setVille(\AdminBundle\Entity\Ville $ville = null)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return \AdminBundle\Entity\Ville
     */

    public function getVille()
    {
        return $this->ville;
    }


    /**
     * Set ville
     *
     * @param \AdminBundle\Entity\Delegation $delegation
     *
     * @return Qville
     */
    public function setDelegation(\AdminBundle\Entity\Delegation $delegation = null)
    {
        $this->delegation = $delegation;

        return $this;
    }

    /**
     * Get ville
     *
     * @return \AdminBundle\Entity\Delegation
     */

    public function getDelegation()
    {
        return $this->delegation;
    }








    /*
    public function __toString()
    {
        return $this->id;
    }
    */

    /**
     * Add Events
     *
     * @param \AdminBundle\Entity\Booking $events
     * @return Theme
     */
    public function addEvents(\AdminBundle\Entity\Events $events)
    {
        $this->eventss[] = $events;

        return $this;
    }

    /**
     * Remove Events
     *
     * @param \AdminBundle\Entity\Booking $events
     */
    public function removeEvents(\AdminBundle\Entity\Events $events)
    {
        $this->eventss->removeElement($events);
    }

}

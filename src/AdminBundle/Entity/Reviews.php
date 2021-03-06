<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reviews
 *
 * @ORM\Table(name="REVIEWS", indexes={@ORM\Index(name="fk_REVIEWS_QOUIQUI1_idx", columns={"QOUIQUI_id"}), @ORM\Index(name="fk_REVIEWS_EVENTS1_idx", columns={"EVENTS_id"})})
 * @ORM\Entity(repositoryClass="AdminBundle\Entity\ReviewsRepository")
 */
class Reviews
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
     * @var string
     *
     * @ORM\Column(name="review_title", type="string", length=45, nullable=true)
     */
    private $reviewTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="review_msg", type="string", length=255, nullable=true)
     */
    private $reviewMsg;

    /**
     * @var string
     *
     * @ORM\Column(name="review_note", type="string", length=45, nullable=true)
     */
    private $reviewNote;

    /**
     * @var \Events
     *
     * @ORM\ManyToOne(targetEntity="Events")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="EVENTS_id", referencedColumnName="id")
     * })
     */
    private $events;

    /**
     * @var \Qouiqui
     *
     * @ORM\ManyToOne(targetEntity="Qouiqui")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="QOUIQUI_id", referencedColumnName="id")
     * })
     */
    private $qouiqui;



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
     * Set reviewTitle
     *
     * @param string $reviewTitle
     *
     * @return Reviews
     */
    public function setReviewTitle($reviewTitle)
    {
        $this->reviewTitle = $reviewTitle;

        return $this;
    }

    /**
     * Get reviewTitle
     *
     * @return string
     */
    public function getReviewTitle()
    {
        return $this->reviewTitle;
    }

    /**
     * Set reviewMsg
     *
     * @param string $reviewMsg
     *
     * @return Reviews
     */
    public function setReviewMsg($reviewMsg)
    {
        $this->reviewMsg = $reviewMsg;

        return $this;
    }

    /**
     * Get reviewMsg
     *
     * @return string
     */
    public function getReviewMsg()
    {
        return $this->reviewMsg;
    }

    /**
     * Set reviewNote
     *
     * @param string $reviewNote
     *
     * @return Reviews
     */
    public function setReviewNote($reviewNote)
    {
        $this->reviewNote = $reviewNote;

        return $this;
    }

    /**
     * Get reviewNote
     *
     * @return string
     */
    public function getReviewNote()
    {
        return $this->reviewNote;
    }

    /**
     * Set events
     *
     * @param \AdminBundle\Entity\Events $events
     *
     * @return Reviews
     */
    public function setEvents(\AdminBundle\Entity\Events $events = null)
    {
        $this->events = $events;

        return $this;
    }

    /**
     * Get events
     *
     * @return \AdminBundle\Entity\Events
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Set qouiqui
     *
     * @param \AdminBundle\Entity\Qouiqui $qouiqui
     *
     * @return Reviews
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
}

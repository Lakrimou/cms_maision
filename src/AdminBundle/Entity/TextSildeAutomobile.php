<?php
/**
 * Created by PhpStorm.
 * User: Ameni
 * Date: 04/07/2017
 * Time: 09:11
 */

namespace AdminBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Embeddable */
class TextSildeAutomobile
{
    /** @ORM\Column(type = "string", nullable=true) */
    private $principalText;

    /** @ORM\Column(type = "string", nullable=true) */
    private $secondarText;
    /**
     * Set principalText
     *
     * @param string $principalText
     *
     * @return TextSildeAutomobile
     */
    public function setPrincipalText($principalText)
    {
        $this->principalText = $principalText;

        return $this;
    }

    /**
     * Get principalText
     *
     * @return string
     */
    public function getPrincipalText()
    {
        return $this->principalText;
    }
    /**
     * Set secondarText
     *
     * @param string $secondarText
     *
     * @return TextSildeAutomobile
     */
    public function setSecondarText($secondarText)
    {
        $this->secondarText= $secondarText;

        return $this;
    }

    /**
     * Get secondarText
     *
     * @return string
     */
    public function getSecondarText()
    {
        return $this->secondarText;
    }
}
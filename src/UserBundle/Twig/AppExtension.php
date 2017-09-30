<?php
namespace UserBundle\Twig;
/**
 * Created by PhpStorm.
 * User: POSTE 8
 * Date: 24/04/2017
 * Time: 13:00
 */
class AppExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            'eventLength' => new \Twig_Function_Method($this, 'eventLength'),
            'jsonDecod' => new \Twig_Function_Method($this, 'jsonDecod'),
        );
    }

    public function eventLength($maxCh)
    {
        if ($maxCh) {
            $maxCh = substr($maxCh, 0, 100);
            return $maxCh;
        } else
            return false;
    }


}
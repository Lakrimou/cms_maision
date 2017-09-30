<?php
/**
 * Created by PhpStorm.
 * User: POSTE 8
 * Date: 17/04/2017
 * Time: 18:08
 */

namespace UserBundle\Controller;

use AdminBundle\AdminBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AdminBundle\Entity\Qouiqui;
use AdminBundle\Entity\Pays;
use AdminBundle\Entity\ville;
use AdminBundle\Entity\Reviews;
use AdminBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class ProfileUserController extends Controller
{
    public function indexAction()
    {
        $userQ = $this->getUser();
        dump($userQ);

        return $this->render('UserBundle:Profile:index.html.twig', array(
            'user' => $userQ
        ));
    }
}
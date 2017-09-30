<?php
/**
 * Created by PhpStorm.
 * User: Hatem
 * Date: 24/04/2017
 * Time: 10:21
 */

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AdminBundle\Entity\Events;
use AdminBundle\Entity\User;
use AdminBundle\Entity\Booking;
use AdminBundle\Entity\Qville;
use AdminBundle\Entity\Qouiqui;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends Controller
{
    public function bookingAction()
    {
        $em = $this->getDoctrine()->getManager();
        $events=$em->getRepository('AdminBundle:Events')
            ->findAll();
        dump($events);
        die();
        return $this->render('UserBundle:default:index.html.twig', array(
            'events' => $events
        ));
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Hatem
 * Date: 21/04/2017
 * Time: 09:23
 */

namespace DashboardBundle\Controller;

use AdminBundle\Form\NgnNewType;
use AdminBundle\Form\EventsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AdminBundle\Entity\Category;
use AdminBundle\Entity\Ngn;
use AdminBundle\Entity\Qville;
use AdminBundle\Entity\Qouiqui;
use AdminBundle\Entity\Events;
use AdminBundle\Entity\Booking;
use AdminBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class EventsController extends controller
{
    public function afficherevAction($qq_id)
    {
        $userQuoiqui = $this->getUser();
        $qq= $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
            ->findOneBy(array('user'=>$userQuoiqui, 'id'=>$qq_id));
        if($qq){
            $events = $this->getDoctrine()->getRepository('AdminBundle:Events')->findEventsByQQ($qq_id);
        }
        return $this->render('DashboardBundle:events:index.html.twig', array(
            'user' => $userQuoiqui,
            'quoiqui'=>$qq,
            'events' => $events,
        ));
    }

    public function listePepoleBookingAction($id)
    {

        $user = $this->getUser();
        dump($user);
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
            ->findOneBy(array('id'=>$id,'user' => $user->getId()));
        dump($qq);
        //die;
        $booking = new Booking();
        $booking = $this->getDoctrine()->getRepository('AdminBundle:Booking')
            ->findBy(array('qouiqui' => $qq->getId()));
        return $this->render('DashboardBundle:events:listePepoleBooking.html.twig', array(
            'booking' => $booking
        ));
    }
}

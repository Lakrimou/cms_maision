<?php

namespace DashboardBundle\Controller;

use AdminBundle\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AdminBundle\Form\NgnNewType;
use AdminBundle\Form\EventsType;
use AdminBundle\Entity\Category;
use AdminBundle\Entity\Ngn;
use AdminBundle\Entity\Qville;
use AdminBundle\Entity\Qouiqui;
use AdminBundle\Entity\Events;
use AdminBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;


/**
 * Booking controller.
 *
 */
class BookingController extends Controller
{
    /**
     * Lists all booking entities.
     *
     */
    public function bookingAction($id)
    {
        $user=$this->getUser();
        $userQ = $this->getUser()->getId();
        $qqUser=$this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
            ->findBy(array('user'=>$userQ));
        $events = $this->getDoctrine()->getRepository('AdminBundle:Events')
            ->findOneBy(array('id' => $id));
        $qville = $events->getQville();
        $qq = $qville->getQouiqui();
        $userEvents =$qq->getUser()->getId();
        if ($userQ !== $userEvents) {
            $booking = new Booking();
            $date= new \DateTime();
            $booking->setDate($date);
            $booking->setEvents($events);
            $booking->setUser($user);
            $booking->setQouiqui($qq);
            $booking->setStatu(0);
        $em = $this->getDoctrine()->getManager();
        $em->persist($booking);
        $em->flush($booking);
        }
        else{
            die('vous ne pouvez pas réserver sur votre évenements!');
        }

        return $this->redirectToRoute('dashboard_homepage');

    }


    public function listeBookingAction(){
        $userB=$this->getUser();
        if($userB){
            $em=$this->getDoctrine()->getManager();
            $booking=$em->getRepository('AdminBundle:Booking')->findBy(array('user'=>$userB));
        }
        return $this->render('DashboardBundle:reservation:listeReservation.html.twig', array(
            'user'=>$userB,
            'booking'=>$booking
        ));
    }
}

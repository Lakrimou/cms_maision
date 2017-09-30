<?php
/**
 * Created by PhpStorm.
 * User: Hatem
 * Date: 19/04/2017
 * Time: 09:08
 */
namespace DashboardBundle\Controller;

use AdminBundle\Form\NgnNewType;
use AdminBundle\Form\EventsType;
use DashboardBundle\Form\Handler\ProfileFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AdminBundle\Entity\Category;
use AdminBundle\Entity\Ngn;
use AdminBundle\Entity\Qville;
use AdminBundle\Entity\Qouiqui;
use AdminBundle\Entity\Events;
use AdminBundle\Entity\Booking;
use AdminBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DashbordProfileController extends Controller
{
    public function indexAction(Request $request)

    {
        $userQ = $this->getUser();
        $user = $this->getUser()->getId();
        $qouiqui = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findBy(array('user' => $user));
        return $this->render('DashboardBundle:Profile:index.html.twig', array(
            'user' => $userQ,
            'qouiqui' => $qouiqui,
        ));

    }


    public function editAction(Request $request)
    {
        $imageOld = $this->getUser()->getImage();

        $user = new User();
        $user = $this->getUser();
        $form = $this->createForm('DashboardBundle\Form\ProfileFormType', $user);
        $form->handleRequest($request);
        $image = uniqid();

        if ($form->isSubmitted() && $form->isValid()) {
            if(!empty($_FILES['profile_form']['tmp_name']['image'])){
            $uploaddir = $_SERVER['PHP_DOCUMENT_ROOT'] . '/web/annuaire/web/uploads/users';


            if ($imageOld && is_file($uploaddir . '/' . $imageOld . '.jpg')) {
                unlink($uploaddir . '/' . $imageOld . '.jpg');

            }

            $user = $form->getData();
            $user->setImage($image);

            move_uploaded_file(
                $_FILES['profile_form']['tmp_name']['image'],
                $uploaddir . '/' . $user->getImage() . '.jpg'
            );
            $em = $this->getDoctrine()->getManager();
            $em->flush($user);

        }
        else{
            $user = $form->getData();
            $user->setImage($imageOld);
            $em = $this->getDoctrine()->getManager();
            $em->flush($user);
        }

        }

        return $this->render('DashboardBundle:Profile:edit.html.twig', array(
            'user' => $user,

            'form' => $form->createView(),
        ));

    }
}
<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Entity\Ngn;
use AdminBundle\Form\NgnNewType;



class DefaultController extends Controller
{
    /**
     * Lists all qouiqui entities.
     *
     */
    public function indexAction()
    {
        $user = $this->getUser();

        $user_id = $user->getID();


        $em = $this->getDoctrine()->getManager();

        $qouiquis = $em->getRepository('AdminBundle:Qouiqui')->findAll();


        return $this->render('AdminBundle:default:index.html.twig', array(
            'qouiquis' => $qouiquis,
        ));


    }

    public function editAction(Request $request, Ngn $quouiqui)
    {

        $ngn_id = $request->get('id');
        $editForm = $this->createForm('AdminBundle\Form\NgnNewType', $quouiqui);
        $editForm->handleRequest($request);
        $editForm->getData()->getqouiqui()->setImage(null);


        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_homepage');

        } else {

            return $this->render('AdminBundle:QQUI:ajout.html.twig', array(
                '$quouiqui' => $quouiqui,
                'ngn_id' => $ngn_id,
                'form' => $editForm->createView(),

            ));
        }


    }

    public function mailAction()
    {

            return $this->render('AdminBundle:mail:inbox.html.twig');

    }

    public function userlistAction(){

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AdminBundle:user')->findall();

        return $this->render('AdminBundle:user:list.html.twig', array(
            'user' => $user,

        ));



    }

    public function userAction(Request $request, $id = null )

    {
        $em = $this->getDoctrine()->getManager();

        if($id){

            $userQ = $em->getRepository('AdminBundle:User')->findOneById($id);

        }
        else {
            $userQ = $this->getUser();
            //$user = $this->getUser()->getId();
        }

        $imageOld = $this->getUser()->getImage();
        $edit = null;
        $form = $this->createForm('DashboardBundle\Form\ProfileFormType', $userQ);
        $form->handleRequest($request);

        $image = uniqid();


        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            if (!empty($_FILES['profile_form']['tmp_name']['image'])) {


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

            } else {

                $user->setImage($imageOld);
            }


            $em->flush($user);
            $edit = 'done';
        }


        return $this->render('AdminBundle:user:edit.html.twig', array(
            'edit' => $edit,
            'user' => $userQ,
            'form' => $form->createView(),
        ));

    }


}


<?php

namespace DashboardBundle\Controller;

use AdminBundle\Entity\Automobile;
use AdminBundle\Entity\Qouiqui;
use AdminBundle\Form\AutomobileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Automobile controller.
 *
 */
class AutomobileController extends Controller
{
    /**
     * Lists all Automobile entities.
     *
     */
    public function indexAction($idQq)
    {
        $Automobiles = $this->getDoctrine()->getRepository('AdminBundle:Automobile')
            ->findBy(array('qouiqui' => $idQq));
        return $this->render('DashboardBundle:automobile:index.html.twig', array(
            'Automobiles' => $Automobiles,
            'quoiqui' => $idQq

        ));

    }

    /**
     * Creates a new Automobile entity.
     *
     */
    public function newAction(Request $request, $idQq)
    {
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
            ->findOneBy(array('id' => $idQq));
        $Automobile = new Automobile();
        $ext = '.jpg';
        $imageNom = uniqid() . $ext;
        $form = $this->createForm('DashboardBundle\Form\AutomobileType', $Automobile);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $Automobile->setQouiqui($qq);

            $em = $this->getDoctrine()->getManager();

            $em->persist($Automobile);
            $em->flush($Automobile);
            $em->refresh($Automobile);
            $Automobile2 = $Automobile->getId();
            $directory = $_SERVER['PHP_DOCUMENT_ROOT'] . '/web/annuaire/web/uploads/automobile/' . $Automobile2 . '/';

            if (!is_dir($directory)) {
                mkdir($directory, 0777);
                $file = $_FILES['adminbundle_automobile']['tmp_name']['images'];
                dump(pathinfo($file));
                dump($file, sizeof($file));
                $fileUpload = $directory . $imageNom;
                dump($fileUpload);
                move_uploaded_file($file, $fileUpload);
            } else {
                die('erreur!');
            }

            $Automobile->setImages($imageNom);
            $em->flush($Automobile);


            return $this->redirectToRoute('dashboard_automobile_afficher', array('idQq' => $qq->getId(), 'idAuto' => $Automobile->getId()));
        }

        return $this->render('DashboardBundle:automobile:new.html.twig', array(
            'Automobile' => $Automobile,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Automobile entity.
     *
     */


    public function showAction($idQq, $idAuto)
    {
        $Automobile = $this->getDoctrine()->getRepository('AdminBundle:Automobile')
            ->findOneBy(array('qouiqui' => $idQq, 'id' => $idAuto));

        if ($Automobile) {
//            $deleteForm = $this->createDeleteForm($Automobile);
            return $this->render('DashboardBundle:automobile:show.html.twig', array(
                'Automobile' => $Automobile,
//                'delete_form' => $deleteForm->createView(),
            ));
        } else {
            die('vous ne peut pas accéder a cette produit!');
        }
    }

    /**
     * Displays a form to edit an existing Automobile entity.
     *
     */
    public function editAction(Request $request, $idQq, $idAuto)
    {
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
            ->findOneBy(array('id' => $idQq));
        $Automobile = $this->getDoctrine()->getRepository('AdminBundle:Automobile')
            ->findOneBy(array('qouiqui' => $idQq, 'id' => $idAuto));


        if ($Automobile) {
            $imageOld = $Automobile->getImages();
            $ext = '.jpg';
            $imageNew = uniqid() . $ext;
            $deleteForm = $this->createDeleteForm($Automobile, $idQq);
            $editForm = $this->createForm('DashboardBundle\Form\AutomobileType', $Automobile);

            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $Automobile2 = $Automobile->getId();
                $directory = $_SERVER['PHP_DOCUMENT_ROOT'] . '/web/annuaire/web/uploads/automobile/' . $Automobile2 . '/';

                if (!empty($_FILES['adminbundle_automobile']['tmp_name']['images'])) {

                    if (is_dir($directory)) {

                        $file = $_FILES['adminbundle_automobile']['tmp_name']['images'];
                        $fileUp = $directory . $imageOld;
                        $fileUpload = $directory . $imageNew;
                        move_uploaded_file($file, $fileUpload);
                    }
                    $Automobile->setImages($imageNew);
                } else {
                    $Automobile->setImages($imageOld);
                }


                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('dashboard_automobile_afficher', array('idQq' => $qq->getId(), 'idAuto' => $Automobile->getId()));
            }

            return $this->render('DashboardBundle:automobile:edit.html.twig', array(
                //'quoiqui' => $qq,
                'Automobile' => $Automobile,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        } else {
            die('vous ne peut pas accéder a cette produit!');
        }
    }

    /**
     * Deletes a Automobile entity.
     *
     */
    public
    function deleteAction(Request $request, $idQq)
    {
        dump($idQq);

        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
            ->findOneBy(array('id' => $idQq));
        $Automobile = $this->getDoctrine()->getRepository('AdminBundle:Automobile')
            ->findOneBy(array('qouiqui' => $idQq));

        if ($Automobile) {

            $form = $this->createDeleteForm($Automobile, $idQq);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($Automobile);
                $em->flush($Automobile);
            }

            return $this->redirectToRoute('dashboard_automobile_liste', array('idQq' => $qq->getId()));
        } else {
            die('vous ne peut pas accéder a cette produit!');
        }
    }

    /**
     * Creates a form to delete a Automobile entity.
     *
     * @param Automobile $Automobile The Automobile entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private
    function createDeleteForm(Automobile $Automobile, $idQq)
    {
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
            ->findOneBy(array('id' => $idQq));

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dashboard_automobile_supprimer', array('idQq' => $qq->getId(), 'id' => $Automobile->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    public function archiveAction($idQq, $idAuto, $stat)
    {

        $user = $this->getUser();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
            ->findOneBy(array('user' => $user, 'id' => $idQq));
        if ($qq) {
            $automobile = $this->getDoctrine()->getRepository('AdminBundle:Automobile')
                ->findOneBy(array('qouiqui' => $idQq, 'id' => $idAuto, 'statut' => $stat));

            if ($automobile) {
                $em = $this->getDoctrine()->getManager();
                $stat = $automobile->getStatut();
                if ($stat == 1) {
                    $automobile->setStatut(0);
                } else {
                    $automobile->setStatut(1);
                }
                $em->flush($automobile);
            }

        } else {
            die('erreur!');
        }
        die;
    }

}

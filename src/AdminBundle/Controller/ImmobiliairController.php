<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Immobiliair;
use AdminBundle\Entity\Qouiqui;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Immobiliair controller.
 *
 */
class ImmobiliairController extends Controller
{
    /**
     * Lists all immobiliair entities.
     *
     */
    public function indexAction($category, $qq)
    {

        $category = ucfirst($category);

        $em = $this->getDoctrine()->getManager();

        $QQ = $em->getRepository('AdminBundle:Qouiqui')->findOneById($qq);

        $cat = $em->getRepository('AdminBundle:' . $category)->findBy(array('qouiqui' => $QQ->getId()));

        return $this->render('AdminBundle:module:list.html.twig', array(
            'cat' => $cat,
            'category' => $category
        ));

    }

    public function indexadminAction()
    {


        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository('AdminBundle:Immobiliair')->findall();

        return $this->render('immobiliair/index.html.twig', array(
            'immobiliairs' => $cat,
        ));

    }

    /**
     * Creates a new immobiliair entity.
     *
     */

    public function editimmoAction(Request $request, Immobiliair $immobiliair, $id)
    {


        $em = $this->getDoctrine()->getManager();
//        $immobiliair = $em->getRepository('AdminBundle:Immobiliair')->findOneBy(array('qouiqui'=>$id_qq));
        $qq_id = $immobiliair->getQouiqui()->getId();
        $form = $this->createForm('AdminBundle\Form\ImmobiliairType', $immobiliair);
        $form->handleRequest($request);
        $immo = $request->get('adminbundle_immobiliair');


        if (!empty($immo['equipment'])) {

            $immo['equipment'] = json_encode($immo['equipment'], true);
            $form->getData()->setequipment($immo['equipment']);
        }
        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($immobiliair);
            $em->flush($immobiliair);

            $em->refresh($immobiliair);

        }

        if (!empty($_FILES['image']['name'][0])) {


            $idUser = $this->getUser()->getId();

//            $chars = preg_split('/#/', $img, -1, PREG_SPLIT_NO_EMPTY);
//            dump($request->get('TypeGallery'),$img,$chars);


            #creation dossier avec l'id de l'utilisateur si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
            endif;

            #creation dossier avec l'id de QUOIQUI si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/", 0777);
            endif;
            #creation dossier annonce si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce", 0777);
            endif;
            #creation dossier gallery si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce/annonce" . $immobiliair->getId())):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce/annonce" . $immobiliair->getId(), 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce/annonce" . $immobiliair->getId(), 0777);
            endif;

            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce/annonce" . $immobiliair->getId();
            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce/annonce" . $immobiliair->getId() . "/" . uniqid() . ".jpg";
            if (sizeof($_FILES['image']['tmp_name']) >= "2") {

                dump($_FILES, sizeof($_FILES['image']['tmp_name']), $_FILES['image']['tmp_name']);


                for ($i = 0; $i <= sizeof($_FILES['image']['tmp_name']) - 1; $i++) {


                    move_uploaded_file($_FILES['image']['tmp_name'][$i], $uploaddir);

                }


            } else {

                $files = $_FILES['image']['tmp_name']['0'];
                move_uploaded_file($files, $uploaddir);

            }

        }
        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Votre annonce à été modifier avec succes.');

        return $this->redirect($_SERVER['PHP_SELF']);
    }

    public function newAction(Request $request, $qq_id)
    {


        $em = $this->getDoctrine()->getManager();
        $immobiliair = new Immobiliair();
        $form = $this->createForm('AdminBundle\Form\ImmobiliairType', $immobiliair);
        $form->handleRequest($request);
        $immo = $request->get('adminbundle_immobiliair');
        if (!empty($immo['equipment'])) {

            $immo['equipment'] = json_encode($immo['equipment'], true);
            $form->getData()->setequipment($immo['equipment']);
        }

        $form->getData()->setPrefix($immo['prefix']);
        $qq = $em->getRepository('AdminBundle:Qouiqui')->findOneById($qq_id);

        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $immobiliair->setQouiqui($qq);
            $em->persist($immobiliair);
            $em->flush($immobiliair);
            $em->refresh($immobiliair);

        }

        if (file_exists($_FILES['image']['tmp_name'][0])) {


            $idUser = $this->getUser()->getId();

//            $chars = preg_split('/#/', $img, -1, PREG_SPLIT_NO_EMPTY);
//            dump($request->get('TypeGallery'),$img,$chars);


            #creation dossier avec l'id de l'utilisateur si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
            endif;

            #creation dossier avec l'id de QUOIQUI si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/", 0777);
            endif;
            #creation dossier annonce si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce", 0777);
            endif;
            #creation dossier gallery si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce/annonce" . $immobiliair->getId())):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce/annonce" . $immobiliair->getId(), 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce/annonce" . $immobiliair->getId(), 0777);
            endif;

            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce/annonce" . $immobiliair->getId();
            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce/annonce" . $immobiliair->getId() . "/" . uniqid() . ".jpg";
            if (sizeof($_FILES['image']['tmp_name']) >= "2") {


                for ($i = 0; $i <= sizeof($_FILES['image']['tmp_name']) - 1; $i++) {


                    move_uploaded_file($_FILES['image']['tmp_name'][$i], $uploaddir);

                }


            } else {


                $files = $_FILES['image']['tmp_name']['0'];
                move_uploaded_file($files, $uploaddir);

            }

        }
        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Votre annonce à été ajouter avec succes.');

        return $this->redirect($_SERVER['PHP_SELF']);
//        return $this->render('immobiliair/new.html.twig', array(
//            'immobiliair' => $immobiliair,
//            'form' => $form->createView(),
//        ));

    }


    /**
     * Finds and displays a immobiliair entity.
     *
     */
    public function showAction(Immobiliair $immobiliair)
    {
        $deleteForm = $this->createDeleteForm($immobiliair);

        return $this->render('immobiliair/show.html.twig', array(
            'immobiliair' => $immobiliair,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing immobiliair entity.
     *
     */
    public function editAction(Request $request, Immobiliair $immobiliair)
    {
//        $deleteForm = $this->createDeleteForm($immobiliair);
        $editForm = $this->createForm('AdminBundle\Form\ImmobiliairType', $immobiliair);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('immobiliair_edit', array('id' => $immobiliair->getId()));
        }

        return $this->render('AdminBundle:module:Immobiliair\edit_immobiliaires.html.twig', array(
            'immobiliair' => $immobiliair,
            'edit_form' => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a immobiliair entity.
     *
     */
    public function deleteAction(Request $request, Immobiliair $immobiliair, $id)
    {

        $form = $this->createDeleteForm($immobiliair);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $em->remove($immobiliair);
        $em->flush($immobiliair);

        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Votre annonce à été supprimer avec succes.');

        return $this->redirect($_SERVER['PHP_SELF']);

    }

    /**
     * Creates a form to delete a immobiliair entity.
     *
     * @param Immobiliair $immobiliair The immobiliair entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Immobiliair $immobiliair)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('immobiliair_delete', array('id' => $immobiliair->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}

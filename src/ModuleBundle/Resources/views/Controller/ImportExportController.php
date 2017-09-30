<?php
/**
 * Created by PhpStorm.
 * User: Ameni
 * Date: 24/07/2017
 * Time: 11:34
 */

namespace ModuleBundle\Controller;


use AdminBundle\Entity\Architecture;
use AdminBundle\Entity\Traiteur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ImportExportController extends Controller
{


    public function newAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $qq_id = $request->get('AdminBundle_traiteur')['qqId'];
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneById($qq_id);
        $idUser = $this->getUser()->getId();
        $traiteur = new Traiteur();
        $form = $this->createForm('AdminBundle\Form\TraiteurType', $traiteur);
        $form->handleRequest($request);
        $form->getData()->setQouiqui($quoiqui);
        if ($form->isSubmitted()) {
            $em->persist($traiteur);
            $em->flush();
            $em->refresh($traiteur);
            $traiteurId = $traiteur->getId();
        }

        if ($_FILES) {

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

            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article")):


                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article", 0777);
            endif;
            #creation dossier gallery si n'existe pas


            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article/$traiteurId")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article/$traiteurId", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article/$traiteurId", 0777);

            endif;

            if (is_file($_FILES["files"]["tmp_name"][0])) {
                $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article/$traiteurId";
                move_uploaded_file($_FILES["files"]["tmp_name"][0], $uploaddir . '/ween-Article-'.$traiteurId.'.jpg');
            }
        }



        return $this->redirect($_SERVER['PHP_SELF'].'/#section-annonces');


    }

    public function editAction(Request $request, Traiteur $traiteur)

    {

        $em = $this->getDoctrine()->getManager();
        $qq_id = $request->get('AdminBundle_traiteur')['qqId'];
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneById($qq_id);
        $idUser = $this->getUser()->getId();
        $traiteurId = $traiteur->getId();
        $deleteForm = $this->createDeleteForm($traiteur);
        $editForm = $this->createForm('AdminBundle\Form\TraiteurType', $traiteur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted()) {
            $this->getDoctrine()->getManager()->flush();

            if ($_FILES) {

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

                if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article")):


                    mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article", 0777);
                    chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article", 0777);
                endif;
                #creation dossier gallery si n'existe pas


                if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article/$traiteurId")):
                    mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article/$traiteurId", 0777);
                    chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article/$traiteurId", 0777);

                endif;

                if (is_file($_FILES["files"]["tmp_name"][0])) {

                    $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article/$traiteurId";
                    move_uploaded_file($_FILES["files"]["tmp_name"][0], $uploaddir . '/ween-Article-'.$traiteurId.'.jpg');

                }
            }

        }
        return $this->redirect($_SERVER['PHP_SELF'].'/#section-annonces');


    }
    public function deleteAction(Request $request, Traiteur $traiteur)
    {

        if(!empty($traiteur) & ($this->getUser()->getId() == $traiteur->getQouiqui()->getUser()->getId() )){

            $em = $this->getDoctrine()->getManager();
            $em->remove($traiteur);
            $em->flush();
        }

        return $this->redirect($_SERVER['PHP_SELF'].'/#section-annonces');
    }

    function ficheAnnoncesAction(Request $request)
    {


        return $this->render('@User/template/fiche/ImportExport/annonces.html.twig', [
            'attributes' => $request->attributes->all()
        ]);
    }


    function ficheServicesAction(Request $request)
    {


        return $this->render('@User/template/fiche/ImportExport/services.html.twig', [
            'attributes' => $request->attributes->all()
        ]);
    }

    private function createDeleteForm(Traiteur $traiteur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('traiteur_delete', array('id' => $traiteur->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }



}
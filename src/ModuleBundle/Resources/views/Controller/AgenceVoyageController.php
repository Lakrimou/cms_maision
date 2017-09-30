<?php

namespace ModuleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AdminBundle\Entity\AgenceVoyage;


class AgenceVoyageController extends Controller
{
    public function indexAction()
    {
        return $this->render('ModuleBundle:ambulance:index.html.twig');
    }

    public function filtrehotelAction()
    {
        $cat = "Hotel";
        $tag = $_GET['tag'];
        $hotels = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findByNorV($tag, $cat);

        return new Response(json_encode($hotels));
    }

    public function filtrevoitureAction()
    {
        $tag = $_GET['tag'];
        $loactionvoiture = $this->getDoctrine()->getRepository('AdminBundle:LocationVoiture')->findvoiturelocation($tag);
        return new Response(json_encode($loactionvoiture));
    }

    public function ajouter_offreAction(request $request)
    {

        $data = $request->get("AdminBundle_agencevoyage");
        $qq_id = $data['qouiqui'];
        $dateDepart = $data["dateDepart"];
        $dateDepart_time = $data["dateDepart_time"];
        $dateRetour = $data["dateRetour"];
        $dateRetour_time = $data["dateRetour_time"];
        $newdateDepart = date('Y-m-d', strtotime($dateDepart)) . ' ' . $dateDepart_time;
        $newdateRetour = date('Y-m-d', strtotime($dateRetour)) . ' ' . $dateRetour_time;
        $agenceVoyage = new Agencevoyage();
        $form = $this->createForm('AdminBundle\Form\AgenceVoyageType', $agenceVoyage);
        $form->handleRequest($request);
        $formData = $form->getData();
        if (!(empty($data['service']))) {
            $datatag = array();
            $datatag['tags'] = $data['service'];
            $datatag = json_encode($datatag);
        } else {
            $datatag = "";
        }
        $formData->setDateDepart($newdateDepart);
        $formData->setDateRetour($newdateRetour);
        $formData->setService($datatag);

        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($agenceVoyage);
            $em->flush();
            $em->refresh($agenceVoyage);


            if ($_FILES) {
                $idUser = $this->getUser()->getId();

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
                #creation dossier produits si n'existe pas
                if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce")):
                    mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce", 0777);
                    chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce", 0777);
                endif;

                $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce/";

                move_uploaded_file(
                    $_FILES['file']['tmp_name'][0],
                    $uploaddir . $agenceVoyage->getId() . '.jpg'
                );

            }


        }

        return $this->redirect($_SERVER['PHP_SELF']);

    }



    function ficheAnnoncesAction()
    {


        return $this->render('@User/template/fiche/agenceVoyage/annonces.html.twig');
    }


    function ficheServicesAction()
    {


        return $this->render('@User/template/fiche/agenceVoyage/services.html.twig');
    }
}
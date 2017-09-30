<?php

namespace ModuleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SalleDesFetesController extends Controller
{


    function ficheServicesAction(Request $request)
    {

        $quoiqui = $request->get('quoiqui');

        $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        if ($service) {
            $service = json_decode($service->getData(), true);

        } else {
            $service = null;
        }


        return $this->render('@User/template/fiche/SalleDesFetes/services.html.twig', [
            'attributes' => $request->attributes->all(), 'Spaservice' => $service
        ]);
    }


    function ficheAnnoncesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');

        $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        if ($service) {
            $service = json_decode($service->getData(), true);

        } else {
            $service = null;
        }


        return $this->render('@User/template/fiche/SalleDesFetes/annonces.html.twig', [
            'attributes' => $request->attributes->all(), 'Spaevent' => $service
        ]);
    }


    function addServiceAction($idqq)
    {

        $idUser = $this->getUser()->getId();

        $id_serv = $_POST['idserv'];


        $em = $this->getDoctrine()->getManager();
        $serv = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $idqq));

        if ($serv) {
            $data = json_decode($serv->getData(), true);
            $data['service'][$_POST['idserv']] = $_POST;
            $serv->setData(json_encode($data));
            dump(json_encode($data));

        } else {
            $data['service'][$_POST['idserv']] = $_POST;
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($idqq);
            $serv = new Theme();
            $serv->setData(json_encode($data));
            $serv->setQouiqui($qq);
        }

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser");
        endif;
        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq");
        endif;

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/service")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/service", 0777);
            chmod($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/service", 0777);
        endif;
        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/service" . "/$id_serv")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/service" . "/$id_serv", 0777);
            chmod($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/service" . "/$id_serv", 0777);
        endif;
        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/service/$id_serv";
        for ($i = 0; $i < sizeof($_FILES['file']['tmp_name']) - 1; $i++) {

            if (!empty($_FILES['file']['tmp_name'][$i])) {
                $tempFile = $_FILES['file']['tmp_name'][$i];
                $name = md5(uniqid(rand(), true));
                $ext = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
                move_uploaded_file(

                    $tempFile,
                    $uploaddir . '/' . $name . "." . $ext
                );
            }

        }

        $em->persist($serv);

        $em->flush($serv);


        return $this->redirect($_SERVER['PHP_SELF'] . '#section-services');
    }


    function addOffresAction($idqq)
    {
//        dump($_POST);
//        die;
        $idUser = $this->getUser()->getId();

        $id_offre = $_POST['idOffre'];

        $em = $this->getDoctrine()->getManager();
        $serv = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $idqq));

        if ($serv) {
            $data = json_decode($serv->getData(), true);
            $data['event'][$_POST['idOffre']] = $_POST;
            $serv->setData(json_encode($data));
            dump(json_encode($data));

        } else {
            $data['event'][$_POST['idOffre']] = $_POST;
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($idqq);
            $serv = new Theme();
            $serv->setData(json_encode($data));
            $serv->setQouiqui($qq);
        }

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser");
        endif;
        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq");
        endif;

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/event")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/event", 0777);
            chmod($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/event", 0777);
        endif;
        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/event" . "/$id_offre")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/event" . "/$id_offre", 0777);
            chmod($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/event" . "/$id_offre", 0777);
        endif;
        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/event/$id_offre";
        for ($i = 0; $i < sizeof($_FILES['file']['tmp_name']) - 1; $i++) {

            if (!empty($_FILES['file']['tmp_name'][$i])) {
                $tempFile = $_FILES['file']['tmp_name'][$i];
                $name = md5(uniqid(rand(), true));
                $ext = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
                move_uploaded_file(

                    $tempFile,
                    $uploaddir . '/' . $name . "." . $ext
                );
            }

        }


        $em->persist($serv);

        $em->flush($serv);


        return $this->redirect($_SERVER['PHP_SELF']);
    }
}


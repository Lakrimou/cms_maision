<?php

namespace ModuleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HuissierController extends Controller
{


    function ficheServicesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');
        $mission = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        if ($mission) {
            $mission = json_decode($mission->getData(), true);
        } else {
            $mission = null;
        }

        return $this->render('@User/template/fiche/Huissier/services.html.twig', [
            'attributes' => $request->attributes->all(),
            'quoiqui' => $quoiqui,
            'mission' => $mission
        ]);
    }


    function ficheAnnoncesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');

        return $this->render('@User/template/fiche/Huissier/annonces.html.twig', [
            'attributes' => $request->attributes->all()
        ]);
    }

    function addMissionHuissierAction($idqq)
    {
//        dump($_POST);
//        die;
        $idUser = $this->getUser()->getId();

        $id_serv = $_POST['idMission'];


        $em = $this->getDoctrine()->getManager();
        $serv = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $idqq));

        if ($serv) {

            $data = json_decode($serv->getData(), true);

            $data['service']['mission' . $_POST['idMission']] = $_POST;
//            $test = $data['service']['mission' . $_POST['idMission']];

            $serv->setData(json_encode($data));
//            dump($test );
            dump(json_encode($data));
//
//
        } else {
            $data['service']['mission' . $_POST['idMission']] = $_POST;
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($idqq);
            $serv = new Theme();
            $serv->setData(json_encode($data));
            $serv->setQouiqui($qq);

        }
        $em->persist($serv);

        $em->flush($serv);
        if (isset($_FILES['file']['name'])) {
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
            $this->uploadFiles($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/service/", $id_serv);


        }
        return $this->redirect($_SERVER['PHP_SELF']);
    }

    function getJsonHuissierAction(Request $request)
    {
        $id_qq = $request->request->get('idqq');

        $idMission = $request->request->get('idserv');


        $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $id_qq));


        $tab = json_decode($service->getData(), true);

        $getmission = $tab['service']['mission' . $idMission];

        $getmission = json_encode($getmission);
        print_r($getmission);
        die;

        $response = new Response($getmission);


        return $response;
    }

    function updateHuissierAction($idqq)

    {
//        dump($_POST);
//        die;


        $idUser = $this->getUser()->getId();


        $em = $this->getDoctrine()->getManager();

        $serv = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $idqq));
        if ($serv) {


            $data = json_decode($serv->getData(), true);
            $data['service']['mission' . $_POST['idMission']] = $_POST;

            $serv->setData(json_encode($data));


            $em->persist($serv);

            $em->flush($serv);

            if (isset($_FILES['file']['name']) && !empty(($_FILES['file']['name']))) {
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
                $this->uploadFiles($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/service/", $_POST['idMission']);


            }

            return $this->redirect($_SERVER['PHP_SELF']);
        }


    }

    function delateMissionHuissierAction($idqq, $idserv)
    {


        $idUser = $this->getUser()->getId();

        $em = $this->getDoctrine()->getManager();


        $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $idqq));
        if ($service) {
            $tab = json_decode($service->getData(), true);


            unset($tab['service']['mission' . $idserv]);
            $newtab = json_encode($tab);
            $service->setData($newtab);
            $em->persist($service);

            $em->flush($service);

            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/service/";


            if (is_file($uploaddir . "$idserv" . '.' . 'jpg')) {

                unlink($uploaddir . "$idserv" . '.' . 'jpg');

            }


        }

        return $this->redirect($_SERVER['PHP_SELF']);

    }

    function uploadFiles($file, $src, $name = null)
    {

        if ($file) {
            $tempFile = $file['file']['tmp_name'];
            if (!$name)
                $name = md5(uniqid(rand(), true));
//            $targetFile = $src . $name . '.' . pathinfo($file['file']['name'], PATHINFO_EXTENSION);
            $targetFile = $src . $name . '.jpg';
            move_uploaded_file($tempFile, $targetFile);

            chmod($targetFile, 0777);
            return true;
        } else {
            return false;
        }
        return false;
    }
}

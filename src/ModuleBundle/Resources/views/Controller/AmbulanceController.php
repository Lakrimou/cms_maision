<?php
/**
 * Created by PhpStorm.
 * User: POSTE 7
 * Date: 19/05/2017
 * Time: 15:00
 */

namespace ModuleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AmbulanceController extends Controller
{
//    public function indexAction(){
//
//
//        return $this->render('ModuleBundle:ambulance:index.html.twig');
//    }


    function ficheServicesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');
        $mission = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        if ($mission) {
            $mission = json_decode($mission->getData(), true);
        } else {
            $mission = null;
        }

        return $this->render('@User/template/fiche/ambulance/services.html.twig', [
            'attributes' => $request->attributes->all(),
            'quoiqui' => $quoiqui,
            'mission' => $mission

        ]);
    }


    function ficheAnnoncesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');
        $mission = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        if ($mission) {
            $mission = json_decode($mission->getData(), true);
        } else {
            $mission = null;
        }

        return $this->render('@User/template/fiche/ambulance/annonces.html.twig', [
            'attributes' => $request->attributes->all(),
            'mission' => $mission
        ]);
    }

    function addEquipementAction($idqq)
    {
        $array1 = array();
        $array2 = array();

//        if (isset($_POST['souscategorie'])) {
//
//            $l = ($_POST['souscategorie']);
//            $serv = '';
//            foreach ($l as $ll => $k) {
//                $serv = $serv . ', ' . $k;
//            }
//        } else {
//            $serv = '';
//            $rslt=$serv;
//        }
//        $rslt['equipement'] = (trim(trim($serv, ',')));
//        dump($rslt);
//        foreach ($_POST as $k=>$V){
//            dump($k);
//            dump(json_encode($V));
//
//
//        }
        dump(json_encode($_POST));
        die;
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
        $this->uploadFiles($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/event/", $id_offre);


        $em->persist($serv);

        $em->flush($serv);


        return $this->redirect($_SERVER['PHP_SELF']);
    }

}
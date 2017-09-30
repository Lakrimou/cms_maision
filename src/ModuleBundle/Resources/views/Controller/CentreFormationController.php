<?php
/**
 * Created by PhpStorm.
 * User: POSTE 7
 * Date: 12/07/2017
 * Time: 12:28
 */

namespace ModuleBundle\Controller;

use AdminBundle\Entity\Qouiqui;
use AdminBundle\Entity\Theme;
use AdminBundle\Entity\Booking;
use AdminBundle\Entity\CentreFormation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CentreFormationController extends Controller
{


    public function edit_aboutAction(Request $request)
    {


        $em = $this->getDoctrine()->getEntityManager();

        $qouiqui_info = $request->get('qouiqui');

        $details = $request->get('editor');
        $address1 = $qouiqui_info['address1'];

        $id = $qouiqui_info['id'];
        $rs = json_encode($qouiqui_info['rs'], true);
        $opneing = json_encode($qouiqui_info['opening'], true);
        if (!(empty($request->get('tags')))) {
            $data = array();
            $data['tags'] = $request->get('tags');
            $data = json_encode($data);
        } else {
            $data = "";
        }
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($id);

        $qq->setDetails($request->get('editor'));
        $qq->setAddress1($address1);
        $qq->setAdress2($qouiqui_info['address2']);
        $qq->setPhone($qouiqui_info['phone']);
        $qq->setPhone2($qouiqui_info['phone2']);
        $qq->setMail($qouiqui_info['mail']);
        $qq->setWebsite($qouiqui_info['website']);
        $qq->setOpening($opneing);
        $qq->setSociaux($rs);
        $qq->setData($data);

        $em->persist($qq);

        $em->flush();

        return $this->redirect($this->generateUrl('sub', array('subdomain' => $qq->getSlug())));

    }


    public function insertDataAction($qq_id)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $data = array();
        $tab = array();
        if (isset($_POST['p1']) && isset($_POST['p2']) && isset($_POST['p3'])) {
            $data['p1'] = $_POST['p1'];
            $data['p3'] = $_POST['p3'];
            $data['p2'] = $_POST['p2'];
            $tab = $data;
            $cf = $this->getDoctrine()->getRepository('AdminBundle:CentreFormation')->findOneBy(array("qouiqui" => $qq_id, 'section' => 'slider'));
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($qq_id);


            if ($cf == null) {
                $cf = new CentreFormation();

                $datas = json_encode($tab);
                $cf->setSection('slider');
                $cf->setData($datas);
                $cf->setQouiqui($qq);
                $em->persist($cf);
                $em->flush($cf);
            } else {

                $cf->setData(json_encode($tab));


                $em->persist($cf);

                $em->flush($cf);


            }
        }
        return $this->redirect($_SERVER['PHP_SELF']);
    }

    public function ajoutserviceAction(Request $request)
    {


        $idUser = $this->getUser()->getId();
        $id_qq = $_POST['qq_id'];
        $id_serv = $_POST['idfrm'];
        $tab = array();
        $tab1 = array();
        $quoiqui = $request->get('quoiqui');
        $em = $this->getDoctrine()->getManager();
        $serv = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $_POST['qq_id']));

        if ($serv) {
            $data = json_decode($serv->getData(), true);
            $data['service']['frm' . $_POST['idfrm']] = $_POST;
            $serv->setData(json_encode($data));
            dump(json_encode($data));

        } else {
            $data['service']['frm' . $_POST['idfrm']] = $_POST;
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($_POST['qq_id']);
            $serv = new Theme();
            $serv->setData(json_encode($data));
            $serv->setQouiqui($qq);
        }

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser");
        endif;
        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq");
        endif;

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/service")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/service", 0777);
            chmod($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/service", 0777);
        endif;
        $this->uploadFiles($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/service/", $id_serv);


        $em->persist($serv);

        $em->flush($serv);


        return $this->redirect($_SERVER['PHP_SELF']);

//        if (isset($_POST)) {
//            if (isset($_POST['certif'])) {
//
//                $tab['certif'] = $_POST['certif'];
//            }
//
//
//            $tab['ncour'] = $_POST['ncour'];
//            $tab['id'] = $_POST['qq_id'];
//            $tab['desc'] = $_POST['desc'];
//            $tab['start'] = $_POST['start-cour'];
//            $tab['end'] = $_POST['end-cour'];
//
//            $tab['prix'] = $_POST['prix'];
//            $tab['dure'] = $_POST['dure'];
//
//            $tab['qouiqui'] = $_POST['qouiqui'];
//            $tab1 = $tab;
//
//            $rslt = json_encode($tab1);
//
//
//            $idUser = $this->getUser()->getId();
//            $id_qq = $_POST['qq_id'];
//
//            $em = $this->getDoctrine()->getManager();
//            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($_POST['qq_id']);
//
//            $cf = new CentreFormation();
//            $cf->setSection('service');
//
//            $cf->setData($rslt);
//
//            $cf->setQouiqui($qq);
//
//            $em->persist($cf);
//
//
//            $em->flush($cf);
//
//            $em->refresh($cf);
//            $id_serv = $cf->getId();
//
//
//            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
//                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser");
//            endif;
//            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq")):
//                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq");
//            endif;
//
//            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/service")):
//                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/service", 0777);
//                chmod($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/service", 0777);
//            endif;
//            $this->uploadFiles($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/service/", $id_serv);
//
//        }
//
//
//        return $this->redirect($_SERVER['PHP_SELF']);

    }


    public function modifserviceAction(Request $request)

    {

        $idUser = $this->getUser()->getId();
        $idqq = $_POST['qq_id'];
        $idservice = $_POST['idfrm'];
        $em = $this->getDoctrine()->getManager();

        $serv = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $_POST['qq_id']));
        $data = json_decode($serv->getData(), true);
        $data['service']['frm' . $_POST['idfrm']] = $_POST;

        $serv->setData(json_encode($data));


        $em->persist($serv);

        $em->flush($serv);
        dump($serv);
        dump($_FILES['file']['name'], $idservice);

        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/service/";

        if (!empty(($_FILES['file']['name'][0]))) {


            if (is_file($uploaddir . "$idservice" . '.' . 'jpg')) {

                unlink($uploaddir . "$idservice" . '.' . 'jpg');
                $ext = pathinfo($_FILES['file']['name'][0], PATHINFO_EXTENSION);
                move_uploaded_file(
                    $_FILES['file']['tmp_name'][0],
                    $uploaddir . "$idservice" . '.' . $ext
                );
            } else {
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
                $this->uploadFiles($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/service/", $idservice);
            }

        }

//        die;
//        if (isset($_POST)) {
//
//
//            $idservice = $_POST['serviceID'];
//
//            $idqq = $_POST['qq_id'];
//            $idUser = $this->getUser()->getId();
//
//            $em = $this->getDoctrine()->getManager();
//
//            $cf_serv = $this->getDoctrine()->getRepository('AdminBundle:CentreFormation')->findOneBy(array('id' => $idservice));
//
//            $cf_serv->setData(json_encode($_POST));
//
//
//            $em->persist($cf_serv);
//
//            $em->flush($cf_serv);
//
//            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/service/";
//
//            if (!empty(($_FILES['file']['name']))) {
//
//
//                if (is_file($uploaddir . "$idservice" . '.' . 'jpg')) {
//
//                    unlink($uploaddir . "$idservice" . '.' . 'jpg');
//                    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
//                    move_uploaded_file(
//                        $_FILES['file']['tmp_name'],
//                        $uploaddir . "$idservice" . '.' . $ext
//                    );
//                } else {
//                    if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
//                        mkdir($this->get('app.image_uploader')->targetDir . "/$idUser");
//                    endif;
//                    if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq")):
//                        mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq");
//                    endif;
//
//                    if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/service")):
//                        mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/service", 0777);
//                        chmod($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/service", 0777);
//                    endif;
//                    $this->uploadFiles($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/service/", $idservice);
//                }

//            }


        return $this->redirect($_SERVER['PHP_SELF']);


    }

    public function editserviceAction(Request $request)

    {


        $id_qq = $request->request->get('idqq');

        $id_serv = $request->request->get('idserv');


        $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $id_qq));

        $tab = json_decode($service->getData(), true);
        $getformation = $tab['service']['frm' . $id_serv];

        $getformation = json_encode($getformation);

        $response = new Response($getformation);


        return $response;

//        $id_qq = $request->request->get('idqq');
//
//        $id_serv = $request->request->get('idserv');
//
//
//        $service = $this->getDoctrine()->getRepository('AdminBundle:CentreFormation')->findOneBy(array('id' => $id_serv, 'qouiqui' => $id_qq, 'section' => 'service'));
//
//
//        $serv = $service->getData();
//
//
//        $response = new Response($serv);
//
//
//        return $response;


    }

    public function horaireAction(Request $request)

    {

        $id_qq = $request->request->get('idqq');

        $id_serv = $request->request->get('idserv');


        $service = $this->getDoctrine()->getRepository('AdminBundle:CentreFormation')->findOneBy(array('id' => $id_serv, 'qouiqui' => $id_qq, 'section' => 'service'));


        $serv = $service->getData();
        $serv = json_decode($serv, true);
        $horaires = $serv['qouiqui'];

        $newH = array();
        foreach ($horaires as $k => $v) {
            if ($v['start'] != 0 && $v['end'] != 0) {


                $time = $v['start'] . ' - ' . $v['end'];
                $newH[$time][] = $k;

            }

        }

//        dump($newH);


//


//        dump(json_encode($newH));

        $response = new Response(json_encode($newH));


        return $response;


        die;


    }

    public function delateserviceAction(Request $request)
    {
        $idUser = $this->getUser()->getId();

        $qqId = $request->request->get('Idqq');

        $IdServ = $request->request->get('Idserv');


        $em = $this->getDoctrine()->getManager();


        $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $qqId));
        if ($service):
            $tab = json_decode($service->getData(), true);
        else:
            $tab = $qqId;
        endif;

        $getformation = $tab['service']['frm' . $IdServ];

        unset($tab['service']['frm' . $IdServ]);
        $newtab = json_encode($tab);
        $service->setData($newtab);
        $em->persist($service);

        $em->flush($service);
        print_r($service->getData());

        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$qqId/service/";


        if (is_file($uploaddir . "$IdServ" . '.' . 'jpg')) {

            unlink($uploaddir . "$IdServ" . '.' . 'jpg');

        }


        die;
//        $service = $em->getRepository('AdminBundle:CentreFormation')->findOneBy(array('id' => $idservice, 'qouiqui' => $id_qq, 'section' => 'service'));
//        if ($service):
//            $em->remove($service);
//            $em->flush($service);
//
//        endif;
//        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/service/";
//
//
//        if (is_file($uploaddir . "$idservice" . '.' . 'jpg')) {
//
//            unlink($uploaddir . "$idservice" . '.' . 'jpg');
//
//        }
//
//
//
//
    }

    public function ajouteventAction(Request $request)
    {

        $data = array();
        $tab = array();
        $data['adr'] = $_POST['adr'];
        $data['start'] = $_POST['start'];
        $data['end'] = $_POST['end'];
        $tab = $data;
        $tab = json_encode($tab);
        $tab1 = array();
        $tab2 = array();
        $tab1['nom'] = $_POST['nom'];
        $tab1['desc'] = $_POST['desc'];
        $tab2 = $tab1;
        $reslt = json_encode($tab2);


        $idUser = $this->getUser()->getId();
        $id_qq = $_POST['qq_id'];

        $em = $this->getDoctrine()->getManager();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($_POST['qq_id']);

        $cf = new CentreFormation();
        $cf->setSection('event');
        $cf->setData(json_encode($_POST));


        $cf->setQouiqui($qq);
        $em->persist($cf);

        $em->flush($cf);
        $em->refresh($cf);
        $id_event = $cf->getId();


        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser");
        endif;
        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq");
        endif;

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/event")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/event", 0777);
            chmod($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/event", 0777);
        endif;
        $this->uploadFiles($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/event/", $id_event);

//        $storeFolder = $file = $this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/service";
//        $targetPath = $storeFolder . $ds;

        return $this->redirect($_SERVER['PHP_SELF']);

    }

    public function editeventAction(Request $request)
    {

        $id_qq = $request->request->get('idqq');

        $id_serv = $request->request->get('idserv');


        $event = $this->getDoctrine()->getRepository('AdminBundle:CentreFormation')->findOneBy(array('id' => $id_serv, 'qouiqui' => $id_qq, 'section' => 'event'));


        $rslt = $event->getData();


        $response = new Response($rslt);


        return $response;


    }

    public function modifeventAction(Request $request, $idqq)

    {


        $idUser = $this->getUser()->getId();
        $idevent = $_POST['eventID'];

        $em = $this->getDoctrine()->getManager();
        $cf_ev = $this->getDoctrine()->getRepository('AdminBundle:CentreFormation')->findOneBy(array('id' => $_POST['eventID']));

        $cf_ev->setData(json_encode($_POST));


        $em->persist($cf_ev);

        $em->flush($cf_ev);
        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/event/";

        if (!empty(($_FILES['file']['name']))) {


            if (is_file($uploaddir . "$idevent" . '.' . 'jpg')) {

                unlink($uploaddir . "$idevent" . '.' . 'jpg');

                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                move_uploaded_file(
                    $_FILES['file']['tmp_name'],
                    $uploaddir . "$idevent" . '.' . $ext
                );
            } else {
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
                $this->uploadFiles($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/event/", $idevent);
            }
        }
        return $this->redirect($_SERVER['PHP_SELF']);


    }

    public function delateeventAction(Request $request)


    {
        $idUser = $this->getUser()->getId();
        $id_qq = $_POST['idqqev'];
        $idevent = $_POST['idev'];


        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('AdminBundle:CentreFormation')->findOneBy(array('id' => $idevent, 'qouiqui' => $id_qq, 'section' => 'event'));

        if ($event):
            $em->remove($event);
            $em->flush($event);
        endif;


        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/service/";


        if (is_file($uploaddir . "$idevent" . '.' . 'jpg')) {

            unlink($uploaddir . "$idevent" . '.' . 'jpg');

        }


        die;

    }

    public function addTrainerAction()
    {

        $idUser = $this->getUser()->getId();
        $id_qq = $_POST['qq_id'];

        $em = $this->getDoctrine()->getManager();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($_POST['qq_id']);

        $cf = new CentreFormation();
        $cf->setSection('trainer');
        $cf->setData(json_encode($_POST));


        $cf->setQouiqui($qq);
        $em->persist($cf);

        $em->flush($cf);
        $em->refresh($cf);
        $id_event = $cf->getId();


        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser");
        endif;
        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq");
        endif;

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/trainer")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/trainer", 0777);
            chmod($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/trainer", 0777);
        endif;
        $this->uploadFiles($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/trainer/", $id_event);

//        $storeFolder = $file = $this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/service";
//        $targetPath = $storeFolder . $ds;

        return $this->redirect($_SERVER['PHP_SELF']);

    }


    public function editTrainerAction(Request $request)
    {

        $id_qq = $request->request->get('idqq');

        $id_serv = $request->request->get('idserv');


        $event = $this->getDoctrine()->getRepository('AdminBundle:CentreFormation')->findOneBy(array('id' => $id_serv, 'qouiqui' => $id_qq, 'section' => 'trainer'));
        if ($event):

            $rslt = $event->getData();
            $response = new Response($rslt);


            return $response;
        endif;

        die;


    }

    public function modifTrainerAction(Request $request, $idqq)

    {
        $idUser = $this->getUser()->getId();
        $idevent = $_POST['eventID'];

        $em = $this->getDoctrine()->getManager();
        $cf_ev = $this->getDoctrine()->getRepository('AdminBundle:CentreFormation')->findOneBy(array('id' => $_POST['eventID']));

        $cf_ev->setData(json_encode($_POST));

        $em->persist($cf_ev);

        $em->flush($cf_ev);
        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/trainer/";

        if (!empty(($_FILES['file']['name']))) {


            if (is_file($uploaddir . "$idevent" . '.' . 'jpg')) {

                unlink($uploaddir . "$idevent" . '.' . 'jpg');

            }
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                $uploaddir . "$idevent" . '.' . $ext
            );
        }
        return $this->redirect($_SERVER['PHP_SELF']);


    }

    public function delateTrainerAction(Request $request)


    {
        $idUser = $this->getUser()->getId();
        $id_qq = $_POST['idqqev'];
        $idevent = $_POST['idev'];


        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('AdminBundle:CentreFormation')->findOneBy(array('id' => $idevent, 'qouiqui' => $id_qq, 'section' => 'trainer'));

        if ($event):
            $em->remove($event);
            $em->flush($event);
        endif;


        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/trainer/";


        if (is_file($uploaddir . "$idevent" . '.' . 'jpg')) {

            unlink($uploaddir . "$idevent" . '.' . 'jpg');

        }


        die;
    }

    public function bookingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if (isset($_POST)) {
            dump($_POST);


            $id_qq = $_POST['qqid'];
            $candidat = $_POST['name'];
            $tel = $_POST['tel'];
            $mail = $_POST['email'];
//            $age = $_POST['age'];
//            $ville = $_POST['ville'];
            $adr = $_POST['adr'];
            $messg = $_POST['message'];
            if (isset($_POST['frmat'])) {
                $frm = $_POST['frmat'];

            } else {
                $frm = null;
            }
            if (isset($_POST['events'])) {
                $events = $_POST['events'];

            } else {
                $events = null;
            }


            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneBy(array("id" => $id_qq));
            $centre = $qq->getFirstName();


            $emailto = $qq->getMail();
            $date = new \DateTime();
            $info = json_encode($_POST);
//                $service = $_POST['appointment'];

            $User = $this->getUser();

            $booking = new Booking();
            $booking->setUser($User);
            $booking->setQouiqui($qq);
            $booking->setDate($date);
            $booking->setData($info);

            $em->persist($booking);
            $em->flush($booking);

            $transport = \Swift_SmtpTransport::newInstance('localhost', 25);
            $mailer = \Swift_Mailer::newInstance($transport);

            $privateKey = $this->getParameter('mail_privateKey');
            $domainName = $this->getParameter('domain');
            $selector = $this->getParameter('mail_selector');

            $signer = new \Swift_Signers_DKIMSigner($privateKey, $domainName, $selector);
            $message = \Swift_SignedMessage::newInstance();

            $message->attachSigner($signer);

            $message->setFrom('noreply@ween.tn')
                ->setTo('kachout.emna@gmail.com')
                ->setSubject('ween.tn')
                ->setBody(
                    $this->renderView('@Module/mail/email-centre-frm.html.twig', array(

                        'mail' => $mail,
                        'tel' => $tel,
                        'frm' => $frm,
                        'events' => $events,
//                        'ville' => $ville,
                        'addresse' => $adr,
//                        'age' => $age,
                        'centre' => $centre,
                        'messg' => $messg
                    )), "text/html"
                );

            $mailer->send($message);


        }

        return $this->redirect($_SERVER['PHP_SELF']);
    }

    function uploadFiles($file, $src, $name = null)
    {

        if (!empty($_FILES['file']['tmp_name'][0])) {
            $tempFile = $file['file']['tmp_name'][0];
            if (!$name)
                $name = md5(uniqid(rand(), true));
//            $targetFile = $src . $name . '.' . pathinfo($file['file']['name'][0], PATHINFO_EXTENSION);
            $targetFile = $src . $name . '.jpg';
            move_uploaded_file($tempFile, $targetFile);

            chmod($targetFile, 0777);
            return true;
        } else {
            return false;
        }
        return false;
    }

    function sectionAdAction($idqq)
    {


        $idUser = $this->getUser()->getId();

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser");
        endif;
        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq");
        endif;

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/sectionAd")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/sectionAd", 0777);
            chmod($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/sectionAd", 0777);
        endif;
//         $this->uploadFiles($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/booking/");
        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/sectionAd/";
        if (!empty($_FILES['file']['tmp_name'])) {


            if (is_file($uploaddir . '/photo.jpg')) {
                unlink($uploaddir . '/photo.jpg');

            }
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                $uploaddir . 'photo.jpg'
            );
        }


        $em = $this->getDoctrine()->getManager();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($idqq);


        $secCateg = $this->getDoctrine()->getRepository('AdminBundle:CentreFormation')->findOneBy(array('id' => $_POST['secCat'], 'qouiqui' => $idqq, 'section' => 'autre'));
        if ($secCateg) {
            $secCateg->setData($_POST['ad']);
            $em = $this->getDoctrine()->getManager();

            $em->persist($secCateg);
            $em->flush($secCateg);
        } else {
            $cf = new CentreFormation();
            $cf->setSection('autre');
            $cf->setData($_POST['ad']);

            $cf->setQouiqui($qq);
            $em->persist($cf);

            $em->flush($cf);
        }
        return $this->redirect($_SERVER['PHP_SELF']);

    }

    public function addCategoriesAction($idqq)
    {
//        dump($_POST['categorie']);
//       $test= explode(', ', ($_POST['categorie']));

        $idUser = $this->getUser()->getId();

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser");
        endif;
        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq");
        endif;

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/categories")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/categories", 0777);
            chmod($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/categories", 0777);
        endif;
//         $this->uploadFiles($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/booking/");
        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/categories/";
        if (!empty($_FILES['file']['tmp_name'])) {


            if (is_file($uploaddir . '/photo.jpg')) {
                unlink($uploaddir . '/photo.jpg');

            }
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                $uploaddir . 'photo.jpg'
            );
        }


        $secCateg = $this->getDoctrine()->getRepository('AdminBundle:CentreFormation')->findOneBy(array('id' => $_POST['idcatego'], 'qouiqui' => $idqq, 'section' => 'categorie'));
        if ($secCateg) {

            $categories = $_POST;
            $cat = json_encode($categories);

            $secCateg->setData($cat);
            $em = $this->getDoctrine()->getManager();

            $em->persist($secCateg);
            $em->flush($secCateg);
        } else {
            $categories = $_POST;
            $cat = json_encode($categories);

            $em = $this->getDoctrine()->getManager();
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($idqq);

            $cf = new CentreFormation();
            $cf->setSection('categorie');

            $cf->setData($cat);

            $cf->setQouiqui($qq);

            $em->persist($cf);


            $em->flush($cf);

            $em->refresh($cf);
        }
        return $this->redirect($_SERVER['PHP_SELF']);


    }

    public function contactezNousAction($id_qq)
    {
        if ($_POST) {

            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
                ->findOneBy(array('id' => $id_qq));
            $user = $qq->getUser();
            $emailqq = $qq->getMail();
            if (isset($_POST['name'])) {
                $name = $_POST['name'];
            } else {
                $name = '';
            };
            $fullName = $name;
            $email = $_POST['email'];
            $tel = $_POST['tel'];

            $messagetxt = $_POST['message'];

            $transport = \Swift_SmtpTransport::newInstance('localhost', 25);
            $mailer = \Swift_Mailer::newInstance($transport);
            $privateKey = $this->getParameter('mail_privateKey');
            $domainName = $this->getParameter('doamin');
            $selector = $this->getParameter('mail_selector');

            $signer = new \Swift_Signers_DKIMSigner($privateKey, $domainName, $selector);
            $message = \Swift_SignedMessage::newInstance();
            $message->attachSigner($signer);
            $message->setFrom('noreply@ween.tn')
                ->setTo('kachout.emna@gmail.com')
                ->setSubject('ween.tn')
                ->setBody(
                    $this->renderView('@Module/mail/contact.html.twig', array(
                        'fullName' => $fullName,
                        'email' => $email,
                        'tel' => $tel,
                        'messagetxt' => $messagetxt
                    )), "text/html"
                );
            $mailer->send($message);

            return $this->redirect($_SERVER['PHP_SELF']);
        }


    }


    function ficheAnnoncesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');
        $event = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        if ($event) {

            $Events = json_decode($event->getData(), true);
//            $Events = $Events['event'];
//            krsort($Events);

        } else {
            $Events = null;
        }


        return $this->render('@User/template/fiche/CentreFormation/annonces.html.twig', [
            'attributes' => $request->attributes->all(),
            'Events' => $Events
        ]);
    }


    function ficheServicesAction(Request $request)
    {

        $quoiqui = $request->get('quoiqui');

        $serv = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        if ($serv) {
            $formation = json_decode($serv->getData(), true);
            $formation = $formation['service'];
//            krsort($formation);
        } else {
            $formation = null;
        }

//        die;


        return $this->render('@User/template/fiche/CentreFormation/services.html.twig', [
            'attributes' => $request->attributes->all(), 'formation' => $formation
        ]);
    }

    function addEventsAction(Request $request, $idqq)
    {
        $idUser = $this->getUser()->getId();
        $quoiqui = $request->get('quoiqui');
        $em = $this->getDoctrine()->getManager();
        $id_serv = $_POST['idfrm'];
        $serv = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $_POST['qq_id']));

        if ($serv) {
            $data = json_decode($serv->getData(), true);
            $data['event']['frm' . $_POST['idfrm']] = $_POST;
            $serv->setData(json_encode($data));
            dump(json_encode($data));

        } else {
            $data['service']['frm' . $_POST['idfrm']] = $_POST;
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($_POST['qq_id']);
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
        $this->uploadFiles($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/event/", $id_serv);


        $em->persist($serv);

        $em->flush($serv);

        dump($serv);
        return $this->redirect($_SERVER['PHP_SELF']);
    }

    public function getEventAction(Request $request)

    {


        $idqq = $request->request->get('idqq');

        $idevent = $request->request->get('idevent');


        $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $idqq));

        $tab = json_decode($service->getData(), true);
        $array_event = $tab['event']['frm' . $idevent];

        $array_event = json_encode($array_event);

        $response = new Response($array_event);


        return $response;
    }

    function updateEventAction($qqId)
    {

        $idUser = $this->getUser()->getId();
        $idqq = $qqId;
        $idevent = $_POST['idfrm'];
        $em = $this->getDoctrine()->getManager();
        dump($_POST);
        $serv = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $qqId));
        $data = json_decode($serv->getData(), true);
        $data['event']['frm' . $_POST['idfrm']] = $_POST;

        $serv->setData(json_encode($data));


        $em->persist($serv);

        $em->flush($serv);


        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/event/";

        if (!empty(($_FILES['file']['name'][0]))) {


            if (is_file($uploaddir . "$idevent" . '.' . 'jpg')) {

                unlink($uploaddir . "$idevent" . '.' . 'jpg');
                $ext = pathinfo($_FILES['file']['name'][0], PATHINFO_EXTENSION);
                move_uploaded_file(
                    $_FILES['file']['tmp_name'][0],
                    $uploaddir . "$idevent" . '.' . $ext
                );
            } else {
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
                $this->uploadFiles($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/event/", $idevent);
            }

        }
        return $this->redirect($_SERVER['PHP_SELF']);
    }

    public function delateEventsAction(Request $request, $idqq, $idEve)
    {

        $idUser = $this->getUser()->getId();


        $em = $this->getDoctrine()->getManager();


        $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $idqq));
        if ($service) {
            $tab = json_decode($service->getData(), true);


            unset($tab['event']['frm' . $idEve]);
            $newtab = json_encode($tab);
            $service->setData($newtab);
            $em->persist($service);

            $em->flush($service);


            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/event/";


            if (is_file($uploaddir . "$idEve" . '.' . 'jpg')) {

                unlink($uploaddir . "$idEve" . '.' . 'jpg');

            }

        }

        return $this->redirect($_SERVER['PHP_SELF']);

    }

    public function getTimeWorkAction(Request $request)

    {

        $id_qq = $request->request->get('idqq');

        $id_serv = $request->request->get('idserv');


        $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $id_qq));


        $serv = $service->getData();

        $service = json_decode($serv, true);

        $horaires = $service['service']['frm' . $id_serv]['qouiqui'];

        $newH = array();
        foreach ($horaires as $k => $v) {
            if ($v['start'] != 0 && $v['end'] != 0) {


                $time = $v['start'] . ' - ' . $v['end'];
                $newH[$time][] = $k;

            }

        }
//        print_r($newH);
        print_r(json_encode($newH));


//        $response = new Response(json_encode($newH));


//        return $response;


        die;


    }


    public function delateServicesAction(Request $request, $idqq, $idserv)
    {

        $idUser = $this->getUser()->getId();


        $em = $this->getDoctrine()->getManager();


        $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $idqq));
        if ($service) {
            $tab = json_decode($service->getData(), true);


            unset($tab['service']['frm' . $idserv]);
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


    function servicePaginateAction(Request $request)
    {
        $page = 1;
        $id = 363;
        $offset = $page * 3;
        $nb = ($page + 1) * 3;
        $delete = array();
        $em = $this->getDoctrine()->getManager();


        $produit = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $id));

        if ($produit) {
            $formation = json_decode($produit->getData(), true);
            $formation = $formation['service'];
//            krsort($formation);
        } else {
            $formation = null;
        }


        $nbp = count($formation);
        foreach ($formation as $k => $v) {
            $sservices[] = $v;
        }
//        dump($sservices);
//        die;
        $nombre = $nbp - $nb;

        if ($nombre < 0) {

            $send = $nombre + 4;
            for ($i = $nbp - 1; $i >= $nbp - $send; $i--) {
                array_push($delete, $sservices[$i]);
            }
        } else {
            for ($i = $nb - 1; $i > $page * 4 - 1; $i--) {
                array_push($delete, $sservices[$i]['idfrm']);
            }
        }
        return new Response(json_encode($delete));
    }


}


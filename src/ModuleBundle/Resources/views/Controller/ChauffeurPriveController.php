<?php

namespace ModuleBundle\Controller;

use AdminBundle\Entity\ChauffeurPrive;
use AdminBundle\Entity\Mark;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ChauffeurPriveController extends Controller
{
    function ficheAnnoncesAction(Request $request)
    {


        $quoiqui = $request->get('quoiqui');
        $mission = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        if ($mission) {
            $mission = json_decode($mission->getData(), true);
        } else {
            $mission = null;
        }
        $marks = $this->getDoctrine()->getRepository('AdminBundle:Mark')->findBy(
            array(),
            array('id' => 'desc')
        );
        $models = $this->getDoctrine()->getRepository('AdminBundle:Model')->findBy(
            array(),
            array('id' => 'desc')
        );

        return $this->render('@User/template/fiche/ChauffeurPrive/annonces.html.twig', [
            'attributes' => $request->attributes->all(),
            'mission' => $mission,
            'marks' => $marks,
            'models' => $models
        ]);
    }


    function ficheServicesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');
        $mission = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        if ($mission) {
            $mission = json_decode($mission->getData(), true);
        } else {
            $mission = null;
        }

        return $this->render('@User/template/fiche/ChauffeurPrive/services.html.twig', [
            'attributes' => $request->attributes->all(),
            'mission' => $mission
        ]);
    }

    public function newAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $qq_id = $request->get('AdminBundle_chauffeur')['qqId'];
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneById($qq_id);
        $idUser = $this->getUser()->getId();
        $chauffeurPrive = new ChauffeurPrive();
        $form = $this->createForm('AdminBundle\Form\ChauffeurType', $chauffeurPrive);
        $form->handleRequest($request);
        $form->getData()->setQouiqui($quoiqui);
        if ($form->isSubmitted()) {
            $em->persist($chauffeurPrive);
            $em->flush();
            $em->refresh($chauffeurPrive);
            $chauffeurPriveId = $chauffeurPrive->getId();
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


            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article/$chauffeurPriveId")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article/$chauffeurPriveId", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article/$chauffeurPriveId", 0777);

            endif;

            if (is_file($_FILES["files"]["tmp_name"][0])) {
                $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article/$chauffeurPriveId";
                move_uploaded_file($_FILES["files"]["tmp_name"][0], $uploaddir . '/ween-Article-' . $chauffeurPriveId . '.jpg');
            }
        }


        return $this->redirect($_SERVER['PHP_SELF'] . '/#section-annonces');


    }

    public function editAction(Request $request, ChauffeurPrive $chauffeurPrive)

    {

        $em = $this->getDoctrine()->getManager();
        $qq_id = $request->get('AdminBundle_chauffeur')['qqId'];
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneById($qq_id);
        $idUser = $this->getUser()->getId();
        $chauffeurId = $chauffeurPrive->getId();
        $deleteForm = $this->createDeleteForm($chauffeurPrive);
        $editForm = $this->createForm('AdminBundle\Form\ChauffeurType', $chauffeurPrive);
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


                if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article/$chauffeurId")):
                    mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article/$chauffeurId", 0777);
                    chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article/$chauffeurId", 0777);

                endif;

                if (is_file($_FILES["files"]["tmp_name"][0])) {

                    $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/Article/$chauffeurId";
                    move_uploaded_file($_FILES["files"]["tmp_name"][0], $uploaddir . '/ween-Article-' . $chauffeurId . '.jpg');

                }
            }

        }
        return $this->redirect($_SERVER['PHP_SELF'] . '/#section-annonces');


    }

    public function deleteAction(Request $request, ChauffeurPrive $chauffeurPrive)
    {

        if (!empty($chauffeurPrive) & ($this->getUser()->getId() == $chauffeurPrive->getQouiqui()->getUser()->getId())) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($chauffeurPrive);
            $em->flush();
        }

        return $this->redirect($_SERVER['PHP_SELF'] . '/#section-annonces');
    }

    private function createDeleteForm(ChauffeurPrive $chauffeurPrive)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('chauffeur_delete', array('id' => $chauffeurPrive->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    public function addOffresAction($idqq)
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
        $this->uploadFiles($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/event/", $id_offre);


        $em->persist($serv);

        $em->flush($serv);


        return $this->redirect($_SERVER['PHP_SELF']);
    }

    public function findModelsAction(Request $request)
    {
        $markId = $request->get('mark_id');
        dump($markId);
        $em = $this->getDoctrine()->getManager();
        $mark = $em->getRepository('AdminBundle:Mark')->find($markId);
        $nameMarque = $mark->getName();
        $models = $em->getRepository('AdminBundle:Model')->findBy(array(
            'mark' => $mark
        ));
        $tab = array();
        foreach ($models as $key => $value) {
            $tab[$key]["name"] = $value->getName();
            $tab[$key]["mark"] = $nameMarque;
            $tab[$key]["id"] = $value->getId();
        }
        return new JsonResponse(array('message' => 'Success!', 'success' => true, 'mark_id' => $markId, 'models' => $tab, 200));
    }

    public function reserverCourseAction(Request $request)
    {
        /* $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');*/
        $em = $this->getDoctrine()->getManager();
        $dateReservation = $request->get('dateRdv');
        $adrDep = $request->get('adrDep');
        $direction = $request->get('direction');
        $adrArr = $request->get('adrArr');
        $distance = $request->get('distance');
        $duration = $request->get('duration');
        $tab = array('dateReservation' => $dateReservation, 'adrDep' => $adrDep, 'direction' => $direction, 'adrArr' => $adrArr, 'distance' => $distance, 'duration' => $duration);
        /*return new JsonResponse($tab);*/
        $transport = \Swift_SmtpTransport::newInstance('localhost', 25);
        $mailer = \Swift_Mailer::newInstance($transport);
        $privateKey = $this->getParameter('mail_privateKey');
//        $domainName = $this->getParameter('doamin');
        $selector = $this->getParameter('mail_selector');
//        $signer = new \Swift_Signers_DKIMSigner($privateKey, $domainName, $selector);
        $message = \Swift_SignedMessage::newInstance();
//        $message->attachSigner($signer);
        $message->setFrom('noreply@ween.tn')
            ->setTo('akrem.boussaha@gmail.com')//$qq->getMail()
            ->setSubject("Demande de reservation ")
            ->setBody(
                $this->renderView('@Module/mail/chauffeurPrive.html.twig', array(
                    'dateReservation' => $dateReservation,
                    'adresseDepart' => $adrDep,
                    'adresseArrive' => $adrArr,
                    'username' => $request->get('username'),
                    'telephone' => $request->get('telephone'),
                    'distance' => $distance,
                    'duration' => $duration,
                    'email' => $request->get("email"),
                    'body' => "Demande de reservation d'un chauffeur :",
                    'subject' => 'Demande de reservation: ',
                )), "text/html");
        $mailer->send($message);
        return new JsonResponse($tab);
    }

    public function estimerCourseAction(Request $request)
    {


        $em = $this->getDoctrine()->getManager();
        $adrDep = $request->get('adrDep');
        $direction = $request->get('direction');
        $adrArr = $request->get('adrArr');
        $distance = $request->get('distance');
        $formatedDistance = str_replace(' ', '', trim($request->get('formatedDistance')));
        $duration = $request->get('duration');
        $priceByMetre = floatval($request->get('priceMetre'));
        $intPriceMetre = floatval($priceByMetre);
        $intDistance = 1 * $formatedDistance;
        $priceMetre = $intDistance * $intPriceMetre;
        $tab = array('adrDep' => $adrDep, 'direction' => $direction, 'adrArr' => $adrArr, 'distance' => $distance, 'duration' => $duration, 'priceMetre' => $priceMetre);
        return new JsonResponse($tab);
    }

    function uploadFiles($file, $src, $name = null)
    {

        if (!empty($file['file']['tmp_name'][0])) {
            $tempFile = $file['file']['tmp_name'][0];
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


    public function addServiceAction($idqq)
    {
        $idUser = $this->getUser()->getId();

        $id_serv = $_POST['idserv'];

        $tab = array();
        $tab1 = array();
//        dump(  $_POST);
//        die;
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
        $this->uploadFiles($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/service/", $id_serv);


        $em->persist($serv);

        $em->flush($serv);

//        dump(  $serv);
//        die;
        return $this->redirect($_SERVER['PHP_SELF']);
    }


    public function getMarksAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $name = $request->get('term');
        $models = $em->getRepository('AdminBundle:Model')->createQueryBuilder('m')
                ->where('m.name LIKE :name')
                ->setParameter('name', '%'.$name.'%')
                ->getQuery()
                ->getResult();
        $tab = array();
        foreach ($models as $model) {
            $tab[] = $model->getName();
        }
       /* var_dump($tab);
        die();*/
        return new JsonResponse($tab);
    }

    public function calculatePriceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $term = $request->get('termm');
        $vehicule = $request->get('inputs');
        $currency = $request->get('currencies');
        if($currency == "Dinar")
        {
            $term = floatval($term)*10;
            $currencyFormated = $term;
        }
        else{
            $currencyFormated = floatval($term);
        }
        $distanceTunisSousse = 146;
        $priceTunisSousse = $distanceTunisSousse*$currencyFormated;
        $priceTunisSousse = floatval($priceTunisSousse);
        $priceTunisSoussee = $priceTunisSousse.' millime(s)'.$vehicule[0].': Tunis - Sousse '.$distanceTunisSousse.' Km';
        $distanceTunisJendouba = 161;
        $priceTunisJendouba = $distanceTunisJendouba*$currencyFormated;
        $priceTunisJendouba = $priceTunisJendouba.' millime(s)'.$vehicule[0].': Tunis - Jendouba '.$distanceTunisJendouba.' Km';
        $tab = array();
        /*$tab[]=$term;*/
        /*$tab[]=$vehicule;
        $tab[]=$currency;*/
        /*$tab[]=$priceTunisJendouba;
        $tab[]=$priceTunisSoussee;*/
        $tab['results']['label'] = $term.' | '.$priceTunisJendouba;
        $tab['results']['value'] = $term;
       /* $tab[]=$priceVehicule;*/
        /*var_dump($tab);
        die();*/
        return new JsonResponse($tab);
    }

}

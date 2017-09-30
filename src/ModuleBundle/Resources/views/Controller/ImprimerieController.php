<?php
/**
 * Created by PhpStorm.
 * User: POSTE 5
 * Date: 18/09/2017
 * Time: 10:33
 */

namespace ModuleBundle\Controller;

use AdminBundle\Entity\Architecture;
use AdminBundle\Entity\Imprimerie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class ImprimerieController extends Controller
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
        return $this->render('@User/template/fiche/Imprimerie/annonces.html.twig', [
            'attributes' => $request->attributes->all(),
            'mission'=>$mission
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
        return $this->render('@User/template/fiche/Imprimerie/services.html.twig', [
            'attributes' => $request->attributes->all(),
            'mission'=>$mission
        ]);
    }

    #crud offres
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
        $this->uploadFiles($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/event/", $id_offre);


        $em->persist($serv);

        $em->flush($serv);


        return $this->redirect($_SERVER['PHP_SELF']);
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

    function updateEventAction($idqq)
    {
//        dump($_POST);
//        die;
        $idUser = $this->getUser()->getId();

        $idservice = $_POST['idOffre'];
        $em = $this->getDoctrine()->getManager();

        $serv = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $idqq));
        $data = json_decode($serv->getData(), true);
        $data['event'][$_POST['idOffre']] = $_POST;

        $serv->setData(json_encode($data));


        $em->persist($serv);

        $em->flush($serv);


        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/event/";

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

                if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/event")):
                    mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/event", 0777);
                    chmod($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/event", 0777);
                endif;
                $this->uploadFiles($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/event/", $idservice);
            }

        }
        return $this->redirect($_SERVER['PHP_SELF']);
    }

    function getJsonOffreSpaAction(Request $request)
    {
        $id_qq = $request->request->get('idqq');

        $id_serv = $request->request->get('idserv');


        $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $id_qq));

        $tab = json_decode($service->getData(), true);
        $getspa = $tab['event'][$id_serv];

        $getspa = json_encode($getspa);


        $response = new Response($getspa);


        return $response;
    }

    public function demandeDevisAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $nomPrenom = $request->get('nomPrenom');
        $societe = $request->get('societe');
        $telephone = $request->get('telephone');
        $email = $request->get('email');
        $adresse = $request->get('adresse');
        $type = $request->get('type');
        $nbrCopie = $request->get('nbrCopie');
        $formaDoc = $request->get('formaDoc');
        $typeImpress = $request->get('typeImpress');
        $typePapier = $request->get('typePapier');
        $tab = array('nomPrenom' => $nomPrenom, 'societe' => $societe, 'telephone' => $telephone, 'email' => $email, 'adresse' => $adresse, 'type' => $type, 'nbrCopie'=>$nbrCopie, 'formaDoc'=>$formaDoc, 'typeImpress'=>$typeImpress, 'typePapier'=>$typePapier);
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
            ->setTo('akrem.boussaha@gmail.com') //$qq->getMail()
            ->setSubject("Demande de reservation ")
            ->setBody(
                $this->renderView('@Module/mail/imprimerieMail.html.twig', array(
                    'nomPrenom' => $nomPrenom, 'societe' => $societe, 'telephone' => $telephone, 'email' => $email, 'adresse' => $adresse, 'type' => $type, 'nbrCopie'=>$nbrCopie, 'formaDoc'=>$formaDoc, 'typeImpress'=>$typeImpress, 'typePapier'=>$typePapier,
                    'body' => "Demande de devis :",
                    'subject' => 'Demande de devis: ',
                )), "text/html");
        $mailer->send($message);
        return new JsonResponse($tab);
    }



}
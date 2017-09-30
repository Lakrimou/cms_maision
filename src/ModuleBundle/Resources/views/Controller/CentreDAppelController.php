<?php

namespace ModuleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CentreDAppelController extends Controller
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


        return $this->render('@User/template/fiche/CentreDAppel/services.html.twig', [
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


        return $this->render('@User/template/fiche/CentreDAppel/annonces.html.twig', [
            'attributes' => $request->attributes->all(), 'Spaevent' => $service
        ]);
    }

    function reservationAction(Request $request, $idqq)
    {
        $user = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $idqq));

        $idUser = $user->getUser()->getId();
        $lien = '';


        $poste = $_POST['ServSpa'];
        $name = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $adr = $_POST['adr'];
        $codepostal = $_POST['codepostal'];
        $tel = $_POST['tel'];


        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser");
        endif;
        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq");
        endif;

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/file")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/file", 0777);
            chmod($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/file", 0777);
        endif;

        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/file";
        for ($i = 0; $i < sizeof($_FILES['file']['tmp_name']) - 1; $i++) {

            if (!empty($_FILES['file']['name'][$i])) {

                $lien1[] = $_FILES['file']['name'][$i];
                $tempFile = $_FILES['file']['tmp_name'][$i];
                $file_name = $_FILES['file']['name'][$i];
                $ext = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
                move_uploaded_file(
                    $tempFile, $uploaddir . '/' . $file_name
                );
            }


        }

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
            ->setSubject($poste)
            ->setBody(
                $this->renderView('@Module/mail/candidature.html.twig', array(
                    'tel' => $tel,
                    'lien1' => $lien1,
                    'email' => $email,
                    'poste' => $poste,
                    'name' => $name,
                    'prenom' => $prenom,
                    'adr' => $adr,
                    'user' => $user,
                    'codepostal' => $codepostal,
                )), "text/html"


            );

        $mailer->send($message);
//        return $this->render('@Module/mail/candidature.html.twig', array(
//            'tel'=>$tel,
//            'lien1' => $lien1,
//            'email' => $email,
//            'poste' => $poste,
//            'name' => $name,
//            'prenom' => $prenom,
//            'adr' => $adr,
//            'codepostal' => $codepostal,
//            'user'=> $user
//        ));

        return $this->redirect($_SERVER['PHP_SELF'] . '#section-services');
    }

    function uploadFiles($file, $src, $name = null)
    {

        if (!empty($file['file']['tmp_name'])) {
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

<?php
/**
 * Created by PhpStorm.
 * User: POSTE 7
 * Date: 07/09/2017
 * Time: 16:38
 */

namespace ModuleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Entity\Booking;

class KineController extends Controller
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


        return $this->render('@User/template/fiche/Kine/services.html.twig', [
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


        return $this->render('@User/template/fiche/Kine/annonces.html.twig', [
            'attributes' => $request->attributes->all(), 'Spaevent' => $service
        ]);
    }
    public function bookingAction(Request $request,$idqq)
    {
        $em = $this->getDoctrine()->getManager();
        $id_qq=$idqq;
        if (isset($_POST)) {




//            $id_qq = $_POST['qqid'];
            $candidat = $_POST['name'];
            $tel = $_POST['tel'];
            $mail = $_POST['email'];

            $adr = $_POST['adr'];

            if (isset($_POST['ServSpa'])) {
                $frm = $_POST['ServSpa'];

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
                    $this->renderView('@Module/mail/rdv.html.twig', array(

                        'mail' => $mail,
                        'tel' => $tel,
                        'frm' => $frm,
                        'events' => $events,
                        'addresse' => $adr,
                        'centre' => $centre,
//                        'niveau_etude' => $niveau_etude
                    )), "text/html"
                );

            $mailer->send($message);


        }

        return $this->redirect($_SERVER['PHP_SELF']);
    }
}
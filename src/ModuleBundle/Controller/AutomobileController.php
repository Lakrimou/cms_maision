<?php
/**
 * Created by PhpStorm.
 * User: Ameni
 * Date: 04/07/2017
 * Time: 08:59
 */

namespace ModuleBundle\Controller;


use AdminBundle\Entity\Automobile;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class AutomobileController extends Controller
{
    public function getTextAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->find($id);
        $textSlider = $quoiqui->getTextSilder();

        return $this->render('ModuleBundle:Module/automobile:renderTextSlide.html.twig', array("textSlider" => $textSlider)
        );


    }

    public function getOffersAction()
    {

        $qouiquiId = $_POST['quoiqui'];


        $em = $this->getDoctrine()->getManager();
        $qouiqui = $em->getRepository('AdminBundle:Qouiqui')->find($qouiquiId);


        $automobiles = $em->getRepository('AdminBundle:Automobile')->findAll();


        $searchJson = $_POST['jsonSearch'];

        if ($searchJson['model'] != "") {

            $newAutomobile = array();

            foreach ($automobiles as $automobile) {
                if ($automobile->getModel()->getName() == $searchJson['model']) {
                    $newAutomobile[] = $automobile;


                }
            }

            $automobiles = $newAutomobile;
        }


        if ($searchJson['mark'] != "") {

            $newAutomobile = array();

            foreach ($automobiles as $automobile) {
                if ($automobile->getModel()->getMark()->getName() == $searchJson['mark']) {
                    $newAutomobile[] = $automobile;


                }
            }
            $automobiles = $newAutomobile;

        }
        if ($searchJson['reference'] != "") {

            $newAutomobile = array();

            foreach ($automobiles as $automobile) {
                if ($automobile->getReference() == $searchJson['reference']) {
                    $newAutomobile[] = $automobile;


                }
            }
            $automobiles = $newAutomobile;
        }


        if (($searchJson['annee-min']) != "") {

            $newAutomobile = array();

            foreach ($automobiles as $automobile) {
                if ($automobile->getModelYear() >= (int)($searchJson['annee-min'])) {
                    $newAutomobile[] = $automobile;


                }
            }
            $automobiles = $newAutomobile;


        }
        if (($searchJson['anne-max']) != "") {


            $newAutomobile = array();

            foreach ($automobiles as $automobile) {
                if ($automobile->getModelYear() <= (int)($searchJson['anne-max'])) {
                    $newAutomobile[] = $automobile;


                }
            }
            $automobiles = $newAutomobile;


        }


        if (($searchJson['km-min']) != "") {

            $newAutomobile = array();

            foreach ($automobiles as $automobile) {
                if ($automobile->getMileage() >= ((int)($searchJson['km-min']))) {
                    $newAutomobile[] = $automobile;


                }
            }
            $automobiles = $newAutomobile;
        }

        if (($searchJson['km-max']) != "") {

            $newAutomobile = array();

            foreach ($automobiles as $automobile) {
                if ($automobile->getMileage() <= (int)($searchJson['km-max'])) {
                    $newAutomobile[] = $automobile;


                }
            }
            $automobiles = $newAutomobile;

        }

        if (($searchJson['prix-min']) != "") {

            $newAutomobile = array();

            foreach ($automobiles as $automobile) {
                if ($automobile->getPrice() >= (int)($searchJson['prix-min'])) {
                    $newAutomobile[] = $automobile;


                }
            }
            $automobiles = $newAutomobile;

        }

        if (($searchJson['prix-max']) != "") {

            $newAutomobile = array();

            foreach ($automobiles as $automobile) {
                if ($automobile->getPrice() <= (int)($searchJson['prix-max'])) {
                    $newAutomobile[] = $automobile;


                }
            }
            $automobiles = $newAutomobile;

        }


        $template = $this->renderView('ModuleBundle:Module/automobile:renderOffres.html.twig', array("automobiles" => $automobiles, "qouiqui" => $qouiqui)
        );

        return new Response($template);


    }

    public function getSlidesAction()
    {

        $id_qq = $_POST['quoiqui'];
        $em = $this->getDoctrine()->getManager();
        $qouiqui = $em->getRepository('AdminBundle:Qouiqui')->find($id_qq);
        $idUser = $qouiqui->getUser()->getId();
        if (is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/slider")):

            $rp = $this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/slider";
            $slider = array();


            $rep = opendir($rp);
            while ($sous_fichier = readdir($rep)) {
                if (($sous_fichier == ".") || ($sous_fichier == "..")) {
                    echo "";
                } else {
                    $slider[] = $sous_fichier;
                }
            }
            sort($slider);
            closedir($rep);
        else:
            $this->addFlash(
                'notice', 'vous n avez pas de photo'
            );


            $slider = false;
        endif;
        $template = $this->renderView('ModuleBundle:Module/automobile:renderListSlider.html.twig', array("slider" => $slider, "qouiqui" => $qouiqui)
        );


        return new Response($template);


    }

    public function getLastOffersAction()
    {
        $id_qq = $_POST['quoiqui'];
        $em = $this->getDoctrine()->getManager();
        $qouiqui = $em->getRepository('AdminBundle:Qouiqui')->find($id_qq);
        $automobiles = $em->getRepository('AdminBundle:Automobile')->findBy(array(), array('id' => 'DESC'));
        $automobiles = array_slice($automobiles, 0, 30);


        return new Response(new JsonResponse(array("automobiles" => $automobiles, "qouiqui" => $qouiqui)));

    }

    public function sendMailAction(Request $request)
    {

        $transport = \Swift_SmtpTransport::newInstance('localhost', 25);
        $mailer = \Swift_Mailer::newInstance($transport);
        $privateKey = $this->getParameter('mail_privateKey');
        $domainName = $this->getParameter('doamin');
        $selector = $this->getParameter('mail_selector');

        $signer = new \Swift_Signers_DKIMSigner($privateKey, $domainName, $selector);
        $message = \Swift_SignedMessage::newInstance();
        $message->attachSigner($signer);
        $message->setFrom('noreply@ween.tn')
            ->setTo($request->request->get("email"))
            ->setSubject("Demande de contact")
            ->setBody(
                $this->renderView('@Module/mail/contact-mail.html.twig', array(
                    'name' => $request->request->get("name"),
                    'email' => $request->request->get("email"),
                    'body' => $request->request->get("body"),
                    'subject' => $request->request->get("subject"),


                )), "text/html");
        $mailer->send($message);
        return $this->redirect($_SERVER['PHP_SELF']);

    }

    public function deleteOfferAction($idQuoi, $idModule)
    {


        $em = $this->getDoctrine()->getManager();
        $qouiqui = $em->getRepository('AdminBundle:Qouiqui')->find($idQuoi);
        $automobile = $em->getRepository('AdminBundle:Automobile')->find($idModule);
        $em->remove($automobile);
        $em->flush();


        return $this->redirect($_SERVER['PHP_SELF']);

    }

    public function changePrincipaleImageAction()
{

    $em = $this->getDoctrine()->getManager();
    $idModule = $_POST['module'];

    $index = $_POST['index'];
    $automobile = $em->getRepository('AdminBundle:Automobile')->find($idModule);
    $automobile->setIndexPrincipaleImage($index);
    $em->flush();
    return $this->redirect($_SERVER['PHP_SELF']);

}

    public function updateLastOffersAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $qouiqui = $em->getRepository('AdminBundle:Qouiqui')->find($id);
        $data = $qouiqui->getData();
        $title = $_POST['titleLastOffers'];
        $numberOfLastOffers = $_POST['numberOfLastOffers'];


        if ($data) {
            $arrayData = json_decode($data, true);
            if (array_key_exists('titleLastOffers', $arrayData)) {
                $arrayData['titleLastOffers'] = $title;

            } else {

                array_push($arrayData, array("titleLastOffers" => $title));
            }
            if (array_key_exists('numberLastOffers', $arrayData)) {
                $arrayData['numberLastOffers'] = $numberOfLastOffers;

            } else {

                array_push($arrayData, array("numberLastOffers" => $numberOfLastOffers));
            }


        } else {
            $arrayData = array();
            $arrayData['titleLastOffers'] = $title;
            $arrayData['numberLastOffers'] = $numberOfLastOffers;

        }
        $data = json_encode($arrayData);
        $qouiqui->setData($data);
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF']);

    }

    public function updateProfileAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->find($id);
        $firstName = $request->request->get("firstName");
        $lastName = $request->request->get("lastName");
        $website = $request->request->get("website");
        $facebook = $request->request->get("facebook");
        $tweeter = $request->request->get("tweeter");
        $google = $request->request->get("google");
        $linkedin = $request->request->get("linkedin");
        $youtube = $request->request->get("youtube");
        $sociaux = array();
        $sociaux["facebook"] = $facebook;
        $sociaux["tweeter"] = $tweeter;
        $sociaux["google"] = $google;
        $sociaux['youtube'] = $youtube;
        $sociaux['linkedin'] = $linkedin;
        $quoiqui->setFirstName($firstName);
        $quoiqui->setLastName($lastName);
        $quoiqui->setWebsite($website);
        $quoiqui->setSociaux(json_encode($sociaux));
        $em->flush();


        return $this->redirect($_SERVER['PHP_SELF']);

    }

    public function changeColorThemeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $quoiquiId = $_POST['quoiqui'];
        $color = $_POST['color'];
        $themes = $em->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiquiId));
        $arrayData = array();
        if ($themes->getData()) {
            $arrayData = json_decode($themes->getData(), true);
            if ($arrayData["Color"]) {
                $arrayData["Color"] = $color;
            } else {
                array_push($arrayData, array("Color" => $color));

            }
        } else {
            $arrayData["Color"] = $color;
        }


        $jsonData = json_encode($arrayData);
        $themes->setData($jsonData);
        $em->persist($themes);
        $em->flush();
        return new Response("ok");


    }

    public function changeBackgroundAction()
    {
        $em = $this->getDoctrine()->getManager();
        $quoiquiId = $_POST['quoiqui'];
        $color = $_POST['color'];
        $themes = $em->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiquiId));
        $arrayData = array();
        if ($themes->getData()) {
            $arrayData = json_decode($themes->getData(), true);
            if ($arrayData["Color"]) {
                $arrayData["Color"] = $color;
            } else {
                array_push($arrayData, array("Color" => $color));

            }
        } else {
            $arrayData["Color"] = $color;
        }


        $jsonData = json_encode($arrayData);
        $themes->setData($jsonData);
        $em->persist($themes);
        $em->flush();
        return new Response("ok");


    }

    public function setColor()
    {
        $em = $this->getDoctrine()->getManager();
        $quoiquiId = $_POST['quoiqui'];
        $color = $_POST['color'];
        $themes = $em->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiquiId));
        $arrayData = array();
        if ($themes->getData()) {
            $arrayData = json_decode($themes->getData(), true);
            if ($arrayData["Color"]) {
                $arrayData["Color"] = $color;
            } else {
                array_push($arrayData, array("Color" => $color));

            }
        } else {
            $arrayData["Color"] = $color;
        }


        $jsonData = json_encode($arrayData);
        $themes->setData($jsonData);
        $em->persist($themes);
        $em->flush();
    }

    public function listModelsAction()
    {
        $markName = $_POST['mark'];

        $em = $this->getDoctrine()->getManager();


        $mark = $em->getRepository('AdminBundle:Mark')->findOneBy(array('name' => $markName));
        $models = $em->getRepository('AdminBundle:Model')->findBy(array('mark' => $mark));


        $template = $this->renderView('ModuleBundle:Module/automobile:renderlistModels.html.twig', array("models" => $models, "name" => $markName)
        );

        return new Response($template);

    }

    public function listMarksAction()
    {

        $em = $this->getDoctrine()->getManager();
        $marks = $em->getRepository('AdminBundle:Mark')->findAll();
        $markArray=array();

       foreach ($marks as $mark){
           $markArray[]=$mark->getName();


       }



        return new Response(json_encode($markArray));


    }

    public function updateProfileSimpleUserAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AdminBundle:User')->find($id);
        $user->setAdress($request->request->get("address"));
        $user->setEmail($request->request->get("email"));
        $user->setUsername($request->request->get("firstName"));
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF']);

    }

    public function updatePasswordAction(Request $request)
    {
        $user = $this->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }


        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.change_password.form.factory');
        $form = $formFactory->createForm();
        $form->setData($user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $password = $_POST[("fos_user_change_password_form")];

            $encoder_service = $this->get('security.encoder_factory');
            $encoder = $encoder_service->getEncoder($user);
            $encoded_pass = $encoder->encodePassword($password["current_password"], $user->getSalt());
            if ($encoded_pass == $user->getPassword()) {


                /** @var $userManager UserManagerInterface */
                $userManager = $this->get('fos_user.user_manager');


                $userManager->updateUser($user);

                return $this->redirect($_SERVER['PHP_SELF']);
            }
            else {
                return $this->redirect("http://ventevoiture.ween.tn/?pwd=false");
            }
        }

        return new Response($this->renderView('ModuleBundle:Module/automobile:renderChangePassword.html.twig', array(
            //note remove this comment. pass the form to template
            'form' => $form->createView()
        )));

    }


    function ficheServicesAction(Request $request)
    {


        return $this->render('@User/template/fiche/Automobile/services.html.twig', [
            'attributes' => $request->attributes->all(),

        ]);
    }


    function ficheAnnoncesAction(Request $request)
    {


        return $this->render('@User/template/fiche/Automobile/annonces.html.twig', [
            'attributes' => $request->attributes->all(),
        ]);
    }

}
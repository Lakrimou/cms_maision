<?php

namespace ModuleBundle\Controller;

use AdminBundle\AdminBundle;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AdminBundle\Entity\Booking;
use AdminBundle\Entity\Theme;
use AdminBundle\Entity\Automobile;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class DefaultController extends Controller
{
    public function indexAction($categorie)
    {

        $em = $this->getDoctrine()->getManager();


        return $this->render('ModuleBundle:Module:' . $categorie . '\index.html.twig');
    }

    public function reservationAction(Request $request, $event_id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $idUser = $this->getUser()->getId();
        $event = $em->getRepository('AdminBundle:Events')->findOneById($event_id);
        $booking = $em->getRepository('AdminBundle:Booking')->findOneBy(array("user" => $user, 'events' => $event));

        if (!$booking) {
            $booking = new Booking();
            $QQ = $event->getQville()->getqouiqui();
            $today = $this->updated = new \DateTime("now");
            $booking->setDate($today);
            $booking->setEvents($event);
            $booking->setQouiqui($QQ);
            $booking->setUser($user);
            $em->persist($booking);
            $em->flush($booking);

            $echec = $_SERVER['PHP_SELF'] . '?reservation=1';
            return $this->redirect($echec);

        } else {

            $echec = $_SERVER['PHP_SELF'] . '?reservation=0';
            return $this->redirect($echec);

        }
    }

    public function suppavatarAction($qq_id)
    {

        $idUser = $this->getUser()->getId();
        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/avatar";

        if (is_file($uploaddir . '/avatar.jpg')) {
            unlink($uploaddir . '/avatar.jpg');
        }

        return $this->redirect($_SERVER['PHP_SELF']);

    }

    public function etrerapelerAction($qq_id)
    {

        $rapele = $_POST['rapele'];
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($qq_id);
        $transport = \Swift_SmtpTransport::newInstance('localhost', 25);
        $mailer = \Swift_Mailer::newInstance($transport);
        $privateKey = $this->getParameter('mail_privateKey');
        $domainName = $this->getParameter('domain');
        $selector = $this->getParameter('mail_selector');

        $signer = new \Swift_Signers_DKIMSigner($privateKey, $domainName, $selector);
        $message = \Swift_SignedMessage::newInstance();
        $message->attachSigner($signer);
        $message->setFrom('noreply@ween.tn')
            ->setTo($qq->getMail())
            ->setSubject('Nouveau mail - ween.tn')
            ->setBody(
                $this->renderView('@Module/mail/rapeler-mail.html.twig', array(
                    'rapele' => $rapele,
                    'qouiqui' => $qq
                )), "text/html"


            );
        $mailer->send($message);

        return $this->render('@Module/mail/rapeler-mail.html.twig', array(
            'rapele' => $rapele,
            'qouiqui' => $qq
        ));
        return $this->redirect($_SERVER['PHP_SELF']);

    }

    public function DemandevisiteAction($qq_id)
    {
        $visite = $_POST['visite'];

        if (!array_key_exists('ref', $visite)) {
            $visite["ref"] = $_GET['ref'];

        }


        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($qq_id);
        $transport = \Swift_SmtpTransport::newInstance('localhost', 25);
        $mailer = \Swift_Mailer::newInstance($transport);
        $privateKey = $this->getParameter('mail_privateKey');
        $domainName = $this->getParameter('domain');
        $selector = $this->getParameter('mail_selector');

        $signer = new \Swift_Signers_DKIMSigner($privateKey, $domainName, $selector);
        $message = \Swift_SignedMessage::newInstance();
        $message->attachSigner($signer);
        $message->setFrom('noreply@ween.tn')
            ->setTo($qq->getMail())
            ->setSubject('ween.tn')
            ->setBody(
                $this->renderView('@Module/mail/visite-mail.html.twig', array(
                    'visite' => $visite,
                    'qouiqui' => $qq
                )), "text/html"
            );
        $mailer->send($message);

        return $this->render('@Module/mail/visite-mail.html.twig', array(
            'visite' => $visite,
            'qouiqui' => $qq
        ));
        return $this->redirect($_SERVER['PHP_SELF']);


    }

    public function changecolorAction(Request $request, $qq_id)
    {


        $theme = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $qq_id));
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($qq_id);
        if ($theme == null) {
            $theme = new Theme();
            $data['color'] = $request->get('color');
            $data = json_encode($data);
            $theme->setData($data);
            $theme->setQouiqui($qq);
        } else {
            $data = json_decode($theme->getData(), true);

            $data['color'] = $request->get('color');
            $data = json_encode($data);
            $theme->setData($data);
        }


        $em = $this->getDoctrine()->getManager();

        $em->persist($theme);
        $em->flush($theme);


        return $this->redirect($_SERVER['PHP_SELF']);

    }

    public function changeBannerAction(Request $request, $qq_id)
    {

        $theme = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $qq_id));
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($qq_id);
        if ($theme == null) {
            $theme = new Theme();
            $data['banner'] = $request->get('banner');
            $data = json_encode($data);
            $theme->setData($data);
            $theme->setQouiqui($qq);
        } else {
            $data = json_decode($theme->getData(), true);
            $data['banner'] = $request->get('banner');
            $data = json_encode($data);


            $theme->setData($data);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($theme);
        $em->flush($theme);
        return $this->redirect($_SERVER['PHP_SELF']);
    }

    public function changeavatarAction(Request $request, $qq_id)
    {

        if ($_FILES['fileToUpload']['tmp_name']) {
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
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/avatar")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/avatar", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/avatar", 0777);
            endif;

            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/avatar/";


            if (is_file($uploaddir . '/avatar.jpg')) {
                unlink($uploaddir . '/avatar.jpg');

            }
            move_uploaded_file(
                $_FILES['fileToUpload']['tmp_name'][0],
                $uploaddir . '/avatar.jpg'
            );


        }


        return $this->redirect($_SERVER['PHP_SELF']);


    }

    public function SupprimImGalleryAction(Request $request, $id_qq)
    {


        $idUser = $this->getUser()->getId();

        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/gallery/";

        $img = $_POST['img'];

        if (is_file($uploaddir . '/' . $img)) {
            unlink($uploaddir . '/' . $img);

            list($image) = split('.jpg', $img);

            $imageThumbs = $image . '~thumbs.jpg';
            if (is_file($uploaddir . '/' . $imageThumbs)) {
                unlink($uploaddir . '/' . $imageThumbs);
            }

        }
        die;

    }


    public function uploadgalleryAction(Request $request, $id_qq)
    {


//        dump(sizeof($_FILES['files']['tmp_name']));die;
        if ($_FILES) {


            $idUser = $this->getUser()->getId();

            if (defined($request->get('TypeGallery'))) {
                $TypeGallery = $request->get('TypeGallery');

            } else {
                $TypeGallery = "ween";
            }

//            $img = $TypeGallery . '-' . uniqid();
//            $chars = preg_split('/#/', $img, -1, PREG_SPLIT_NO_EMPTY);
//            dump($request->get('TypeGallery'),$img,$chars);

            #creation dossier avec l'id de l'utilisateur si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
            endif;

            #creation dossier avec l'id de QUOIQUI si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/", 0777);
            endif;
            #creation dossier gallery si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/gallery")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/gallery", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/gallery", 0777);
            endif;

            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/gallery/";


            for ($i = 0; $i <= sizeof($_FILES['files']['tmp_name']) - 1; $i++) {
                if (!empty($_FILES['files']['tmp_name'][$i])) {
                    $img = $TypeGallery . '-' . uniqid();
                    list($width, $height) = getimagesize($_FILES['files']['tmp_name'][$i]);
                    move_uploaded_file(

                        $_FILES['files']['tmp_name'][$i],
                        $uploaddir . '/' . $img . '.jpg'
                    );
                    $newheight = ($height * 350) / $width;

                    $img_big = imagecreatefromjpeg($uploaddir . '/' . $img . '.jpg');
                    $img_new = imagecreate($newheight, 350);

                    $newheight = $height ;
                    $newwidth = $width;

                    if($height > 670 && $width > 980){
                        $newheight = $height/2 ;
                        $newwidth = $width/2;
                    }

                    $src_x = ($width - 350)/2;
                    $src_y = ($height - 233)/2;


                    $img_petite = imagecreatetruecolor(350, 233) or $img_petite = imagecreate(350, 233);
                    imagecopyresized($img_petite, $img_big, 0, 0, $src_x, $src_y, $newwidth, $newheight, $width, $height);
                    imagejpeg($img_petite, $uploaddir . '/' . $img . '~thumbs.jpg');

                }
            }

            return $this->redirect($_SERVER['PHP_SELF'] . '#section-gallerie');


        }
        die;

    }


    public function isviewAction(Request $request)
    {

        $qq_id = $request->get('qqid');
        $QQ = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
            ->findOneBy(array('id' => $qq_id));
        $QQ->setIsview('1');
        $em = $this->getDoctrine()->getManager();
        $em->persist($QQ);
        $em->flush();
        die('updated !');

    }


    public function contactezNousAction($id_qq)
    {
        if ($_POST) {
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
                ->findOneBy(array('id' => $id_qq));
            $user = $qq->getUser();
            $emailqq = $qq->getMail();
            $name = $_POST['name'];
            if (isset($_POST['surname'])) {
                $surname = $_POST['surname'];
            } else {
                $surname = '';
            };
            $fullName = $name . ' ' . $surname;
            $email = $_POST['email'];
            $objet = $_POST['objet'];
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
                ->setTo('moknisofien@gmail.com')
                ->setSubject('ween.tn')
                ->setBody(
                    $this->renderView('@Module/mail/contact.html.twig', array(
                        'fullName' => $fullName,
                        'email' => $email,
                        'objet' => $objet,
                        'messagetxt' => $messagetxt
                    )), "text/html"
                );
            $mailer->send($message);

            return $this->redirect($_SERVER['PHP_SELF']);
        }

    }

    public function logomailAction($qqid)
    {
        if ($_POST) {
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
                ->findOneBy(array('id' => $qqid));
            $user = $qq->getUser();
            $emailqq = $qq->getMail();
            $name = $_POST['non'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $fullName = $name . ' ' . $prenom;
            $phone = $_POST['phonenumber'];


            $transport = \Swift_SmtpTransport::newInstance('localhost', 25);
            $mailer = \Swift_Mailer::newInstance($transport);
            $privateKey = $this->getParameter('mail_privateKey');
            $domainName = $this->getParameter('domain');
            $selector = $this->getParameter('mail_selector');

            $signer = new \Swift_Signers_DKIMSigner($privateKey, $domainName, $selector);
            $message = \Swift_SignedMessage::newInstance();
            $message->attachSigner($signer);
            $message->setFrom('noreply@ween.tn')
                ->setTo('moknisofien@gmail.com')
                ->setSubject('ween.tn')
                ->setBody(
                    $this->renderView('@Module/mail/logo-mail.html.twig', array(
                        'fullName' => $fullName,
                        'email' => $email,
                        'phone' => $phone
                    )), "text/html"
                );
//            $mailer->send($message);

            return $this->render('@Module/mail/logo-mail.html.twig', array(
                'fullName' => $fullName,
                'email' => $email,
                'phone' => $phone
            ));
        }

    }

    public function numberOfModulesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $object = $_POST['object'];
        $searchJson = $_POST['jsonSearch'];
        $objectGlobal = "AdminBundle\Entity\\$object";
        $objectSon = array();
        $quoiquiId = $_POST['quoiqui'];
        $quoiqui = $em->getRepository("AdminBundle:Qouiqui")->find($quoiquiId);
        $modules = $em->getRepository("AdminBundle:$object")->findBy(array("qouiqui" => $quoiqui));
        $searchJson = (json_decode($searchJson, true));
        $modules = $this->getSonsModule($searchJson, $objectGlobal, $modules, $objectSon);
        return new Response(count($modules));


    }

    public function listObjectsAction()
    {


        $em = $this->getDoctrine()->getManager();
        $numberPerPage = $_POST['number'];
        $object = $_POST['object'];
        $page = $_POST['page'];
        $searchJson = $_POST['jsonSearch'];
        $quoiquiId = $_POST['quoiqui'];
        $quoiqui = $em->getRepository("AdminBundle:Qouiqui")->find($quoiquiId);

        $idUser = $quoiqui->getUser()->getId();

        $modulesArray = array();
        $index = 0;


        $objectGlobal = "AdminBundle\Entity\\$object";
        $searchJson = (json_decode($searchJson, true));


        $modules = $em->getRepository("AdminBundle:$object")->findBy(array("qouiqui" => $quoiqui), array(), $numberPerPage, ($page - 1) * $numberPerPage);
        $objectSon = array();

        $modules = $this->getSonsModule($searchJson, $objectGlobal, $modules, $objectSon);

        $ingnored = $this->transformObjectToString($objectGlobal);
        $ingnoredExpectQuoiquiArray = array();
        foreach ($ingnored as $ingnoredExpectQuoiqui) {
            if ($ingnoredExpectQuoiqui != "qouiqui") {

                $ingnoredExpectQuoiquiArray[] = $ingnoredExpectQuoiqui;
            }
        }

        foreach ($modules as $module) {


            $idModule = $module->getId();


            $images = $this->getImagesOfObject($_SERVER['PHP_DOCUMENT_ROOT'] . "/web/annuaire/web/uploads/image/$idUser/$quoiquiId/Offres/$idModule");
            $moduleJson = $this->transformObjectToJson($module, $ingnored);
            $modulesArray[$index] = json_decode($moduleJson, true);
            foreach ($ingnoredExpectQuoiquiArray as $obectSon) {
                $function = "get" . ucfirst($obectSon);
                $modulesArray[$index][$obectSon] = (string)($module->$function());
                $objectSonGlobal = "AdminBundle\Entity\\$obectSon";
                $objectNewSonArray = $this->transformObjectToString($objectSonGlobal);
                foreach ($objectNewSonArray as $objectNewSon) {
                    $functionSon = "get" . ucfirst($objectNewSon);
                    $modulesArray[$index][$objectNewSon] = (string)($module->$function()->$functionSon());
                }


            }


            $modulesArray[$index]["images"] = $images;

            $index++;

        }


        return new Response(json_encode($modulesArray));

    }

    public function transformObjectToJson($object, $ignoredAttributes)
    {

        $normalizer = new ObjectNormalizer();

        $normalizer->setIgnoredAttributes($ignoredAttributes);

        $encoder = new JsonEncoder();

        $serializer = new Serializer(array($normalizer), array($encoder));
        $object = $serializer->serialize($object, 'json');
        return $object;
    }

    private function getSonsModule($array, $objectGlobal, $modules, $objectSon)
    {


        foreach ($array as $key => $value) {

            if (($value != "") && (property_exists($objectGlobal, $key)) && !is_array($value)) {


                $newModules = array();
                $function = "get" . ucfirst($key);


                foreach ($modules as $module) {


                    $newmodule = $module;
                    foreach ($objectSon as $objectString) {
                        $newmodule = $newmodule->$objectString();
                    }

                    if ($newmodule->$function() == $value) {
                        $newModules[] = $module;
                    }
                }
                $modules = $newModules;


            } else if ((property_exists($objectGlobal, $key)) && is_array($value)) {
                $objectSon[] = "get" . ucfirst($key);


                $modules = $this->getSonsModule($value, "AdminBundle\Entity\\$key", $modules, $objectSon);

            } else if (!(property_exists($objectGlobal, $key)) && is_array($value)) {


                foreach ($value as $keyCompare => $valueCompare) {
                    if ($valueCompare != "") {
                        $newModules = array();
                        $function = "get" . ucfirst($keyCompare);
                        foreach ($modules as $module) {
                            if ($key == "min") {
                                if ($module->$function() >= $valueCompare) {
                                    $newModules[] = $module;
                                }
                            } else {
                                if ($module->$function() <= $valueCompare) {
                                    $newModules[] = $module;
                                }

                            }
                        }
                        $modules = $newModules;
                    }


                }

            }

        }


        return $modules;

    }

    function transformObjectToString($objectGlobal)
    {

        $ingonered = array();
        $class = ((new \ReflectionClass(new $objectGlobal)));
        $properties = $class->getProperties();
        foreach ($properties as $property) {

            $propertyTypes = $this->get('doctrine.orm.default_entity_manager.property_info_extractor')->getTypes($objectGlobal, $property->getName());

            if ($propertyTypes[0]->getBuiltinType() == "object" && $propertyTypes[0]->getClassName() != "DateTime") {
                $ingonered[] = $property->getName();
            }

        }


        return $ingonered;

    }

    public function getImagesOfObject($pathObject)
    {
        if (is_dir($pathObject)) {
            $images = array_diff(scandir($pathObject), array('..', '.'));
            $images = array_values($images);
        } else {
            $images = false;
        }
        return $images;

    }


}


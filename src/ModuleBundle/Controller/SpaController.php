<?php
/**
 * Created by PhpStorm.
 * User: POSTE 7
 * Date: 15/05/2017
 * Time: 10:00
 */

namespace ModuleBundle\Controller;

use AdminBundle\Entity\Qouiqui;
use AdminBundle\Entity\Theme;
use AdminBundle\Entity\Spa;
use AdminBundle\Entity\CentreFormation;

use AdminBundle\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

//use Symfony\Component\HttpFoundation\JsonResponse;

class SpaController extends Controller
{
    public function headerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $idUser = $this->getUser()->getId();
        $module = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('user' => $idUser));
        $file = $this->get('app.image_uploader')->targetDir . "/$idUser";


        if (is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/slider")):
            $liste = array();
            $rp = $this->get('app.image_uploader')->targetDir . "/$idUser" . "/slider";
            $tab = array();

            $rep = opendir($rp);
            while ($sous_fichier = readdir($rep)) {
                if (($sous_fichier == ".") || ($sous_fichier == "..")) {
                    echo "";
                } else {
                    $tab[] = $sous_fichier;
                }
            }
            closedir($rep);
        else:
            $this->addFlash(
                'notice', 'vous n avez pas de photo'
            );


            $tab = false;
        endif;

        return $this->render('ModuleBundle:Module:spa\index.html.twig',
            array('qouiqui' => $module,
                'tab' => $tab,
                'iduser' => $idUser
            ));
    }


    public function storeFolderAction($idqq)
    {

        $ds = DIRECTORY_SEPARATOR;
        $em = $this->getDoctrine()->getManager();
        $iduser = $this->getUser()->getId();
//        $qq = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('user' => $iduser));
//        $id_qq = $qq->getId();

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$iduser")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$iduser");
        endif;
        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$idqq")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$idqq");
            chmod($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$idqq", 0777);
        endif;
        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$idqq" . "/slider")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$idqq" . "/slider", 0777);
            chmod($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$idqq" . "/slider", 0777);
        endif;
        $storeFolder = $file = $this->get('app.image_uploader')->targetDir . "/$iduser" . "/$idqq" . "/slider";


        if (!empty($_FILES)) {


            $tempFile = $_FILES['file']['tmp_name'];

            $targetPath = $storeFolder . $ds;

            $fileName = md5(uniqid(rand(), true));

            $targetFile = $targetPath . $fileName . '.' . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            move_uploaded_file($tempFile, $targetFile);

        } else {

            $result = array();

            $files = scandir($storeFolder);

            if (false !== $files) {
                foreach ($files as $file) {
                    if ('.' != $file && '..' != $file) {
                        $obj['name'] = $file;
                        $obj['size'] = filesize($storeFolder . $ds . $file);
                        $result[] = $obj;
                    }
                }
            }

            header('Content-type: text/json');
            header('Content-type: application/json');
            echo json_encode($result);
        }

        die();
    }

    Public function DeleteFileAction()
    {


        $toDelete = $_POST['filetodelete'];
        $id = $_POST['id'];

        $iduser = $this->getUser()->getId();
        $file = $this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id" . "/slider" . "/$toDelete";

        unlink($file);

        die;
    }

#delete from gallery
    Public function DeleteFileFromGalleryAction()
    {


        $toDelete = $_POST['filetodelete'];
        $id = $_POST['id'];

        $iduser = $this->getUser()->getId();
        $file = $this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id" . "/gallery" . "/$toDelete";

        unlink($file);

        die;
    }

    public function tmpfolderAction(Request $request, $qq_id)
    {

        if (isset($_POST)) {


            $em = $this->getDoctrine()->getManager();
            $iduser = $this->getUser()->getId();

            $id_qq = $qq_id;

            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$iduser")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$iduser");
            endif;
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq");
            endif;

            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/tmp")):

                mkdir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/tmp", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/tmp", 0777);
            endif;


            $i = 0;
            foreach ($_POST as $img) {
                $ext = pathinfo($img, PATHINFO_EXTENSION);

                copy($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/slider/" . $img, $this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/tmp/" . $i . '.' . $ext);
//                dump($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/tmp/" . $i . '.' . $ext);
                $i += 1;
            }


            $this->recurseRmdir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/slider");

            rename($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/tmp", $this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/slider");


            return $this->redirect($_SERVER['PHP_SELF']);

        }

    }

    public function serviceAction(Request $request)
    {


        $idUser = $this->getUser()->getId();


        $theme = new Theme();

        $user = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneBy(array("user" => $idUser));

        $section = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array("qouiqui" => $user->getId()));

        if (isset($_POST['serv']['type']) && isset($_POST['serv']['offre']) && isset($_POST['serv']['prix'])):


            #upload image service


            $ds = DIRECTORY_SEPARATOR;
            $em = $this->getDoctrine()->getManager();

            $qq = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('user' => $idUser));
            $id_qq = $qq->getId();

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
            $storeFolder = $file = $this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/service";
            $targetPath = $storeFolder . $ds;


            $type = $_POST['serv']['type'];
            $offre = $_POST['serv']['offre'];
            $prix = $_POST['serv']['prix'];
            if (isset($_POST['serv']['img'])):
                $img = $_POST['serv']['img'];
            endif;


            $data = array();
            $service = array();

            $i = 0;

            //  $data['titre'] = $_POST['section']['titre'];
//            $data['desc'] = $_POST['section']['desc'];
            foreach ($type as $t):

                if (!empty($t)):
                    $data['type'] = $type [$i];
                    $data['offre'] = $offre[$i];
                    $data['prix'] = $prix[$i];
                    if (($_FILES["serv"]["name"][$i])):

                        $data['img'] = $_FILES["serv"]["name"][$i];
                        $fileName = $_FILES["serv"]["name"][$i];
                        $tmp = $_FILES["serv"]["tmp_name"][$i];
                        $targetFile = $targetPath . $fileName;
                        move_uploaded_file($tmp, $targetFile);
                    elseif ($img):
                        $data['img'] = $img[$i];
                    endif;
                    $service[] = $data;

                    $i++;


                endif;

            endforeach;


            $a = json_encode($service);


            $em = $this->getDoctrine()->getManager();
            if ($section) {


                $query = $em->createQuery('UPDATE AdminBundle:Theme p SET p.data=?1 WHERE p.id =?2');
                $query->setParameter(1, $a);
                $query->setParameter(2, $section->getId());
                $rs = $query->getResult();

                return $this->redirect($_SERVER['PHP_SELF']);


            } else {

                $theme->setData($a);
                $theme->setQouiqui($user);
                $em->persist($theme);
                $em->flush($theme);
                return $this->redirect($_SERVER['PHP_SELF']);
            }

        endif;
        return $this->redirect($_SERVER['PHP_SELF']);
    }

    public function editAction(Request $request)
    {
        $idUser = $this->getUser()->getId();


        $user = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneBy(array("user" => $idUser));

        $section = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array("qouiqui" => $user->getId()));

        if ($section) {
            $b = json_decode($section->getData(), true);
        } else {
            $b = false;
        }
        dump($b);
        die('');
    }

    public function eventAction(Request $request)
    {
        $idUser = $this->getUser()->getId();


        $em = $this->getDoctrine()->getManager();
        $theme = new Theme();

        $user = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneBy(array("user" => $idUser));

        $section = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array("qouiqui" => $user->getId()));

        if (isset($_POST['event']['type']) && isset($_POST['event']['delais']) && isset($_POST['event']['prix'])):
            $ds = DIRECTORY_SEPARATOR;
            $em = $this->getDoctrine()->getManager();

            $qq = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('user' => $idUser));
            $id_qq = $qq->getId();

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
            $storeFolder = $file = $this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/event";
            $targetPath = $storeFolder . $ds;


            $type = $_POST['event']['type'];
            $delais = $_POST['event']['delais'];
            $prix = $_POST['event']['prix'];
            if (isset($_POST['event']['img'])):


                $img = $_POST['event']['img'];
            endif;
            $data = array();
            $service = array();

            $i = 0;
//            $data['titre'] = $_POST['section']['titre'];
//            $data['desc'] = $_POST['section']['desc'];
            foreach ($type as $t):
                if (!empty($t)):
                    $data['type'] = $type [$i];
                    $data['delais'] = $delais[$i];
                    $data['prix'] = $prix[$i];

                    if (($_FILES["event"]["name"][$i])):

                        $data['img'] = $_FILES["event"]["name"][$i];
                        $fileName = $_FILES["event"]["name"][$i];
                        $tmp = $_FILES["event"]["tmp_name"][$i];
                        $targetFile = $targetPath . $fileName;
                        move_uploaded_file($tmp, $targetFile);
                    elseif ($img):


                        $data['img'] = $img[$i];
                    endif;
                    $service[] = $data;

                    $i++;
                endif;
            endforeach;

            $a = json_encode($service);

            if ($section) {


                $query = $em->createQuery('UPDATE AdminBundle:Theme p SET p.event=?1 WHERE p.id =?2');
                $query->setParameter(1, $a);
                $query->setParameter(2, $section->getId());
                $rs = $query->getResult();

                return $this->redirect($_SERVER['PHP_SELF']);


            } else {

                $theme->setEvent($a);
                $theme->setQouiqui($user);
                $em->persist($theme);
                $em->flush($theme);
                return $this->redirect($_SERVER['PHP_SELF']);
            }

        endif;
        return $this->redirect($_SERVER['PHP_SELF']);
    }

    public function galleryAction(Request $request, $id_qq)
    {
        if ($_FILES) {
            $idUser = $this->getUser()->getId();

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

            $this->uploadFile($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/gallery/");

            die;


        }

    }

    function recurseRmdir($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? recurseRmdir("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    /**
     * l'uploade d'une fichier
     * @param $file = $_File
     * @param $src = chemain de l'upload
     * @param null $name = le nom du ficher si definie si non md5
     * @return bool
     */


    function uploadFile($file, $src, $name = null)
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

    #image section a propos
    public function img_aproposAction(Request $request, $id)
    {


        if ($_FILES['fileToUpload']['tmp_name']) {


            $idUser = $this->getUser()->getId();

            #creation dossier avec l'id de l'utilisateur si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
            endif;

            #creation dossier avec l'id de QUOIQUI si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$id/", 0777);
            endif;
            #creation dossier produits si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/avatar")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/avatar", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$id/avatar", 0777);
            endif;

            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$id/avatar/";


            if (is_file($uploaddir . '/avatar.jpg')) {
                unlink($uploaddir . '/avatar.jpg');

            }
            move_uploaded_file(
                $_FILES['fileToUpload']['tmp_name'],
                $uploaddir . '/avatar.jpg'
            );


        }


        return $this->redirect($_SERVER['PHP_SELF']);


    }

    public function deleteLogoAction(Request $requestn, $idqq)
    {

        $idUser = $this->getUser()->getId();
        $idqq =
        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/avatar/";
        if (is_file($uploaddir . '/avatar.jpg')) {
            unlink($uploaddir . '/avatar.jpg');

        }
        die();
    }

    public function spachangecolorAction(Request $request, $qq_id)
    {

        $idUser = $this->getUser()->getId();


        $em = $this->getDoctrine()->getManager();


        $colors = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array("qouiqui" => $qq_id));
        $color = $request->get('num_test');

        $data['color'] = $color;
        $a = json_encode($data);

        $em = $this->getDoctrine()->getManager();


        $colors->setData($a);

        $em->persist($colors);

        $em->flush($colors);

        return $this->redirect($_SERVER['PHP_SELF']);

    }

    public function bookingAction($id_qq)
    {
        $em = $this->getDoctrine()->getManager();

        if (isset($_POST)) {

            if (isset($_POST['service']['data'])):
                $l = $_POST['service']['data'];
                $serv = '';
                foreach ($l as $ll => $k):
                    $serv = $serv . ', ' . $k;
                endforeach;
            else:
                $serv = '';
            endif;
            $a_reserver = (trim(trim($serv, ',')));

            if (isset($_POST['date'])) {
                $jour = $_POST['date'];
            } else {
                $jour = null;
            }
            if (isset($_POST['from'])) {
                $from = $_POST['from'];
            } else {
                $from = null;
            }
            if (isset($_POST['from'])) {
                $from = $_POST['from'];
            } else {
                $from = null;
            }
            if (isset($_POST['to'])) {
                $to = $_POST['to'];
            } else {
                $to = null;
            }

            if (isset($_POST['spaservice']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['tel']) && isset($_POST['ville']) && isset($_POST['adr'])) {
                $serv = $_POST['spaservice'];
                $name = $_POST['name'];
                $tel = $_POST['tel'];
                $ville = $_POST['ville'];
                $adr = $_POST['adr'];
                $email = $_POST['email'];
                $date_dispo = $_POST['date'];

            } else {
                $serv = null;
                $name = null;
                $tel = null;
                $ville = null;
                $adr = null;
                $email = null;
                $date_dispo = null;
            }
            $date = new \DateTime();

            $info = json_encode($_POST);
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneBy(array("id" => $id_qq));
            if ($this->getUser() && $this->getUser() != $qq->getUser()) {
                $name = $this->getUser()->getUserName() . ' ' . $this->getUser()->getPrenom();
                $email = $this->getUser()->getEmail();
                $tel = $this->getUser()->getPhoneNumber();

                $User = $this->getUser();
                $booking = new Booking();
                $booking->setUser($User);
                $booking->setQouiqui($qq);
                $booking->setDate($date);
                $booking->setData($info);
            } else {
                $booking = new Booking();

                $booking->setQouiqui($qq);
                $booking->setDate($date);
                $booking->setData($info);
            }
//            return $this->render('@Module/mail/spa-reservation.html.twig' ,array(
//
//                'jour' => $jour,
//                'reservation' => $a_reserver,
//                'from' => $from,
//                'to' => $to,
//                'serv' => $serv,
//                'name' => $name,
//                'tel' => $tel,
//                'ville' => $ville,
//                'adr' => $adr,
//                'email' => $email,
//                'date' =>  $date_dispo
//            ));

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
                    $this->renderView('@Module/mail/spa-reservation.html.twig', array(
                        'jour' => $jour,
                        'reservation' => $a_reserver,
                        'from' => $from,
                        'to' => $to,
                        'serv' => $serv,
                        'name' => $name,
                        'tel' => $tel,
                        'ville' => $ville,
                        'adr' => $adr,
                        'email' => $email,
                        'date' => $date_dispo

                    )), "text/html"
                );
            $mailer->send($message);
            return $this->redirect($_SERVER['PHP_SELF']);


        }

    }

    public function ajoutserviceAction()
    {

        $idUser = $this->getUser()->getId();
        $id_qq = $_POST['qq_id'];

        $em = $this->getDoctrine()->getManager();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($_POST['qq_id']);

        $spa = new Spa();
        $spa->setSection('service');
        $spa->setData($_POST['desc']);
        $spa->setNom($_POST['service']);
        $spa->setQouiqui($qq);
        $em->persist($spa);

        $em->flush($spa);
        $em->refresh($spa);
        $id_serv = $spa->getId();


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

//        $storeFolder = $file = $this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/service";
//        $targetPath = $storeFolder . $ds;

        return $this->redirect($_SERVER['PHP_SELF']);

    }

    public function ajoutcarteAction()
    {
        if (isset($_POST)) {

            $idUser = $this->getUser()->getId();
            $id_qq = $_POST['qq_id'];
            $designation = $_POST['designation'];

            $em = $this->getDoctrine()->getManager();
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($_POST['qq_id']);
            $exist = $this->getDoctrine()->getRepository('AdminBundle:Spa')->findOneBy(array('designation' => $_POST['designation'], 'sdesignation' => $_POST['sdesignation'], 'qouiqui' => $id_qq));
            if ($exist):
                $this->addFlash(
                    'notice', 'la designation que vous êtes entrain d ajouter: est déja trouvé !'
                );
            else:
                $spa = new Spa();
                $spa->setSection('carte');
                $spa->setDesignation($_POST['designation']);
                $spa->setSdesignation($_POST['sdesignation']);
                $spa->setQouiqui($qq);
                $spa->setPrix($_POST['prix']);
                $em->persist($spa);


                $em->flush($spa);


            endif;

            return $this->redirect($_SERVER['PHP_SELF']);
        }
    }


    public function ajoutcartetypeAction(Request $request, $idqq)
    {


        if (isset($_POST)) {
            dump($_POST);
//            die;

            $em = $this->getDoctrine()->getManager();
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($idqq);

            $spa = new Spa();
            $spa->setSection('autre');
            $spa->setDesignation($_POST['cat1']);
            $spa->setSdesignation($_POST['cat2']);
            $spa->setQouiqui($qq);
            $em->persist($spa);

            $em->flush($spa);

            return $this->redirect($_SERVER['PHP_SELF']);
        }
    }


    public function delateserviceAction(Request $request)
    {
        $idUser = $this->getUser()->getId();
        $id_qq = $request->request->get('idqq');

        $idservice = $request->request->get('idserv');

//        $idUser = $this->getUser()->getId();
//        $id_qq = $_POST['id_qq'];
//        $idservice = $_POST['supprimer'];


        $em = $this->getDoctrine()->getManager();
        $service = $this->getDoctrine()->getRepository('AdminBundle:Spa')->findOneBy(array('id' => $idservice, 'qouiqui' => $id_qq, 'section' => 'service'));
        $em->remove($service);
        $em->flush($service);

        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/service/";


        if (is_file($uploaddir . "$idservice" . '.' . 'jpg')) {

            unlink($uploaddir . "$idservice" . '.' . 'jpg');

        }


        die;

    }

    public function delateeventAction()
    {

        $idUser = $this->getUser()->getId();
        $id_qq = $_POST['idqqev'];
        $idevent = $_POST['idev'];


        $em = $this->getDoctrine()->getManager();
        $service = $this->getDoctrine()->getRepository('AdminBundle:Spa')->findOneBy(array('id' => $idevent, 'qouiqui' => $id_qq, 'section' => 'event'));
        $em->remove($service);
        $em->flush($service);
//        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($_POST['qq_id']);

        die;

    }


    public function editserviceAction(Request $request)

    {

        $id_qq = $request->request->get('idqq');

        $id_serv = $request->request->get('idserv');


        $service = $this->getDoctrine()->getRepository('AdminBundle:Spa')->findOneBy(array('id' => $id_serv, 'qouiqui' => $id_qq, 'section' => 'service'));


        $serv = null;
        if ($service) {
            $serv = array(
                'id' => $service->getId(),
                'nom' => $service->getNom(),
                'desc' => $service->getData()
            );
        }
        $response = new Response(json_encode($serv));


        return $response;


    }

    public function modifserviceAction(Request $request)

    {
        if (isset($_POST['service']) && isset($_POST['desc'])) {
            $idservice = $_POST['serviceID'];
            $idqq = $_POST['qq_id'];
            $idUser = $this->getUser()->getId();
            dump($_POST);
//            die;
            $em = $this->getDoctrine()->getManager();
//            $service = $this->getDoctrine()->getRepository('AdminBundle:Spa')->findOneBy(array('id' => $idservice, 'qouiqui' => $idqq, 'section' => 'service'));
            $query = $em->createQuery('UPDATE AdminBundle:Spa s SET s.nom=?1, s.data=?2 WHERE s.id =?3');
            $query->setParameter(1, $_POST['service']);
            $query->setParameter(2, $_POST['desc']);
            $query->setParameter(3, $_POST['serviceID']);
            $rs = $query->getResult();


            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/service/";

            if (!empty(($_FILES['file']['name']))) {


                if (is_file($uploaddir . "$idservice" . '.' . 'jpg')) {

                    unlink($uploaddir . "$idservice" . '.' . 'jpg');

                }
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                move_uploaded_file(
                    $_FILES['file']['tmp_name'],
                    $uploaddir . "$idservice" . '.' . $ext
                );
            }


            return $this->redirect($_SERVER['PHP_SELF']);


        }
    }

    public function editeventAction(Request $request)
    {

        $id_qq = $request->request->get('idqq');

        $id_serv = $request->request->get('idserv');


        $event = $this->getDoctrine()->getRepository('AdminBundle:Spa')->findOneBy(array('id' => $id_serv, 'qouiqui' => $id_qq, 'section' => 'event'));


        $serv = null;
        if ($event) {
            $serv = array(
                'id' => $event->getId(),
                'nom' => $event->getNom(),
                'data' => $event->getData(),
                'prix' => $event->getPrix()
            );
        }
        $response = new Response(json_encode($serv));


        return $response;


    }

    public function ajouteventAction(Request $request)
    {

        $idUser = $this->getUser()->getId();
        $id_qq = $_POST['qq_id'];

        $em = $this->getDoctrine()->getManager();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($_POST['qq_id']);

        $spa = new Spa();
        $spa->setSection('event');
        $spa->setData($_POST['data']);
        $spa->setPrix($_POST['prix']);
        $spa->setNom($_POST['event']);
        $spa->setQouiqui($qq);
        $em->persist($spa);

        $em->flush($spa);
        $em->refresh($spa);
        $id_event = $spa->getId();


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

    public function modifeventAction(Request $request)

    {
        if (isset($_POST['event']) && isset($_POST['data']) && isset($_POST['prix'])) {
            $idqq = $_POST['qq_id'];
            $idevent = $_POST['eventID'];
            $idUser = $this->getUser()->getId();
            $em = $this->getDoctrine()->getManager();
            $service = $this->getDoctrine()->getRepository('AdminBundle:Spa')->findOneBy(array('id' => $_POST['eventID'], 'qouiqui' => $_POST['qq_id'], 'section' => 'event'));

            $query = $em->createQuery('UPDATE AdminBundle:Spa p SET p.nom=?1, p.data=?2  , p.prix=?4 WHERE p.id =?3');
            $query->setParameter(1, $_POST['event']);
            $query->setParameter(2, $_POST['data']);
            $query->setParameter(3, $_POST['eventID']);
            $query->setParameter(4, $_POST['prix']);
            $rs = $query->getResult();

            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/event/";

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
    }

    public function sendMailAction($idqq)
    {

        $em = $this->getDoctrine()->getManager();

        if (isset($_POST)) {
            $email = $_POST['email'];
            $mesg = $_POST['message'];
            $nom = $_POST['name'];


            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneBy(array("id" => $idqq));


            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneBy(array("id" => $idqq));

            $emailto = $qq->getMail();
            $date = new \DateTime();


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
                    $this->renderView('@Module/mail/mail.html.twig', array(


                        'email' => $email,
                        'mesg' => $mesg,
                        'nom' => $nom,


                    )), "text/html"
                );
            $mailer->send($message);


            die;


        }


    }

    public function ThemeColorAction(Request $request, $idqq)
    {


        $couleur['Couleur'] = $_POST;
        $em = $this->getDoctrine()->getManager();

        $theme = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array("qouiqui" => $idqq));
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($idqq);


        if ($theme == null) {
            $theme = new Theme();

            $data = json_encode($couleur);
            $theme->setData($data);
            $theme->setQouiqui($qq);
            $em->persist($theme);
            $em->flush($theme);
        } else {

            $theme->setData(json_encode($couleur));


            $em->persist($theme);

            $em->flush($theme);

        }


        die();


//        $colors = $this->getDoctrine()->getRepository('AdminBundle:Spa')->findOneBy(array("qouiqui" => $idqq));
//        $em = $this->getDoctrine()->getManager();
//
//        $theme->setCouleur(json_encode($couleur));
//
//
//        $em->persist($colors);
//
//        $em->flush($colors);
    }


    public function getColorAction($idqq)
    {

        print_r('aaaa');

        die();
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


    public function modifierCarteAction(Request $request)

    {

        $id_qq = $request->request->get('idqq');

        $id_carte = $request->request->get('idcarte');


        $carte = $this->getDoctrine()->getRepository('AdminBundle:Spa')->findOneBy(array('id' => $id_carte, 'qouiqui' => $id_qq, 'section' => 'carte'));


        $c = null;
        if ($carte) {
            $c = array(
                'id' => $carte->getId(),
                'nom' => $carte->getSdesignation(),
                'prix' => $carte->getPrix()
            );
        }

        $response = new Response(json_encode($c));


        return $response;


    }

    public function modifCarteAction(Request $request)

    {
        if (isset($_POST)) {

            $em = $this->getDoctrine()->getManager();
            $service = $this->getDoctrine()->getRepository('AdminBundle:Spa')->findOneBy(array('id' => $_POST['carteID'], 'qouiqui' => $_POST['qq_id'], 'section' => 'carte'));

            $query = $em->createQuery('UPDATE AdminBundle:Spa p SET  p.sdesignation=?1, p.prix=?2 WHERE p.id =?3');
            $query->setParameter(1, $_POST['sdesignation']);
            $query->setParameter(2, $_POST['nouveauprix']);
            $query->setParameter(3, $_POST['carteID']);
            $rs = $query->getResult();

            return $this->redirect($_SERVER['PHP_SELF']);


        }
    }


    public function delateCarteAction(Request $request)
    {

        $id_qq = $request->request->get('idqq');

        $idservice = $request->request->get('idserv');

//        $idUser = $this->getUser()->getId();
//        $id_qq = $_POST['id_qq'];
//        $idservice = $_POST['supprimer'];


        $em = $this->getDoctrine()->getManager();
        $service = $this->getDoctrine()->getRepository('AdminBundle:Spa')->findOneBy(array('id' => $idservice, 'qouiqui' => $id_qq, 'section' => 'carte'));
        $em->remove($service);
        $em->flush($service);

        die;

    }

    public function SectionReserverAction($idqq, Request $request)
    {
        $idUser = $this->getUser()->getId();

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser");
        endif;
        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq");
        endif;

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/booking")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/booking", 0777);
            chmod($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" . "/booking", 0777);
        endif;
//         $this->uploadFiles($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/booking/");
        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/booking/";
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


        $secbooking = $this->getDoctrine()->getRepository('AdminBundle:Spa')->findOneBy(array('id' => $_POST['secreserve'], 'qouiqui' => $idqq, 'section' => 'booking'));
        if ($secbooking) {
            $secbooking->setData($_POST['data']);
            $em = $this->getDoctrine()->getManager();

            $em->persist($secbooking);
            $em->flush($secbooking);
        } else {
            $spa = new Spa();
            $spa->setSection('booking');
            $spa->setData($_POST['data']);

            $spa->setQouiqui($qq);
            $em->persist($spa);

            $em->flush($spa);
        }


//        $em->refresh($spa);
//        $id_reserv = $spa->getId();


//        $storeFolder = $file = $this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/service";
//        $targetPath = $storeFolder . $ds;

        return $this->redirect($_SERVER['PHP_SELF']);

    }


    function ficheServicesAction(Request $request)
    {

        $quoiqui = $request->get('quoiqui');

        $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        if ($service) {
            $service = json_decode($service->getData(), true);

        } else {
            $service = null;
        }


        return $this->render('@User/template/fiche/spa/services.html.twig', [
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


        return $this->render('@User/template/fiche/spa/annonces.html.twig', [
            'attributes' => $request->attributes->all(), 'Spaevent' => $service
        ]);
    }

    function addServiceAction($idqq)
    {

        $idUser = $this->getUser()->getId();

        $id_serv = $_POST['idserv'];


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


        return $this->redirect($_SERVER['PHP_SELF']. '#section-services');
    }

    function updateServiceAction($idqq)

    {

        $idUser = $this->getUser()->getId();

        $idservice = $_POST['idserv'];
        $em = $this->getDoctrine()->getManager();

        $serv = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $idqq));
        $data = json_decode($serv->getData(), true);
        $data['service'][$_POST['idserv']] = $_POST;

        $serv->setData(json_encode($data));


        $em->persist($serv);

        $em->flush($serv);


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
        return $this->redirect($_SERVER['PHP_SELF']. '#section-services');
//        dump($_POST,$idqq);
//        dump($_FILES);
//        die;
    }

    function getJsonSpaAction(Request $request)
    {
        $id_qq = $request->request->get('idqq');

        $id_serv = $request->request->get('idserv');
//print_r('pp');
//        die;

        $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $id_qq));

        $tab = json_decode($service->getData(), true);
        $getspa = $tab['service'][$id_serv];

        $getspa = json_encode($getspa);


        $response = new Response($getspa);


        return $response;
    }

    function delateServiceSpaAction($idqq, $idserv)
    {

        $idUser = $this->getUser()->getId();


        $em = $this->getDoctrine()->getManager();


        $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $idqq));
        if ($service) {
            $tab = json_decode($service->getData(), true);


            unset($tab['service'][$idserv]);
            $newtab = json_encode($tab);
            $service->setData($newtab);
            $em->persist($service);

            $em->flush($service);


            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/service/";


            if (is_file($uploaddir . "$idserv" . '.' . 'jpg')) {

                unlink($uploaddir . "$idserv" . '.' . 'jpg');

            }

        }

        return $this->redirect($_SERVER['PHP_SELF']. '#section-services');

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

    function delateEventSpaAction($idqq, $idevent)
    {

        $idUser = $this->getUser()->getId();


        $em = $this->getDoctrine()->getManager();


        $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $idqq));
        if ($service) {
            $tab = json_decode($service->getData(), true);


            unset($tab['event'][$idevent]);
            $newtab = json_encode($tab);
            $service->setData($newtab);
            $em->persist($service);

            $em->flush($service);


            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/event/";


            if (is_file($uploaddir . "$idevent" . '.' . 'jpg')) {

                unlink($uploaddir . "$idevent" . '.' . 'jpg');

            }

        }

        return $this->redirect($_SERVER['PHP_SELF']);

    }

    function spabookingAction($idqq)
    {
        $service = $_POST['spaservice'];
        $nom = $_POST['name'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];


        $em = $this->getDoctrine()->getManager();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneBy(array("id" => $idqq));

        $date = new \DateTime();
        $info = json_encode($_POST);
        $booking = new Booking();

        $booking->setQouiqui($qq);
        $booking->setDate($date);
        $booking->setData($info);

        $em->persist($booking);
        $em->flush($booking);
        dump($_POST);
        die;
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
                $this->renderView('@Module/mail/spa-reservation.html.twig', array(
                    'jour' => $jour,
                    'reservation' => $a_reserver,

                    'email' => $email_client,
                    'tel' => $this->getUser()->getPhoneNumber(),
                    'nom' => $nom,
                    'from' => $from,
                    'to' => $to

                )), "text/html"
            );
        $mailer->send($message);

    }

    function PaginatesAction(Request $request, $page, $id)
    {

        $offset = $page * 3;
        $nb = ($page + 1) * 3;
        $delete = array();
        $em = $this->getDoctrine()->getManager();
        $services = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $id));
        if ($services) {
            $service = json_decode($services->getData(), true);

        } else {
            $service = null;
        }

        $nbp = count($service['service']);
        $service['service'];
        $sservices = [];
        foreach ($service['service'] as $k => $v) {
            $sservices[] = $v;
        }


        $nombre = $nbp - $nb;

        if ($nombre < 0) {

            $send = $nombre + 3;
            for ($i = $nbp - 1; $i >= $nbp - $send; $i--) {
                array_push($delete, $sservices[$i]);
            }
        } else {
            for ($i = $nb - 1; $i > $page * 3 - 1; $i--) {
                array_push($delete, $sservices[$i]);
            }
        }
        return new Response(json_encode($delete));
    }

    function morePaginatOffreAction(Request $request, $page, $id)
    {
        $offset = $page * 3;
        $nb = ($page + 1) * 3;
        $delete = array();
        $em = $this->getDoctrine()->getManager();
        $services = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $id));
        if ($services) {
            $service = json_decode($services->getData(), true);

        } else {
            $service = null;
        }

        $nbp = count($service['event']);
        $service['event'];
        $sservices = [];
        foreach ($service['event'] as $k => $v) {
            $sservices[] = $v;
        }

        $nombre = $nbp - $nb;

        if ($nombre < 0) {

            $send = $nombre + 3;
            for ($i = $nbp - 1; $i >= $nbp - $send; $i--) {
                array_push($delete, $sservices[$i]);
            }
        } else {
            for ($i = $nb - 1; $i > $page * 3 - 1; $i--) {
                array_push($delete, $sservices[$i]);
            }
        }
        return new Response(json_encode($delete));
    }

    function ficheMoinsPagesAction($page, $id)
    {
        $delete = array();
        $offset = $page * 3;
        $nb = ($page + 1) * 3;
        $nb1 = $nb - 1;

        $services = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $id));
        if ($services) {
            $service = json_decode($services->getData(), true);

        } else {
            $service = null;
        }
        $nbp = count($service['service']);
        foreach ($service['service'] as $k => $v) {
            $sservices[] = $v;
        }

        if ($nbp < 6) {


            for ($i = $nbp - 1; $i >= 3; $i--) {
                array_push($delete, $sservices[$i]);
            }
        } else {

            for ($i = $nbp - 1; $i > $page * 3 - 1; $i--) {
                array_push($delete, $sservices[$i]);
            }
        }

        return new Response(json_encode($delete));

    }
}

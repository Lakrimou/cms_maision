<?php

namespace UserBundle\Controller;

use AdminBundle\AdminBundle;
use AdminBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AdminBundle\Entity\Qouiqui;
use AdminBundle\Entity\Pays;
use AdminBundle\Entity\ville;
use AdminBundle\Entity\Reviews;
use AdminBundle\Entity\Events;
use AdminBundle\Entity\Qville;
use AdminBundle\Entity\Hotel;
use Symfony\Component\HttpFoundation\Request;
use FacebookFacebookSession;
use FacebookFacebookRedirectLoginHelper;
use FacebookFacebookRequest;
use FacebookFacebookResponse;
use FacebookFacebookSDKException;
use FacebookFacebookRequestException;
use FacebookFacebookAuthorizationException;
use FacebookGraphObject;
use FacebookEntitiesAccessToken;
use FacebookHttpClientsFacebookCurlHttpClient;
use FacebookHttpClientsFacebookHttpable;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();


        $pays = "222"; //tunisia
        $villes = $em->getRepository('AdminBundle:Ville')->findby(array("pays" => $pays));
        $events = $em->getRepository('AdminBundle:Events')->findEvents();
        $qouiquis = $em->getRepository('AdminBundle:Qouiqui')->findBy(array(), array('id' => 'DESC'), 6);
        $category = $em->getRepository('AdminBundle:Category')->findAll();

        return $this->render('UserBundle:default:index.html.twig', array(
            'category' => $category,
            'qouiquis' => $qouiquis,
            'villes' => $villes,
            'events' => $events

        ));


    }

    public function FBloginAction()
    {
        $fb = new Facebook\Facebook([
            'app_id' => '1640022052970113', // Replace {app-id} with your app id
            'app_secret' => '3f08c0b72127cccd027185b2ce2e3d47',
            'default_graph_version' => 'v2.2',
        ]);
        $helper = $fb->getRedirectLoginHelper();
        dump($helper);
        die;
        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl('https://example.com/fb-callback.php', $permissions);
        echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
    }


    public function filtreAction()
    {

        if (isset($_GET)) {
            $info = $_GET['info'];
            $vid = $_GET['ville'];
            dump($info, $vid);
            $em = $this->getDoctrine()->getManager();
            if (empty($info)) {
                $qqresult = $em->getRepository('AdminBundle:Qouiqui')->filtreQQuibyville($vid);
            } else {
                $qqresult = $em->getRepository('AdminBundle:Qouiqui')->filterByTag($info, $vid);
            }
            $pays = "222"; //tunisia
            $villes = $em->getRepository('AdminBundle:Ville')->findby(array("pays" => $pays));

            return $this->render('UserBundle:default:recherche.html.twig', array(
                'qouiquis' => $qqresult,
                'villes' => $villes,
            ));
        }


    }

    public function profilAction($vid, $cat, $id, $name)
    {
//                path:     /{vid}/{cat}/{id}/{name}


        $em = $this->getDoctrine()->getManager();
        $qqresult = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $id));
        $reviews = $em->getRepository('AdminBundle:Reviews')->findReviewsByqq($id);
        $n = $qqresult->getFirstName();

        if ($n == $name) {

            $dir = $_SERVER['PHP_DOCUMENT_ROOT'] . '/web/annuaire/web/uploads/quoiqui/' . $id;

            if (is_dir($dir)) {
                $files2 = scandir($dir, 1);
                unset($files2[sizeof($files2) - 1]);
                unset($files2[sizeof($files2) - 1]);
            } else {
                $files2 = null;
            }
//            dump($files2);

            return $this->render('UserBundle:profil:index.html.twig', array(

                'qouiqui' => $qqresult,
                'cat' => $cat,
                'name' => $name,
                'reviews' => $reviews,
                'images' => $files2
            ));

        } else {
            return $this->render('UserBundle:default:index.html.twig');
        }


    }

    public function revAction()
    {

        if (isset($_POST)) {

            $id = $_POST['id'];
            $em = $this->getDoctrine()->getManager();
            $qq = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $id));
            $rev = new Reviews();
            $rev->setReviewTitle($_POST['title']);
            $rev->setReviewMsg($_POST['message']);
            $rev->setReviewNote($_POST['note']);
            $rev->setQouiqui($qq);

            // print_r($rev);
            $em = $this->getDoctrine()->getManager();

            $em->persist($rev);

//            var_dump($rev);

            $em->flush($rev);
            die('h');
        }

    }

    public function subdomainAction(Request $request)
    {


        $domain = $_SERVER['HTTP_HOST'];
        $domain = explode('.', $domain);
        $domain = $domain['1'] . "." . $domain['2'];
        //dump($domain);

        $em = $this->getDoctrine()->getManager();

        $slug = $request->get('subdomain');

        $qqresult = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('slug' => $slug));


//         ==============#theme category================

        if (empty($qqresult)) {
            die('thabat fil lien ');
        }


        $qq_id = $qqresult->getId();
        $category = $em->getRepository('AdminBundle:Category')->findCatByid($qq_id);


        $servieListe = $em->getRepository('AdminBundle:Serviceliste')->findBy(array('category' => $category->getId()));


//         ==============si il eexist une quoiqui ================
        if ($qqresult) {


            $themes = $em->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $qqresult->getID()));

            if ($themes) {
                $theme = json_decode($themes->getData(), true);
                $event = json_decode($themes->getEvent(), true);
                $themeId = $themes->getId();

//            $this->$theme['test']->imports['loaded'] = true;
//            $theme->set[newtest]= 'test';
            } else {
                $event = false;
                $theme = null;
                $themeId = null;
            }

//         ==============#theme color================
            $colors = $em->getRepository('AdminBundle:Spa')->findOneBy(array('qouiqui' => $qqresult->getID()));

            if ($colors) {
                $clor = json_decode($colors->getCouleur(), true);
            } else {
                $clor = false;

            }


//         ==============#theme trouver les events par l'id de qouiqui================
            $events = $this->getDoctrine()->getRepository('AdminBundle:Events')->findEventsByQQ($qq_id);

            if ($events):
                foreach ($events as $ev) {

                    $start = $ev->getDateStart();
                    $end = $ev->getDateEnd();

                }
            else:
                $start = false;
                $end = false;
            endif;

            $events = $this->getDoctrine()->getRepository('AdminBundle:Events')->findEventsByQQ($qq_id);
            $reviews = $em->getRepository('AdminBundle:Reviews')->findReviewsByqq($qq_id);
            $dir = $_SERVER['PHP_DOCUMENT_ROOT'] . '/web/annuaire/web/uploads/quoiqui/' . $qq_id;


            if (is_dir($dir)) {
                $files2 = scandir($dir, 1);
                unset($files2[sizeof($files2) - 1]);
                unset($files2[sizeof($files2) - 1]);
            } else {
                $files2 = null;
            }
        } else {

            die;
        }

        $cat = ucfirst($category->getSlug());


        $module = $em->getRepository('AdminBundle:' . $cat)->findBy(array('qouiqui' => $qq_id));

//        if ($module) {
//            if ($module->getQouiqui()->getOpening()):
//                $horaire = json_decode($module->getQouiqui()->getOpening(),true);
//            else:
//                $horaire = false;
//            endif;
//        }


        ########################get slider##########

        $user = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $qqresult->getId()));
        $id_qq = $user->getId();
        $idUser = $user->getUser()->getId();

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
        ########################get image service##########
        $user = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $qqresult->getId()));
        $id_qq = $user->getId();
        $idUser = $user->getUser()->getId();

        if (is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/service")):

            $rp = $this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/service";
            $img_service = array();


            $rep = opendir($rp);
            while ($sous_fichier = readdir($rep)) {
                if (($sous_fichier == ".") || ($sous_fichier == "..")) {
                    echo "";
                } else {
                    $img_service[] = $sous_fichier;
                }
            }
            closedir($rep);
        else:
            $this->addFlash(
                'notice', 'vous n avez pas de photo'
            );


            $img_service = false;
        endif;


        ########################get image from gallery##########
        $user = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $qqresult->getId()));
        $id_qq = $user->getId();
        $idUser = $user->getUser()->getId();

        if (is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/gallery")):

            $rp = $this->get('app.image_uploader')->targetDir . "/$idUser" . "/$id_qq" . "/gallery";
            $img_gallery = array();


            $rep = opendir($rp);
            while ($sous_fichier = readdir($rep)) {
                if (($sous_fichier == ".") || ($sous_fichier == "..")) {
                    echo "";
                } else {
                    $img_gallery[] = $sous_fichier;
                }
            }
            closedir($rep);
        else:
            $this->addFlash(
                'notice', 'vous n avez pas de photo'
            );


            $img_gallery = false;
        endif;
        $cat_minuscul = strtolower($category->getSlug());

        /*
                if($cat_minuscul == 'hotel'){
                    foreach ( $module as $hotel){
                        $DescriptionRoom = json_decode($hotel->getDescriptionRoom(), true);
                        $hotel->setDescriptionRoom($DescriptionRoom);
                    }
                }
                if($cat_minuscul == 'hotel'){
                    foreach ( $module as $hotel){
                        $DescriptionServices = json_decode($hotel->getDescriptionServices(), true);
                        $hotel->setDescriptionServices($DescriptionServices);
                    }
                }
                if($cat_minuscul == 'hotel'){
                    foreach ( $module as $hotel){
                        $DescriptionEvents = json_decode($hotel->getDescriptionEvents(), true);
                        $hotel->setDescriptionEvents($DescriptionEvents);
                    }
                }
                if($cat_minuscul == 'hotel'){
                    foreach ( $module as $hotel){
                        $DescriptionNews = json_decode($hotel->getDescriptionNews(), true);
                        $hotel->setDescriptionNews($DescriptionNews);
                    }
                }
                if($cat_minuscul == 'hotel'){
                    foreach ( $module as $hotel){
                        $DescriptionNews = json_decode($hotel->getAbout(), true);
                        $hotel->setAbout($DescriptionNews);
                    }
                }
        */
        if ($category->getIsmodule() == '1') {

            return $this->render('ModuleBundle:Module:' . $cat_minuscul . '\index.html.twig', array(
//            'horaire' => $horaire,
                'module' => $module,
                'qouiqui' => $qqresult,
                'reviews' => $reviews,
                'images' => $files2,
                'events' => $events,
                'category' => $category,
                'start' => $start,
                'end' => $end,
                'theme' => $theme,
                'slider' => $slider,
                'iduser' => $idUser,
                'img_service' => $img_service,
                'img_gallery' => $img_gallery,
                'event' => $event,
                'color' => $clor,
                'servieListe'=>$servieListe


            ));

        } else {

            return $this->render('@User/template/ficheNew.html.twig', array(
                'module' => $module,
                'qouiqui' => $qqresult,
                'reviews' => $reviews,
                'images' => $files2,
                'events' => $events,
                'category' => $category,
                'start' => $start,
                'end' => $end,
                'theme' => $theme,
                'slider' => $slider,
                'iduser' => $idUser,
                'img_service' => $img_service,
                'img_gallery' => $img_gallery,
                'event' => $event,
                'color' => $clor,
                'themeId' => $themeId,
                'servieListe'=>$servieListe
            ));

        }


    }


    public function getAllCategoryAction()
    {
        $cat = $this->getDoctrine()->getRepository('AdminBundle:Category')->findBy([], ['libelle' => 'ASC']);
        $serializer = $this->container->get('serializer');
        $reports = $serializer->serialize($cat, 'json');
        return new Response($reports);
    }

    public function etreRappelerAction(Request $request)
    {


        $transport = \Swift_SmtpTransport::newInstance('localhost', 25);
        $mailer = \Swift_Mailer::newInstance($transport);
        $privateKey = $this->getParameter('mail_privateKey');
        $domainName = $this->getParameter('domain');
        $selector = $this->getParameter('mail_selector');

        $signer = new \Swift_Signers_DKIMSigner($privateKey, $domainName, $selector);
        $message = \Swift_SignedMessage::newInstance();
        $message->attachSigner($signer);
        $message->setFrom('noreply@ween.tn')
            ->setTo($_POST['mailTo'])
            ->setSubject('Demande de rappel - Ween.tn')
            ->setBody(
                $this->renderView('@Module/mail/etre-rappeler.html.twig', array(
                    'fullName' => $_POST['nom'] . ' ' . $_POST['prenom'],
                    'email' => $_POST['email'],
                    'objet' => 'Demande de rappel',
                    'phone' => $_POST['phone'],
                    'date' => $_POST['date'],
                    'heur' => $_POST['heur'],
                )), "text/html"
            );
        $mailer->send($message);
        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Votre demande de rappel à été envoyer avec succès à ' . $_POST['email'] . '!');
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-rappeler');
    }

    public function testwordAction()
    {

        $file = $this->get('app.uploads_directory')->targetDir . 'nicewords/niceword.txt';

        $text = file_get_contents($file);
        $result = false;
//        if ($_POST){
        $word = strtolower('Sexaosofien');
        $niceword = explode(';', $text);
        foreach ($niceword as $nicewords) {
            if (strpos($word, $nicewords) !== false) {
                $result = true;
            }
        }


//        }
        return new Response(json_encode($result));
    }


}

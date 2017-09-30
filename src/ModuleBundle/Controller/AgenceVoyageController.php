<?php

namespace ModuleBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AdminBundle\Entity\AgenceVoyage;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use AdminBundle\Entity\Theme;
use FOS\UserBundle\Model\UserInterface;

class AgenceVoyageController extends Controller
{
//    reservation offre
    public function reservationOffreAction(Request $request)
    {




        $em = $this->getDoctrine()->getManager();
        $qq = $em->getRepository('AdminBundle:Qouiqui')->findBy(['id' => $request->request->get('id_qq')]);
        $qq=$qq[0];

        $transport = \Swift_SmtpTransport::newInstance('localhost', 25);
        $mailer = \Swift_Mailer::newInstance($transport);
        $privateKey = $this->getParameter('mail_privateKey');
//        $domainName = $this->getParameter('doamin');
        $selector = $this->getParameter('mail_selector');
//        $signer = new \Swift_Signers_DKIMSigner($privateKey, $domainName, $selector);
        $message = \Swift_SignedMessage::newInstance();
//        $message->attachSigner($signer);
        $message->setFrom('noreply@ween.tn')
            ->setTo($qq->getMail())
            ->setSubject("Demande de reservation")
            ->setBody(
                $this->renderView('@Module/mail/agence-reserver-offre-mail.html.twig', array(
                    'name' => $request->request->get("prenom"),
                    'nom'=>$request->request->get('nom'),
                    'num'=>$request->request->get('tel'),
                    'email' => $request->request->get("email"),
                    'body' => "Demande de reservation de l'offre :".$request->request->get("offre").', numéro  '.$request->request->get("id"),
                    'subject' =>'Demande de reservation: '.$request->request->get("offre"),

                )), "text/html");
        $mailer->send($message);
        return $this->redirect($_SERVER['PHP_SELF']);

    }
    //    supprimer un service
    public function deleteServiceByIdAction(Request $request)
    {
        $qqId = $_POST['idquoiqui'];
        $IdServ = $_POST['idService'];
        $em = $this->getDoctrine()->getManager();
        $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $qqId));

        if ($service):
            $tab = json_decode($service->getData(), true);
        else:
            $tab = $qqId;
        endif;
        $getservice = $tab['service']['serv' . $IdServ];
        unset($tab['service']['serv' . $IdServ]);
        $newtab = json_encode($tab);
        $service->setData($newtab);
        $em->persist($service);

        $em->flush($service);
        print_r($service->getData());
        die();
    }

    /*get service par id */
    public function getServiceByIdAction(Request $request, $id)
    {

        $quoiqui = $request->get('quoiqui');

        $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));

        $tab = json_decode($service->getData(), true);

        $getservice = $tab['service']['serv' . $id];


        $getservice = json_encode($getservice);

        $response = new Response($getservice);

        return $response;

    }
    /*modifier un service*/
    public function editServiceAction(Request $request)
    {
        if (isset($_POST)) {
            $em = $this->getDoctrine()->getManager();
            $idqq = $_POST['qq_id'];
            $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $idqq));
            $data = json_decode($service->getData(), true);
            $data['service']['serv' . $_POST['idservice']] = $_POST;
            $service->setData(json_encode($data));
            $em->persist($service);
            $em->flush($service);

        }

        return $this->redirect($_SERVER['PHP_SELF']."#section-services");
    }
    /*nouveau service*/
    public function ajoutserviceAction()
    {
        $id_qq = $_POST['qq_id'];
        $em = $this->getDoctrine()->getManager();
        $serv = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $id_qq));
        if ($serv) {
            $data = json_decode($serv->getData(), true);
            $data['service']['serv' . $_POST['idservice']] = $_POST;
            $serv->setData(json_encode($data));
        } else {
            $data['service']['serv' . $_POST['idservice']] = $_POST;
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($_POST['qq_id']);
            $serv = new Theme();
            $serv->setData(json_encode($data));
            $serv->setQouiqui($qq);
        }
        $em->persist($serv);
        $em->flush($serv);
        return $this->redirect($_SERVER['PHP_SELF']."#section-services");
    }
//    modifier annonce
    public function modifeirAnnonceAction(){
        if (isset($_POST)) {
            $iduser = $this->getUser()->getId();
            $em = $this->getDoctrine()->getManager();
            $id_qq = $_POST['qouiqui_id'];
            $agenceVoyage = $em->getRepository('AdminBundle:AgenceVoyage')->findBy(['id' => $_POST['id']]);
            $qq = $em->getRepository('AdminBundle:Qouiqui')->findBy(['id' => $_POST['qouiqui_id']]);
            $qq = $qq[0];

            if ($agenceVoyage) {


                $services=explode(",",$_POST['services']);
                $services=array('tags'=>$services);
                $servicesjson=json_encode($services);

                $agenceVoyage[0]->setPrix($_POST['prix']);
                $agenceVoyage[0]->setOffreName($_POST['offre']);
                $agenceVoyage[0]->setDateDepart($_POST['datedepart']);
                $agenceVoyage[0]->setDateRetour($_POST['dateretour']);
                $agenceVoyage[0]->setDepartPlace($_POST['placedepart']);
                $agenceVoyage[0]->setRetourPlace($_POST['placeretour']);
                $agenceVoyage[0]->setCabine($_POST['cabine']);
                $agenceVoyage[0]->setNbrEscale($_POST['nbr_escal']);
                $agenceVoyage[0]->setBoatPlaneModel($_POST['model']);
                $agenceVoyage[0]->setType($_POST['type']);
                $agenceVoyage[0]->setService($servicesjson);
                $agenceVoyage[0]->setQouiqui($qq);

                $em->persist($agenceVoyage[0]);
                $em->flush();
                $em->refresh($agenceVoyage[0]);
                $idAgence = $agenceVoyage[0]->getId();
                $storeFolder = $file = $this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/annonce/";

                $tmp = $_FILES["img"]["tmp_name"];
                move_uploaded_file($tmp, $storeFolder . "$idAgence" . '.' . "png");
                $this->addFlash('success', 'modification annonce enregistrer');
                return $this->redirect($_SERVER['PHP_SELF'].'#section-annonces');
            } else {
                $this->addFlash('error', 'modification annonce non  enregistrer');
            }

        }
    }
//    annonce par id
    public function getAnnnceByIdAction($id){

        $agence = $this->getDoctrine()->getRepository('AdminBundle:AgenceVoyage')->findOneBy(array('id' => $id));
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($agence) {
            return $agence->getId();
        });
        $serializer = $this->container->get('serializer');
        $serializer = new Serializer(array($normalizer), array($encoder));
        $report = $serializer->serialize($agence, 'json');
        dump($report);
        return new Response($report);


    }
//    supprimer une annonce
    public function deleteAnnonceByIdAction(Request $request){
        $qouiID = $request->request->get('idquoiqui');
        $qouiqui = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($request->request->get('idquoiqui'));
        if ($qouiqui) {
            $agence = $this->getDoctrine()->getRepository('AdminBundle:AgenceVoyage')->findOneById($request->request->get('idAnnonce'));

            $em = $this->getDoctrine()->getManager();
            $em->remove($agence);
            $em->flush();
            $iduser = $this->getUser()->getId();
            $storeFolder = $file = $this->get('app.image_uploader')->targetDir . "/$iduser" . "/$qouiID" . "/annonce/";
            if (is_file($storeFolder . $request->request->get('idAnnonce') . '.' . 'png')) {
                unlink($storeFolder . $request->request->get('idAnnonce') . '.' . 'png');
            }
            return $this->redirect($_SERVER['PHP_SELF'].'#section-annonces');
        } else {
            return $this->redirect($_SERVER['PHP_SELF'].'#section-annonces');
        }
    }
    /* ajouter une annonce*/
    public function addAnnonceAction(){
        if(!$_POST){
            return $this->redirect($_SERVER['PHP_SELF'].'#section-annonces');
        }else{
            $em = $this->getDoctrine()->getManager();
            $agenceVoyage=new AgenceVoyage();
            $qouiqui_id=$_POST['qouiqui_id'];
            $qq = $em->getRepository('AdminBundle:Qouiqui')->findBy(['id' => $qouiqui_id]);
            $qq = $qq[0];
            $offre=$_POST['offre'];
            $prix=$_POST['prix'];
            $placedepart=$_POST['placedepart'];
            $placeretour=$_POST['placeretour'];
            $datedepart=$_POST['datedepart'];
            $dateretour=$_POST['dateretour'];
            $cabine=$_POST['cabine'];
            $nbr_escal=$_POST['nbr_escal'];
            $model=$_POST['model'];
            $type=$_POST['type'];
            $services=explode(",",$_POST['services']);
            $services=array('tags'=>$services);
            $servicesjson=json_encode($services);
            $agenceVoyage->setPrix($prix);
            $agenceVoyage->setOffreName($offre);
            $agenceVoyage->setDateDepart($datedepart);
            $agenceVoyage->setDateRetour($dateretour);
            $agenceVoyage->setDepartPlace($placedepart);
            $agenceVoyage->setRetourPlace($placeretour);
            $agenceVoyage->setCabine($cabine);
            $agenceVoyage->setNbrEscale($nbr_escal);
            $agenceVoyage->setBoatPlaneModel($model);
            $agenceVoyage->setType($type);
            $agenceVoyage->setService($servicesjson);
            $agenceVoyage->setQouiqui($qq);
            $em->persist($agenceVoyage);
            $em->flush();
            $em->refresh($agenceVoyage);
            $idannonce = $agenceVoyage->getId();
            if ($_FILES) {
                $idUser = $this->getUser()->getId();
                $qq_id = $_POST['qouiqui_id'];
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
                if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce")):
                    mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce", 0777);
                    chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce", 0777);
                endif;
                $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce/";

                $tmp = $_FILES["img"]["tmp_name"];
                move_uploaded_file($tmp, $uploaddir . "$idannonce" . '.' . "png");
            }
            return $this->redirect($_SERVER['PHP_SELF'].'#section-annonces');
        }
    }
    public function getPaysAction(){
        $pays = $this->getDoctrine()->getRepository('AdminBundle:Pays')->findAll();
        $serializer = $this->container->get('serializer');
        $pays = $serializer->serialize($pays, 'json');
        return new Response($pays);
    }
    public function indexAction()
    {
        return $this->render('ModuleBundle:ambulance:index.html.twig');
    }
    public function filtrehotelAction()
    {
        $cat = "hotel";
        $tag = $_GET['tag'];
        $hotels = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findByNorV($tag, $cat);
        return new Response(json_encode($hotels));
    }
    public function filtrevoitureAction()
    {
        $tag = $_GET['tag'];
        $loactionvoiture = $this->getDoctrine()->getRepository('AdminBundle:LocationVoiture')->findvoiturelocation($tag);
        return new Response(json_encode($loactionvoiture));
    }
    public function ajouter_offreAction(request $request)
    {

        $data = $request->get("AdminBundle_agencevoyage");
        $qq_id = $data['qouiqui'];
        $dateDepart = $data["dateDepart"];
        $dateDepart_time = $data["dateDepart_time"];
        $dateRetour = $data["dateRetour"];
        $dateRetour_time = $data["dateRetour_time"];
        $newdateDepart = date('Y-m-d', strtotime($dateDepart)) . ' ' . $dateDepart_time;
        $newdateRetour = date('Y-m-d', strtotime($dateRetour)) . ' ' . $dateRetour_time;
        $agenceVoyage = new Agencevoyage();
        $form = $this->createForm('AdminBundle\Form\AgenceVoyageType', $agenceVoyage);
        $form->handleRequest($request);
        $formData = $form->getData();
        if (!(empty($data['service']))) {
            $datatag = array();
            $datatag['tags'] = $data['service'];
            $datatag = json_encode($datatag);
        } else {
            $datatag = "";
        }
        $formData->setDateDepart($newdateDepart);
        $formData->setDateRetour($newdateRetour);
        $formData->setService($datatag);

        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($agenceVoyage);
            $em->flush();
            $em->refresh($agenceVoyage);


            if ($_FILES) {
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
                if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce")):
                    mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce", 0777);
                    chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce", 0777);
                endif;

                $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/annonce/";

                move_uploaded_file(
                    $_FILES['file']['tmp_name'][0],
                    $uploaddir . $agenceVoyage->getId() . '.jpg'
                );

            }


        }

        return $this->redirect($_SERVER['PHP_SELF']);

    }
    function ficheAnnoncesAction(Request $request)
    {

        $quoiqui = $request->get('quoiqui');
//       $AgenceVoyage= $this->getDoctrine()->getRepository('AdminBundle:AgenceVoyage')->findByQouiqui($quoiqui);
        $AgenceVoyage= $this->getDoctrine()->getRepository('AdminBundle:AgenceVoyage')->findBy(array('qouiqui'=>$quoiqui->getId(),'type'=>'vol'));
        $AgenceVoyageCroi= $this->getDoctrine()->getRepository('AdminBundle:AgenceVoyage')->findBy(array('qouiqui'=>$quoiqui->getId(),'type'=>'croi'));
        $locationvoitures = $this->getDoctrine()->getRepository('AdminBundle:LocationVoiture')->findByQouiqui($quoiqui);
        $chambres = $this->getDoctrine()->getRepository('AdminBundle:Hotel')->findByQouiqui($quoiqui);

//        $categorie=$this->getDoctrine()->getRepository('AdminBundle:Category')->findBySlug('Hotel');
//        $categorie=$categorie[0];
//        $ngn=$this->getDoctrine()->getRepository('AdminBundle:Ngn')->findAll();
//        dump($ngn);
        return $this->render('@User/template/fiche/agenceVoyage/annonces.html.twig', [
            'attributes' => $request->attributes->all(),'quoiqui' => $quoiqui,'AgenceVoyages'=>$AgenceVoyage,
           'AgenceVoyageCroi'=>$AgenceVoyageCroi,'locationvoitures'=>$locationvoitures,'chambres'=>$chambres

        ]);
    }
    function ficheServicesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');
        $serv = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        if ($serv) {
            $Services = json_decode($serv->getData(), true);
        } else {
            $Services = null;
        }

        return $this->render('@User/template/fiche/agenceVoyage/services.html.twig', [
            'attributes' => $request->attributes->all(),'services' => $Services, 'quoiqui' => $quoiqui

        ]);
    }
}
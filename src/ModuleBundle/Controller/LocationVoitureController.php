<?php
/**
 * Created by PhpStorm.
 * User: POSTE 3
 * Date: 19/07/2017
 * Time: 11:09
 */

namespace ModuleBundle\Controller;


use AdminBundle\Entity\LocationVoiture;
use AdminBundle\Entity\Theme;
use ModuleBundle\Form\LocationVoitureType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;


class LocationVoitureController extends Controller
{
    public function minTarifByCategorie($id)
    {
        $min = $this->getDoctrine()
            ->getManager()
            ->createQueryBuilder()
            ->select('MIN(p.tarif) AS tarif')
            ->from('AdminBundle:LocationVoiture', 'p')
            ->where('p.marque = :marque')
            ->setParameter('marque', $id)
            ->getQuery()->getSingleResult();
        return $min;
    }

    public function maxTarifByCategorie($id)
    {
        $min = $this->getDoctrine()
            ->getManager()
            ->createQueryBuilder()
            ->select('MAX(p.tarif) AS tarif')
            ->from('AdminBundle:LocationVoiture', 'p')
            ->where('p.marque = :marque')
            ->setParameter('marque', $id)
            ->getQuery()->getSingleResult();
        return $min;
    }

    public function marqueCar()
    {
        $marque = $this->getDoctrine()
            ->getManager()
            ->createQueryBuilder()
            ->select('p')
            ->from('AdminBundle:Mark', 'p')
            ->where('p.id <158')
            ->getQuery()->getResult();
        return $marque;
    }

    public function is_404($url)
    {
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);

        /* Get the HTML or whatever is linked in $url. */
        $response = curl_exec($handle);

        /* Check for 404 (file not found). */
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);

        /* If the document has loaded successfully without any redirection or error */
        if ($httpCode == 404) {
            return false;
        } else {
            return true;
        }
    }

    //liste des marques
    function ficheAnnoncesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');
        $idUser = $quoiqui->getUser()->getId();
        $idQQ = $quoiqui->getId();
        $targetFile = $this->get('app.image_uploader')->targetDir . '/marque/';
        $em = $this->getDoctrine()->getManager();
        $voiture = $em->getRepository('AdminBundle:LocationVoiture')->findBy(array('qouiqui' => $quoiqui));
        $delegation = $em->getRepository('AdminBundle:Delegation')->findAll();
        $marques = $this->marqueCar();
        $marque = array();
        $ln = array();
        foreach ($voiture as $v) {
            array_push($marque, $v->getMarque());
        }
        $marque = array_unique($marque);
        foreach ($marque as $m) {
            $lm = array();
            $lm['nb'] = count($em->getRepository('AdminBundle:LocationVoiture')->findBy(array('marque' => $m)));
            $lm['nom'] = $m->getName();
            $lm['min'] = $this->minTarifByCategorie($m->getId())['tarif'];
            $lm['max'] = $this->maxTarifByCategorie($m->getId())['tarif'];
            $lm['photo'] = $m->getPicture();
            $lm['id'] = $m->getId();
            array_push($ln, $lm);
        }
        return $this->render('@User/template/fiche/locationVoiture/annonces.html.twig', [
            'attributes' => $request->attributes->all(), 'quoiqui' => $quoiqui, 'marque' => $ln, "voiture" => $voiture, "marques" => $marques, 'delegation' => $delegation
        ]);
    }

    //search des voitures
    function searchVoitureAction(Request $request)
    {
        dump($request);
        die;
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $request->get('quoiqui');
        $voiture = $em->getRepository('AdminBundle:LocationVoiture')->findBy(array('qouiqui' => $quoiqui));
        $marque = array();
        $ln = array();
        foreach ($voiture as $v) {
            array_push($marque, $v->getMarque());
        }
        $marque = array_unique($marque);
        foreach ($marque as $m) {
            $lm = array();
            $lm['nb'] = count($em->getRepository('AdminBundle:LocationVoiture')->findBy(array('marque' => $m)));
            $lm['nom'] = $m->getName();
            $lm['min'] = $this->minTarifByCategorie($m->getId())['tarif'];
            $lm['max'] = $this->maxTarifByCategorie($m->getId())['tarif'];
            $lm['photo'] = $m->getPicture();
            $lm['id'] = $m->getId();
            array_push($ln, $lm);
        }
        return $this->render('@User/template/fiche/locationVoiture/annonces.html.twig', [
            'attributes' => $request->attributes->all(), 'quoiqui' => $quoiqui, 'marque' => $ln, "voiture" => $voiture
        ]);
    }

    //liste des voitures
    public function ShowVehiculesAction($id, $idq)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findBy(array('id' => $idq));
        $marque = $em->getRepository('AdminBundle:Mark')->findBy(array('id' => $id));
        $vehicule = $em->getRepository('AdminBundle:LocationVoiture')->findBy(array('qouiqui' => $quoiqui, 'marque' => $marque));
        //objet to Json
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($vehicule) {
            return $vehicule->getId();
        });
        $serializer = $this->container->get('serializer');
        $serializer = new Serializer(array($normalizer), array($encoder));
        $report = $serializer->serialize($vehicule, 'json');
        return new Response($report);
    }

    public function getListeVoituresLimitAction($debut, $fin)
    {
        $locationvoitures = $this->getDoctrine()->getRepository('AdminBundle:LocationVoiture')->findAll();
        if ($fin >= count($locationvoitures))
            $fin = 1;

        $voitures = $this->getDoctrine()
            ->getManager()
            ->createQueryBuilder()
            ->select('l')
            ->from('AdminBundle:LocationVoiture', 'l')
            ->setFirstResult($debut)
            ->setMaxResults($fin)
            ->getQuery()->getResult();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($voitures) {
            return $voitures->getId();
        });
        $serializer = $this->container->get('serializer');
        $serializer = new Serializer(array($normalizer), array($encoder));
        $report = $serializer->serialize($voitures, 'json');
        return new Response($report);
        die();
        dump($voitures);
        die();
        $serializer = $this->container->get('serializer');
        $reports = $serializer->serialize($voitures, 'json');
        dump($reports);
        die();
        return new Response($reports);

    }

    /*reservation voiture*/
    public function reservationVoitureAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $voiture = $em->getRepository('AdminBundle:LocationVoiture')->findOneById($request->get('reserver'));
        $qouiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneById($request->get('id'));
        $delegation = $em->getRepository('AdminBundle:Delegation')->findOneById($request->get('selectbox3'));
        $voiture->setPosition($delegation);
        $em->flush();
        $transport = \Swift_SmtpTransport::newInstance('localhost', 25);
        $mailer = \Swift_Mailer::newInstance($transport);
        $privateKey = $this->getParameter('mail_privateKey');
        $selector = $this->getParameter('mail_selector');
        $message = \Swift_SignedMessage::newInstance();
        $message->setFrom('noreply@ween.tn')
            ->setTo("oussemaakrouti@gmail.com")
            ->setSubject("Demande de reservation ")
            ->setBody(
                $this->renderView('@Module/mail/location-reserver-voiture-mail.html.twig', array(
                    'name' => $request->get("nom") . " " . $request->get("prenom"),
                    'cin' => $request->get('cin'),
                    'tel' => $request->request->get('tel'),
                    'email' => $request->get("email"),
                    'body' => "Demande de reservation  voiture : " . $voiture->getSerie() . ' ' . $voiture->getMarque()->getName() . ' ' . $voiture->getModel(),
                    'delais' => ' du ' . $request->get('debut') . ' ' . $request->get('debHeure') . ' au ' . $request->get('fin') . ' ' . $request->get('finHeure'),
                    'subject' => 'Demande de reservation ',
                    'entreprise' => $qouiqui->getSlug(),
                )), "text/html");
        $mailer->send($message);
        $this->addFlash('email', 'Envoi de Demande succès attend votre confirmation par téléphone');
        return $this->redirect($_SERVER['PHP_SELF']);
    }

    /*detail voiture edit*/
    public function showEditAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $this->getDoctrine()->getRepository('AdminBundle:LocationVoiture')->findOneById($id);
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $produit->getQouiqui(), 'user' => $this->getUser()));
        $idUser = $this->getUser()->getId();
        $idQQ = $quoiqui->getId();
        if ($produit->getPicture() != null) {
            $produit->setPhotoArr(json_decode($produit->getPicture(), true));
            $phot = array();
            $arr = json_decode($produit->getPicture(), true);
            foreach ($arr as $photo) {
                $url = "uploads/image/$idUser/$idQQ/produits/$photo";
                array_push($phot, $url);
            }
            $produit->setPicture($phot);
        }
        //objet to Json
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($produit) {
            return $produit->getId();
        });
        $serializer = $this->container->get('serializer');
        $serializer = new Serializer(array($normalizer), array($encoder));
        $report = $serializer->serialize($produit, 'json');
        return new Response($report);
    }

    //delete picture
    function deletePictureAnnoncesAction($id, $pic)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('AdminBundle:LocationVoiture')->findOneById($id);
        $idUser = $this->getUser()->getId();
        $idQQ = $produit->getQouiqui()->getId();
        $photo = json_decode($produit->getPicture(), true);
        for ($i = 0; $i < count($photo); $i++) {
            if ($photo[$i] == $pic) {
                unset($photo[$i]);
                $img = $this->get('app.image_uploader')->targetDir . "/$idUser/$idQQ/produits/" . $pic;
                unlink($img);
            }
        }
        $produit->setPicture(json_encode(array_values($photo)));
        $produit->setPhotoArr(array_values($photo));
        $em->flush();

        $produits = $em->getRepository('AdminBundle:LocationVoiture')->findOneById($id);
        $prod = array();
        foreach (json_decode($produits->getPicture(), true) as $p) {
            $x = "uploads/image/$idUser/$idQQ/produits/" . $p;
            array_push($prod, $x);
        }
        $produits->setPicture($prod);
        //objet to Json
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($produits) {
            return $produits->getId();
        });
        $serializer = $this->container->get('serializer');
        $serializer = new Serializer(array($normalizer), array($encoder));
        $report = $serializer->serialize($produits, 'json');
        return new Response($report);

    }

    /*edit about*/
    public function edit_aboutAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $qouiqui_info = $request->get('qouiqui');
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

    /*edit logo apropos*/
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

    /*ajout d'une voiture*/
    public function AddVehiculeV2Action(Request $request)
    {
        if (isset($_POST)) {
            $em = $this->getDoctrine()->getManager();
            $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $request->get('qouiqui_id'), 'user' => $this->getUser()));
            $position = $em->getRepository('AdminBundle:Delegation')->findOneById($request->get('postion'));
            if ($request->get('marque') != null) {
                $marque = $em->getRepository('AdminBundle:Mark')->findOneByName($request->get('marque'));
            } else {
                $marque = $em->getRepository('AdminBundle:Mark')->findOneByName($request->get('mark'));
            }
            $idUser = $this->getUser()->getId();
            $idQQ = $quoiqui->getId();
            $picture = array();
            //upload file
            for ($i = 0; $i < count($_FILES['img']['name']); $i++) {
                if (!empty($_FILES['img']['name'][$i])) {
                    $tempFile = $_FILES['img']['tmp_name'][$i];
                    $name = md5(uniqid(rand(), true)) . '.jpg';
                    $targetFile = $this->get('app.image_uploader')->targetDir . "/$idUser/$idQQ/produits/$name";
                    #creation dossier avec l'id de l'utilisateur si n'existe pas
                    if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
                        mkdir($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
                        chmod($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
                    endif;
                    #creation dossier avec l'id de QUOIQUI si n'existe pas
                    if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$idQQ/")):
                        mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$idQQ/", 0777);
                        chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$idQQ/", 0777);
                    endif;
                    #creation dossier produits si n'existe pas
                    if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$idQQ/produits")):
                        mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$idQQ/produits", 0777);
                        chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$idQQ/produits", 0777);
                    endif;
                    move_uploaded_file($tempFile, $targetFile);
                    chmod($targetFile, 0777);
                    array_push($picture, $name);
                }
            }
            //insert car
            $vh = new LocationVoiture();
            $qq = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(['id' => $_POST['qouiqui_id']]);
            $vh->setSerie($_POST['serie']);
            $vh->setNbrPlace($_POST['nbr_place']);
            $vh->setPrixJour($_POST['prix']);
            $vh->setQouiqui($quoiqui);
            $vh->setAire($_POST['aire']);
            $vh->setBoite($_POST['boite']);
            $vh->setConducteur($_POST['conducteur']);
            $vh->setDescription($_POST['editeur']);
            $vh->setEnergy($_POST['energy']);
            $vh->setFiscalPower($_POST['fiscal_power']);
            $vh->setGps($_POST['gps']);
            $vh->setGrandvalises($_POST['grandvalises']);
            $vh->setKilow($_POST['kiloW']);
            $vh->setMileage($_POST['mileage']);
            $vh->setModelYear($_POST['model_year']);
            $vh->setPetitvalises($_POST['petitValises']);
            $vh->setPorte($_POST['ports']);
            $vh->setPosition($position);
            $vh->setModel($_POST['model']);
            $vh->setTarif($_POST['prix']);
            $vh->setDisponibilite($_POST['datee'] . " " . $_POST['timee']);
            $vh->setCouleur($_POST['couleur']);
            $vh->setMarque($marque);
            $vh->setEtat($request->get('etat'));
            $vh->setPicture(json_encode($picture));
            $em->persist($vh);
            $em->flush();
            $this->addFlash('success', 'véhicule enregistrer');
            return $this->redirect($_SERVER['PHP_SELF'] . "#section-annonces");
        } else {
            $this->addFlash('error', 'véhicule non enregistrer');
            return $this->redirect($_SERVER['PHP_SELF'] . "#section-annonces");
        }
    }

    /*edit voiture */
    public function editVoitureAction(Request $request)
    {
        if (isset($_POST)) {
            $em = $this->getDoctrine()->getManager();
            $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $request->get('qouiqui_id'), 'user' => $this->getUser()));
            $marque = $em->getRepository('AdminBundle:Mark')->findOneById($request->get('marque'));
            $idUser = $this->getUser()->getId();
            $idQQ = $quoiqui->getId();
            $picture = array();

            //update car
            $vh = $em->getRepository('AdminBundle:LocationVoiture')->findOneById($request->get('id'));
            $qq = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(['id' => $_POST['qouiqui_id']]);
            $vh->setSerie($_POST['serie']);
            $vh->setNbrPlace($_POST['nbr_place']);
            $vh->setPrixJour($_POST['prix']);
            $vh->setQouiqui($quoiqui);
            if ($request->get('aire') != null) {
                $vh->setAire($_POST['aire']);
            }
            $vh->setBoite($_POST['boite']);
            $vh->setConducteur($_POST['conducteur']);
            $vh->setDescription($_POST['editeur']);
            $vh->setEnergy($_POST['energy']);
            $vh->setFiscalPower($_POST['fiscal_power']);
            $vh->setGps($_POST['gps']);
            $vh->setGrandvalises($_POST['grandvalises']);
            $vh->setKilow($_POST['kiloW']);
            $vh->setMileage($_POST['mileage']);
            $vh->setModelYear($_POST['model_year']);
            $vh->setPetitvalises($_POST['petitValises']);
            $vh->setPorte($_POST['ports']);
            if ($request->get('siege') != null) {
                $vh->setSieges($_POST['sieges']);
            }
            $vh->setModel($_POST['model']);
            $vh->setTarif($_POST['prix']);
            $vh->setDisponibilite($_POST['datee'] . " " . $_POST['timee']);
            $vh->setCouleur($_POST['couleur']);
            $vh->setMarque($marque);
            $vh->setEtat($request->get('etat'));
            $photo = array();
            if ($vh->getPicture() != null) {
                $photo = json_decode($vh->getPicture(), true);
            }
            for ($i = 0; $i < count($_FILES['img']['name']) - 1; $i++) {
                if (!empty($_FILES['img']['name'][$i])) {
                    $name = md5(uniqid(rand(), true)) . '.jpg';
                    $targetFile = $this->get('app.image_uploader')->targetDir . "/" . $this->getUser()->getId() . "/" . $vh->getQouiqui()->getId() . "/produits/$name";
                    move_uploaded_file($_FILES['img']['tmp_name'][$i], $targetFile);
                    chmod($targetFile, 0777);
                    array_push($photo, $name);
                }
            }
            $vh->setPicture(json_encode($photo));
            $em->persist($vh);
            $em->flush();
            $this->addFlash('success', 'modification de véhicule enregistrer');
            return $this->redirect($_SERVER['PHP_SELF'] . "#section-annonces");
        } else {
            $this->addFlash('error', 'modidification de véhicule non enregistrer');
            return $this->redirect($_SERVER['PHP_SELF'] . "#section-annonces");
        }
    }

    /*liste des voitures render vers la page listeVehicule.html.twig*/
    public function ListeVehiculesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');
        $em = $this->getDoctrine()->getManager();
        $qqid = $_GET['qqid'];
        $qq = $em->getRepository('AdminBundle:Qouiqui')->findBy(['id' => $qqid]);
        $qq = $qq[0];
        $a = $this->getDoctrine()->getRepository('AdminBundle:LocationVoiture')->findByQouiqui($quoiqui);
        $response = array();
        foreach ($a as $v) {
            $response[] = array(
                'id' => $v->getId(),
                'serie' => $v->getSerie(),
                'prix_jour' => $v->getPrixJour(),
                'nbr_place' => $v->getNbrPlace(),
                'statut' => $v->getNbrPlace()
            );
        }
        return $this->render('ModuleBundle:Module:locationvoiture/listeVehicule.html.twig', array('vehicules' => $a));
    }

    /*liste des mark json*/
    public function GetmarkAction()
    {
        $Mark = $this->getDoctrine()->getRepository('AdminBundle:Mark')->findAll();
        $serializer = $this->container->get('serializer');
        $reports = $serializer->serialize($Mark, 'json');
        return new Response($reports);
    }

    /*liste des modeles json*/
    public function getModelVoitureAction()
    {
        $mark = $this->getDoctrine()->getRepository('AdminBundle:Mark')->findByName($_POST["id"]);
        $models = $this->getDoctrine()->getRepository('AdminBundle:Model')->findBy(array("mark" => $mark));
        $serializer = $this->container->get('serializer');
        $reports = $serializer->serialize($models, 'json');
        return new Response($reports);
    }

    /*get voiture par id json*/
    public function getVoitureByIdAction($id)
    {
        $voiture = $this->getDoctrine()->getRepository('AdminBundle:LocationVoiture')->findOneBy(array('id' => $id));
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($voiture) {
            return $voiture->getId();
        });
        $serializer = $this->container->get('serializer');
        $serializer = new Serializer(array($normalizer), array($encoder));
        $report = $serializer->serialize($voiture, 'json');
        return new Response($report);
    }

    /*suppression des voiture ajax*/
    public function deleteVoitureAction($id)
    {
        $voiture = $this->getDoctrine()->getRepository('AdminBundle:LocationVoiture')->findOneById($id);
        $em = $this->getDoctrine()->getManager();
        $iduser = $this->getUser()->getId();
        $qouiID = $voiture->getQouiqui()->getId();
        $storeFolder = $file = $this->get('app.image_uploader')->targetDir . "/$iduser" . "/$qouiID" . "/vehicule/";
        if ($voiture->getPicture() != "[]") {
            $voiture->setPicture(json_decode($voiture->getPicture(), true));
            foreach ($voiture->getPicture() as $pic) {
                if (is_file($storeFolder . $pic)) {
                    unlink($storeFolder . $pic);
                }
            }
        }
        $em->remove($voiture);
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF'] . "#section-annonces");
    }

    /*supprimer logo */
    public function deleteLogoAction(Request $requestn, $idqq)
    {
        die();
        $idUser = $this->getUser()->getId();
        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/avatar/";
        if (is_file($uploaddir . '/avatar.jpg')) {
            unlink($uploaddir . '/avatar.jpg');
        }
    }


//liste de services
    function ficheServicesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');
        $serv = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        if ($serv) {
            $locationVoitruesServices = json_decode($serv->getData(), true);
        } else {
            $locationVoitruesServices = null;
        }
        return $this->render('@User/template/fiche/locationVoiture/services.html.twig', [
            'attributes' => $request->attributes->all(), 'services' => $locationVoitruesServices, 'quoiqui' => $quoiqui
        ]);
    }
}
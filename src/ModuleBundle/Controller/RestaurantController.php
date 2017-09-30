<?php

namespace ModuleBundle\Controller;

use AdminBundle\Entity\Restaurant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;

class RestaurantController extends Controller
{
    function ficheAnnoncesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');
        $category = array();
        $data = array();
        $id = null;
        $idUser = $quoiqui->getUser()->getId();
        $idQQ = $quoiqui->getId();
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('AdminBundle:Restaurant')->findBy(array('qouiqui' => $quoiqui, 'category' => 'Meilleures ventes du moment'));
        $produits = $em->getRepository('AdminBundle:Restaurant')->findBy(array('qouiqui' => $quoiqui));
        foreach ($produit as $c) {
            $c->setPhoto(json_decode($c->getPhoto(), true));
            $phot = array();
            foreach ($c->getPhoto() as $photo) {
                $url = "uploads/image/$idUser/$idQQ/produits/$photo";
                array_push($phot, $url);
            }
            $c->setPhoto($phot);
        }
        return $this->render('@User/template/fiche/restaurant/annonces.html.twig', ['attributes' => $request->attributes->all(), 'plats' => $produits, 'produit' => $produit, 'id' => $id, 'category' => $category]);
    }

    function showAnnoncesAction($id, $idq)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $idq));
        $idUser = $quoiqui->getUser()->getId();
        $idQQ = $quoiqui->getId();
        $produit = $em->getRepository('AdminBundle:Restaurant')->findOneById($id);
        $phot = array();
        $arr = json_decode($produit->getPhoto(), true);
        foreach ($arr as $photo) {
            $url = "uploads/image/$idUser/$idQQ/produits/$photo";
            array_push($phot, $url);
        }
        $produit->setPhoto($phot);
        $produit->setContenu(strip_tags($produit->getContenu()));
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

    function filterAnnonceAction($filter, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $id));
        $produit = $em->getRepository('AdminBundle:Restaurant')->findByCategory($filter);
        $idUser = $quoiqui->getUser()->getId();
        $idQQ = $quoiqui->getId();
        foreach ($produit as $p) {
            $arr = json_decode($p->getPhoto(), true);
            $phot = array();
            foreach ($arr as $photo) {
                $url = "uploads/image/$idUser/$idQQ/produits/$photo";
                array_push($phot, $url);
            }
            $p->setPhoto($phot);
        }
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

    function addAnnoncesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $request->get('id'), 'user' => $this->getUser()));
        $idUser = $this->getUser()->getId();
        $idQQ = $quoiqui->getId();
        $picture = array();
        //upload file
        for ($i = 0; $i < count($_FILES['photo']['name']); $i++) {
            if (!empty($_FILES['photo']['name'][$i])) {
                $tempFile = $_FILES['photo']['tmp_name'][$i];
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
        //insert product
        $produit = new Restaurant();
       // $produit->setPhoto(json_encode($picture, true));
        $produit->setNom($request->get('title'));
        if ($request->get('sous-categorie') == null) {
            $produit->setCategory(strtolower($request->get('categorie-add')));
        } else {
            $produit->setCategory(strtolower($request->get('sous-categorie')));
            $request->attributes->set('sous-categorie-add', null);
        }
        $produit->setQouiqui($quoiqui);
        $produit->setPrix($request->get('prix'));
        $produit->setContenu($request->get('editeur'));
        $em->persist($produit);
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-annonces');
    }

    function deleteAnnoncesAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('AdminBundle:Restaurant')->findOneById($id);
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $produit->getQouiqui(), 'user' => $this->getUser()));
        $idUser = $this->getUser()->getId();
        $idQQ = $quoiqui->getId();
        $img = $this->get('app.image_uploader')->targetDir . "/$idUser/$idQQ/produits/" . $produit->getPhoto();
        if (is_file($img))
            unlink($img);
        $em->remove($produit);
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-annonces');
    }

    function deletePictureAnnoncesAction($id, $pic)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('AdminBundle:Restaurant')->findOneById($id);
        $idUser = $this->getUser()->getId();
        $idQQ = $produit->getQouiqui()->getId();
        $photo = json_decode($produit->getPhoto(), true);
        for ($i = 0; $i < count($photo); $i++) {
            if ($photo[$i] == $pic) {
                unset($photo[$i]);
                $img = $this->get('app.image_uploader')->targetDir . "/$idUser/$idQQ/produits/" . $pic;
                unlink($img);
            }
        }
        $produit->setPhoto(json_encode(array_values($photo)));
        $produit->setPhotoArr(array_values($photo));
        $em->flush();

        $produits = $em->getRepository('AdminBundle:Restaurant')->findOneById($id);
        $prod = array();
        foreach (json_decode($produits->getPhoto(), true) as $p) {
            $x = "uploads/image/$idUser/$idQQ/produits/" . $p;
            array_push($prod, $x);
        }
        $produits->setPhoto($prod);
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
        $response = new Response(json_encode($p, true));
        return $response;

    }

    function editAnnoncesAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $this->getDoctrine()->getRepository('AdminBundle:Restaurant')->findOneById($id);
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $produit->getQouiqui(), 'user' => $this->getUser()));
        $idUser = $this->getUser()->getId();
        $idQQ = $quoiqui->getId();
        $produit->setPhotoArr(json_decode($produit->getPhoto(), true));
        $phot = array();
        $arr = json_decode($produit->getPhoto(), true);
        foreach ($arr as $photo) {
            $url = "uploads/image/$idUser/$idQQ/produits/$photo";
            array_push($phot, $url);
        }
        $produit->setPhoto($phot);
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
        $response = new Response(json_encode($p, true));
        return $response;
    }

    function updateAnnoncesAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('AdminBundle:Restaurant')->findOneById($id);
        $produit->setNom($request->get('title'));
        $produit->setPrix($request->get('prix'));
        $produit->setContenu($request->get('editeur'));
        $produit->setCategory($request->get('categorie'));
        $photo = array();
        if ($produit->getPhoto() != null) {
            $photo = json_decode($produit->getPhoto(), true);
        }
        for ($i = 0; $i < count($_FILES['photo']['name']) - 1; $i++) {
            if ($_FILES['photo']['name'][$i] != null) {
                $name = md5(uniqid(rand(), true)) . '.jpg';
                $targetFile = $this->get('app.image_uploader')->targetDir . "/" . $this->getUser()->getId() . "/" . $produit->getQouiqui()->getId() . "/produits/$name";
                move_uploaded_file($_FILES['photo']['tmp_name'][$i], $targetFile);
                chmod($targetFile, 0777);
                array_push($photo, $name);
            }
        }
        $produit->setPhoto(json_encode($photo));
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-annonces');
    }

    function commandeAnnoncesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $request->get('id')));
        $panier = json_decode($_POST['commande'], true)['panierRest'];
        $commande = json_decode($panier, true);
        $message = (new \Swift_Message('Reservation'))
            ->setFrom('noreply@ween.tn')
            ->setTo("oussemaakrouti@gmail.com")
            ->setBody($this->renderView('@User/template/fiche/restaurant/email.html.twig',
                array(
                    'entreprise' => $quoiqui->getFirstName(),
                    'name' => $request->get('nom') . ' ' . $request->get('prenom'),
                    'adresse' => $request->get('adresse'),
                    'email' => $request->get('email'),
                    'remarque' =>$request->get('remarque'),
                    'tel' =>$request->get('tel'),
                    'commande' => $commande,
                    'origin'=> $request->get('origin'),
                )), 'text/html');


        $this->get('mailer')->send($message);
        unset($_COOKIE['panierRest']);
        $this->get('session')->getFlashBag()->add('email', 'envoi email');
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-annonces');
    }

    function ficheServicesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');
        $data = array();
        $id = null;
        $em = $this->getDoctrine()->getManager();
        $theme = $em->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        if ($theme != null) {
            $data = json_decode($theme->getData(), true)['Service'];
            $id = $theme->getId();
        }
        return $this->render('@User/template/fiche/restaurant/services.html.twig', [
            'attributes' => $request->attributes->all(),
            'service' => $data,
            'id' => $id, 'nbr' => count($data)
        ]);
    }
}

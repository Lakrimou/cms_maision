<?php

namespace ModuleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AdminBundle\Entity\Opticien;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class OpticienController extends Controller
{
    function pathPicture($opticen, $idUser, $idQQ)
    {
        foreach ($opticen as $c) {
            $c->setPicture(json_decode($c->getPicture(), true));
            $phot = array();
            foreach ($c->getPicture() as $photo) {
                $url = "uploads/image/$idUser/$idQQ/produits/$photo";
                array_push($phot, $url);
            }
            $c->setPicture($phot);
        }

    }

    function ficheAnnoncesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');
        $category = array();
        $data = array();
        $id = null;
        $idUser = $quoiqui->getUser()->getId();
        $idQQ = $quoiqui->getId();
        $em = $this->getDoctrine()->getManager();
        $lentis = $em->getRepository('AdminBundle:Opticien')->findBy(array('qouiqui' => $quoiqui, 'categorie' => 'lentille'));
        $soleil = $em->getRepository('AdminBundle:Opticien')->findBy(array('qouiqui' => $quoiqui, 'categorie' => 'lunette soleil'));
        $vue = $em->getRepository('AdminBundle:Opticien')->findBy(array('qouiqui' => $quoiqui, 'categorie' => 'lunette vue'));
        $verre = $em->getRepository('AdminBundle:Opticien')->findBy(array('qouiqui' => $quoiqui, 'categorie' => 'verre'));
        $this->pathPicture($lentis, $idUser, $idQQ);
        $this->pathPicture($soleil, $idUser, $idQQ);
        $this->pathPicture($vue, $idUser, $idQQ);
        $this->pathPicture($verre, $idUser, $idQQ);
        return $this->render('@User/template/fiche/Opticien/annonces.html.twig', [
            'attributes' => $request->attributes->all(),
            'lentille' => $lentis, 'soleil' => $soleil, 'vue' => $vue, 'verre' => $verre
        ]);
    }

    function ficheAnnoncesPagesAction($page, $id, $categorie)
    {
        $offset = $page * 4;
        $nb = ($page + 1) * 4;
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $id));
        $nbp = count($em->getRepository('AdminBundle:Opticien')->findBy(array('qouiqui' => $quoiqui, 'categorie' => $categorie)));
        $produit = $em->getRepository('AdminBundle:Opticien')->findBy(array('qouiqui' => $quoiqui), array('id' => 'DESC'), 4, $offset);
        foreach ($produit as $p) {
            $p->setPicture(json_decode($p->getPhoto(), true));
        }
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array("qouiqui"));
        $encoder = new JsonEncoder();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $object = $serializer->serialize($produit, 'json');
        return new Response($object);

    }

    function ficheAnnoncesPagesDeleteAction($page, $id, $categorie)
    {
        $offset = $page * 4;
        $nb = ($page + 1) * 4;
        $delete = array();
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $id));
        $produit = $em->getRepository('AdminBundle:Opticien')->findBy(array('qouiqui' => $quoiqui, 'categorie' => $categorie), array('id' => 'DESC'));
        $nbp = count($produit);
        $nombre = $nbp - $nb;
        if ($nombre < 0) {
            $send = $nombre + 4;
            for ($i = $nbp - 1; $i >= $nbp - $send; $i--) {
                array_push($delete, $produit[$i]->getId());
            }
        } else {
            for ($i = $nb - 1; $i > $page * 4 - 1; $i--) {
                array_push($delete, $produit[$i]->getId());
            }
        }
        return new Response(json_encode($delete));
    }

    function showAnnoncesAction($id, $idq)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $idq));
        $idUser = $quoiqui->getUser()->getId();
        $idQQ = $quoiqui->getId();
        $produit = $em->getRepository('AdminBundle:Opticien')->findOneById($id);
        $phot = array();
        $arr = json_decode($produit->getPicture(), true);
        foreach ($arr as $photo) {
            $url = "uploads/image/$idUser/$idQQ/produits/$photo";
            array_push($phot, $url);
        }
        $produit->setPicture($phot);
        $produit->setDescription(strip_tags(html_entity_decode($produit->getDescription())));
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
        $produit = new Opticien();
        $produit->setPicture(json_encode($picture, true));
        $produit->setNom($request->get('nom'));
        $produit->setReference($request->get('reference'));
        $produit->setSex($request->get('sex'));
        $produit->setColor($request->get('couleur'));
        $produit->setModel($request->get('modele'));
        $produit->setMarque($request->get('marque'));
        $produit->setforme($request->get('forme'));
        $produit->setQuantity((int)$request->get('quantite'));
        $produit->setDescription($request->get('editeur'));
        $produit->setPeriodicite($request->get('periodicite'));
        $produit->setConditions($request->get('condition'));
        $produit->setCorrection($request->get('correction'));
        $produit->setMaterial($request->get('matiere'));
        $produit->setQouiqui($quoiqui);
        $produit->setPrice((float)$request->get('prix'));
        $produit->setLabo($request->get('labo'));
        $produit->setCategorie($request->get('categorie'));
        $produit->setIndice($request->get('indice'));
        $produit->setDescription($request->get('editeur'));
        $produit->setWeight($request->get('weight'));
        $produit->setDimensions($request->get('dimension'));
        $em->persist($produit);
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-annonces');
    }

    function deleteAnnoncesAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('AdminBundle:Opticien')->findOneById($id);
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $produit->getQouiqui(), 'user' => $this->getUser()));
        $idUser = $this->getUser()->getId();
        $idQQ = $quoiqui->getId();
        $produit->setPicture(json_decode($produit->getPicture(), true));
        foreach ($produit->getPicture() as $photo) {
            $img = $this->get('app.image_uploader')->targetDir . "/$idUser/$idQQ/produits/" . $photo;
            if (is_file($img))
                unlink($img);
        }
        $em->remove($produit);
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-annonces');
    }

    function editAnnoncesAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $this->getDoctrine()->getRepository('AdminBundle:Opticien')->findOneById($id);
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $produit->getQouiqui(), 'user' => $this->getUser()));
        $idUser = $this->getUser()->getId();
        $idQQ = $quoiqui->getId();
        $phot = array();
        $arr = json_decode($produit->getPicture(), true);
        foreach ($arr as $photo) {
            $url = "uploads/image/$idUser/$idQQ/produits/$photo";
            array_push($phot, $url);
        }
        $produit->setPicture($phot);
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
        $produit = $em->getRepository('AdminBundle:Opticien')->findOneById($request->get('id'));
        $produit->setNom($request->get('nom'));
        $produit->setReference($request->get('reference'));
        $produit->setSex($request->get('sex'));
        $produit->setColor($request->get('couleur'));
        $produit->setModel($request->get('modele'));
        $produit->setMarque($request->get('marque'));
        $produit->setforme($request->get('forme'));
        $produit->setQuantity((int)$request->get('quantite'));
        $produit->setDescription($request->get('editeur'));
        $produit->setPeriodicite($request->get('periodicite'));
        $produit->setConditions($request->get('condition'));
        $produit->setCorrection($request->get('correction'));
        $produit->setMaterial($request->get('matiere'));
        $produit->setPrice((float)$request->get('prix'));
        $produit->setLabo($request->get('labo'));
        $produit->setIndice($request->get('indice'));
        $produit->setDescription($request->get('editeur'));
        $produit->setWeight($request->get('weight'));
        $produit->setDimensions($request->get('dimension'));
        $photo = array();
        if ($produit->getPicture() != null) {
            $photo = json_decode($produit->getPicture(), true);
            for ($i = 0; $i < count($_FILES['photo']['name']) - 1; $i++) {
                if ($_FILES['photo']['name'][$i] != null) {
                    $name = md5(uniqid(rand(), true)) . '.jpg';
                    $targetFile = $this->get('app.image_uploader')->targetDir . "/" . $this->getUser()->getId() . "/" . $produit->getQouiqui()->getId() . "/produits/$name";
                    move_uploaded_file($_FILES['photo']['tmp_name'][$i], $targetFile);
                    chmod($targetFile, 0777);
                    array_push($photo, $name);
                }
            }
            $produit->setPicture(json_encode($photo));
        }
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-annonces');
    }

    function reserverAnnoncesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $offre = $em->getRepository('AdminBundle:AutoEcole')->findOneById($request->get('commande'));
        $message = (new \Swift_Message('Reservation'))
            ->setFrom('noreply@ween.tn')
            ->setTo(/*$request->get('user')*/
                "oussemaakrouti@gmail.com")
            ->setBody($this->renderView('@User/template/fiche/AutoEcole/email.html.twig',
                array(
                    'name' => $request->get('nom'),
                    'adresse' => $request->get('adresee'),
                    'email' => $request->get('email'),
                    'remarque' => $request->get('remarque'),
                    'tel' => $request->get('tel'),
                    'offre' => $offre,
                )), 'text/html');
        $this->get('mailer')->send($message);
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-services');
    }


    function ficheServicesAction(Request $request)
    {
        return $this->render('@User/template/fiche/Opticien/services.html.twig', [
            'attributes' => $request->attributes->all()
        ]);
    }


}

<?php

namespace ModuleBundle\Controller;

use AdminBundle\Entity\AutoEcole;
use AdminBundle\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;


class AutoEcoleController extends Controller
{
    function ficheAnnoncesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');
        $data = array();
        $id = null;
        $date = date("Y-m-d");
        $prod = array();
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('AdminBundle:AutoEcole')->findBy(array('qouiqui' => $quoiqui), array('id' => 'DESC'));
        $nb = count($em->getRepository('AdminBundle:AutoEcole')->findBy(array('qouiqui' => $quoiqui)));
        foreach ($produit as $p) {
            if ($p->getDateDeb() >= $date) {
                array_push($prod, $p);
            }
            $p->setPhoto(json_decode($p->getPhoto(), true));
        }
        array_reverse($prod);
        return $this->render('@User/template/fiche/AutoEcole/annonces.html.twig', [
            'attributes' => $request->attributes->all(),
            'produit' => $prod,
            'id' => $id,
            'nb' => $nb
        ]);
    }

    function ficheAnnoncesPagesAction($page, $id)
    {
        $offset = $page * 4;
        $nb = ($page + 1) * 4;
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $id));
        $nbp = count($em->getRepository('AdminBundle:AutoEcole')->findBy(array('qouiqui' => $quoiqui)));
        $produit = $em->getRepository('AdminBundle:AutoEcole')->findBy(array('qouiqui' => $quoiqui), array('id' => 'DESC'), 4, $offset);
        foreach ($produit as $p) {
            $p->setPhoto(json_decode($p->getPhoto(), true));
        }
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array("qouiqui"));
        $encoder = new JsonEncoder();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $object = $serializer->serialize($produit, 'json');
        return new Response($object);

    }

    function ficheAnnoncesPagesDeleteAction($page, $id)
    {
        $offset = $page * 4;
        $nb = ($page + 1) * 4;
        $delete = array();
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $id));
        $produit = $em->getRepository('AdminBundle:AutoEcole')->findBy(array('qouiqui' => $quoiqui), array('id' => 'DESC'));
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
        $produit = $em->getRepository('AdminBundle:AutoEcole')->findOneById($id);
        $phot = array();
        $arr = json_decode($produit->getPhoto(), true);
        foreach ($arr as $photo) {
            $url = "uploads/image/$idUser/$idQQ/produits/$photo";
            array_push($phot, $url);
        }
        $produit->setPhoto($phot);
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
        $produit = new AutoEcole();
        $produit->setPhoto(json_encode($picture, true));
        $produit->setNom($request->get('title'));
        $produit->setDateDeb($request->get('dateDeb'));
        $produit->setDateFin($request->get('dateFin'));
        $produit->setQouiqui($quoiqui);
        $produit->setDateAjoute(new \DateTime());
        $produit->setPrix($request->get('prix'));
        $produit->setDescription($request->get('editeur'));
        $em->persist($produit);
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-annonces');
    }

    function deleteAnnoncesAction($id)
    {
        dump($id);die;
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('AdminBundle:AutoEcole')->findOneById($id);
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $produit->getQouiqui(), 'user' => $this->getUser()));
        $idUser = $this->getUser()->getId();
        $idQQ = $quoiqui->getId();
        if($produit->getPicture() != null) {
            $produit->setPicture(json_decode($produit->getPicture(),true));
            foreach ($produit->getPicture() as $pic) {
                $img = $this->get('app.image_uploader')->targetDir . "/$idUser/$idQQ/produits/" . $pic;
                if (is_file($img))
                    unlink($img);
            }
        }
        $em->remove($produit);
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-annonces');
    }

    function editAnnoncesAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $this->getDoctrine()->getRepository('AdminBundle:AutoEcole')->findOneById($id);
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
    }

    function updateAnnoncesAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('AdminBundle:AutoEcole')->findOneById($request->get('id'));
        $produit->setNom($request->get('title'));
        $produit->setPrix($request->get('prix'));
        $produit->setDateDeb($request->get('dateDeb'));
        $produit->setDateFin($request->get('dateFin'));
        $produit->setDescription($request->get('editeur'));
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
        return $this->render('@User/template/fiche/AutoEcole/services.html.twig', [
            'attributes' => $request->attributes->all(),
            'service' => $data,
            'id' => $id, 'nbr' => count($data)
        ]);
    }

    function addServiceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $request->get('id'), 'user' => $this->getUser()));
        $theme = $em->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        $data['Service'] = array();
        $service = array();
        $service['title'] = $request->get('title');
        $service['href'] = '"http://' . $quoiqui->getSlug() . 'ween.tn/' . $request->get('title');
        $service['description'] = $request->get('description');
        if ($theme == null) {
            $service['pos'] = 1;
            $data['Service'][0] = $service;
            $theme = new Theme();
            $theme->setQouiqui($quoiqui);
            $theme->setData(json_encode($data, true));
            $em->persist($theme);
            $em->flush();
        } else {
            $json = json_decode($theme->getData(), true);
            if ($json['Service'] == null) {
                $service['pos'] = 1;
                $data['Service'][0] = $service;
                $theme->setData(json_encode($data, true));
                $em->flush();
            } else {
                $data = json_decode($theme->getData(), true);
                $dataa = $data['Service'];
                $service['pos'] = end($dataa)['pos'] + 1;
                array_push($dataa, $service);
                $data["Service"] = $dataa;
                $theme->setData(json_encode($data, true));
                $em->flush();
            }
        }
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-services');
    }

    function recherchePosDel($data, $pos)
    {
        foreach ($data as $index => $val) {
            if ($val['pos'] == (int)$pos) {
                return $index;
                break;
            }
        }
    }

    function showServiceAction($id, $pos)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneById($id);
        $theme = $em->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        $data = json_decode($theme->getData(), true);
        $dataa = array();
        $dataa = $data["Service"];
        $p = $this->recherchePosDel($dataa, $pos);
        $response = new Response(json_encode($data['Service'][$p], true));
        return $response;
    }

    function deleteServiceAction($id, $pos)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneById($id);
        $theme = $em->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        $data = json_decode($theme->getData(), true);
        $dataa = array();
        $dataa = $data["Service"];
        $p = $this->recherchePosDel($dataa, $pos);
        unset($dataa[$p]);
        $data["Service"] = $dataa;
        $theme->setData(json_encode($data, true));
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-services');
    }

    function editServiceAction($id, $pos)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneById($id);
        $theme = $em->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        $data = json_decode($theme->getData(), true);
        $p = $this->recherchePosDel($data['Service'], $pos);
        $response = new Response(json_encode($data['Service'][$p], true));
        return $response;
    }

    function updateServiceAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneById($id);
        $theme = $em->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        $data = json_decode($theme->getData(), true);
        $dataa = $data["Service"];
        $service['title'] = $request->get('title');
        $service['href'] = '"http://' . $quoiqui->getSlug() . 'ween.tn/' . $request->get('title');
        $service['description'] = $request->get('description');
        $service['pos'] = $request->get('p');
        $dataa[$request->get('p') - 1] = $service;
        $data["Service"] = $dataa;
        $theme->setData(json_encode($data, true));
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-services');
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
}

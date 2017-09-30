<?php

namespace ModuleBundle\Controller;

use AdminBundle\Entity\ModECommerce;
use AdminBundle\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class ModECommerceController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }


    public function nouveauProduitAction()
    {

        $produit = new ModECommerce();

        $produit->setSection('produits');
        $produit->setNom($_POST['nom']);
        $produit->setData(json_encode(array('desc' => $_POST['description'], 'prix' => $_POST['prix'])));
        $produit->setQouiqui($this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($_POST['quoiqui']));
        if (isset($_POST['status']))
            $produit->setStatus(1);


        $em = $this->getDoctrine()->getManager();
        $em->persist($produit);
        $em->flush();
        $em->refresh($produit);


        $idUser = $this->getUser()->getId();
        $idQQ = $_POST['quoiqui'];
        $idProduit = $produit->getId();


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

        $this->uploadFile($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$idQQ/produits/", $idProduit);


        die();
    }

    /**
     * modification d"un produit
     */
    public function editProduitAction()
    {


        $produit = new ModECommerce();
        $produit = $this->getDoctrine()->getRepository('AdminBundle:ModECommerce')->findOneBy(array('id' => $_POST['id'], 'qouiqui' => $_POST['quoiqui']));

        $produit->setSection('produits');
        $produit->setNom($_POST['nom']);
        $produit->setData(json_encode(array('desc' => $_POST['description'], 'prix' => $_POST['prix'])));
        $produit->setQouiqui($this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($_POST['quoiqui']));
        if (isset($_POST['status']))
            $produit->setStatus(1);


        $em = $this->getDoctrine()->getManager();
        $em->persist($produit);
        $em->flush();
        $em->refresh($produit);


        $idUser = $this->getUser()->getId();
        $idQQ = $_POST['quoiqui'];
        $idProduit = $produit->getId();

        if (isset($_FILES['file'])) {
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

            $this->uploadFile($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$idQQ/produits/", $idProduit);
        }

        die();
    }

    /**
     * afficher la liste des  produits en format json
     * @param $idQQ
     * @return JsonResponse
     */
    function listeProduitAction($idQQ)
    {

        $produits = $this->getDoctrine()->getRepository('AdminBundle:ModECommerce')->findBy(array('qouiqui' => $idQQ, 'section' => 'produits'));
        $prod = array();
        foreach ($produits as $p) {

            $pp = false;
            $pathImg = 'https://' . $this->getParameter('doamin') . '/uploads/image/' . $this->getUser()->getId() . '/' . $idQQ . '/produits/' . $p->getId() . '.jpg';
            $data = json_decode($p->getData(), true);
            $pp[] = "<img src='$pathImg' class='img-responsive'>";
            $pp[] = $p->getNom();
            $pp[] = $data['prix'] . 'DT';
            $pp[] = $data['desc'];
            $pp[] = ($p->getStatus() == 0) ? '<i class="fa fa-eye-slash fa-2x" aria-hidden="true"></i>' : '<i class="fa fa-eye fa-2x" aria-hidden="true"></i>';
            $pp[] = '<button class="btn btn-default btn-xs btnProduitModifier" data-id="' . $p->getId() . '" data-qq="' . $idQQ . '">Modifier</button>' .
                '<button data-id="' . $p->getId() . '" data-qq="' . $idQQ . '" class="btn btn-danger btn-xs deleteProd">Supprimer</button>';


            $prod['data'][] = $pp;
        }


        $response = new JsonResponse();
        $response->setData($prod);

        return $response;
    }


    public function deleteProduitAction($idQQ, $idProd)
    {

        $idUser = $this->getUser()->getId();


        $produit = $this->getDoctrine()->getRepository('AdminBundle:ModECommerce')->findOneBy(array('id' => $idProd, 'qouiqui' => $idQQ));
        if ($produit) {
            if ($produit->getQouiqui()->getUser()->getId() == $idUser) {


                $img = $this->get('app.image_uploader')->targetDir . "/$idUser/$idQQ/produits/$idProd.jpg";
                if (is_file($img))
                    unlink($img);
                $em = $this->getDoctrine()->getManager();
                $em->remove($produit);
                $em->flush($produit);
                die('1');

            } else {
                die('0');
            }
        }

        die('0');
    }


    public function uploadImageCroppingLogoAction($idQQ)
    {


        $target = $this->get('app.image_uploader')->targetDir . "/" . $this->getUser()->getId();

        #creation dossier avec l'id du l'avocat
        if (!is_dir($target)):
            mkdir($target, 0777);
            chmod($target, 0777);
        endif;

        #creation dossier avec l'id du l'avocat
        if (!is_dir($target . "/$idQQ")):
            mkdir($target . "/$idQQ", 0777);
            chmod($target . "/$idQQ", 0777);
        endif;


        if ($_POST['data']) {
            $base64 = str_replace(' ', '+', $_POST['data']);

            if ($this->save_base64_image($base64, 'avatar', $target . "/$idQQ/")) {
                echo '1';
                die();
            }

        }
        echo '0';
        die();
    }


    public function save_base64_image($base64_image_string, $output_file_without_extension, $path_with_end_slash = "")
    {

        //usage:  if( substr( $img_src, 0, 5 ) === "data:" ) {  $filename=save_base64_image($base64_image_string, $output_file_without_extentnion, getcwd() . "/application/assets/pins/$user_id/"); }
        //
        //data is like:    data:image/png;base64,asdfasdfasdf
        $splited = explode(',', substr($base64_image_string, 5), 2);
        $mime = $splited[0];
        $data = $splited[1];

        $mime_split_without_base64 = explode(';', $mime, 2);
        $mime_split = explode('/', $mime_split_without_base64[0], 2);
        if (count($mime_split) == 2) {
            $extension = $mime_split[1];
            if ($extension == 'jpeg') $extension = 'jpg';
            //if($extension=='javascript')$extension='js';
            //if($extension=='text')$extension='txt';
            $output_file_with_extension = $output_file_without_extension . '.' . $extension;
        }
        file_put_contents($path_with_end_slash . $output_file_with_extension, base64_decode($data));
        return $output_file_with_extension;
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


    function ficheAnnoncesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');
        $data = array();
        $id = null;
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('AdminBundle:ModECommerce')->findBy(array('qouiqui' => $quoiqui), array('prix' => 'ASC'));
        $offre = $em->getRepository('AdminBundle:ModECommerce')->findBy(array('qouiqui' => $quoiqui,'offre'=>1), array('prix' => 'ASC'));
        foreach ($produit as $p) {
            $x = json_decode($p->getData(), true)['desc'];
            $p->setData($x);
            $p->setPhotoArray(json_decode($p->getPhoto(), true));
        }
        return $this->render('@User/template/fiche/ModECommerce/annonces.html.twig', [
            'attributes' => $request->attributes->all(),
            'offre' =>$offre,
            'produit' => $produit,
            'id' => $id,
        ]);
    }

    function showAnnoncesAction($id, $idq)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $idq));
        $idUser = $quoiqui->getUser()->getId();
        $idQQ = $quoiqui->getId();
        $produit = $em->getRepository('AdminBundle:ModECommerce')->findOneById($id);
        $img = $produit->getPhoto();
        $phot = array();
        $arr = json_decode($produit->getPhoto(), true);
        foreach ($arr as $photo) {
            $url = "uploads/image/$idUser/$idQQ/produits/$photo";
            array_push($phot, $url);
        }
        $produit->setPhoto($phot);
        $produit->setData(strip_tags(json_decode($produit->getData(), true)['desc']));
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
        $photo = array();
        //upload file
        for ($i = 0; $i < count($_FILES['photo']['name']); $i++) {
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
            array_push($photo, $name);
        }
        //insert product
        $produit = new ModECommerce();
        $produit->setPhoto(json_encode($photo, true));
        $produit->setNom($request->get('title'));
        $produit->setMarque($request->get('marque'));
        $produit->setQouiqui($quoiqui);
        $produit->setDatecreate(new \DateTime());
        $produit->setStatus(1);
        $produit->setCategorie($request->get('selectbox1'));
        $produit->setSousCategorie($request->get('selectbox2'));
        $produit->setSection('informatique');
        $produit->setPrix($request->get('prix'));
        $produit->setStock($request->get('stock'));
        $data = array();
        $data['desc'] = $request->get('editeur');
        $produit->setData(json_encode($data, true));
        $em->persist($produit);
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-annonces');
    }

    function deleteAnnoncesAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('AdminBundle:ModECommerce')->findOneById($id);
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $produit->getQouiqui(), 'user' => $this->getUser()));
        $idUser = $this->getUser()->getId();
        $idQQ = $quoiqui->getId();
        $json = json_decode($produit->getPhoto(), true);
        if(count($json)>0) {
            foreach ($json as $j) {
                $img = $this->get('app.image_uploader')->targetDir . "/" . $this->getUser()->getId() . "/" . $produit->getQouiqui()->getId() . "/produits/" . $j;
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
        $produit = $this->getDoctrine()->getRepository('AdminBundle:ModECommerce')->findOneById($id);
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $produit->getQouiqui(), 'user' => $this->getUser()));
        $produit->setData(json_decode($produit->getData(), true)['desc']);
        $idUser = $this->getUser()->getId();
        $idQQ = $quoiqui->getId();
        $produit->setPhoto("uploads/image/$idUser/$idQQ/produits/" . $produit->getPhoto());
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
        $produit = $em->getRepository('AdminBundle:ModECommerce')->findOneById($id);
        $produit->setMarque($request->get('marque'));
        $produit->setNom($request->get('title'));
        $produit->setPrix($request->get('prix'));
        $produit->setStock($request->get('stock'));
        $data['desc'] = $request->get('editeur');
        $produit->setData(json_encode($data, true));
        $json = json_decode($produit->getPhoto(), true);
        if ($_FILES['photo']['name'] != null) {
            $photo = array();
            if(count($json)>0) {
                foreach ($json as $j) {
                    $img = $this->get('app.image_uploader')->targetDir . "/" . $this->getUser()->getId() . "/" . $produit->getQouiqui()->getId() . "/produits/" . $j;
                    unlink($img);
                }
            }
            for ($i = 0; $i < count($_FILES['photo']['name']); $i++) {
                $name = md5(uniqid(rand(), true)) . '.jpg';
                $targetFile = $this->get('app.image_uploader')->targetDir . "/" . $this->getUser()->getId() . "/" . $produit->getQouiqui()->getId() . "/produits/$name";
                move_uploaded_file($_FILES['photo']['tmp_name'][$i], $targetFile);
                chmod($targetFile, 0777);
                array_push($photo, $name);
            }
            $produit->setPhoto(json_encode($photo, true));
        }
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
        return $this->render('@User/template/fiche/ModECommerce/services.html.twig', [
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

    private function recherchePosDel($data, $pos)
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

    function addOffreAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $request->get('id'), 'user' => $this->getUser()));
        $produit = $em->getRepository('AdminBundle:ModECommerce')->findOneById($request->get('selectbox1'));
        $produit->setDateDeb($request->get('start'));
        $produit->setDateFin($request->get('end'));
        $produit->setPrixN($request->get('prix'));
        dump($produit);die;
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-offre');
    }
}

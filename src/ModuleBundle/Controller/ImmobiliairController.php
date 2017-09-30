<?php
/**
 * Created by PhpStorm.
 * User: POSTE 7
 * Date: 15/05/2017
 * Time: 10:00
 */

namespace ModuleBundle\Controller;

use AdminBundle\Entity\Qville;
use AdminBundle\Entity\Theme;
use AdminBundle\Entity\Immobiliair;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;


class ImmobiliairController extends Controller
{

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

            if (isset($file['file'])) {
                $tempFile = $file['file']['tmp_name'];
                if (!$name)
                    $name = md5(uniqid(rand(), true));
//            $targetFile = $src . $name . '.' . pathinfo($file['file']['name'], PATHINFO_EXTENSION);
                $targetFile = $src . $name . '.jpg';
                move_uploaded_file($tempFile, $targetFile);
                chmod($targetFile, 0777);
            }

            if (isset($file['files'])) {
                foreach ($file['files']['tmp_name'] as $tempFile) {
                    if (!$name)
                        $name = md5(uniqid(rand(), true));
                    $targetFile = $src . $name . '.jpg';
                    move_uploaded_file($tempFile, $targetFile);
                    chmod($targetFile, 0777);
//                    echo $targetFile;
                }
            }

            return true;
        } else {
            return false;
        }
        return false;
    }

    public function editheaderAction()
    {


        die('ici');

    }

    public function editproposAction(Request $request)
    {

//        dump($_POST);
//        die();


        $em = $this->getDoctrine()->getEntityManager();

        $qouiqui_info = $request->get('qouiqui');
//        dump($request->get('editor'));
        $details = $request->get('editor');
        $address1 = $qouiqui_info['address1'];
        $id = $qouiqui_info['id'];
        $rs = json_encode($qouiqui_info['rs'], true);
        $opneing = json_encode($qouiqui_info['opening'], true);


        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($id);

        if (!(empty($request->get('tags')))) {
            $data = array();
            $data['tags'] = $request->get('tags');
            $data = json_encode($data);
        } else {
            $data = "";
        }

        $qq->setFirstName($qouiqui_info['firstName']);
        $qq->setNumRegistre($qouiqui_info['numRegistre']);
        $qq->setNumPatente($qouiqui_info['numPatente']);

        $qq->setDetails($request->get('editor'));
        $qq->setAddress1($address1);
        $qq->setAdress2($qouiqui_info['address2']);
        $qq->setPhone($qouiqui_info['phone']);
        $qq->setPhone2($qouiqui_info['phone2']);
        $qq->setVideo($qouiqui_info['video']);
        $qq->setMail($qouiqui_info['mail']);
        $qq->setWebsite($qouiqui_info['website']);
        $qq->setOpening($opneing);
        $qq->setSociaux($rs);
        $qq->setData($data);
        $em->persist($qq);
//        $em->flush();


        $qville = $this->getDoctrine()->getRepository('AdminBundle:Qville')->findOneByQouiqui($qq->getId());
        $qville->setVille($this->getDoctrine()->getRepository('AdminBundle:Ville')->findOneById($_POST['qville']['ville']));
        $qville->setDelegation($this->getDoctrine()->getRepository('AdminBundle:Delegation')->findOneById($_POST['qville']['delegation']));
        $em->persist($qville);
        $em->flush();


        return $this->redirect($this->generateUrl('sub', array('subdomain' => $qq->getSlug())));

    }

    public function editbienvenusAction(Request $request)
    {
//***********parti twig incoming***********

        $id = $request->get('id_qq');
        $theme = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array("qouiqui" => $id));
        $QQ = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($id);

        if ($theme == null) {
            $theme = new Theme();
            $data['section'] = $request->get('section1');
            $data = json_encode($data);
            $theme->setData($data);
            $theme->setQouiqui($QQ);
        } else {
            $data = json_decode($theme->getData(), true);
            $data['section'] = $request->get('section1');
            $data = json_encode($data);
            $theme->setData($data);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($theme);
        $em->flush($theme);


        return $this->redirect($_SERVER['PHP_SELF']);

    }

    public function uploadsliderAction($qq_id)
    {


//        print_r($_FILES);
//        print_r('============================');
//        print_r($_FILES['files']['tmp_name']);
//
//
//        die();

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
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/slider")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/slider", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/slider", 0777);
            endif;


            $this->uploadFile($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/slider/");


            $name = md5(uniqid(rand(), true));
            $targetFile = $this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/slider/$name.jpg";
            move_uploaded_file($_FILES['croppedImage']['tmp_name'], $targetFile);
            chmod($targetFile, 0777);
            die;
        }
        die;
    }

    function filtreAnnonceAction(Request $request ){


        $limit = 1 * 6;
        $annonce = $this->getDoctrine()->getRepository('AdminBundle:Immobiliair')->filtreAnnonce($_POST,$limit);


        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array("qouiqui"));
        $encoder = new JsonEncoder();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $object = $serializer->serialize($annonce, 'json');

        return new Response($object);

    }

    function ficheAnnoncesPagesAction($nb, $id_qq)
    {
        $offset = $nb * 3;
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $id_qq));
        $nbp = count($em->getRepository('AdminBundle:Immobiliair')->findBy(array('qouiqui' => $quoiqui)));
        $produit = $em->getRepository('AdminBundle:Immobiliair')->findBy(array('qouiqui' => $quoiqui), array('id' => 'DESC'), 3 , $offset);

        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array("qouiqui"));
        $encoder = new JsonEncoder();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $object = $serializer->serialize($produit, 'json');
        return new Response($object);

    }


    function annonceJSONAction($id){


        $quoiqui = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $id));
        $annonce = $this->getDoctrine()->getRepository('AdminBundle:Immobiliair')->findBy(array('qouiqui' => $quoiqui), array('id' => 'DESC'), 3, null);
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array("qouiqui"));
        $encoder = new JsonEncoder();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $object = $serializer->serialize($annonce, 'json');
        return new Response($object);

    }


    function ficheAnnoncesAction(Request $request)
    {
        return $this->render('@User/template/fiche/immobiliair/annonces.html.twig', [
            'attributes' => $request->attributes->all()
        ]);
    }


    function ficheServicesAction(Request $request)
    {
        return $this->render('@User/template/fiche/immobiliair/services.html.twig', [
            'attributes' => $request->attributes->all()
        ]);
    }
}
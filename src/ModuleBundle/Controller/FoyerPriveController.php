<?php

namespace ModuleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AdminBundle\Entity\FoyerPrive;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;


class FoyerPriveController extends Controller
{
    function ficheAnnoncesAction(Request $request)
    {

        $quoiqui = $request->get('quoiqui');
        return $this->render('@User/template/fiche/FoyerPrive/annonces.html.twig', [
            'attributes' => $request->attributes->all(),
            'quoiqui' => $quoiqui
        ]);

    }


    function ficheServicesAction(Request $request)
    {

        $quoiqui = $request->get('quoiqui');
        return $this->render('@User/template/fiche/FoyerPrive/services.html.twig', [
            'attributes' => $request->attributes->all(),
            'quoiqui' => $quoiqui
        ]);

    }

    function addAnnonceAction($idqq)
    {
        dump($_POST);


        $idUser = $this->getUser()->getId();

        $id_annonce = $_POST['idAnnonce'];

        $em = $this->getDoctrine()->getManager();
        $serv = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $idqq));

        if ($serv) {
            $data = json_decode($serv->getData(), true);
            $data['event'][$_POST['idAnnonce']] = $_POST;
            $serv->setData(json_encode($data));
            dump(json_encode($data));

        } else {
            $data['event'][$_POST['id']] = $_POST;
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($idqq);
            $serv = new Theme();
            $serv->setData(json_encode($data));
            $serv->setQouiqui($qq);
        }

        $em->persist($serv);

        $id_annonce = $serv->getId() ;


        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser");
        endif;
        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq");
        endif;
        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq"."/annonce/")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq"."/annonce/",0777);
        endif;
        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" ."/annonce" ."/annonce-" . $id_annonce)):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" ."/annonce"."/annonce-" . $id_annonce, 0777);
            chmod($this->get('app.image_uploader')->targetDir . "/$idUser" . "/$idqq" ."/annonce"."/annonce-" . $id_annonce, 0777);
        endif;
        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$idqq/annonce/annonce-".$id_annonce;
        for ($i = 0; $i < sizeof($_FILES['file']['tmp_name']) - 1; $i++) {



            if (!empty($_FILES['file']['tmp_name'][$i])) {
                $tempFile = $_FILES['file']['tmp_name'][$i];

                $name = md5(uniqid(rand(), true));

                $ext = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
                move_uploaded_file(

                    $tempFile,
                    $uploaddir . '/' . $name . "." . $ext
                );
            }

        }



        $em->flush($serv);

        return $this->redirect($_SERVER['PHP_SELF']);
    }




}

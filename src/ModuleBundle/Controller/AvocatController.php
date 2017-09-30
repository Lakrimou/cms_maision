<?php

namespace ModuleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AdminBundle\Entity\Theme;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class AvocatController extends Controller
{
    function addInformationGlobalAction()
    {
        $em = $this->getDoctrine()->getManager();

        $themeId = $_POST["theme"];
        $quoiquiId = $_POST["quoiqui"];
        $informationName = $_POST["informationName"];
        if ($themeId != null) {
            $theme = $em->getRepository('AdminBundle:Theme')->find($themeId);
            $dataArray = json_decode($theme->getData(), true);

        } else {
            $theme = new Theme();
            $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->find($quoiquiId);
            $theme->setQouiqui($quoiqui);
            $dataArray = array();

        }
        $newArray = array();
        $idInformation = $_POST["informationId"];
        if ($idInformation == null) {
            $idInformation = uniqid();
        }


        foreach ($_POST["jsonInput"] as $key => $value) {
            $newArray[$key] = $value;
        }

        $dataArray[$informationName][$idInformation] = $newArray;


        $data = json_encode($dataArray);

        $theme->setData($data);
        $em->persist($theme);
        $em->flush();
        $em->refresh($theme);
        $normalizer = new ObjectNormalizer();

        $normalizer->setIgnoredAttributes(array("qouiqui"));

        $encoder = new JsonEncoder();

        $serializer = new Serializer(array($normalizer), array($encoder));
        $theme = $serializer->serialize($theme, 'json');


        return new Response($theme);

    }

    function deleteInformationGlobalAction()
    {
        $em = $this->getDoctrine()->getManager();

        $themeId = $_POST["theme"];

        $informationName = $_POST["informationName"];
        if ($themeId != null) {
            $theme = $em->getRepository('AdminBundle:Theme')->find($themeId);
            $dataArray = json_decode($theme->getData(), true);

        }

        $idInformation = $_POST["informationId"];
        unset($dataArray[$informationName][$idInformation]);


        $data = json_encode($dataArray);

        $theme->setData($data);
        $em->persist($theme);
        $em->flush();
        $em->refresh($theme);
        $normalizer = new ObjectNormalizer();

        $normalizer->setIgnoredAttributes(array("qouiqui"));

        $encoder = new JsonEncoder();

        $serializer = new Serializer(array($normalizer), array($encoder));
        $theme = $serializer->serialize($theme, 'json');


        return new Response($theme);
    }

    function ficheAnnoncesAction(Request $request)
    {


        return $this->render('@User/template/fiche/Avocat/annonces.html.twig', [
            'attributes' => $request->attributes->all()
        ]);
    }


    function ficheServicesAction(Request $request)
    {


        return $this->render('@User/template/fiche/Avocat/services.html.twig', [
            'attributes' => $request->attributes->all()
        ]);
    }

    function getAllInformationsGlobalAction()
    {
        $em = $this->getDoctrine()->getManager();

        $themeId = $_POST["theme"];
        $theme = $em->getRepository('AdminBundle:Theme')->find($themeId);



        $normalizer = new ObjectNormalizer();

        $normalizer->setIgnoredAttributes(array("qouiqui"));

        $encoder = new JsonEncoder();

        $serializer = new Serializer(array($normalizer), array($encoder));
        $theme = $serializer->serialize($theme, 'json');


        return new Response($theme);
    }
}

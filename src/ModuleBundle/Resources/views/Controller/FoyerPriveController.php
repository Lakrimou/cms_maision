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




}

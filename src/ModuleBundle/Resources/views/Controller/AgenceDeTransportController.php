<?php

namespace ModuleBundle\Controller;

use AdminBundle\Entity\AgenceDePresse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AgenceDeTransportController extends Controller
{


    function ficheAnnoncesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');

        return $this->render('@User/template/fiche/AgenceDeTransport/annonces.html.twig', [
            'attributes' => $request->attributes->all(), 'quoiqui' => $quoiqui,
        ]);
    }


    function ficheServicesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');

        return $this->render('@User/template/fiche/AgenceDeTransport/services.html.twig', [
            'attributes' => $request->attributes->all(), 'quoiqui' => $quoiqui
        ]);
    }
}

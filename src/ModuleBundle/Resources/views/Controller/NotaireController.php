<?php

namespace ModuleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NotaireController extends Controller
{
    function ficheAnnoncesAction(Request $request)
    {


        return $this->render('@User/template/fiche/Notaire/annonces.html.twig', [
            'attributes' => $request->attributes->all()
        ]);
    }


    function ficheServicesAction(Request $request)
    {


        return $this->render('@User/template/fiche/Notaire/services.html.twig', [
            'attributes' => $request->attributes->all()
        ]);
    }
}

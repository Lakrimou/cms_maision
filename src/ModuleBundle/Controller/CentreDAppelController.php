<?php

namespace ModuleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CentreDAppelController extends Controller
{


    function ficheServicesAction(Request $request)
    {

        $quoiqui = $request->get('quoiqui');

        $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        if ($service) {
            $service = json_decode($service->getData(), true);

        } else {
            $service = null;
        }


        return $this->render('@User/template/fiche/CentreDAppel/services.html.twig', [
            'attributes' => $request->attributes->all(), 'Spaservice' => $service
        ]);
    }


    function ficheAnnoncesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');

        $service = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        if ($service) {
            $service = json_decode($service->getData(), true);

        } else {
            $service = null;
        }



        return $this->render('@User/template/fiche/CentreDAppel/annonces.html.twig', [
            'attributes' => $request->attributes->all(), 'Spaevent' => $service
        ]);
    }
    function  reservationAction(Request $request, $idqq){
        dump($_FILES);
        die;

    }


}

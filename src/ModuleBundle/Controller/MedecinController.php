<?php

namespace ModuleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MedecinController extends Controller
{
    function ficheAnnoncesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');
        $professional = array();
        $horaire = array();
        $pratique = array();
        $data = array();
        $id = null;
        $em = $this->getDoctrine()->getManager();
        $theme = $em->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        $etat =false;
        if ($theme != null) {
            $data = json_decode($theme->getData(), true);
            $professional = array();
            if(array_key_exists ( 'Professionnelle' , $data )){
                $professional = $data['Professionnelle'];
            }
            if(array_key_exists ( 'horaire' , $data )){
                $horaire = $data['horaire'];
            }
            if(array_key_exists ( 'sceance' , $data )){
                $etat = $data['sceance'];
            }
            if(array_key_exists ( 'pratique' , $data )){
                $pratique = $data['pratique'];
            }
            $id = $theme->getId();
        }
        return $this->render('@User/template/fiche/Medecin/annonces.html.twig', [
            'attributes' => $request->attributes->all(),
            'pro'=> $professional,
            'horaire' => $horaire,
            'pratique'=>$pratique,
            'etat'=>$etat,
            'id' => $id, 'nbr' => count($data)
        ]);
    }


    public function ficheServicesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');
        $professional = array();
        $data = array();
        $id = null;
        $em = $this->getDoctrine()->getManager();
        $theme = $em->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        if ($theme != null) {
            $data = json_decode($theme->getData(), true);
            $professional = array();
            if(array_key_exists ( 'Professionnelle' , $data )){
                $professional = $data['Professionnelle'];
            }
            $id = $theme->getId();
        }
        return $this->render('@User/template/fiche/Medecin/services.html.twig', [
            'attributes' => $request->attributes->all(),
            'pro'=> $professional,
            'id' => $id, 'nbr' => count($data)
        ]);
    }

    function addProfesionnalAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $request->get('id'), 'user' => $this->getUser()));
        $theme = $em->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        $data['Professionnelle'] = array();
        $service = array();
        $service['specialite'] = $request->get('specialite');
        $service['langue'] = $request->get('langue');
        $service['description'] = $request->get('editeur');
        if ($theme == null) {
            $data['Professionnelle'] = $service;
            $theme = new Theme();
            $theme->setQouiqui($quoiqui);
            $theme->setData(json_encode($data, true));
            $em->persist($theme);
            $em->flush();
        } else {
            $professional = array();
            $professional = json_decode($theme->getData(), true);
            $professional['Professionnelle']= $service;
            $theme->setData(json_encode($professional, true));
            $em->flush();
        }
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-services');
    }

    function showProfesionnalAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneById($id);
        $theme = $em->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        $data = json_decode($theme->getData(), true);
        $response = new Response(json_encode($data["Professionnelle"], true));
        return $response;
    }

    function addScheduleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $request->get('id'), 'user' => $this->getUser()));
        $theme = $em->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        $data=array();
        $day = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
        for($i=0;$i<6;$i++){
            $jour=array();
            $jour[$day[$i]]['debutS1']=$request->get('deb1'.$day[$i]);
            $jour[$day[$i]]['finS1']=$request->get('fin1'.$day[$i]);
            if($request->get('etat') == 0){
                $jour[$day[$i]]['debutS2']=$request->get('deb2'.$day[$i]);
                $jour[$day[$i]]['finS2']=$request->get('fin2'.$day[$i]);
            }else{
                $jour[$day[$i]]['debutS2']=null;
                $jour[$day[$i]]['finS2']=null;
            }
            array_push($data,$jour);
        }
        if ($theme == null) {
            $horaire['horaire']=$data;
            $horaire['sceance']=$request->get('etat');
            $theme = new Theme();
            $theme->setQouiqui($quoiqui);
            $theme->setData(json_encode($horaire, true));
            $em->persist($theme);
            $em->flush();
        } else {
            $professional = array();
            $professional = json_decode($theme->getData(), true);
            $professional['horaire']= $data;
            $professional['sceance']=$request->get('etat');
            $theme->setData(json_encode($professional, true));
            $em->flush();
        }
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-services');
    }

    function showPratiqueAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneById($id);
        $theme = $em->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        $data = json_decode($theme->getData(), true);
        $response = new Response(json_encode($data["pratique"], true));
        return $response;
    }

    function addPratiqueAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('id' => $request->get('id'), 'user' => $this->getUser()));
        $theme = $em->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        $data=array();
        $pratique=array();
        $pratique['assurance']=$request->get('assurance');
        $pratique['mode']=$request->get('mode');
        if ($theme == null) {
            $horaire['pratique']=$pratique;
            $theme = new Theme();
            $theme->setQouiqui($quoiqui);
            $theme->setData(json_encode($horaire, true));
            $em->persist($theme);
            $em->flush();
        } else {
            $professional = array();
            $professional = json_decode($theme->getData(), true);
            $professional['pratique']= $pratique;
            $theme->setData(json_encode($professional, true));
            $em->flush();
        }
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-services');
    }
}

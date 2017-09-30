<?php

namespace ModuleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SerrurierController extends Controller
{
    function ficheAnnoncesAction(Request $request)
    {


        return $this->render('@User/template/fiche/Serrurier/annonces.html.twig', [
            'attributes' => $request->attributes->all()
        ]);
    }


    public function ficheServicesAction(Request $request)
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
        return $this->render('@User/template/fiche/Serrurier/services.html.twig', [
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
        if($request->get('title')!=null){
            $service['title'] = $request->get('title');
            $service['auto']=0;
        }else{
            $service['title'] = $request->get('service');
            $service['auto']=1;
        }
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
        return $this->redirect($_SERVER['PHP_SELF'].'#section-services');
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
        return $this->redirect($_SERVER['PHP_SELF']);
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
        if($request->get('title')!=null){
            $service['title'] = $request->get('title');
            $service['auto']=0;
        }else{
            $service['title'] = $request->get('service');
            $service['auto']=1;
        }
        $service['href'] = '"http://' . $quoiqui->getSlug() . 'ween.tn/' . $request->get('title');
        $service['description'] = $request->get('description');
        $service['pos'] = $request->get('p');
        $dataa[$request->get('p') - 1] = $service;
        $data["Service"] = $dataa;
        $theme->setData(json_encode($data, true));
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF'].'#section-services');
    }

    function appelServiceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $message = (new \Swift_Message('Reservation'))
            ->setFrom('noreply@ween.tn')
            ->setTo(/*$request->get('user')*/"oussemaakrouti@gmail.com")
            ->setBody($this->renderView('@User/template/fiche/Serrurier/email.html.twig',
                array(
                    'name' => $request->get('nom'),
                    'adresse' => $request->get('adresee'),
                    'email' => $request->get('email'),
                    'remarque' => $request->get('remarque'),
                    'tel' => $request->get('tel'),
                    'origin' => $request->get('origin'),
                )), 'text/html');
        $this->get('mailer')->send($message);
        $this->get('session')->getFlashBag()->add('email', 'envoi email');
        return $this->redirect($_SERVER['PHP_SELF'] . '#section-services');
    }

}

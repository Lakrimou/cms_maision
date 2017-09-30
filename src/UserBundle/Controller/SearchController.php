<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Cocur\Slugify\Slugify;

class SearchController extends Controller
{
    public function filtreAction()
    {




        $q = (isset($_GET['q'])) ? $_GET['q'] : null;
        $vId = (isset($_GET['ville'])) ? $_GET['ville'] : null;

        #dump($q, $vId);
        $em = $this->getDoctrine()->getManager();
        if (empty($q)) {
            $qqresult = $em->getRepository('AdminBundle:Qouiqui')->filtreQQuibyville($vId);
        } else {
            $qqresult = $em->getRepository('AdminBundle:Qouiqui')->filterByTag($q, $vId);
        }
        $pays = "222"; //tunisia
        $villes = $em->getRepository('AdminBundle:Ville')->findby(array("pays" => $pays));


        return $this->render('UserBundle:default:search.html.twig', array(
            'qouiquis' => $qqresult,
            'villes' => $villes,
        ));
    }


    public function getAllLocationAction()
    {
        $pays = "222";
        $ville = $this->getDoctrine()->getRepository('AdminBundle:Ville')->findby(array("pays" => $pays));
        $delegation = $this->getDoctrine()->getRepository('AdminBundle:Delegation')->findAll();


        $location = [];
        foreach ($ville as $v) {
            $location[] = ['id' => $v->getSlug(), 'name' => $v->getLibelle()];
        }

        foreach ($delegation as $d) {
            $location[] = ['id' => $d->getSlug(), 'name' => $d->getLibelle()];
        }

        $serializer = $this->container->get('serializer');
        $object = $serializer->serialize($location, 'json');
        return new Response($object);

    }
}

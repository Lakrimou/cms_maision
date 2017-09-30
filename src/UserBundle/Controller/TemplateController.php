<?php

namespace UserBundle\Controller;

use AdminBundle\Entity\Ngn;
use AdminBundle\Entity\Qville;
use AdminBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Cocur\Slugify\Slugify;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class TemplateController extends Controller
{
    public function indexAction()
    {
        return $this->render('@User/template/index.html.twig');
    }


    public function contactAction()
    {
        return $this->render('@User/template/contact.html.twig');
    }


    public function ficheAction()
    {
        return $this->render('@User/template/fiche.html.twig');
    }


    public function rechercheAction()
    {
        return $this->render('@User/template/recherche.html.twig');
    }


    public function getslugAction(Request $request)
    {

        $searchterm = $request->request->get('slug');
        $slugify = new Slugify();
        $slug = $slugify->slugify($searchterm);
        if ($slug):


            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository('AdminBundle:Qouiqui');
            $query = $repo->createQueryBuilder('q')
                ->select("q.id")
                ->where("q.slug =:slug")
                ->setParameter('slug', $slug)
                ->getQuery();

            $slug = $query->getResult();
        endif;
        if ($slug):
            $result = 'le nom de site est  déja utilisé';
        else:
            $result = '0';
            $file = $this->get('app.uploads_directory')->targetDir . 'nicewords/niceword.txt';
            $file2 = $this->get('app.uploads_directory')->targetDir . 'nicewords/notAllowed.txt';
            $text = file_get_contents($file);
            $word = strtolower ($searchterm);
            $niceword = explode(';', $text);
            foreach ($niceword as $nicewords) {
                if (strpos($word, $nicewords) !== false) {
                    $result = 'le nom de site est interdit';
                }
            }
            if (strpos(file_get_contents($file2), $word) !== false) {
                $result = 'le nom de site est  interid';
            };



        endif;

        $response = new Response(
            $result, Response::HTTP_OK, array('Content-type' => 'text/html')
        );

        return $response;

    }

    public function getAllVilleAction()
    {
        $ville = $this->getDoctrine()->getRepository('AdminBundle:Ville')->findBy(array('pays' => '222'), ['libelle' => 'ASC']);
        $serializer = $this->container->get('serializer');
        $json = $serializer->serialize($ville, 'json');
        return new Response($json);
    }

    public function getAllDelegationAction()
    {
        $delegation = $this->getDoctrine()->getRepository('AdminBundle:Delegation')->findBy([], ['libelle' => 'ASC']);
        $serializer = $this->container->get('serializer');
        $json = $serializer->serialize($delegation, 'json');
        return new Response($json);
    }


    public function addNewListingAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        //register and connection
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setUsername($_POST['adminbundle_ngn']['qouiqui']['firstName']);
        $user->setEmail($_POST['user']['email']);
        $user->setPlainPassword($_POST['user']['pwd']);
        $user->addRole('ROLE_USER');
        $user->setEnabled(true);
        $userManager->updateUser($user);
        $em->refresh($user);
        $user_id = $user->getId();
        $this->authenticateUser($user); #call function authenticateUser($user){}
        //register and connection END

        $form = $this->createForm('AdminBundle\Form\NgnNewType', null);
        $form->handleRequest($request);
        if (isset($_POST['adminbundle_ngn']['qouiqui']['slug'])):
            $ssd = $_POST['adminbundle_ngn']['qouiqui']['slug'];
            $slugify = new Slugify();
            $slug = $slugify->slugify($ssd);
        else:
            $slug = false;
        endif;


        $user = $this->getUser();
        $qq = $form->get('qouiqui')->getData();
        $qq->setUser($user);
        $qq->setSlug($slug);
        $qq->setDetails($_POST['adminbundle_ngn']['qouiqui']['shortDescription']);
        $qq->setImage(null);
        $qq->setMail($_POST['user']['email']);


        if (isset($_POST['qouiqui']['rs']))
            $qq->setSociaux(json_encode($_POST['qouiqui']['rs']));


        $ville = $form->get('ville')->getData();
        $delegation = $form->get('delegation')->getData();
        $category = $form->get('category')->getData();
        $scategory = $form->get('scategory')->getData();

        $ngn = new Ngn();
        $ngn->setCategory($category);
        $ngn->setScategory($scategory);
        $ngn->setQouiqui($qq);
        $em->persist($ngn);

        if ($ville) {
            $qville = new Qville();
            $qville->setQouiqui($ngn->getQouiqui());
            $qville->setVille($ville);


            if ($delegation)
                $qville->setDelegation($delegation);
            $em->persist($qville);
        }

        $em->flush();
        $em->refresh($ngn);

        return $this->redirect('https://' . $slug . '.ween.tn');
        dump($form);

        die();
    }

    private function authenticateUser(User $user)
    {
        $providerKey = 'secured_area'; // your firewall name
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->container->get('security.token_storage')->setToken($token);
        $this->container->get('session')->set('_security_main', serialize($token));
    }
}

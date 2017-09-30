<?php

namespace DashboardBundle\Controller;

use AdminBundle\Form\NgnNewType;
use AdminBundle\Form\EventsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AdminBundle\Entity\Category;
use AdminBundle\Entity\Ngn;
use AdminBundle\Entity\Qville;
use AdminBundle\Entity\Qouiqui;
use AdminBundle\Entity\Events;
use AdminBundle\Entity\Booking;
use AdminBundle\Entity\User;
use Cocur\Slugify\Slugify;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()

    {
//        $userQ = $this->getUser();
//
//        return $this->render('DashboardBundle:Default:index.html.twig', array(
//            'user'=>$userQ
//        ));
    }

    public function editAction(Request $request, Ngn $quouiqui)
    {


        $quouiqui->getQouiqui()->setImage('null');


        $ngn_id = $request->get('id');
        $editForm = $this->createForm('AdminBundle\Form\NgnNewType', $quouiqui);
        $editForm->handleRequest($request);
        $editForm->getData()->getqouiqui()->setImage(null);


        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_homepage');

        } else {

            return $this->render('DashboardBundle:Default:edit.html.twig', array(
                '$quouiqui' => $quouiqui,
                'ngn_id' => $ngn_id,
                'form' => $editForm->createView(),

            ));
        }


    }



    public function geoUpdateAction(Request $request){

        $qq_id = $request->get('qqid');
        $lat = $request->get('lat');
        $long = $request->get('long');
        $QQ = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
            ->findOneBy(array('id' => $qq_id));
        $QQ->setGeoLat($lat);
        $QQ->setGeoLong($long);
        $em = $this->getDoctrine()->getManager();
        $em->persist($QQ);
        $em->flush();

        die('done!');

    }

    public function ajoutAction(Request $request)

    {


        $form = $this->createForm('AdminBundle\Form\NgnNewType', null);
        $form->handleRequest($request);

        $imgName = uniqid();
        $opening = json_encode($request->get("opening"));
        if ($form->isSubmitted() and $form->isValid()) {
            if(isset($_POST['adminbundle_ngn']['qouiqui']['slug'])):
            $ssd=$_POST['adminbundle_ngn']['qouiqui']['slug'];
                $slugify = new Slugify();
               $slug= $slugify->slugify($ssd);
               else:
                $slug=false;
                endif;



            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();
            $qq = $form->get('qouiqui')->getData();
            $qq->setUser($user);
            $qq->setSlug($slug);

            $qq->setOpening($opening);
            $qq->setImage(null);

            $ville = $form->get('ville')->getData();
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
                $em->persist($qville);
            }

            $em->flush();
            $em->refresh($ngn);

            //            **********hatthi traj3ilna le ID ta3 el qq *************
            $a = $ngn->getQouiqui();
            $qq_id = $a->getId();

            if (isset($_FILES)) {
                //if (!empty($_FILES['adminbundle_ngn']['tmp_name']['qouiqui']['image'])) {
                $nnom = '/web/annuaire/web/uploads/quoiqui/' . $qq_id . '/';

                $qq->setImage($nnom);

                $fs = new Filesystem();

                $fs->mkdir('../web/uploads/quoiqui/' . $qq_id . '/', 0755);

                $files = $_FILES['adminbundle_ngn']['name']['qouiqui']['image'];

                dump($files, sizeof($files));


                if (sizeof($files) >= "2") {


                    for ($i = 0; $i <= sizeof($files) - 1; $i++) {

                        $ext = pathinfo($_FILES['adminbundle_ngn']['name']['qouiqui']['image'][$i], PATHINFO_EXTENSION);


                        $uploaddir = $_SERVER['PHP_DOCUMENT_ROOT'] . '/web/annuaire/web/uploads/quoiqui/' . $qq_id . '/' . $imgName . '.' . $ext;
//                        dump($uploaddir);
//                        dump($_FILES['adminbundle_ngn']['tmp_name']['qouiqui']['image'][$i]);

                        move_uploaded_file($_FILES['adminbundle_ngn']['tmp_name']['qouiqui']['image'][$i], $uploaddir);

                    }


                } else {
                    $files = $_FILES['adminbundle_ngn']['name']['qouiqui']['image']['0'];
                    $ext = pathinfo($files, PATHINFO_EXTENSION);
                    $imageOne = 'avatar.' . $ext;
                    $uploaddir = $_SERVER['PHP_DOCUMENT_ROOT'] . '/web/annuaire/web/uploads/quoiqui/' . $qq_id . '/' . $imageOne;
                    dump($uploaddir);
                    // die();
                    move_uploaded_file($_FILES['adminbundle_ngn']['tmp_name']['qouiqui']['image'][0], $uploaddir);

                }

                //}
            }

            $uploaddir = $_SERVER['PHP_DOCUMENT_ROOT'] . '/web/annuaire/web/uploads/quoiqui/' . $qq_id . '/' . 'test.jpg';

            $uploads_dir = $_FILES['adminbundle_ngn']['name']['qouiqui']['image'];
            $file_keys = array_keys($_FILES['adminbundle_ngn']['name']['qouiqui']['image']);
//dump($files);
//dump($uploads_dir);
//die;
            $qq->setImage($imageOne);
            $em->flush($qq);


            //die();
            return $this->redirectToRoute('dashboard_liste');

        }


        /*
        if (isset($_POST['q']) ) {


            $test = $this->slugify($_POST['q']['firstname']);
            dump($_POST);
            dump($test);

            die();

            $em = $this->getDoctrine()->getManager();
            $qouiqui->setUser($user);


            $em->persist($qouiqui);
            $em->flush($qouiqui);

            return $this->redirectToRoute('qouiqui_show', array('id' => $qouiqui->getId()));
        }
        */

        return $this->render('DashboardBundle:Default:ajout.html.twig', array(
            //'qouiqui' => $qouiqui,
            'form' => $form->createView(),

        ));

    }

    public function listeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $userQ = $this->getUser();
        $qq = new Qouiqui();
        $qq = $em->getRepository('AdminBundle:Qouiqui')->findBy(array('user' => $userQ));
//        dump($qq);
//        die;


        return $this->render('DashboardBundle:quoiquiListe:listeQuoiqui.html.twig', array(
            'user' => $userQ,
            'quoiqui' => $qq
        ));
    }


    public function save_base64_image($base64_image_string, $output_file_without_extension, $path_with_end_slash = "")
    {


        //usage:  if( substr( $img_src, 0, 5 ) === "data:" ) {  $filename=save_base64_image($base64_image_string, $output_file_without_extentnion, getcwd() . "/application/assets/pins/$user_id/"); }
        //
        //data is like:    data:image/png;base64,asdfasdfasdf
        $splited = explode(',', substr($base64_image_string, 5), 2);
        $mime = $splited[0];
        $data = $splited[1];

        $mime_split_without_base64 = explode(';', $mime, 2);
        $mime_split = explode('/', $mime_split_without_base64[0], 2);
        if (count($mime_split) == 2) {
            $extension = $mime_split[1];
            if ($extension == 'jpeg') $extension = 'jpg';
            $output_file_with_extension = $output_file_without_extension . '.' . $extension;
        }
        file_put_contents($path_with_end_slash . $output_file_with_extension, base64_decode($data));
        return $output_file_with_extension;
    }

    public function ajoutevAction(Request $request, $qq_id)

    {
        $post = $request->get('adminbundle_events');
        $user = $this->getUser();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
            ->findOneBy(array('id' => $qq_id, 'user' => $user->getId()));
        if ($qq) {
            $image = uniqid();
            $event = new Events();
            $form = $this->createForm('AdminBundle\Form\EventsType', $event);
            $form->handleRequest($request);
//            dump($form,$form->isValid());die;
            if ($form->isSubmitted()) {
                if (!empty($post['image'])) {
                    $date_s = $_POST['date_start']['date'];
                    $time_s = $_POST['date_start']['time'];
                    $date_e = $_POST['date_end']['date'];
                    $time_e = $_POST['date_end']['time'];
                    $date_st = $date_s . ' ' . $time_s;
                    $date_ed = $date_e . ' ' . $time_e;

//                    dump(new \Datetime($date_st));die;

                    $idUser = $this->getUser()->getId();

                    #creation dossier avec l'id de l'utilisateur si n'existe pas
                    if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
                        mkdir($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
                        chmod($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
                    endif;

                    #creation dossier avec l'id de QUOIQUI si n'existe pas
                    if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/")):
                        mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/", 0777);
                        chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/", 0777);
                    endif;
                    #creation dossier produits si n'existe pas
                    if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/event")):
                        mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/event", 0777);
                        chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/event", 0777);
                    endif;


                    $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$qq_id/event/";
                    $this->save_base64_image($post['image'],$image,$uploaddir);

//                    move_uploaded_file(
//                        $_FILES['adminbundle_events']['tmp_name']['image'],
//                        $uploaddir . '/' . $image . '.jpg'
//                    );

                    $em = $this->getDoctrine()->getManager();

                    $qville = $em->getRepository('AdminBundle:Qville')->findoneby(array('qouiqui' => $qq_id));

                    $events = $form->getData();
                    $events->setImage($image);

                    if ((isset($post['location']['ville'])) && (isset($post['location']['pays'])) ) {
                      $location = $post['location']['ville']." ". $post['location']['pays'];
                      $events->setLocation($location);
                    }

                    $events->setDateStart(new \Datetime($date_st));
                    $events->setDateEnd(new \Datetime($date_ed));
                    $events->setQville($qville);
                    $em->persist($events);
                    $em->flush($event);
                    }

                return $this->redirect($_SERVER['PHP_SELF']);

            }
        } else {
            die("Lien non valide");
        }
        return $this->render('DashboardBundle:events:ajout.html.twig', array(
            'event' => $event,
            'form' => $form->createView()


        ));
    }

    public function reservationAction(Request $request)
    {
        $booking = new Booking();
        $form = $this->createForm('AdminBundle\Form\BookingType', $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->flush($booking);

            return $this->redirectToRoute('booking_show', array('id' => $booking->getId()));
        }
        return $this->render('DashboardBundle:events:reservation.html.twig', array(
            'booking' => $booking,
            'form' => $form->createView(),
        ));
    }

    public function getslugAction(Request $request)
    {

        $searchterm = $request->request->get('slug');
        $slugify = new Slugify();
        $slug= $slugify->slugify($searchterm);
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

        endif;

        $response = new Response(
            $result, Response::HTTP_OK, array('Content-type' => 'text/html')
        );

        return $response;

    }


}

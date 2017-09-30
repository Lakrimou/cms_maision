<?php

namespace AdminBundle\Controller;

use AdminBundle\AdminBundle;
use AdminBundle\Entity\Qouiqui;
use AdminBundle\Entity\Scategory;
use AdminBundle\Entity\Category;
use AdminBundle\Entity\Ngn;
use AdminBundle\Entity\Qville;
use AdminBundle\Entity\Pays;
use AdminBundle\Entity\Ville;
use AdminBundle\Form\QouiquiType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Entity\User;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Qouiqui controller.
 *
 */
class QouiquiController extends Controller
{
    /**
     * Lists all qouiqui entities.
     *
     */
    public function indexAction()
    {



        $user = $this->getUser();
        $user_id = $user->getID();
        $em = $this->getDoctrine()->getManager();
        $qqresult = $em->getRepository('AdminBundle:Qouiqui')->findBy(array('user' => $user_id));

        return $this->render('AdminBundle:default:index.html.twig', array(
            'qouiquis' => $qqresult,

        ));


    }

    /**
     * serach function qouiqui reposotry.
     *
     */
    public function filtreAction()
    {
        $user = $this->getUser();

        $user_id = $user->getID();


        $em = $this->getDoctrine()->getManager();

        $vid = $_GET['vid'];

        if (isset($_GET['info'])) {

            $info = $catslug = $_GET['info'];
            $vid = $_GET['vid'];


            $qqresult1 = $em->getRepository('AdminBundle:Qouiqui')->filtreQQuibyinfo($info, $vid);
            $qqresult2 = $em->getRepository('AdminBundle:Qouiqui')->filtreQQuibycat($catslug, $vid);


            //both arrays will be merged including duplicates
            $qqresult = array_merge($qqresult1, $qqresult2);
            //duplicate objects will be removed
            $qqresult = array_map("unserialize", array_unique(array_map("serialize", $qqresult)));
            //array is sorted on the bases of id
            sort($qqresult);


        } else {
            $qqresult = $em->getRepository('AdminBundle:Qouiqui')->filtreQQuibyville($vid);
        }

        //  $qouiquis = $em->getRepository('AdminBundle:Qouiqui')->findBy(array('user' => $user_id));


        return $this->render('AdminBundle:default:index.html.twig', array(
            'qouiquis' => $qqresult,
        ));


    }

    /**
     * Creates a new qouiqui entity.
     *
     */
    public function newAction(Request $request)
    {

        $form = $this->createForm('AdminBundle\Form\NgnNewType', null);
        $form->handleRequest($request);

//            dump($form);
//            dump($form->get('ville')->getData());
//
//            dump($form->isValid());
//            dump($form->getData());
//            dump($form->isSubmitted());
       $opening = json_encode($request->get("opening"));

        if ($form->isSubmitted() and $form->isValid()) {

     

            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();
            $qq = $form->get('qouiqui')->getData();
            $qq->setUser($user);

            $user = $this->getUser();
            $qq = $form->get('qouiqui')->getData();
            $qq->setUser($user);

            $qq->setOpening($opening);

            $qq->setImage(null);
            // nos tables


//            dump($qq);//zit hadhi


            // $image=$form->get('image')->getData();
            //$this->image = $this->file->getClientOriginalName();
// tt


            $ville = $form->get('ville')->getData();
            $category = $form->get('category')->getData();
            $scategory = $form->get('scategory')->getData();
//            dump($qq,$ville,$category,$scategory);
//            dump($form,$form->getData(),$ville);


            $ngn = new Ngn();

            $ngn->setCategory($category);
            $ngn->setScategory($scategory);
            $ngn->setQouiqui($qq);


            $em->persist($ngn);
            $sr = $qq->getId();


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
//            **********hatthi traj3ilna le ID ta3 el qq *************


            if (isset($_FILES)) {

                $nnom = '/web/annuaire/web/uploads/quoiqui/' . $qq_id . '/';

                $qq->setImage($nnom);

                $fs = new Filesystem();
                $fs->mkdir('../web/uploads/quoiqui/' . $qq_id . '/', 0755);

                $files = $_FILES['adminbundle_ngn']['name']['qouiqui']['image'];

                dump($files,sizeof($files));


                if ( sizeof($files) >= "2"){




                    for ($i = 0; $i <= sizeof($files)-1; $i++) {

                        $ext = pathinfo($_FILES['adminbundle_ngn']['name']['qouiqui']['image'][$i], PATHINFO_EXTENSION);


                        $uploaddir = $_SERVER['PHP_DOCUMENT_ROOT'] . '/web/annuaire/web/uploads/quoiqui/' . $qq_id . '/' . uniqid() . '.' . $ext;
//                        dump($uploaddir);
//                        dump($_FILES['adminbundle_ngn']['tmp_name']['qouiqui']['image'][$i]);

                        move_uploaded_file($_FILES['adminbundle_ngn']['tmp_name']['qouiqui']['image'][$i], $uploaddir);

                    }


                }
                else{
                    $files = $_FILES['adminbundle_ngn']['name']['qouiqui']['image']['0'];
                    $ext = pathinfo($files, PATHINFO_EXTENSION);
                    $uploaddir = $_SERVER['PHP_DOCUMENT_ROOT'] . '/web/annuaire/web/uploads/quoiqui/' . $qq_id . '/avatar.' . $ext;
                    move_uploaded_file($_FILES['adminbundle_ngn']['tmp_name']['qouiqui']['image'][0], $uploaddir);

                }

            }


            $uploaddir = $_SERVER['PHP_DOCUMENT_ROOT'] . '/web/annuaire/web/uploads/quoiqui/' . $qq_id . '/' . 'test.jpg';


            $uploads_dir = $_FILES['adminbundle_ngn']['name']['qouiqui']['image'];
            $file_keys = array_keys($_FILES['adminbundle_ngn']['name']['qouiqui']['image']);


            return $this->redirectToRoute('qouiqui_index');

        }


        return $this->render('AdminBundle:QQUI:ajout.html.twig', array(
            //'qouiqui' => $qouiqui,
            'form' => $form->createView(),

        ));
    }


    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    /**
     * Finds and displays a qouiqui entity.
     *
     */
    public function showAction(Qouiqui $qouiqui)
    {
        $deleteForm = $this->createDeleteForm($qouiqui);

        return $this->render('qouiqui/show.html.twig', array(
            'qouiqui' => $qouiqui,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing qouiqui entity.
     *
     */
    public function editAction(Request $request, qouiqui $qouiqui)
    {

        $deleteForm = $this->createDeleteForm($qouiqui);
        $editForm = $this->createForm('AdminBundle\Form\QouiquiType', $qouiqui);
        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('qouiqui_edit', array('id' => $qouiqui->getId()));
        }

        return $this->render('qouiqui/edit.html.twig', array(
            'qouiqui' => $qouiqui,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Deletes a qouiqui entity from the datatable.
     *
     */
    public function supAction($id)
    {
        $qouiqui = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneById($id);

        if($qouiqui){

            $em = $this->getDoctrine()->getManager();
            $em->remove($qouiqui);
            $em->flush($qouiqui);
                die;

        }

        die;

    }

    /**
     * Deletes a qouiqui entity.
     *
     */
    public function deleteAction(Request $request, Qouiqui $qouiqui)
    {
        $form = $this->createDeleteForm($qouiqui);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($qouiqui);
            $em->flush($qouiqui);
        }

        return $this->redirectToRoute('qouiqui_index');
    }

    /**
     * Creates a form to delete a qouiqui entity.
     *
     * @param Qouiqui $qouiqui The qouiqui entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Qouiqui $qouiqui)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('qouiqui_delete', array('id' => $qouiqui->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}


//            $test=$qq->getId();
//            dump($test);
//            die;

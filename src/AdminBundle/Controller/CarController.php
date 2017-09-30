<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Automobile;
use AdminBundle\Entity\TextSildeAutomobile;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Car controller.
 *
 */
class CarController extends Controller
{
    /**
     * Lists all car entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cars = $em->getRepository('AdminBundle:Car')->findAll();

        return $this->render('car/index.html.twig', array(
            'cars' => $cars,
        ));
    }

    /**
     * Creates a new car entity.
     *
     */
    public function ajouter_voitureAction(Request $request, $id, $idVoiture)
    {


        $filesDeleted = $request->request->get("deleteFile");
        $reference = $request->request->get("adminbundle_automobile")["reference"];

        $modelName = $request->request->get("model");


        $em = $this->getDoctrine()->getManager();

        $model = $em->getRepository('AdminBundle:Model')->findOneBy(array("name" => $modelName));
        $automobile = new Automobile();
        $automobilesByReference = $em->getRepository('AdminBundle:Automobile')->findOneByReference($reference);
        $lastReference = "";

        if ($idVoiture != "null") {

            $automobile = $em->getRepository('AdminBundle:Automobile')->findOneById($idVoiture);
            $lastReference = $automobile->getReference();

        }


        $form = $this->createForm('AdminBundle\Form\CarType', $automobile);


        $form->handleRequest($request);


        $qq = $em->getRepository('AdminBundle:Qouiqui')->findOneById($id);
        $form->getData()->setqouiqui($qq);
        $form->getData()->setDateCreation(new \DateTime());


        if ($form->isSubmitted()) {

            if ($lastReference == $automobile->getReference() || !$automobilesByReference) {
                $automobile->setModel($model);


                $em->persist($automobile);

                $em->flush($automobile);

                $em->refresh($automobile);

                if ($_FILES) {
                    if ($filesDeleted) {
                        foreach ($filesDeleted as $key => $value) {
                            unset($_FILES['images']['tmp_name'][$value]);
                        }

                    }


                    $idUser = $this->getUser()->getId();

//            $chars = preg_split('/#/', $img, -1, PREG_SPLIT_NO_EMPTY);
//            dump($request->get('TypeGallery'),$img,$chars);
                    #creation dossier avec l'id de l'utilisateur si n'existe pas
                    if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
                        mkdir($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
                        chmod($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
                    endif;
                    #creation dossier avec l'id de QUOIQUI si n'existe pas
                    if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/")):
                        mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/", 0777);
                        chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$id/", 0777);
                    endif;
                    #creation dossier annonce si n'existe pas

                    if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Offres")):


                        mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Offres", 0777);
                        chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Offres", 0777);
                    endif;
                    #creation dossier gallery si n'existe pas
                    $automobileId = $automobile->getId();


                    if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Offres/$automobileId")):
                        mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Offres/$automobileId", 0777);
                        chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Offres/$automobileId", 0777);
                    endif;


                    if (sizeof($_FILES['images']['tmp_name']) >= "2") {


                        for ($i = 0; $i <= sizeof($_FILES['images']['tmp_name']) - 1; $i++) {
                            if (array_key_exists($i, $_FILES['images']['tmp_name'])) {

                                $temporaryId = uniqid();

                                $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$id/Offres/" . $automobileId . "/" . $temporaryId . ".jpg";
                                move_uploaded_file($_FILES['images']['tmp_name'][$i], $uploaddir);
                            }
                        }


                    } else {
                        if (array_key_exists(0, $_FILES['images']['tmp_name'])) {
                            $temporaryId = uniqid();

                            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$id/Offres/" . $automobileId . "/" . $temporaryId . ".jpg";


                            $files = $_FILES['images']['tmp_name']['0'];
                            move_uploaded_file($files, $uploaddir);

                        }
                    }

                }
            } else {
                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'désolé vous ne pouvez pas ajouter deux voiture avec une meme référence');


            }


        }
        return $this->redirect($_SERVER['PHP_SELF']);


    }

    /**
     * Finds and displays a car entity.
     *
     */
    public function showAction(Car $car)
    {
        $deleteForm = $this->createDeleteForm($car);

        return $this->render('car/show.html.twig', array(
            'car' => $car,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing car entity.
     *
     */
    public function editAction(Request $request, Car $car)
    {
        $deleteForm = $this->createDeleteForm($car);
        $editForm = $this->createForm('AdminBundle\Form\CarType', $car);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('car_edit', array('id' => $car->getId()));
        }

        return $this->render('car/edit.html.twig', array(
            'car' => $car,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a car entity.
     *
     */
    public function deleteAction(Request $request, Car $car)
    {
        $form = $this->createDeleteForm($car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($car);
            $em->flush($car);
        }

        return $this->redirectToRoute('car_index');
    }

    /**
     * Creates a form to delete a car entity.
     *
     * @param Car $car The car entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Car $car)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('car_delete', array('id' => $car->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    public function deleteFileAction()
    {


        $em = $this->getDoctrine()->getManager();

        $idUser = $_POST['user'];
        $qq_id = $_POST['quoiqui'];
        $id = $_POST['module'];
        $automobile = $em->getRepository('AdminBundle:Automobile')->find($id);
        $indexImage = $automobile->getIndexPrincipaleImage();
        $image = $_POST['image'];
        $dir = $_SERVER['PHP_DOCUMENT_ROOT'] . "/web/annuaire/web/uploads/image/$idUser/$qq_id/Offres/$id";
        $file = $dir . "/$image";
        $allImage = scandir($dir);


        foreach ($allImage as $key => $value) {

            if ($value != $image) {


                if ($key < $indexImage) {

                    $automobile->setIndexPrincipaleImage($indexImage - 1);
                    $em->flush();
                }
                break;


            }
        }

        if (file_exists($file)) {


            unlink($file);


        }


        return new Response("ok");
    }

    public function createSliderAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $qq = $em->getRepository('AdminBundle:Qouiqui')->findOneById($id);


        $filesDeleted = $request->request->get("deleteFile");
        $textSlider = new TextSildeAutomobile();
        $principal = $request->request->get("principale");
        $secondaire = $request->request->get("secondaire");
        $textSlider->setPrincipalText($principal);
        $textSlider->setSecondarText($secondaire);
        $qq->setTextSilder($textSlider);
        $em->flush();


        if ($_FILES) {
            if ($filesDeleted) {
                foreach ($filesDeleted as $key => $value) {
                    unset($_FILES['images']['tmp_name'][$value]);
                }

            }


            $idUser = $this->getUser()->getId();

//            $chars = preg_split('/#/', $img, -1, PREG_SPLIT_NO_EMPTY);
//            dump($request->get('TypeGallery'),$img,$chars);
            #creation dossier avec l'id de l'utilisateur si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
            endif;
            #creation dossier avec l'id de QUOIQUI si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$id/", 0777);
            endif;
            #creation dossier annonce si n'existe pas

            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/slider")):


                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/slider", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$id/slider", 0777);
            endif;
            #creation dossier gallery si n'existe pas


            if (sizeof($_FILES['images']['tmp_name']) >= "2") {


                for ($i = 0; $i <= sizeof($_FILES['images']['tmp_name']) - 1; $i++) {
                    if (array_key_exists($i, $_FILES['images']['tmp_name'])) {

                        $temporaryId = uniqid();

                        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$id/slider/" . $temporaryId . ".jpg";
                        move_uploaded_file($_FILES['images']['tmp_name'][$i], $uploaddir);
                    }
                }


            } else {
                if (array_key_exists(0, $_FILES['images']['tmp_name'])) {
                    $temporaryId = uniqid();

                    $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$id/slider/" . $temporaryId . ".jpg";


                    $files = $_FILES['images']['tmp_name']['0'];
                    move_uploaded_file($files, $uploaddir);

                }
            }


        }
        return $this->redirect($_SERVER['PHP_SELF']);

    }

    public function deleteSliderAction()
    {

        $idUser = $_POST['user'];
        $qq_id = $_POST['quoiqui'];

        $image = $_POST['image'];
        $file = $_SERVER['PHP_DOCUMENT_ROOT'] . "/web/annuaire/web/uploads/image/$idUser/$qq_id/slider/$image";

        if (file_exists($file)) {


            unlink($file);
            $response['status'] = true;

        }

        return $this->redirect($_SERVER['PHP_SELF']);
    }

    public function updateAboutAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $qq = $em->getRepository('AdminBundle:Qouiqui')->findOneById($id);
        $details = $request->request->get("details");

        $address = $request->request->get("address");

        $tel = $request->request->get("phone");

        $email = $request->request->get("email");


        $isSamedi = $request->request->get("isSamedi");
        $isDimanche = $request->request->get("isDimanche");
        $week1Start = $request->request->get("week1-start");
        $week1End = $request->request->get("week1-end");
        $week2Start = $request->request->get("week2-start");
        $week2End = $request->request->get("week2-end");
        $startSamedi = $request->request->get("strat-samedi");
        $endSamedi = $request->request->get("end-samedi");
        $startDimanche = $request->request->get("start-dimanche");
        $endDimanche = $request->request->get("end-dimanche");
        $arrayDate = array();
        $arrayDate["week1"] = array("start" => $week1Start, "end" => $week1End);
        $arrayDate["week2"] = array("start" => $week2Start, "end" => $week2End);
        $arrayDate["weekendsamedi"] = array("open" => $isSamedi, "start" => $startSamedi, "end" => $endSamedi);
        $arrayDate["weekenddimanche"] = array("open" => $isDimanche, "start" => $startDimanche, "end" => $endDimanche);
        $jsonDate = json_encode($arrayDate);


        $qq->setDetails($details);
        $qq->setAddress1($address);
        $qq->setOpening($jsonDate);
        $qq->setPhone($tel);
        $qq->setMail($email);
        $em->flush();
        $idUser = $this->getUser()->getId();
        if (is_file($_FILES["image"]["tmp_name"])) {


//            $chars = preg_split('/#/', $img, -1, PREG_SPLIT_NO_EMPTY);
//            dump($request->get('TypeGallery'),$img,$chars);
            #creation dossier avec l'id de l'utilisateur si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
            endif;
            #creation dossier avec l'id de QUOIQUI si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$id/", 0777);
            endif;
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/avatar")):


                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/avatar", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$id/avatar", 0777);
            endif;
            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$id/avatar/avatar.jpg";
            $files = $_FILES['image']['tmp_name'];

            move_uploaded_file($files, $uploaddir);

        } else if ($_POST['isDeleted'] == "true") {

            $directory = $this->get('app.image_uploader')->targetDir . "/$idUser/$id/avatar";


            $files = scandir($directory);

            foreach ($files as $file) {

                if (is_file($directory . '/' . $file)) {



               unlink($directory . '/' . $file);

                }


            }


        }

        return $this->redirect($_SERVER['PHP_SELF']);


    }


}


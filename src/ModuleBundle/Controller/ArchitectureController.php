<?php
/**
 * Created by PhpStorm.
 * User: Ameni
 * Date: 24/07/2017
 * Time: 11:34
 */

namespace ModuleBundle\Controller;


use AdminBundle\Entity\Architecture;
use AdminBundle\Entity\Theme;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ArchitectureController extends Controller
{
    public function addProjectAction($id, Request $request)
    {
        $reference = $request->request->get("reference");
        $filesDeleted = $request->request->get("deleteFile");

        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->find($id);
        $project = new Architecture();
        $project->setName($request->request->get("name"));
        $project->setDateCreation(new \DateTime($request->request->get("date")));
        $project->setDescription($request->request->get("description"));
        $project->setQouiqui($quoiqui);
        $project->setReference($reference);
        $project->setAdress($request->request->get("adress"));
        $project->setClient($request->request->get("client"));
        $project->setSurface($request->request->get("surface"));

        $projectsByReference = $em->getRepository('AdminBundle:Architecture')->findBy(array("reference" => $reference));

        if (!$projectsByReference) {
            $em->persist($project);
            $em->flush();
            $em->refresh($project);
            $projectId = $project->getId();

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


                if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Offres/$projectId")):
                    mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Offres/$projectId", 0777);
                    chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Offres/$projectId", 0777);
                endif;


                for ($i = 0; $i <= sizeof($_FILES['images']['name']) - 1; $i++) {
                    if (array_key_exists($i, $_FILES['images']['tmp_name'])) {

                        $temporaryId = uniqid();

                        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$id/Offres/" . $projectId . "/" . $temporaryId . ".jpg";
                        move_uploaded_file($_FILES['images']['tmp_name'][$i], $uploaddir);
                    }
                }


            }
        } else {
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'désolé vous ne pouvez pas ajouter deux projets avec une meme référence');
        }
        return $this->redirect($_SERVER['PHP_SELF']);


    }

    public function deleteProjectAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('AdminBundle:Architecture')->find($id);
        $idUser = $project->getQouiqui()->getUser()->getId();
        $quoiqui = $project->getQouiqui()->getId();

        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$quoiqui/Offres/$id";
        system('/bin/rm -rf ' . escapeshellarg($uploaddir));
        $em->remove($project);
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF']);

    }

    public function updateProjectAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('AdminBundle:Architecture')->find($id);
        $quoiqui = $project->getQouiqui();
        $quoiquiId = $quoiqui->getId();
        $form = $this->createForm('AdminBundle\Form\ArchitectureType', $project);
        $filesDeleted = $request->request->get("deleteFile");

        $oldReference = $project->getReference();
        $form->handleRequest($request);


        if ($form->isSubmitted()) {


            $project->setQouiqui($quoiqui);

            $project->setDateCreation(new \DateTime($request->request->get("adminbundle_architecture")["dateCreation"]));
            $newReference = $project->getReference();
            $projectsByReference = $em->getRepository('AdminBundle:Architecture')->findBy(array("reference" => $newReference));
            if ((($oldReference != $newReference) && (!$projectsByReference)) || ($oldReference === $newReference)) {
                $em->persist($project);
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
                    if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$quoiquiId/")):
                        mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$quoiquiId/", 0777);
                        chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$quoiquiId/", 0777);
                    endif;
                    #creation dossier annonce si n'existe pas

                    if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$quoiquiId/Offres")):


                        mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$quoiquiId/Offres", 0777);
                        chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$quoiquiId/Offres", 0777);
                    endif;
                    #creation dossier gallery si n'existe pas


                    if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$quoiquiId/Offres/$id")):
                        mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$quoiquiId/Offres/$id", 0777);
                        chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$quoiquiId/Offres/$id", 0777);
                    endif;


                    for ($i = 0; $i <= sizeof($_FILES['images']['name']) - 1; $i++) {
                        if (array_key_exists($i, $_FILES['images']['tmp_name'])) {

                            $temporaryId = uniqid();

                            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$quoiquiId/Offres/" . $id . "/" . $temporaryId . ".jpg";
                            move_uploaded_file($_FILES['images']['tmp_name'][$i], $uploaddir);
                        }
                    }

                }
            }
        } else {
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'désolé vous ne pouvez pas ajouter deux projets avec une meme référence');

        }


        return $this->redirect($_SERVER['PHP_SELF']);


    }


    public function deleteImageAction()
    {

        $em = $this->getDoctrine()->getManager();
        $idUser = $_POST['user'];
        $qq_id = $_POST['quoiqui'];
        $id = $_POST['module'];
        $project = $em->getRepository('AdminBundle:Architecture')->find($id);
        $indexImage = $project->getIndexPrincipaleImage();
        $image = $_POST['image'];
        $dir = $_SERVER['PHP_DOCUMENT_ROOT'] . "/web/annuaire/web/uploads/image/$idUser/$qq_id/Offres/$id";
        $file = $dir . "/$image";
        $allImage = scandir($dir);


        foreach ($allImage as $key => $value) {

            if ($value != $image) {


                if ($key < $indexImage) {

                    $project->setIndexPrincipaleImage($indexImage - 1);
                    $em->flush();
                }
                break;


            }
        }

        if (file_exists($file)) {


            unlink($file);


        }


        die('bhima');
    }

    public function changePrincipaleImageAction()
    {

        $em = $this->getDoctrine()->getManager();
        $idModule = $_POST['module'];

        $index = $_POST['index'];
        $project = $em->getRepository('AdminBundle:Architecture')->find($idModule);
        $project->setIndexPrincipaleImage($index);
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF']);

    }

    public function addMemberTeamAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->find($id);
        $data = $quoiqui->getData();
        $newArray = array();
        $social = $_POST['social'];
        foreach ($social as $key => $value) {
            if ($value == "") {
                $social[$key] = "#";
            }
        }
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $post = $_POST['post'];
        $facebook = $social['facebook'];
        $google = $social['google'];
        $tweeter = $social['tweeter'];
        $dribbble = $social['dribbble'];
        $idMember = uniqid();
        $newArray = array("firstName" => $firstName, "lastName" => $lastName, "post" => $post, "social" => array("Facebook" => $facebook, "Google" => $google, "Tweeter" => $tweeter, "Dribbble" => $dribbble), "id" => $idMember);

        $idUser = $this->getUser()->getId();

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

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Team")):


            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Team", 0777);
            chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Team", 0777);
        endif;
        #creation dossier gallery si n'existe pas
        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Team/$idMember")):


            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Team/$idMember", 0777);
            chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Team/$idMember", 0777);
        endif;

        if (is_file($_FILES["images"]["tmp_name"][0])) {


            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$id/Team/$idMember/" . $_FILES['images']['name'][0];
            move_uploaded_file($_FILES['images']['tmp_name'][0], $uploaddir);

            $newArray["image"] = $_FILES['images']['name'][0];

        } else {
            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$id/Team/$idMember/noImage.jpg";
            copy($this->get('app.image_uploader')->targetDir . "/Architecture/Team/noImage.jpg", $uploaddir);
            $newArray["image"] = "noImage.jpg";
        }
        if ($data) {
            $dataArray = json_decode($data, true);


        }
        $dataArray['team']["$idMember"] = $newArray;
        $data = json_encode($dataArray);
        $quoiqui->setData($data);
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF']);


    }

    public function listMembersTeamAction()
    {
        $em = $this->getDoctrine()->getManager();
        $id = $_POST['quoiqui'];
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->find($id);
        $data = $quoiqui->getData();
        $arrayMemember = array();

        if ($data) {


            $dataArray = json_decode($data, true);

            if ($dataArray["team"]) {
                $arrayMemember = $dataArray["team"];

            }


        }
        return new Response($this->renderView("ModuleBundle:Module/architecture/Ajax:renderListMembers.html.twig", array("members" => $arrayMemember, "quoiqui" => $id)));


    }

    public function deleteMembersTeamAction($id, $quoiqui)
    {

        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->find($quoiqui);
        $idUser = $quoiqui->getUser()->getId();
        $data = $quoiqui->getData();
        $members = json_decode($data, true);
        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$quoiqui/Team/$id";
        unset($members["team"]["$id"]);
        system('/bin/rm -rf ' . escapeshellarg($uploaddir));
        $newData = json_encode($members);
        $quoiqui->setData($newData);
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF']);


    }


    public function updateMembersTeamAction($id, $quoiqui)
    {

        $em = $this->getDoctrine()->getManager();
        $quoiquiObject = $em->getRepository('AdminBundle:Qouiqui')->find($quoiqui);
        $idUser = $quoiquiObject->getUser()->getId();
        $data = $quoiquiObject->getData();
        $dataArray = json_decode($data, true);
        $dataArray["team"]["$id"]["firstName"] = $_POST["firstName"];
        $dataArray["team"]["$id"]["lastName"] = $_POST["lastName"];
        $dataArray["team"]["$id"]["post"] = $_POST["post"];
        $socials = $_POST["social"];
        foreach ($socials as $key => $value) {
            $dataArray["team"]["$id"][$key] = $value;

        }
        $uploaderDir = $this->get('app.image_uploader')->targetDir . "/$idUser/$quoiqui/Team/$id";

        if (is_file($_FILES["images"]["tmp_name"][0])) {

            $dataArray["team"]["$id"]["image"] = $_FILES['images']['name'][0];

            $files = scandir($uploaderDir);
            foreach ($files as $file) { // iterate files
                if (is_file($file))
                    unlink($file); // delete file
            }


            move_uploaded_file($_FILES['images']['tmp_name'][0], $uploaderDir . "/" . $_FILES['images']['name'][0]);
            $dataArray["team"]["$id"]["image"] = $_FILES['images']['name'][0];
        } else if ($_POST['isDeleted'] == "true") {

            $this->deleteFilesIntoDirectory($uploaderDir);
            $dataArray["team"]["$id"]["image"] = "noImage.jpg";
            copy($this->get('app.image_uploader')->targetDir . "/Architecture/Team/noImage.jpg", $uploaderDir . "/noImage.jpg");
        }
        $newData = json_encode($dataArray);
        $quoiquiObject->setData($newData);
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF']);


    }

    public
    function addServiceAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->find($id);
        $data = $quoiqui->getData();
        $newArray = array();
        $dataArray = array();
        $idService = uniqid();

        foreach ($_POST as $key => $value) {
            $newArray[$key] = $value;
        }

        if ($data) {
            $dataArray = json_decode($data, true);


        }
        $dataArray["Service"][$idService] = $newArray;
        $idUser = $this->getUser()->getId();
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

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Service")):


            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Service", 0777);
            chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Service", 0777);
        endif;
        #creation dossier gallery si n'existe pas


        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Service/$idService")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Service/$idService", 0777);
            chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$id/Service/$idService", 0777);

        endif;
        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$id/Service/$idService/service.jpg";


        if (is_file($_FILES["images"]["tmp_name"])) {

            move_uploaded_file($_FILES['images']['tmp_name'], $uploaddir);

        } else {


            copy($this->get('app.image_uploader')->targetDir . "/Architecture/Service/service.jpg", $uploaddir);
        }
        $data = json_encode($dataArray);

        $quoiqui->setData($data);
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF']);


    }

    public
    function deleteServiceAction($serviceId, $quoiquiId)
    {

        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->find($quoiquiId);
        $idUser = $quoiqui->getUser()->getId();
        $data = $quoiqui->getData();
        $dataArray = json_decode($data, true);
        unset($dataArray["Service"][$serviceId]);
        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$quoiquiId/Service/$serviceId";
        system('/bin/rm -rf ' . escapeshellarg($uploaddir));

        $data = json_encode($dataArray);
        $quoiqui->setData($data);
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF']);
    }

    public
    function updateServiceAction($serviceId, $quoiquiId)
    {

        $em = $this->getDoctrine()->getManager();
        $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->find($quoiquiId);
        $idUser = $quoiqui->getUser()->getId();
        $data = $quoiqui->getData();
        $dataArray = json_decode($data, true);
        $newArray = array();
        foreach ($_POST as $key => $value) {
            if ($key != "isDeleted")
                $newArray[$key] = $value;
        }
        $dataArray["Service"]["$serviceId"] = $newArray;
        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$quoiquiId/Service/$serviceId";
        if (is_file($_FILES["images"]["tmp_name"][0])) {
            $this->deleteFilesIntoDirectory($uploaddir);

            move_uploaded_file($_FILES['images']['tmp_name'][0], $uploaddir . '/service.jpg');
        } else if ($_POST['isDeleted'] == "true") {

            $this->deleteFilesIntoDirectory($uploaddir);

            copy($this->get('app.image_uploader')->targetDir . "/Architecture/Service/service.jpg", $uploaddir . "/service.jpg");
        }
        $data = json_encode($dataArray);
        $quoiqui->setData($data);
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF']);


    }

    public function deleteFilesIntoDirectory($directory)
    {
        $files = scandir($directory);
        foreach ($files as $file) { // iterate files
            if (is_file($file))


                unlink($file); // delete file
        }
    }


    function ficheAnnoncesAction(Request $request)
    {


        return $this->render('@User/template/fiche/Architecture/annonces.html.twig', [
            'attributes' => $request->attributes->all()
        ]);
    }


    function ficheServicesAction(Request $request)
    {


        return $this->render('@User/template/fiche/Architecture/services.html.twig', [
            'attributes' => $request->attributes->all()
        ]);
    }

    function addServiceGlobalAction($themeId, $quoiquiId)
    {

        $em = $this->getDoctrine()->getManager();


        if ($themeId == "null") {

            $theme = new Theme();
            $quoiqui = $em->getRepository('AdminBundle:Qouiqui')->find($quoiquiId);
            $theme->setQouiqui($quoiqui);
            $dataArray = array();
        } else {
            $theme = $em->getRepository('AdminBundle:Theme')->find($themeId);


            $dataArray = json_decode($theme->getData(), true);

        }

        $newArray = array();

        $idService = uniqid();

        foreach ($_POST as $key => $value) {
            $newArray[$key] = $value;
        }

        $dataArray["Service"][$idService] = $newArray;


        if ($_FILES) {
            $idUser = $this->getUser()->getId();
            $arrayDirectory = array($this->get('app.image_uploader')->targetDir, "/" . $idUser, "/" . $quoiquiId, "/Service", "/" . $idService);
            $this->makeListDirectories($arrayDirectory);
            $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$quoiquiId/Service/$idService/service.jpg";
            $this->uploadOneImage($_FILES["images"]["tmp_name"], $uploaddir, $this->get('app.image_uploader')->targetDir . "/Architecture/Service/service.jpg", "true");
        }
        $data = json_encode($dataArray);

        $theme->setData($data);
        $em->persist($theme);
        $em->flush();


        return $this->redirect($_SERVER['PHP_SELF'] . '/#section-services');
    }

    public function deleteServiceGlobalAction($serviceId, $themeId)
    {


        $em = $this->getDoctrine()->getManager();
        $theme = $em->getRepository('AdminBundle:Theme')->find($themeId);

        $quoiquiId = $theme->getQouiqui()->getId();
        $idUser = $theme->getQouiqui()->getUser()->getId();

        $dataArray = json_decode($theme->getData(), true);
        unset($dataArray["Service"][$serviceId]);
        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$quoiquiId/Service/$serviceId";
        system('/bin/rm -rf ' . escapeshellarg($uploaddir));

        $data = json_encode($dataArray);
        $theme->setData($data);
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF']);
    }

    public function makeDirectory($directory)
    {


        if (!is_dir($directory)):


            mkdir($directory, 0777);
            chmod($directory, 0777);

        endif;

    }

    public function uploadOneImage($file, $uploaddir, $defaultImagePath, $condition)
    {
        if (is_file($file)) {

            move_uploaded_file($file, $uploaddir);

        } else if ($condition = "true") {


            copy($defaultImagePath, $uploaddir);
        }
    }

    public function makeListDirectories($array)
    {
        $directoryPath = "";
        foreach ($array as $directory) {

            $directoryPath = $directoryPath . $directory;
            $this->makeDirectory($directoryPath);

        }

    }

    public function updateServiceGlobalAction($serviceId, $themeId)
    {
        $em = $this->getDoctrine()->getManager();
        $theme = $em->getRepository('AdminBundle:Theme')->find($themeId);
        $idUser = $theme->getQouiqui()->getUser()->getId();
        $quoiquiId = $theme->getQouiqui()->getId();
        $data = $theme->getData();
        $dataArray = json_decode($data, true);
        $newArray = array();
        foreach ($_POST as $key => $value) {
            if ($key != "isDeleted")
                $newArray[$key] = $value;
        }
        $dataArray["Service"]["$serviceId"] = $newArray;
        $uploaddir = $this->get('app.image_uploader')->targetDir . "/$idUser/$quoiquiId/Service/$serviceId";
        if ($_FILES) {
            $this->uploadOneImage($_FILES["images"]["tmp_name"][0], $uploaddir . '/service.jpg', $this->get('app.image_uploader')->targetDir . "/Architecture/Service/service.jpg", $_POST['isDeleted']);
        }
        $data = json_encode($dataArray);
        $theme->setData($data);
        $em->flush();
        return $this->redirect($_SERVER['PHP_SELF']);


    }


}
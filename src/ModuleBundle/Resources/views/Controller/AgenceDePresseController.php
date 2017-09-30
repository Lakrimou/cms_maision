<?php

namespace ModuleBundle\Controller;

use AdminBundle\Entity\AgenceDePresse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AgenceDePresseController extends Controller
{
//    supprimer un article
    public function deleteArticleByIdAction()
    {
        die();
    }

//    modifier un article
    public function getArticleByIdAction()
    {
        die();
    }

//    ajout nouveau article
    public function addArticleAction(Request $request)
    {

        $iduser = $this->getUser()->getId();
        if (isset($_POST)) {
            $em = $this->getDoctrine()->getManager();
            $agence = new  AgenceDePresse();
            $qq = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(['id' => $_POST['qouiqui_id']]);
            if($_POST['Categorie']=="autre"){
//                echo $_POST['Categorie'];
            $agence->setCategorie($_POST['autreCategorie']);
            }else{
//                echo $_POST['Categorie'];
            $agence->setCategorie($_POST['Categorie']);
            }
            $agence->setDatepub(new \DateTime());
            $agence->setQouiqui($qq);
            $agence->setText($_POST['detail']);
            $agence->setTitre($_POST['titre']);
            $agence->setAuteur($_POST['auteur']);
            $agence->setStatut($_POST['statut']);
            $agence->setDesc($_POST['desc']);
            $em->persist($agence);
//            dump($em);die();
            $em->flush();
            $em->refresh($agence);
            $idArticle = $agence->getId();
            $id_qq = $_POST['qouiqui_id'];
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$iduser")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$iduser");
            endif;
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq");
            endif;
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/presse")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/presse", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/presse", 0777);
            endif;
            $storeFolder = $file = $this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/presse/";
            foreach ($_FILES['img']['tmp_name'] as $file) {
                if ($file != '') {
                    $tmp = $file;
                    move_uploaded_file($tmp, $storeFolder . $idArticle . '.' . "png");
                }
            }
            $this->addFlash('success', 'Article enregistrer');
            return $this->redirect($_SERVER['PHP_SELF'] . "#articles");

        } else {
            $this->addFlash('error', 'Article non enregistrer');
            return $this->redirect($_SERVER['PHP_SELF'] . "#articles");
        }


    }

    function ficheAnnoncesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');
        $articles = $this->getDoctrine()->getRepository('AdminBundle:AgenceDePresse')->findByQouiqui($quoiqui);
        dump($articles);
        return $this->render('@User/template/fiche/AgenceDePresse/annonces.html.twig', [
            'attributes' => $request->attributes->all(), 'quoiqui' => $quoiqui, 'articles' => $articles
        ]);
    }


    function ficheServicesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');
        $serv = $this->getDoctrine()->getRepository('AdminBundle:Theme')->findOneBy(array('qouiqui' => $quoiqui));
        if ($serv) {
            $locationVoitruesServices = json_decode($serv->getData(), true);
        } else {
            $locationVoitruesServices = null;
        }

        return $this->render('@User/template/fiche/AgenceDePresse/services.html.twig', [
            'attributes' => $request->attributes->all(),'services' => $locationVoitruesServices, 'quoiqui' => $quoiqui
        ]);
    }
}

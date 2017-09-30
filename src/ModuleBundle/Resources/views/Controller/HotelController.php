<?php
/**
 * Created by PhpStorm.
 * User: Hatem
 * Date: 17/05/2017
 * Time: 14:37
 */
namespace ModuleBundle\Controller;

use AdminBundle\Entity\Hotel;
use AdminBundle\Entity\Qouiqui;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AdminBundle\Entity\Booking;

/**
 * Hotel controller.
 *
 */
class HotelController extends Controller
{
    //===================================Begin Code Chambre===================================//
    public function ajouterChambreAction(Request $request, $id_qq)
    {
        if (isset($_POST)) {
            $user = $this->getUser()->getId();
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
                ->findOneBy(array('user' => $user, 'id' => $id_qq));
            $id_qq = $qq->getId();
            $hotel = $this->getDoctrine()->getRepository('AdminBundle:Hotel')
                ->findBy(array('qouiqui' => $qq));
            //============================debut ajouter image=======================//
            $ext = '.jpg';
            $imageNom = uniqid() . $ext;
            $ds = DIRECTORY_SEPARATOR;
            if ($qq) {
                //============================Creer dossier avec idUser=======================//
                $directory1 = $this->get('app.image_uploader')->targetDir . "/$user";
                if (!is_dir($directory1)) {
                    mkdir($directory1, 0777);
                }
                //============================Creer dossier avec idQouiqui=======================//
                $directory2 = $this->get('app.image_uploader')->targetDir . "/$user" . "/$id_qq";
                if (!is_dir($directory2)) {
                    mkdir($directory2, 0777);
                }
                //============================Creer dossier avec Nom du section et ajouter l'image=======================//
                $directoryCh = $this->get('app.image_uploader')->targetDir . "/$user" . "/$id_qq" . "/chambres";
                if (!is_dir($directoryCh)) {
                    mkdir($directoryCh, 0777);
                    if (!empty($_FILES['chambre']['tmp_name']['image-chambre'][0])) {

                        $file = $_FILES['chambre']['tmp_name']['image-chambre'][0];
                        $fileUpload = $directoryCh . $ds . $imageNom;
                        $direct = move_uploaded_file($file, $fileUpload);
                    }
                } else {

                    if (!empty($_FILES['chambre']['tmp_name']['image-chambre'][0])) {
                        $file = $_FILES['chambre']['tmp_name']['image-chambre'][0];
                        $fileUpload = $directoryCh . $ds . $imageNom;
                        $direct = move_uploaded_file($file, $fileUpload);
                    }
                }
                //============================fin ajouter image=======================//
                //==================Ajouter les information dans la base des données format json=========================//
                $hotels = new Hotel();
                $hotels->setQouiqui($qq);
                $nombre = $request->get('chambre')['nombre'];
                $prix = $request->get('chambre')['prix'];
                $nombreLit = $request->get('chambre')['nombreLit'];
                $chambreS = $request->get('chambre')['chambreS'];
                //=====================Test si les champs son vides=================================//
                if (!empty($nombre && $prix && $nombreLit && $chambreS)) {
                    $chambre = $request->get('chambre');
                    //=======================Ajouter le nom de l'image dans la tableau chambre===========================//
                    $chambre['image_chambre'] = $imageNom;
                    $json_data = json_encode($chambre);
                    $hotels->setDescriptionRoom($json_data);
                } else {
                    return $this->render('ModuleBundle:Module:hotel\page404.html.twig');
                }
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($hotels);
            $em->flush($hotels);
            return $this->redirect($_SERVER['PHP_SELF'].'#section-annonces');
        } else {
            die('Quoiqui non existe');
        }
        die;
    }

    public function editAction(request $request, $id_qq, $id_ch)
    {
        $user = $this->getUser()->getId();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneBy(array("user" => $user, 'id' => $id_qq));
        $qq_id = $qq->getId();
        $hotel = $this->getDoctrine()->getRepository('AdminBundle:Hotel')->findOneBy(array("qouiqui" => $qq, 'id' => $id_ch));
        $descriptionRoom = json_decode($hotel->getDescriptionRoom(), true);
        $imageOld = $descriptionRoom['image_chambre'];
        $nombre = $request->get('chambre')['nombre'];
        $prix = $request->get('chambre')['prix'];
        $nombreLit = $request->get('chambre')['nombreLit'];
        $chambreS = $request->get('chambre')['chambreS'];
        if ($_POST) {
            if ($qq && $hotel) {
                $em = $this->getDoctrine()->getManager();
                //============================debut Edit image=======================//
                $ext = '.jpg';
                $imageNew = uniqid() . $ext;
                $ds = DIRECTORY_SEPARATOR;
                //==========================Dossier du section Chambre==================//
                $directoryCh = $_SERVER['PHP_DOCUMENT_ROOT'] . '/web/annuaire/web/uploads/image/' . $user . '/' . $qq_id . '/chambres';
                //==========================En cas où il veut changer l'image du chambre==================//
                if (!empty($_FILES['chambre']['tmp_name']['image-chambre'])) {
                    if (is_dir($directoryCh)) {
                        $file = $_FILES['chambre']['tmp_name']['image-chambre'];
                        $fileUpload = $directoryCh . $ds . $imageNew;
                        $direct = move_uploaded_file($file, $fileUpload);
                    }
                    if (!empty($nombre && $prix && $nombreLit && $chambreS)) {
                        $chambre = $request->get('chambre');
                        $chambre['image_chambre'] = $imageNew;
                        $chambre_encode = json_encode($chambre);
                    } else {
                        return $this->render('ModuleBundle:Module:hotel\page404.html.twig');
                    }
                } //==========================En cas où  l'image du chambre ne doit pas etre changer==================//
                else {
                    if (!empty($nombre && $prix && $nombreLit && $chambreS)) {
                        $chambre = $request->get('chambre');
                        $chambre['image_chambre'] = $imageOld;
                        $chambre_encode = json_encode($chambre);
                        dump($chambre, $chambre_encode);
                    } else {
                        return $this->render('ModuleBundle:Module:hotel\page404.html.twig');
                    }
                }
                $hotel->setDescriptionRoom($chambre_encode);
                $em->persist($hotel);
                $em->flush();
                return $this->redirect($_SERVER['PHP_SELF'].'#section-annonces');
            } else {
                die('Non existe!');
            }
        }
        die;


    }

    public function supprimerChambreAction(request $request, $id_qq, $id_ch)
    {
        $user = $this->getUser()->getId();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
            ->findOneBy(array('user' => $user, 'id' => $id_qq));
        $hotel = $this->getDoctrine()->getRepository('AdminBundle:Hotel')
            ->findOneBy(array('qouiqui' => $id_qq, 'id' => $id_ch));
        if ($qq && $hotel) {
            $room = $hotel->getDescriptionRoom();
            if (!empty($room)) {
                $em = $this->getDoctrine()->getManager();
                $room = $em->getRepository('AdminBundle:Hotel')
                    ->findOneBy(array('id' => $id_ch));
                $em->remove($room);
                $em->flush($room);
                return $this->redirect($_SERVER['PHP_SELF']);
            } else {
                die('Ereur!');
            }
        } else {
            die('Chambre n\'est pas existe!');
        }
        die;
    }
    //===================================End Code Chambre===================================//
    //===================================Begin Code Service===================================//
    public function ajouterServiceAction(request $request, $id_qq)
    {
        if (isset($_POST)) {
            $user = $this->getUser()->getId();
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
                ->findOneBy(array('user' => $user, 'id' => $id_qq));
            $id_qq = $qq->getId();
            $hotel = $this->getDoctrine()->getRepository('AdminBundle:Hotel')
                ->findBy(array('qouiqui' => $qq));
            //============================debut ajouter image=======================//
            $ext = '.jpg';
            $imageNom = uniqid() . $ext;
            $ds = DIRECTORY_SEPARATOR;

            if ($qq) {
                //============================Creer dossier avec idUser=======================//
                $directory1 = $this->get('app.image_uploader')->targetDir . "/$user";
                if (!is_dir($directory1)) {
                    mkdir($directory1, 0777);
                }
                //============================Creer dossier avec idQouiqui=======================//
                $directory2 = $this->get('app.image_uploader')->targetDir . "/$user" . "/$id_qq";
                if (!is_dir($directory2)) {
                    mkdir($directory2, 0777);
                }
                //============================Creer dossier avec Nom du section et ajouter l'image=======================//
                $directorySer = $this->get('app.image_uploader')->targetDir . "/$user" . "/$id_qq" . "/services";
                if (!is_dir($directorySer)) {
                    mkdir($directorySer, 0777);
                    if (!empty($_FILES['services']['tmp_name']['imageService'])) {
                        $file = $_FILES['services']['tmp_name']['imageService'];
                        $fileUpload = $directorySer . $ds . $imageNom;
                        $direct = move_uploaded_file($file, $fileUpload);
                    }
                } else {
                    if (!empty($_FILES['services']['tmp_name']['imageService'])) {
                        $file = $_FILES['services']['tmp_name']['imageService'];
                        $fileUpload = $directorySer . $ds . $imageNom;
                        $direct = move_uploaded_file($file, $fileUpload);
                    }
                }
                //============================fin ajouter image=======================//
                $hotels = new Hotel();
                $hotels->setQouiqui($qq);
                $nameService = $request->get('services')['nameService'];
                if (!empty($nameService)) {
                    $services = $request->get('services');
                    $services['imageService'] = $imageNom;
                    $json_data = json_encode($services);
                    $hotels->setDescriptionServices($json_data);
                } else {
                    return $this->render('ModuleBundle:Module:hotel\page404.html.twig');
                }
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($hotels);
            $em->flush($hotels);
            return $this->redirect($_SERVER['PHP_SELF']);
        } else {
            die('Quoiqui non existe');
        }
        die;
    }

    public function editServiceAction(request $request, $id_qq, $id_ch)
    {
        $user = $this->getUser()->getId();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneBy(array("user" => $user, 'id' => $id_qq));
        $qq_id = $qq->getId();
        $hotel = $this->getDoctrine()->getRepository('AdminBundle:Hotel')->findOneBy(array("qouiqui" => $qq, 'id' => $id_ch));
        $descriptionServices = json_decode($hotel->getDescriptionServices(), true);
        $imageSerOld = $descriptionServices['imageService'];
        $nameService = $request->get('services')['nameService'];
        if ($_POST) {
            if ($qq && $hotel) {
                $em = $this->getDoctrine()->getManager();

                //============================debut Edit image=======================//
                $ext = '.jpg';
                $imageNew = uniqid() . $ext;
                $ds = DIRECTORY_SEPARATOR;
                //==========================Dossier du section Services==================//
                $directorySer = $_SERVER['PHP_DOCUMENT_ROOT'] . '/web/annuaire/web/uploads/image/' . $user . '/' . $qq_id . '/services';
                //==========================En cas où il veut changer l'image du Services==================//
                if (!empty($_FILES['services']['tmp_name']['imageService'])) {
                    if (is_dir($directorySer)) {
                        $file = $_FILES['services']['tmp_name']['imageService'];
                        $fileUpload = $directorySer . $ds . $imageNew;
                        $direct = move_uploaded_file($file, $fileUpload);
                    }
                    if (!empty($nameService)) {
                        $services = $request->get('services');
                        $services['imageService'] = $imageNew;
                        $services_encode = json_encode($services);
                    } else {
                        return $this->render('ModuleBundle:Module:hotel\page404.html.twig');
                    }

                } //==========================En cas où  l'image du service ne doit pas etre changer==================//
                else {
                    if (!empty($nameService)) {
                        $services = $request->get('services');
                        $services['imageService'] = $imageSerOld;
                        $services_encode = json_encode($services);
                    } else {
                        return $this->render('ModuleBundle:Module:hotel\page404.html.twig');
                    }

                }
                $hotel->setDescriptionServices($services_encode);
                $em->persist($hotel);
                $em->flush();
                return $this->redirect($_SERVER['PHP_SELF']);

            } else {
                die('Non existe!');
            }
        }
        die;
    }

    public function supprimerServiceAction(request $request, $id_qq, $id_ch)
    {
        $user = $this->getUser()->getId();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
            ->findOneBy(array('user' => $user, 'id' => $id_qq));
        $hotel = $this->getDoctrine()->getRepository('AdminBundle:Hotel')
            ->findOneBy(array('qouiqui' => $id_qq, 'id' => $id_ch));
        if ($qq && $hotel) {
            $service = $hotel->getDescriptionServices();
            if (!empty($service)) {
                $em = $this->getDoctrine()->getManager();
                $service = $em->getRepository('AdminBundle:Hotel')
                    ->findOneBy(array('id' => $id_ch));
                $em->remove($service);
                $em->flush($service);
                return $this->redirect($_SERVER['PHP_SELF']);
            } else {
                die('Ereur!');
            }
        } else {
            die('Service n\'est pas existe!');
        }
        die;
    }
    //===================================End Code Service===================================//
    //===================================Begin Code Events===================================//
    public function ajouterEventsAction(request $request, $id_qq)
    {
        if (isset($_POST)) {
            $user = $this->getUser()->getId();
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
                ->findOneBy(array('user' => $user, 'id' => $id_qq));
            $id_qq = $qq->getId();
            $hotel = $this->getDoctrine()->getRepository('AdminBundle:Hotel')
                ->findBy(array('qouiqui' => $qq));
            //============================debut ajouter image=======================//
            $ext = '.jpg';
            $imageNom = uniqid() . $ext;
            $ds = DIRECTORY_SEPARATOR;

            if ($qq) {
                //============================Creer dossier avec idUser=======================//
                $directory1 = $this->get('app.image_uploader')->targetDir . "/$user";
                if (!is_dir($directory1)) {
                    mkdir($directory1, 0777);
                }
                //============================Creer dossier avec idQouiqui=======================//
                $directory2 = $this->get('app.image_uploader')->targetDir . "/$user" . "/$id_qq";
                if (!is_dir($directory2)) {
                    mkdir($directory2, 0777);
                }
                //============================Creer dossier avec Nom du section et ajouter l'image=======================//
                $directoryEv = $this->get('app.image_uploader')->targetDir . "/$user" . "/$id_qq" . "/events";
                if (!is_dir($directoryEv)) {
                    mkdir($directoryEv, 0777);
                    if (!empty($_FILES['events']['tmp_name']['eventsImage'])) {
                        $file = $_FILES['events']['tmp_name']['eventsImage'];
                        $fileUpload = $directoryEv . $ds . $imageNom;
                        $direct = move_uploaded_file($file, $fileUpload);
                    }
                } else {
                    if (!empty($_FILES['events']['tmp_name']['eventsImage'])) {
                        $file = $_FILES['events']['tmp_name']['eventsImage'];
                        $fileUpload = $directoryEv . $ds . $imageNom;
                        $direct = move_uploaded_file($file, $fileUpload);
                    }
                }
                //============================fin ajouter image=======================//
                $hotels = new Hotel();
                $hotels->setQouiqui($qq);
                $nameEvents = $request->get('events')['nameEvents'];
                $dateEvents = $request->get('events')['dateEvents'];
                if (!empty($nameEvents && $dateEvents)) {
                    $events = $request->get('events');
                    $events['eventsImage'] = $imageNom;
                    $json_data = json_encode($events);
                    $hotels->setDescriptionEvents($json_data);
                } else {
                    return $this->render('ModuleBundle:Module:hotel\page404.html.twig');
                }

            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($hotels);
            $em->flush($hotels);
            return $this->redirect($_SERVER['PHP_SELF']);
        } else {
            die('Quoiqui non existe');
        }
        die;
    }

    public function editEventsAction(request $request, $id_qq, $id_ev)
    {
        $user = $this->getUser()->getId();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneBy(array("user" => $user, 'id' => $id_qq));
        $qq_id = $qq->getId();
        $hotel = $this->getDoctrine()->getRepository('AdminBundle:Hotel')->findOneBy(array("qouiqui" => $qq, 'id' => $id_ev));
        $descriptionServices = json_decode($hotel->getDescriptionEvents(), true);
        $imageevOld = $descriptionServices['eventsImage'];
        $nameEvents = $request->get('events')['nameEvents'];
        $dateEvents = $request->get('events')['dateEvents'];
        if ($_POST) {
            if ($qq && $hotel) {
                $em = $this->getDoctrine()->getManager();

                //============================debut Edit image=======================//
                $ext = '.jpg';
                $imageNew = uniqid() . $ext;
                $ds = DIRECTORY_SEPARATOR;
                //==========================Dossier du section Services==================//
                $directoryEv = $_SERVER['PHP_DOCUMENT_ROOT'] . '/web/annuaire/web/uploads/image/' . $user . '/' . $qq_id . '/events';
                //==========================En cas où il veut changer l'image du Services==================//
                if (!empty($_FILES['events']['tmp_name']['eventsImage'])) {
                    if (is_dir($directoryEv)) {
                        $file = $_FILES['events']['tmp_name']['eventsImage'];
                        $fileUpload = $directoryEv . $ds . $imageNew;
                        $direct = move_uploaded_file($file, $fileUpload);
                    }
                    if (!empty($nameEvents && $dateEvents)) {
                        $events = $request->get('events');
                        $events['eventsImage'] = $imageNew;
                        $events_encode = json_encode($events);
                    } else {
                        return $this->render('ModuleBundle:Module:hotel\page404.html.twig');
                    }

                } //==========================En cas où  l'image du service ne doit pas etre changer==================//
                else {
                    if (!empty($nameEvents && $dateEvents)) {
                        $events = $request->get('events');
                        $events['eventsImage'] = $imageevOld;
                        $events_encode = json_encode($events);
                    } else {
                        return $this->render('ModuleBundle:Module:hotel\page404.html.twig');
                    }
                }
                $hotel->setDescriptionEvents($events_encode);
                $em->persist($hotel);
                $em->flush();
                return $this->redirect($_SERVER['PHP_SELF']);

            } else {
                die('Non existe!');
            }
        }
        die;
    }

    public function supprimerEventsAction(request $request, $id_qq, $id_ev)
    {
        $user = $this->getUser()->getId();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
            ->findOneBy(array('user' => $user, 'id' => $id_qq));
        $hotel = $this->getDoctrine()->getRepository('AdminBundle:Hotel')
            ->findOneBy(array('qouiqui' => $id_qq, 'id' => $id_ev));
        if ($qq && $hotel) {
            $events = $hotel->getDescriptionEvents();
            if (!empty($events)) {
                $em = $this->getDoctrine()->getManager();
                $events = $em->getRepository('AdminBundle:Hotel')
                    ->findOneBy(array('id' => $id_ev));
                $em->remove($events);
                $em->flush($events);
                return $this->redirect($_SERVER['PHP_SELF']);
            } else {
                die('Ereur!');
            }
        } else {
            die('Service n\'est pas existe!');
        }
        die;
    }
    //===================================End Code Events===================================//

//===================================Begin Code Actualités===================================//
    public function ajouterActualitesAction(request $request, $id_qq)
    {
        if (isset($_POST)) {
            $user = $this->getUser()->getId();
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
                ->findOneBy(array('user' => $user, 'id' => $id_qq));
            $id_qq = $qq->getId();
            $hotel = $this->getDoctrine()->getRepository('AdminBundle:Hotel')
                ->findBy(array('qouiqui' => $qq));
            //============================debut ajouter image=======================//
            $ext = '.jpg';
            $imageNom = uniqid() . $ext;
            $ds = DIRECTORY_SEPARATOR;

            if ($qq) {
                //============================Creer dossier avec idUser=======================//
                $directory1 = $this->get('app.image_uploader')->targetDir . "/$user";
                if (!is_dir($directory1)) {
                    mkdir($directory1, 0777);
                }
                //============================Creer dossier avec idQouiqui=======================//
                $directory2 = $this->get('app.image_uploader')->targetDir . "/$user" . "/$id_qq";
                if (!is_dir($directory2)) {
                    mkdir($directory2, 0777);
                }
                //============================Creer dossier avec Nom du section et ajouter l'image=======================//
                $directoryAC = $this->get('app.image_uploader')->targetDir . "/$user" . "/$id_qq" . "/actualites";

                if (!is_dir($directoryAC)) {
                    mkdir($directoryAC, 0777);
                    if (!empty($_FILES['actualites']['tmp_name']['image_actualites'])) {
                        $file = $_FILES['actualites']['tmp_name']['image_actualites'];
                        $fileUpload = $directoryAC . $ds . $imageNom;
                        $direct = move_uploaded_file($file, $fileUpload);
                    }
                } else {
                    if (!empty($_FILES['actualites']['tmp_name']['image_actualites'])) {
                        $file = $_FILES['actualites']['tmp_name']['image_actualites'];
                        $fileUpload = $directoryAC . $ds . $imageNom;
                        $direct = move_uploaded_file($file, $fileUpload);
                    }
                }
                //============================fin ajouter image=======================//
                $hotels = new Hotel();
                $hotels->setQouiqui($qq);
                $titre_actualites = $request->get('actualites')['titre_actualites'];
                $date_actualites = $request->get('actualites')['date_actualites'];
                if (!empty($titre_actualites && $date_actualites)) {
                    $actualites = $request->get('actualites');
                    $actualites['image_actualites'] = $imageNom;
                    $json_data = json_encode($actualites);
                    $hotels->setDescriptionNews($json_data);
                } else {
                    return $this->render('ModuleBundle:Module:hotel\page404.html.twig');
                }
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($hotels);
            $em->flush($hotels);
            return $this->redirect($_SERVER['PHP_SELF']);
        } else {
            die('Quoiqui non existe');
        }
        die;
    }

    public function editActualitesAction(request $request, $id_qq, $id_ac)
    {
        $user = $this->getUser()->getId();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneBy(array("user" => $user, 'id' => $id_qq));
        $qq_id = $qq->getId();
        $hotel = $this->getDoctrine()->getRepository('AdminBundle:Hotel')->findOneBy(array("qouiqui" => $qq, 'id' => $id_ac));
        $descriptionNews = json_decode($hotel->getDescriptionNews(), true);
        $imageSerOld = $descriptionNews['image_actualites'];
        $titre_actualites = $request->get('actualites')['titre_actualites'];
        $date_actualites = $request->get('actualites')['date_actualites'];
        if ($_POST) {
            if ($qq && $hotel) {
                $em = $this->getDoctrine()->getManager();

                //============================debut Edit image=======================//
                $ext = '.jpg';
                $imageNew = uniqid() . $ext;
                $ds = DIRECTORY_SEPARATOR;
                //==========================Dossier du section Services==================//
                $directoryEv = $_SERVER['PHP_DOCUMENT_ROOT'] . '/web/annuaire/web/uploads/image/' . $user . '/' . $qq_id . '/actualites';
                //==========================En cas où il veut changer l'image du Actualités==================//
                if (!empty($_FILES['actualites']['tmp_name']['image_actualites'])) {
                    if (is_dir($directoryEv)) {
                        $file = $_FILES['actualites']['tmp_name']['image_actualites'];
                        $fileUpload = $directoryEv . $ds . $imageNew;
                        $direct = move_uploaded_file($file, $fileUpload);
                    }
                    if (!empty($titre_actualites && $date_actualites)) {

                        $actualites = $request->get('actualites');
                        $actualites['image_actualites'] = $imageNew;
                        $actualites_encode = json_encode($actualites);
                    } else {
                        return $this->render('ModuleBundle:Module:hotel\page404.html.twig');
                    }
                } //==========================En cas où  l'image du service ne doit pas etre changer==================//
                else {
                    if (!empty($titre_actualites && $date_actualites)) {
                        $actualites = $request->get('actualites');
                        $actualites['image_actualites'] = $imageSerOld;
                        $actualites_encode = json_encode($actualites);
                    } else {
                        return $this->render('ModuleBundle:Module:hotel\page404.html.twig');
                    }
                }
                $hotel->setDescriptionNews($actualites_encode);
                $em->persist($hotel);
                $em->flush();
                return $this->redirect($_SERVER['PHP_SELF']);

            } else {
                die('Non existe!');
            }
        }
        die;
    }

    public function supprimerActualitesAction(request $request, $id_qq, $id_ac)
    {
        $user = $this->getUser()->getId();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
            ->findOneBy(array('user' => $user, 'id' => $id_qq));
        $hotel = $this->getDoctrine()->getRepository('AdminBundle:Hotel')
            ->findOneBy(array('qouiqui' => $id_qq, 'id' => $id_ac));
        if ($qq && $hotel) {
            $actualites = $hotel->getDescriptionNews();
            if (!empty($actualites)) {
                $em = $this->getDoctrine()->getManager();
                $actualites = $em->getRepository('AdminBundle:Hotel')
                    ->findOneBy(array('id' => $id_ac));
                $em->remove($actualites);
                $em->flush($actualites);
                return $this->redirect($_SERVER['PHP_SELF']);
            } else {
                die('Ereur!');
            }
        } else {
            die('Service n\'est pas existe!');
        }
        die;
    }
    //===================================End Code Actualités===================================//

    //===================================Begin Code a propos===================================//
    public function ajouterAproposAction(request $request, $id_qq)
    {
        if (isset($_POST)) {
            $user = $this->getUser()->getId();
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
                ->findOneBy(array('user' => $user, 'id' => $id_qq));
            $id_qq = $qq->getId();
            $hotel = $this->getDoctrine()->getRepository('AdminBundle:Hotel')
                ->findBy(array('qouiqui' => $qq));
            //============================debut ajouter image=======================//
            $ext = '.jpg';
            $imageNom = uniqid() . $ext;
            $ds = DIRECTORY_SEPARATOR;

            if ($qq) {
                //============================Creer dossier avec idUser=======================//
                $directory1 = $this->get('app.image_uploader')->targetDir . "/$user";
                if (!is_dir($directory1)) {
                    mkdir($directory1, 0777);
                }
                //============================Creer dossier avec idQouiqui=======================//
                $directory2 = $this->get('app.image_uploader')->targetDir . "/$user" . "/$id_qq";
                if (!is_dir($directory2)) {
                    mkdir($directory2, 0777);
                }
                //============================Creer dossier avec Nom du section et ajouter l'image=======================//
                $directoryAC = $this->get('app.image_uploader')->targetDir . "/$user" . "/$id_qq" . "/apropos";

                if (!is_dir($directoryAC)) {
                    mkdir($directoryAC, 0777);
                    if (!empty($_FILES['apropos']['tmp_name']['image_apropos'])) {
                        $file = $_FILES['apropos']['tmp_name']['image_apropos'];
                        $fileUpload = $directoryAC . $ds . $imageNom;
                        $direct = move_uploaded_file($file, $fileUpload);
                    }
                } else {
                    if (!empty($_FILES['apropos']['tmp_name']['image_apropos'])) {
                        $file = $_FILES['apropos']['tmp_name']['image_apropos'];
                        $fileUpload = $directoryAC . $ds . $imageNom;
                        $direct = move_uploaded_file($file, $fileUpload);
                    }
                }
                //============================fin ajouter image=======================//
                $hotels = new Hotel();
                $hotels->setQouiqui($qq);
                $apropos = $request->get('apropos');
                $apropos['image_apropos'] = $imageNom;
                $json_data = json_encode($apropos);
                $hotels->setAbout($json_data);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($hotels);
            $em->flush($hotels);
            return $this->redirect($_SERVER['PHP_SELF']);
        } else {
            die('Quoiqui non existe');
        }
        die;
    }

    public function editAproposAction(request $request, $id_qq, $id_ap)
    {
        $user = $this->getUser()->getId();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneBy(array("user" => $user, 'id' => $id_qq));
        $qq_id = $qq->getId();
        $hotel = $this->getDoctrine()->getRepository('AdminBundle:Hotel')->findOneBy(array("qouiqui" => $qq, 'id' => $id_ap));
        $descriptionNews = json_decode($hotel->getAbout(), true);
        $imageSerOld = $descriptionNews['image_apropos'];
        $apropos_details = $request->get('apropos')['apropos_details'];
        if ($_POST) {
            if ($qq && $hotel) {
                $em = $this->getDoctrine()->getManager();

                //============================debut Edit image=======================//
                $ext = '.jpg';
                $imageNew = uniqid() . $ext;
                $ds = DIRECTORY_SEPARATOR;
                //==========================Dossier du section Services==================//
                $directoryEv = $_SERVER['PHP_DOCUMENT_ROOT'] . '/web/annuaire/web/uploads/image/' . $user . '/' . $qq_id . '/apropos';
                //==========================En cas où il veut changer l'image du Actualités==================//
                if (!empty($_FILES['apropos']['tmp_name']['image_apropos'])) {
                    if (is_dir($directoryEv)) {
                        $file = $_FILES['apropos']['tmp_name']['image_apropos'];
                        $fileUpload = $directoryEv . $ds . $imageNew;
                        $direct = move_uploaded_file($file, $fileUpload);
                    }
                    if (!empty($apropos_details)) {
                        $apropos = $request->get('apropos');
                        $apropos['image_apropos'] = $imageNew;
                        $apropos_encode = json_encode($apropos);
                    } else {
                        return $this->render('ModuleBundle:Module:hotel\page404.html.twig');
                    }

                } //==========================En cas où  l'image du service ne doit pas etre changer==================//
                else {
                    if (!empty($apropos_details)) {
                        $apropos = $request->get('apropos');
                        $apropos['image_apropos'] = $imageSerOld;
                        $apropos_encode = json_encode($apropos);
                    } else {
                        return $this->render('ModuleBundle:Module:hotel\page404.html.twig');
                    }
                }
                $hotel->setAbout($apropos_encode);
                $em->persist($hotel);
                $em->flush();
                return $this->redirect($_SERVER['PHP_SELF']);

            } else {
                die('Non existe!');
            }
        }
        die;
    }

    //===================================End Code a propos===================================//


    //===================================Begin Code Horaires===================================//
    public function ajouterHorairesAction(request $request, $id_qq)
    {
        if (isset($_POST)) {
            $user = $this->getUser()->getId();
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
                ->findOneBy(array('user' => $user, 'id' => $id_qq));
            $id_qq = $qq->getId();
            $hotel = $this->getDoctrine()->getRepository('AdminBundle:Hotel')
                ->findBy(array('qouiqui' => $qq));

            if ($qq) {
                $hotels = new Hotel();
                $hotels->setQouiqui($qq);
                $h = $_POST;
                $json_data = json_encode($h);
                $hotels->setHoraires($json_data);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($hotels);
            $em->flush($hotels);
            return $this->redirect($_SERVER['PHP_SELF']);
        } else {
            die('Quoiqui non existe');
        }
        die;
    }

    public function modifierHorairesAction(request $request, $id_qq, $id_ho)
    {
        $user = $this->getUser()->getId();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneBy(array("user" => $user, 'id' => $id_qq));
        $qq_id = $qq->getId();
        $hotel = $this->getDoctrine()->getRepository('AdminBundle:Hotel')->findOneBy(array("qouiqui" => $qq, 'id' => $id_ho));
        $horaires = json_decode($hotel->getHoraires(), true);
        if ($_POST) {

            if ($qq && $hotel) {
                $em = $this->getDoctrine()->getManager();
//                dump($request->get('horaires'));
//                die;
                $horaires = $request->get('horaires');
                $apropos_encode = json_encode($horaires);
                $hotel->setHoraires($apropos_encode);
                $em->persist($hotel);
                $em->flush();
                return $this->redirect($_SERVER['PHP_SELF']);

            } else {
                die('Non existe!');
            }
        }
        die;
    }
    //===================================End Code Horaires===================================//

//==================================Slider=====================================//
    public function storeFolderAction($id_qq)
    {

        $ds = DIRECTORY_SEPARATOR;
        $em = $this->getDoctrine()->getManager();
        $iduser = $this->getUser()->getId();
        $qq = $em->getRepository('AdminBundle:Qouiqui')->findOneBy(array('user' => $iduser));
        $id_qq = $qq->getId();

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$iduser")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$iduser");
        endif;
        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq");
        endif;

        if (!is_dir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/slider")):
            mkdir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/slider", 0777);
            chmod($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/slider", 0777);
        endif;

        $storeFolder = $file = $this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/slider";

        if (!empty($_FILES)) {


            $tempFile = $_FILES['file']['tmp_name'];

            $targetPath = $storeFolder . $ds;

            $fileName = md5(uniqid(rand(), true));

            $targetFile = $targetPath . $fileName . '.' . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            move_uploaded_file($tempFile, $targetFile);

        } else {

            $result = array();

            $files = scandir($storeFolder);

            if (false !== $files) {
                foreach ($files as $file) {
                    if ('.' != $file && '..' != $file) {
                        $obj['name'] = $file;
                        $obj['size'] = filesize($storeFolder . $ds . $file);
                        $result[] = $obj;
                    }
                }
            }

            header('Content-type: text/json');
            header('Content-type: application/json');
            echo json_encode($result);
        }

        die();
    }

    Public function DeleteFileAction($id_qq)
    {


        $toDelete = $_POST['filetodelete'];
        $id = $_POST['id'];

        $iduser = $this->getUser()->getId();
        $file = $this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id" . "/slider" . "/$toDelete";

        unlink($file);

        die;
    }

    public function tmpfolderAction(Request $request, $qq_id)
    {

        if (isset($_POST)) {


            $em = $this->getDoctrine()->getManager();
            $iduser = $this->getUser()->getId();

            $id_qq = $qq_id;

            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$iduser")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$iduser");
            endif;
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq");
            endif;

            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/tmp")):

                mkdir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/tmp", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/tmp", 0777);
            endif;


            $i = 0;
            foreach ($_POST as $img) {
                $ext = pathinfo($img, PATHINFO_EXTENSION);

                copy($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/slider/" . $img, $this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/tmp/" . $i . '.' . $ext);
                dump($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/tmp/" . $i . '.' . $ext);
                $i += 1;
            }


            $this->recurseRmdir($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/slider");

            rename($this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/tmp", $this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id_qq" . "/slider");


            return $this->redirect($_SERVER['PHP_SELF']);

        }

    }
//==================================Slider=====================================//
//==================================Gallery=====================================//
    public function galleryAction(Request $request, $id_qq)
    {

        if ($_FILES) {
            $idUser = $this->getUser()->getId();
            #creation dossier avec l'id de l'utilisateur si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser", 0777);
            endif;
            #creation dossier avec l'id de QUOIQUI si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/", 0777);
            endif;

            #creation dossier gallery si n'existe pas
            if (!is_dir($this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/gallery")):
                mkdir($this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/gallery", 0777);
                chmod($this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/gallery", 0777);
            endif;

            $this->uploadFile($_FILES, $this->get('app.image_uploader')->targetDir . "/$idUser/$id_qq/gallery/");

            die;


        }

    }

//==================================Gallery=====================================//
//==================================Delete Gallery=====================================//
    Public function DeleteFileFromGalleryAction($id_qq)
    {
        $toDelete = $_POST['filetodelete'];
        $id = $_POST['id'];

        $iduser = $this->getUser()->getId();
        $file = $this->get('app.image_uploader')->targetDir . "/$iduser" . "/$id" . "/gallery" . "/$toDelete";

        unlink($file);

        die;
    }
//==================================Delete Gallery=====================================//

//=================recurseRmdir=============//
    function recurseRmdir($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? recurseRmdir("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
    //===============recurseRmdir===============//
    //========================Upload File==========//
    function uploadFile($file, $src, $name = null)
    {

        if ($file) {
            $tempFile = $file['file']['tmp_name'];
            if (!$name)
                $name = md5(uniqid(rand(), true));
//            $targetFile = $src . $name . '.' . pathinfo($file['file']['name'], PATHINFO_EXTENSION);
            $targetFile = $src . $name . '.jpg';
            move_uploaded_file($tempFile, $targetFile);
            chmod($targetFile, 0777);
            return true;
        } else {
            return false;
        }
        return false;
    }
    //========================Upload File==========//

    //    ===========================Begin Booking Room=======================//
    public function bookingAction($id_qq, $id_ch)
    {
        $em = $this->getDoctrine()->getManager();
        if (isset($_POST)) {
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneBy(array("id" => $id_qq));
            if ($qq->getUser()->getId() != $this->getUser()->getId()) {
                $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneBy(array("id" => $id_qq));
                $hotel = $this->getDoctrine()->getRepository('AdminBundle:Hotel')->findOneBy(array("qouiqui" => $qq, 'id' => $id_ch));
                $descriptionRoom = json_decode($hotel->getDescriptionRoom(), true);
                $email_client = $this->getUser()->getEmail();
                $name_client = $this->getUser()->getUsername();
                $prenom_client = $this->getUser()->getPrenom();
                $mobile_client = $this->getUser()->getPhoneNumber();
                $emailto = $qq->getMail();
                $date = new \DateTime();
                $info = json_encode($_POST);

                $service = $descriptionRoom['nombre'] . '/' . $descriptionRoom['nombreLit'];
                $price = $descriptionRoom['prix'];
                $dateDebut = $_POST['dateDebut'];
                $dateFin = $_POST['dateFin'];

                $User = $this->getUser();
                $booking = new Booking();
                $booking->setUser($User);
                $booking->setQouiqui($qq);
                $booking->setDate($date);
                $booking->setData($info);
                $em->persist($booking);
                $em->flush($booking);


                $message = \Swift_Message::newInstance()
                    ->setSubject('Reservation')
                    ->setFrom('noreply@ween.tn')
                    ->setTo('hatem.dev.app@gmail.com')
                    ->setBody(
                        $this->renderView(
                            'hotelLayaout/emailHotel.html.twig', array('nom' => $name_client,
                                'prenom' => $prenom_client,
                                'numero' => $mobile_client,
                                'mail' => $email_client,
                                'typeChambre' => $service,
                                'prix' => $price,
                                'darrive' => $dateDebut,
                                'dDepart' => $dateFin)
                        ),
                        'text/html'
                    );
                $this->get('mailer')->send($message);

                $response = new Response(
                    $this->get('mailer')->send($message), Response::HTTP_OK, array('Content-type' => 'application/json')
                );

//                return $response;
                return $this->redirect($_SERVER['PHP_SELF']);

            }


        }

    }
    //    ===========================End Booking Room=======================//

    //    ===========================Begin Booking Events=======================//
    public function bookingEventsAction($id_qq, $id_ev)
    {
        $em = $this->getDoctrine()->getManager();
        if (isset($_POST)) {
            $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneBy(array("id" => $id_qq));
            if ($qq->getUser()->getId() != $this->getUser()->getId()) {
                $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')->findOneBy(array("id" => $id_qq));
                $hotel = $this->getDoctrine()->getRepository('AdminBundle:Hotel')->findOneBy(array("qouiqui" => $qq, 'id' => $id_ev));
                $descriptionRoom = json_decode($hotel->getDescriptionEvents(), true);
                $email_client = $this->getUser()->getEmail();
                $name_client = $this->getUser()->getUsername();
                $prenom_client = $this->getUser()->getPrenom();
                $mobile_client = $this->getUser()->getPhoneNumber();
                $emailto = $qq->getMail();
                $date = new \DateTime();
                $info = json_encode($_POST);
                $name_events = $descriptionRoom['nameEvents'];
                $User = $this->getUser();
                $booking = new Booking();
                $booking->setUser($User);
                $booking->setQouiqui($qq);
                $booking->setDate($date);
                $booking->setData($info);
                $em->persist($booking);
                $em->flush($booking);


                $message = \Swift_Message::newInstance()
                    ->setSubject('Reservation')
                    ->setFrom('noreply@ween.tn')
                    ->setTo('hatem.dev.app@gmail.com')
                    ->setBody(
                        $this->renderView(
                            'hotelLayaout/emailBookingEventsHotel.html.twig', array('nom' => $name_client,
                                'prenom' => $prenom_client,
                                'numero' => $mobile_client,
                                'mail' => $email_client,
                                'nEvents' => $name_events,
                            )
                        ),
                        'text/html'
                    );

                $response = new Response(
                    $this->get('mailer')->send($message), Response::HTTP_OK, array('Content-type' => 'application/json')
                );

//                return $response;


            }


        }
        return $this->redirect($_SERVER['PHP_SELF']);

    }

    //    ===========================End Booking Events=======================//


//    ========================delete color========================== //
    public function deleteColorAction($id_qq)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $qq = $em->getRepository('AdminBundle:Qouiqui')
            ->findOneBy(array('user' => $user, 'id' => $id_qq));
        if ($id_qq = $qq) {
            $userQQ = $qq->getUser()->getId();
            if ($user = $userQQ) {
                $theme = $em->getRepository('AdminBundle:Theme')
                    ->findOneBy(array('qouiqui' => $id_qq));
                $em->remove($theme);
                $em->flush($theme);
                return $this->redirect($_SERVER['PHP_SELF']);
            }
        } else {
            die('page non existe!');
        }

        die;
    }
//    ========================delete color========================== //

//    =========================Fonction resize image base 64 =====================//
//    public function save_base64_image($base64_image_string, $output_file_without_extension, $path_with_end_slash = "")
//    {
//
//        //usage:  if( substr( $img_src, 0, 5 ) === "data:" ) {  $filename=save_base64_image($base64_image_string, $output_file_without_extentnion, getcwd() . "/application/assets/pins/$user_id/"); }
//        //
//        //data is like:    data:image/png;base64,asdfasdfasdf
//        $splited = explode(',', substr($base64_image_string, 5), 2);
//        $mime = $splited[0];
//        $data = $splited[1];
//
//        $mime_split_without_base64 = explode(';', $mime, 2);
//        $mime_split = explode('/', $mime_split_without_base64[0], 2);
//        if (count($mime_split) == 2) {
//            $extension = $mime_split[1];
//            if ($extension == 'jpeg') $extension = 'jpg';
//            $output_file_with_extension = $output_file_without_extension . '.' . $extension;
//        }
//        file_put_contents($path_with_end_slash . $output_file_with_extension, base64_decode($data));
//        return $output_file_with_extension;
//    }








    function ficheServicesAction(Request $request)
    {
        $quoiqui = $request->get('quoiqui');

        return $this->render('@User/template/fiche/hotel/services.html.twig', [
            'attributes' => $request->attributes->all(),

        ]);
    }


    function ficheAnnoncesAction(Request $request)
    {

//        $str = 'Ceci est une chaîne encodée';
//        echo base64_encode($str);
//
//
//
//
//        die();
        $quoiqui = $request->get('quoiqui');

        return $this->render('@User/template/fiche/hotel/annonces.html.twig', [
            'attributes' => $request->attributes->all(),
        ]);
    }
}

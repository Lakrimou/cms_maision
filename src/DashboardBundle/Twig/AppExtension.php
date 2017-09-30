<?php

namespace DashboardBundle\Twig;
/**
 * Created by PhpStorm.
 * User: Hatem
 * Date: 21/04/2017
 * Time: 15:47
 */
class AppExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('base64Decode', array($this, 'base64DecodeFilter'))
        );
    }

    public function base64DecodeFilter($str)
    {
        return base64_encode($str);
    }

    public function getFunctions()
    {
        return array(
            'eventTime' => new \Twig_Function_Method($this, 'eventTime'),
            'eventLength' => new \Twig_Function_Method($this, 'eventLength'),
            'jsonDecod' => new \Twig_Function_Method($this, 'jsonDecod'),
            'DirParcour' => new \Twig_Function_Method($this, 'DirParcour'),
            'DirAssetParcour' => new \Twig_Function_Method($this, 'DirAssetParcour'),
            'randomAnnonce' => new \Twig_Function_Method($this, 'randomAnnonce'),
            'asset_exists' => new \Twig_Function_Method($this, 'asset_exists'),
            'spaCarte' => new \Twig_Function_Method($this, 'spaCarte'),
            'spaService' => new \Twig_Function_Method($this, 'spaService'),
            'spaEvent' => new \Twig_Function_Method($this, 'spaEvent'),
            'Couleur' => new \Twig_Function_Method($this, 'Couleur'),
            'getColorModule' => new \Twig_Function_Method($this, 'getColorModule'),
            'getColorModuleJSON' => new \Twig_Function_Method($this, 'getColorModuleJSON'),
            'browseAutomobileOfferImage' => new \Twig_Function_Method($this, 'browseAutomobileOfferImage'),
            'deleteFile' => new \Twig_Function_Method($this, 'deleteFile'),
            'patternImage' => new \Twig_Function_Method($this, 'patternImage'),
            'spaBook' => new \Twig_Function_Method($this, 'spaBook'),
            'spaNouveauCarte' => new \Twig_Function_Method($this, 'spaNouveauCarte'),
            'encodeData' => new \Twig_Function_Method($this, 'encodeData'),
            'getData' => new \Twig_Function_Method($this, 'getData'),
            'getTrainer' => new \Twig_Function_Method($this, 'getTrainer'),
            'cfService' => new \Twig_Function_Method($this, 'cfService'),
            'cfEvent' => new \Twig_Function_Method($this, 'cfEvent'),
            'toAscii' => new \Twig_Function_Method($this, 'toAscii'),
            'uniqueId' => new \Twig_Function_Method($this, 'uniqueId'),
            'filterService' => new \Twig_Function_Method($this, 'filterService'),
            'filterListServiceHuissier' => new \Twig_Function_Method($this, 'filterListServiceHuissier'),
            'filterListServiceAmbu' => new \Twig_Function_Method($this, 'filterListServiceAmbu'),
            'filterListServiceKine' => new \Twig_Function_Method($this, 'filterListServiceKine'),
            'filterListequipementKine' => new \Twig_Function_Method($this, 'filterListequipementKine'),
            'urlToEmbded' => new \Twig_Function_Method($this, 'urlToEmbded'),


            'translateDate' => new \Twig_Function_Method($this, 'translateDate'),
            'translateJourDate' => new \Twig_Function_Method($this, 'translateJourDate'),

            'centreFormationAd' => new \Twig_Function_Method($this, 'centreFormationAd'),
            'centreFormationcategorie' => new \Twig_Function_Method($this, 'centreFormationcategorie'),
            'centreFormationCatego' => new \Twig_Function_Method($this, 'centreFormationCatego'),
            'browseArchitectureServiceImage' => new \Twig_Function_Method($this, 'browseArchitectureServiceImage'),
            'browseLocationAutomobile' => new \Twig_Function_Method($this, 'browseLocationAutomobile'),


        );
    }

    public function urlToEmbded($url)
    {
        #youtube
        if ((strpos($url, "youtube.com/watch?v") !== false) or (strpos($url, "youtu.be/") !== false)) {
            $url = preg_replace(
                "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
                "//www.youtube.com/embed/$2",
                $url
            );
            return $url;
        }


        #dalimotion
        if (preg_match('!^.+dailymotion\.com/(video|hub)/([^_]+)[^#]*(#video=([^_&]+))?|(dai\.ly/([^_]+))!', $url, $m)) {
            $dailymotion = '//www.dailymotion.com/embed/video/';
            if (isset($m[6])) {
                return $dailymotion . $m[6];
            }
            if (isset($m[4])) {
                return $dailymotion . $m[4];
            }
            return $dailymotion . $m[2];
        }

        if (preg_match('#(?:https?://)?(?:www.)?(?:player.)?vimeo.com/(?:[a-z]*/)*([0-9]{6,11})[?]?.*#', $url, $m)) {
            return $m[1];
        }

        return false;
    }

    public function translateDate($date)
    {

        setlocale(LC_TIME, "fr_FR");
        return utf8_encode(strftime('%A %d %B %Y', strtotime($date)));

    }

    public function translateJourDate($date)
    {

        setlocale(LC_TIME, "fr_FR");
        return utf8_encode(strftime(' %d %B ', strtotime($date)));

    }
    public function eventTime($time)
    {
        if ($time) {
            $time = json_decode($time, true);
            $time = $time['date_start'] . ' - ' . $time['date_end'];
            return $time;
        } else
            return false;
    }

    public function eventLength($maxCh)
    {
        if ($maxCh) {
            $maxCh = substr($maxCh, 0, 80);

            return $maxCh;
        } else
            return false;
    }

    public function jsonDecod($tab)
    {

        return json_decode($tab, true);

    }

    public function DirParcour($idUser, $qq_id, $id)
    {

        $rp = $_SERVER['PHP_DOCUMENT_ROOT'] . "/web/annuaire/web/uploads/image/$idUser/$qq_id/annonce/annonce" . $id . "/";

        if (is_dir($rp)) {
            $img_annonce = array();

            $rep = opendir($rp);
            while ($sous_fichier = readdir($rep)) {
                if (($sous_fichier == ".") || ($sous_fichier == "..")) {
                    echo "";
                } else {
                    $img_annonce[] = $sous_fichier;
                }
            }
            closedir($rep);
        } else {

            $img_annonce = false;
        }

        return $img_annonce;

    }

    public function DirAssetParcour($path)
    {


        $rp = $_SERVER["PHP_DOCUMENT_ROOT"] . '/web/annuaire/web' . $path;

        if (is_dir($rp)) {
            $directory = array();

            $rep = opendir($rp);
            while ($sous_fichier = readdir($rep)) {
                if (($sous_fichier == ".") || ($sous_fichier == "..")) {
                    echo "";
                } else {
                    $directory[] = $sous_fichier;
                }
            }
            closedir($rep);
        } else {

            $directory = false;
        }

        return $directory;

    }

    public function randomAnnonce($tab)
    {

        if (sizeof($tab) > 2) {
            shuffle($tab);
            return array($tab[0], $tab[1]);
        } else {
            return $tab;

        }


    }

    public function asset_exists($path)
    {

        $webRoot = $_SERVER["PHP_DOCUMENT_ROOT"] . '/web/annuaire/web';
        $toCheck = $webRoot . $path;

//        return var_dump($path,$webRoot,$toCheck);

        // check if the file exists
        if (!is_file($toCheck)) {
            return false;
        }

        // check if file is well contained in web/ directory (prevents ../ in paths)
        if (strncmp($webRoot, $toCheck, strlen($webRoot)) !== 0) {
            return false;
        }

        return true;
    }


    public function toAscii($data)
    {


        $arr1 = str_split($data);

        $result = "";
        foreach ($arr1 as $str) {
            $char = ord($str);
            $result = $result . ' ' . $char;
        }
        return $result;
    }


    public function spaCarte($carte)
    {

        foreach ($carte as $c) {

            $a[$c->getDesignation()][] = $c;
        }


        if (!empty($a)) {
            return $a;
        } else {
            return null;
        }
    }

    public function spaService($module)
    {

        foreach ($module as $c) {
            if ($c->getSection() == 'service') {

                $a[$c->getNom()] = $c;
            }


        }
        if (!empty($a)) {
            return $a;
        } else {
            return null;
        }


    }

    public function cfService($module)
    {

        foreach ($module as $c) {
            if ($c->getSection() == 'service') {

                $a[$c->getData()] = $c;
            }


        }
        if (!empty($a)) {
            return $a;
        } else {
            return null;
        }


    }

    public function getTrainer($module)
    {

        foreach ($module as $c) {
            if ($c->getSection() == 'trainer') {

                $a[$c->getData()] = $c;
            }


        }
        if (!empty($a)) {
            return $a;
        } else {
            return null;
        }


    }

    public function spaEvent($module)
    {

        foreach ($module as $c) {
            if ($c->getSection() == 'event'):

                $a[$c->getNom()] = $c;
            endif;
        }


        if (!empty($a)) {
            return $a;
        } else {
            return null;
        }
    }

    public function cfEvent($module)
    {

        foreach ($module as $c) {
            if ($c->getSection() == 'event'):

                $a[$c->getData()] = $c;
            endif;
        }


        if (!empty($a)) {
            return $a;
        } else {
            return null;
        }
    }

    public function spaBook($module)
    {

        foreach ($module as $c) {
            if ($c->getSection() == 'booking'):

                $a[$c->getData()] = $c;
            endif;
        }


        if (!empty($a)) {
            return $a;
        } else {
            return null;
        }
    }

    public function centreFormationAd($module)
    {

        foreach ($module as $c) {
            if ($c->getSection() == 'autre'):

                $a[$c->getData()] = $c;
            endif;
        }


        if (!empty($a)) {
            return $a;
        } else {
            return null;
        }
    }

    public function centreFormationcategorie($module)
    {

        foreach ($module as $m) {
            if ($m->getSection() == 'categorie') {
                $categorie = $m->getData();
//                $a[$m->getData()] = $m;
                $cat = json_decode($categorie, true);
                $categories = explode(', ', ($cat['categorie']));
//                $c = json_decode($categorie, true);

            }
        }
        if (!empty($categories)) {
            return $categories;
        } else {
            return null;
        }
    }

    public function centreFormationCatego($module)
    {

        foreach ($module as $m) {
            if ($m->getSection() == 'categorie') {

                $a[$m->getData()] = $m;

//                $c = json_decode($categorie, true);

            }
        }
        if (!empty($a)) {
            return $a;
        } else {
            return null;
        }
    }

    public function spaNouveauCarte($module)
    {

        foreach ($module as $c) {
            if ($c->getSection() == 'autre'):

                $a[$c->getDesignation()] = $c;
            endif;
        }


        if (!empty($a)) {
            return $a;
        } else {
            return null;
        }
    }

    public function Couleur($module)
    {
        foreach ($module as $m) {
            if ($m->getCouleur() != null) {
                $color = $m->getCouleur();
                return json_decode($color, true);
            } else {
                return false;
            }
        }
    }

    public function getData($slideData)
    {
        foreach ($slideData as $m) {
            if ($m->getSection() == 'slider') {

                $p[$m->getData()] = $m;

            }
            if (!empty($p)) {
                return $p;
            } else {
                return null;
            }


        }

    }

    public function getColorModule($module)
    {
        foreach ($module as $m) {
            if ($m->getCouleur() != null) {
                $color = $m->getCouleur();
                $c = json_decode($color, true);
                return $c['Couleur'];
            } else {
                return false;
            }
        }
    }

    public function getColorModuleJSON($theme)
    {


        return json_encode($theme);

    }

    public function encodeData($qouiqui)
    {
        $qq_data = json_decode($qouiqui->getData(), true);
        return $qq_data;
    }

    public function browseAutomobileOfferImage($idUser, $qq_id, $id)
    {


        $rp = $_SERVER['PHP_DOCUMENT_ROOT'] . "/web/annuaire/web/uploads/image/$idUser/$qq_id/Offres/" . $id . "/";

        if (is_dir($rp)) {
            $img_annonce = array();

            $rep = opendir($rp);
            while ($sous_fichier = readdir($rep)) {
                if (($sous_fichier == ".") || ($sous_fichier == "..")) {
                    echo "";
                } else {
                    $img_annonce[] = $sous_fichier;
                }
            }
            closedir($rep);
        } else {

            $img_annonce = false;
        }

        return $img_annonce;

    }

    public function deleteFile($path)
    {
        $file = $_SERVER['PHP_DOCUMENT_ROOT'] . "/web/annuaire/web/uploads/image/" . $path;
        if (file_exists($file)) {
            unlink($file);
        }

    }

    public function patternImage()
    {


        $rp = $_SERVER['PHP_DOCUMENT_ROOT'] . "/web/annuaire/web/module/spa/patterns/";

        if (is_dir($rp)) {
            $pattern = array();

            $rep = opendir($rp);
            while ($sous_fichier = readdir($rep)) {
                if (($sous_fichier == ".") || ($sous_fichier == "..")) {
                    echo "";
                } else {
                    $pattern[] = $sous_fichier;
                }
            }
            closedir($rep);
        } else {

            $pattern = false;
        }

        return $pattern;

    }

    public function browseArchitectureServiceImage($idUser, $qq_id, $id)
    {
        $rp = $_SERVER['PHP_DOCUMENT_ROOT'] . "/web/annuaire/web/uploads/image/$idUser/$qq_id/Service/" . $id . "/";

        if (is_dir($rp)) {
            $img_annonce = "";

            $rep = opendir($rp);
            while ($sous_fichier = readdir($rep)) {
                dump($sous_fichier);

                if (($sous_fichier == ".") || ($sous_fichier == "..")) {
                    echo "";
                } else {
                    $img_annonce = $sous_fichier;
                }
            }
            die();
            closedir($rep);
        } else {

            $img_annonce = false;
        }


        return $img_annonce;


    }

    public function uniqueId()
    {

        return (uniqid());
    }

    function filterService($attributes)
    {
        $array1 = array('Coup de peigne', 'Coup', 'cil a cil', 'Vernis permenent', 'Soin de lux (manucure)', 'Soin botox fiberceutic'
        , 'Soin botox fiberceutic', 'Coloration racine inoa', 'Babylis brushing', 'Coloration majirel', 'Soin anti-ride',
            'Soin soleil', 'Soin hydratation', 'Soin hydratation', 'Soin eclaircisant', 'Stimulation des muscules'
        , 'Epilation sourcils', 'Epilation menton', 'Aisselles', 'Avant bras (sucre)', 'Jambe complète (cire)', 'Maillot classique',
            'Corps complet (cire)', 'Epilation pour tour du visage', 'Epilation ventre', 'Soin purifiant', 'Combiné machine', 'Soin hydradermi basic selon le type de peau',
            'Hammam+gommage+savon marocain+enveloppement', 'Massage relaxant 1h', 'Combiné machine', 'Massage pierre chaude', 'Soin thalasso visage', ' Réflexologie palmaire', 'Soin modelant des yeux',
            'Soin tendresse', 'Soin basic Soin spécifique');
        $new = array();
        if (!empty($attributes['theme']['service'])) {
            $array = $attributes['theme']['service'];
            foreach ($array as $a) {
                $tab[] = $a['ServSpa'];

            }
        }
        else {
            $tab = null;
        }
        if ($tab != null) {
            $reslt = array_merge($tab, $array1);
        } else {
            $reslt = $array1;
        }


        foreach ($reslt as $k => $v) {
            $new[$v] = $k;
        }
        return $new;
    }
    function filterListServiceHuissier($attributes){
        $array1=array('La rédaction et la signification des actes', 'Le conseil juridique aux particuliers et aux entreprises','L’exécution des décisions de justice','Les constats',
'Solutionner vos conflits locatifs','Solutionner vos conflits de voisinage','Le recouvrement amiable','Le recouvrement judiciaire','Les Jeux et Concours ');
        $new = array();
        if (!empty($attributes['theme']['service'])) {
            $array = $attributes['theme']['service'];
            foreach ($array as $a) {
                $tab[] = $a['mission'];

            }
        } else {
            $tab = null;
        }
        if ($tab != null) {
            $reslt = array_merge($tab, $array1);
        } else {
            $reslt = $array1;
        }


        foreach ($reslt as $k => $v) {
            $new[$v] = $k;
        }
        return $new;
    }
     function filterListServiceAmbu($attributes){
         $array1=array('Transports en ambulance pour des séances de radiothérapie','Transports en Ambulance pour des séances de dialyses','Transports en ambulance pour des séances de rééducation',
                            'Transports en ambulance pour des séances de chimiothérapie','Transports en ambulance pour permission de week-end','Transports d\'urgence en ambulance',
                            'Transports en ambulance pour des séances de radiothérapie',
                                'Transports en ambulance pour un rapatriement sanitaire','Transports en ambulance longue distance','Transports en Ambulance pour une sortie d\'hospitalisation','Transports en Ambulance pour une hospitalisation'
                                ,'Le transport médicalisé','Le transport sanitaire');


         $new = array();
         if (!empty($attributes['theme']['service'])) {
             $array = $attributes['theme']['service'];
             foreach ($array as $a) {
                 $tab[] = $a['mission'];

             }
         }
         else {
             $tab = null;
         }
         if ($tab != null) {
             $reslt = array_merge($tab, $array1);
         } else {
             $reslt = $array1;
         }


         foreach ($reslt as $k => $v) {
             $new[$v] = $k;
         }
         return $new;
     }
    function filterListServiceKine($attributes){
        $array1=array('Kinésithérapie Générale - Autres','Kinésithérapie gynécologiques','Kinésithérapie en pédiatrie',
            'Recommandations pour les patients','Kinésithérapie en rhumatologie','Kinésithérapie en orthopédie',
            'Kinésithérapie neurologique',
            'Kinésithérapie du sport','Physiothérapie posturale. Chaînes musculaires','Kinésithérapie en gériatrie','Kinésithérapie respiratoire'
        ,'Thérapies naturelles','Électrothérapie','Kinésithérapie esthétique');


        $new = array();
        if (!empty($attributes['theme']['service'])) {
            $array = $attributes['theme']['service'];
            foreach ($array as $a) {
                $tab[] = $a['ServSpa'];

            }
        }
        else {
            $tab = null;
        }
        if ($tab != null) {
            $reslt = array_merge($tab, $array1);
        } else {
            $reslt = $array1;
        }


        foreach ($reslt as $k => $v) {
            $new[$v] = $k;
        }
        return $new;
    }

    function filterListequipementKine($attributes){
        $array1=array('Balnéothérapie','Controle et mesure','Coussin',
            'Cryothérapie - Compresse froide','Hygiène','Laser','Réeducation Vestibulaire','Strapping','Table massage électrique','Table massage hydraulique','Table massage pliante',
            'Mobilier','Onde de choc','Ostéologie','Pressothérapie','Poulietherapie','Rééducation main','Rééducation marche','Rééducation respiratoire',
            'Table massage fixe','Thermothérapie - Compresse chaude','Traction','Uro-gynécologie'
        ,'Ultrason','Vélo-ergomètre médical Monark');


        $new = array();
        if (!empty($attributes['theme']['event'])) {
            $array = $attributes['theme']['event'];
            foreach ($array as $a) {
                $tab[] = $a['ServSpa'];

            }
        }
        else {
            $tab = null;
        }
        if ($tab != null) {
            $reslt = array_merge($tab, $array1);
        } else {
            $reslt = $array1;
        }


        foreach ($reslt as $k => $v) {
            $new[$v] = $k;
        }
        return $new;
    }
    public function browseLocationAutomobile($idUser, $qq_id, $id)
    {
        $rp = $_SERVER['PHP_DOCUMENT_ROOT'] . "/web/annuaire/web/uploads/image/$idUser/$qq_id/vehicule/" . $id . "/";

        if (is_dir($rp)) {
            $img_annonce = array();

            $rep = opendir($rp);
            while ($sous_fichier = readdir($rep)) {
                if (($sous_fichier == ".") || ($sous_fichier == "..")) {
                    echo "";
                } else {
                    $img_annonce[] = $sous_fichier;
                }
            }
            closedir($rep);
        } else {

            $img_annonce = false;
        }

        return $img_annonce;

    }

}
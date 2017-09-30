<?php
/**
 * Created by PhpStorm.
 * User: Ameni
 * Date: 06/09/2017
 * Time: 15:57
 */

namespace ModuleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AdminBundle\Entity\MarksOptician;
use AdminBundle\Entity\ModelOptician;

class testAddMarkModelLentilsController extends Controller
{
    public function addMarksAction()
    {
        $em = $this->getDoctrine()->getManager();
        $array = array(0
        =>
            array("models"
            =>
                array("model0"
                =>
                    " 1-Day Acuvue Moist Multifocal "
                ,"model1"
                =>
                    " 1-Day Acuvue Moist Multifocal 90 "
                ,"model2"
                =>
                    " Acuvue Oasys with Hydraclear Plus "
                ,"model3"
                =>
                    " Acuvue Oasys 12 with Hydraclear Plus "
                ,"model4"
                =>
                    " Acuvue Oasys 24 with Hydraclear Plus "
                ,"model5"
                =>
                    " Acuvue Oasys for Presbyopia with Hydraclear Plus "
                ,"model6"
                =>
                    " Acuvue VITA ™ "
                ,"model7"
                =>
                    " 1-Day Acuvue 30 "
                ,"model8"
                =>
                    " 1-Day Acuvue 90 "
                ,"model9"
                =>
                    " 1-Day Acuvue Moist 180 "
                ,"model0"
                =>
                    " 1-Day Acuvue Moist 30 "
                ,"model1"
                =>
                    " 1-Day Acuvue Moist 90 "
                ,"model2"
                =>
                    " 1 Day Acuvue Moist for Astigmatism 30 "
                ,"model3"
                =>
                    " 1 Day Acuvue TruEye 180 "
                ,"model4"
                =>
                    " 1 Day Acuvue TruEye 30 "
                ,"model5"
                =>
                    " 1 Day Acuvue TruEye 90 "
                ,"model6"
                =>
                    " Acuvue 2 "
                ,"model7"
                =>
                    " Acuvue Advance with Hydraclear "
                ,"model8"
                =>
                    " Acuvue Oasys 1 day 30 "
                ,"model9"
                =>
                    " Acuvue Oasys 1 day 90 "
                ,"model0"
                =>
                    " Acuvue Oasys 1 Day For Astigmatism 30 "
                ,"model1"
                =>
                    " Acuvue Oasys For Astigmatism "
                ),
                "name"
                =>
                    "acuvue"
            ),
            1
            =>
                array("models"
                =>
                    array("model0"
                    =>
                        " Air Optix Aqua "
                    ,"model1"
                    =>
                        " Air Optix Night & Day Aqua "
                    ,"model2"
                    =>
                        " Air Optix Plus Hydraglyde "
                    ,"model3"
                    =>
                        " Air Optix for Astigmatism "
                    ,"model4"
                    =>
                        " Air Optix Aqua Multifocal "
                    ,"model5"
                    =>
                        " Air Optix Colors "
                    ),
                    "name"
                    =>
                        "airoptix"
                ),
            2
            =>
                array("models"
                =>
                    array("model0"
                    =>
                        " Biofinity multifocal "
                    ,"model1"
                    =>
                        " Biofinity "
                    ,"model2"
                    =>
                        " Biofinity ENERGYS "
                    ,"model3"
                    =>
                        " Biofinity Toric 3 3 "
                    ,"model4"
                    =>
                        " Biofinity Toric 6 "
                    ,"model5"
                    =>
                        " Biofinity Toric XR 6 "
                    ),
                    "name"
                    =>
                        "biofinity"
                ),
            3
            =>
                array("models"
                =>
                    array("model0"
                    =>
                        " Biomedics 1 Day 90 "
                    ,"model1"
                    =>
                        " Biomedics 1 Day 30 "
                    ,"model2"
                    =>
                        " Biomedics 1 Day Toric 30 "
                    ,"model3"
                    =>
                        " Biomedics Evolution "
                    ,"model4"
                    =>
                        " Biomedics Toric "
                    ,"model5"
                    =>
                        " Biomedics Toric XR "
                    ,"model6"
                    =>
                        " Biomedics 1 Day Extra 30 "
                    ,"model7"
                    =>
                        " Biomedics 1 Day Extra 90 "
                    ),
                    "name"
                    =>
                        "biomedics"
                ),
            4
            =>
                array("models"
                =>
                    array("model0"
                    =>
                        " DAILIES TOTAL 1 30 "
                    ,"model1"
                    =>
                        " DAILIES TOTAL 1 90 "
                    ,"model2"
                    =>
                        " DAILIES AquaComfort Plus 30 "
                    ,"model3"
                    =>
                        " DAILIES AquaComfort Plus 90 "
                    ,"model4"
                    =>
                        " DAILIES AquaComfort Plus Toric 30 "
                    ,"model5"
                    =>
                        " DAILIES AquaComfort Plus Toric 90 "
                    ,"model6"
                    =>
                        " Dailies AquaComfort Plus Multifocal 30 "
                    ,"model7"
                    =>
                        " DAILIES TOTAL 1 Multifocal 30 "
                    ,"model8"
                    =>
                        " Dailies All Day Comfort 30 "
                    ,"model9"
                    =>
                        " Dailies All Day Comfort 90 "
                    ,"model0"
                    =>
                        " Dailies All Day Comfort Progressives 30 "
                    ,"model1"
                    =>
                        " Dailies All Day Comfort Toric 30 "
                    ,"model2"
                    =>
                        " Dailies All Day Comfort Toric 90 "
                    ),
                    "name"
                    =>
                        "dailies"
                ),
            5
            =>
                array("models"
                =>
                    array("model0"
                    =>
                        " FreshLook ColorBlends "
                    ,"model1"
                    =>
                        " FreshLook Colors "
                    ,"model2"
                    =>
                        " FreshLook Dimensions "
                    ,"model3"
                    =>
                        " FreshLook 1 Day "
                    ),
                    "name"
                    =>
                        "freshlook"
                ),
            6
            =>
                array("models"
                =>
                    array("model0"
                    =>
                        " PureVision 2 HD pour Astigmates "
                    ,"model1"
                    =>
                        " PureVision "
                    ,"model2"
                    =>
                        " PureVision 2 pour Presbytes "
                    ,"model3"
                    =>
                        " PureVision Multi-Focal "
                    ,"model4"
                    =>
                        " PureVision Torique "
                    ,"model5"
                    =>
                        " PureVision 2 HD "
                    ,"model6"
                    =>
                        " Ultra "
                    ),
                    "name"
                    =>
                        "purevision"
                ),
            7
            =>
                array("models"
                =>
                    array("model0"
                    =>
                        " SofLens 38 "
                    ,"model1"
                    =>
                        " SofLens 59 "
                    ,"model2"
                    =>
                        " SofLens Torique "
                    ,"model3"
                    =>
                        " SofLens daily disposable 30 "
                    ,"model4"
                    =>
                        " SofLens daily disposable 90 "
                    ,"model5"
                    =>
                        " SofLens daily disposable pour Astigmates 30 "
                    ,"model6"
                    =>
                        " SofLens Multi-focal "
                    ,"model7"
                    =>
                        " SofLens Natural Colors "
                    ),
                    "name"
                    =>
                        "soflens"
                ),
            8
            =>
                array("models"
                =>
                    array("model0"
                    =>
                        " Miru 1 day 30 "
                    ,"model1"
                    =>
                        " Miru 1 month "
                    ,"model2"
                    =>
                        " Miru 1 month Multifocal "
                    ,"model3"
                    =>
                        " Miru 1 month for Astigmatism "
                    ),
                    "name"
                    =>
                        "miru"
                ),
            9
            =>
                array("models"
                =>
                    array("model0"
                    =>
                        " PremiO "
                    ,"model1"
                    =>
                        " PremiO Toric "
                    ),
                    "name"
                    =>
                        "premio"
                ),
            10
            =>
                array("models"
                =>
                    array("model0"
                    =>
                        " Hydrofeel "
                    ,"model1"
                    =>
                        " Hydrofeel 1 Day 30 "
                    ,"model2"
                    =>
                        " Hydrofeel 55 Aspheric "
                    ,"model3"
                    =>
                        " Hydrofeel Toric "
                    ,"model4"
                    =>
                        " Ophtalmic 55 "
                    ,"model5"
                    =>
                        " Ophtalmic 55 Progressive "
                    ,"model6"
                    =>
                        " Ophtalmic 55 Toric "
                    ,"model7"
                    =>
                        " Ophtalmic Aspherique "
                    ,"model8"
                    =>
                        " Ophtalmic HR SPHERIC "
                    ,"model9"
                    =>
                        " Ophtalmic HR 1 Day 30 "
                    ,"model0"
                    =>
                        " Ophtalmic HR 1 Day 90 "
                    ,"model1"
                    =>
                        " Ophtalmic HR 1 Day Progressive 30 "
                    ,"model2"
                    =>
                        " Ophtalmic HR 1 Day Toric 30 "
                    ,"model3"
                    =>
                        " Ophtalmic HR SPHERIC BC 8,60 "
                    ,"model4"
                    =>
                        " Ophtalmic HR PROGRESSIVE "
                    ,"model5"
                    =>
                        " Ophtalmic HR TORIC "
                    ,"model6"
                    =>
                        " Ophtalmic MAX 2 "
                    ),
                    "name"
                    =>
                        "ophtalmic"
                )

        );
        foreach ($array as $element){
          $mark=new MarksOptician();
          $mark->setName($element['name']);
            $em->persist($mark);
            $em->flush();
            $em->refresh($mark);

            foreach ($element["models"] as $elementModel){
                $model=new ModelOptician();
                $model->setName($elementModel);
                $model->setMark($mark);
                $em->persist($model);
                $em->flush();
                $em->refresh($model);


            }
        }
        die();
    }
}
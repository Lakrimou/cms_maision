<?php

namespace ModuleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class EcommModeController extends Controller
{

    public function nouveauProduitAction(Request $request)
    {

        dump($_FILES);


        die();

        print_r($_POST);

        die();
    }
}

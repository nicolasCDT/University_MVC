<?php

namespace App\Controller;

require_once('../core/AbstractController.php');

use App\HTTP\Request;
use App\HTTP\Response;
use App\Models\repositories\AccountRepository;
use App\Service\QuizReader;

class MesCoursController extends AbstractController
{
    public function __construct() {
        parent::__construct();
        // Update routes :
        // Last: default page
        $this->routes["/maquettecours/"] = "maquettecours";
        $this->routes["/biologie/"] = "biologie";
        $this->routes["/chimie/"] = "chimie";
        $this->routes["/geographie/"] = "geographie";
        $this->routes["/histoire/"] = "histoire";
        $this->routes["/litterature/"] = "litterature";
        $this->routes["/physique/"] = "physique";
        $this->routes["/mesCours/"] = "mesCours";
        $this->routes["/qcm/"] = "qcm";
    }

    public function qcm(Request $request): Response {
        $qcmReader = $this->get(QuizReader::class);
        $qcmReader->setPath("mqc1.xml");
        $qcmReader->load();
        return new Response("");
    }

    public function mesCours(Request $request): Response {
        $response = new Response();

        $response->render("Cours/mesCours.html");
        return $response;
    }
    
    public function maquettecours(Request $request): Response {
        $response = new Response();

        $response->render("Cours/maquettecours.html");
        return $response;
    }

    public function biologie(Request $request): Response {
        $response = new Response();

        $response->render("Cours/biologie.html");
        return $response;
    }

    public function chimie(Request $request): Response {
        $response = new Response();

        $response->render("Cours/chimie.html");
        return $response;
    }

    public function geographie(Request $request): Response {
        $response = new Response();

        $response->render("Cours/geographie.html");
        return $response;
    }

    public function histoire(Request $request): Response {
        $response = new Response();

        $response->render("Cours/histoire.html");
        return $response;
    }

    public function litterature(Request $request): Response {
        $response = new Response();

        $response->render("Cours/litterature.html");
        return $response;
    }

    public function physique(Request $request): Response {
        $response = new Response();

        $response->render("Cours/physique.html");
        return $response;
    }

   
}
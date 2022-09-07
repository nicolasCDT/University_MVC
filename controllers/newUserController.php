<?php

namespace App\Controller;

require_once('../core/AbstractController.php');

use App\HTTP\Request;
use App\HTTP\Response;
use App\Models\repositories\AccountRepository;

class newUserController extends AbstractController
{
    public function __construct() {
        parent::__construct();
        // Update routes :
        // Last: default page
        $this->routes["/nouveaucompte/"] = "nouveaucompte";

    }

    public function nouveaucompte(Request $request): Response {
        $response = new Response();

        $response->render("admin/nouveaucompte.html");
        return $response;
    }

    public function connect(Request $request): Response {
        $response = new Response();
        $response->render("admin/nouveaucompte.html", []);
        return $response;

    }
}
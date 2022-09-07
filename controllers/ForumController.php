<?php

namespace App\Controller;

require_once('../core/AbstractController.php');

use App\HTTP\Request;
use App\HTTP\Response;
use App\Models\repositories\AccountRepository;

class ForumController extends AbstractController
{
    public function __construct() {
        parent::__construct();
        // Update routes :
        // Last: default page
        $this->routes["/newfil/"] = "newfil";
        $this->routes["/forumC/"] = "forumC";
        $this->routes["/affichetopic/"] = "affichetopic";
        $this->routes["/afftopicC/"] = "afftopicC";
        $this->routes["/forum/"] = "forum";
    }

    public function forum(Request $request): Response {
        $response = new Response();

        $response->render("Forum/forum.html");
        return $response;
    }
    public function forumC(Request $request): Response {
        $response = new Response();

        $response->render("Forum/forumC.html");
        return $response;
    }

    public function newfil(Request $request): Response {
        $response = new Response();

        $response->render("Forum/newfil.html");
        return $response;
    }

    public function affichetopic(Request $request): Response {
        $response = new Response();

        $response->render("Forum/affichetopic.html");
        return $response;
    }

    public function afftopicC(Request $request): Response {
        $response = new Response();

        $response->render("Forum/affichetopicC.html");
        return $response;
    }
}
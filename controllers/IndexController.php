<?php

namespace App\Controller;

require_once('../core/AbstractController.php');

use App\HTTP\Request;
use App\HTTP\Response;
use App\Models\repositories\AccountRepository;
use App\Service\SessionMgr;

class IndexController extends AbstractController
{
    private ?SessionMgr $session;

    public function __construct() {
        parent::__construct();
        // Update routes :
        // Last: default page
        //var_dump($this->get(SessionMgr::class));
        $this->routes["/connect\/(?<login>\w+)\/(?<password>\w+)/"] = "connect"; // Exemple bidon (ne pas faire comme ça)
        $this->routes["/indexC/"] = "indexC";
        $this->routes["/indexA/"] = "indexA";
        $this->routes["//"] = "index";
    }

    public function index(Request $request): Response {
        $response = new Response();
        $this->session = $this->get(SessionMgr::class);
        $response->render("index.html", ["connected" => $this->session->isConnected()]);
        return $response;
    }
    public function indexC(Request $request): Response {
        $response = new Response();
        $response->render("indexC.html");
        return $response;
    }
    public function indexA(Request $request): Response {
        $response = new Response();
        $response->render("indexA.html");
        return $response;
    }

    public function connect(Request $request): Response {
        $this->session = $this->get(SessionMgr::class);
        $login = $request->getURIParam("login");
        $password = $request->getURIParam("password");

        if($this->getRepository(AccountRepository::class)->isValidLogs($login, $password)) {
            $a = $this->getRepository(AccountRepository::class)->findOneBy(array("login" => "taku"));
            $this->session->connect($a);
        }

        return new Response($this->session->isConnected() ? "oui" : "non");

    }
}

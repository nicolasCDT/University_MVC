<?php
namespace App\Controller;

require_once("../core/AbstractController.php");

use App\HTTP\Request;
use App\HTTP\Response;
use App\Models\entities\AbstractService;
use App\Models\entities\Account;
use App\Models\repositories\AccountRepository;
use App\Service\SessionMgr;

class AdminUsersUtilsController extends AbstractController
{
    private ?SessionMgr $sessionMgr;

    public function __construct() {
        parent::__construct();
        // Update routes :
        $this->routes["/test/"] = "test";
        $this->routes["/deleteTest/"] = "deleteTest";

        $this->sessionMgr = null;
    }

    public function init(): void  {
        $this->sessionMgr = $this->get(SessionMgr::class);
    }

    public function test(Request $request): Response {
        $response = new Response();

        $accounts = $this->getRepository(AccountRepository::class)->findAll();
        $tab = "<table>";
        foreach($accounts as $account)
        {
            $tab .= "<tr>";
            $tab .= "<td>".$account->getLogin()."</td>";
            $tab .= "<td><button id='button_".$account->getId()."'>Supprimer</button></td>";
            $tab .= "</tr>";
        }

        $tab .= "</table>";

        $response->render("test.html", array("tab" => $tab));
        return $response;
    }

    public function deleteTest(Request $request): Response {
        $id = $request->getPost()["id"] ?? 0;

        if($this->sessionMgr->isConnected() && $this->sessionMgr->isMod()) {
            $account = $this->getRepository(AccountRepository::class)->findById((int)$id);
            if($account) {
                $this->getDBManager()->delete($account);
                $this->getDBManager()->flush();
                return new Response("SUCCESS_DELETE");
            }
        }
        return new Response("ACCOUNT_NOT_FOUND");
    }
}

<?php
namespace App\Controller;

require_once("../core/AbstractController.php");

use App\HTTP\Request;
use App\HTTP\Response;
use App\Models\repositories\AccountRepository;
use App\Service\SessionMgr;

class UserUtilsController extends AbstractController
{
    public function __construct() {
        parent::__construct();
        // Update routes :
        $this->routes["/change\/theme/"] = "changeTheme";
    }

    public function changeTheme(Request $r): Response { // TODO: test
        $theme = (int)$r->get("POST", "themeID") ?? 0;
        $sessionMgr = $this->get(SessionMgr::class);

        if($sessionMgr->isConnected()) {
            $account = $this->getRepository(AccountRepository::class)->findById($r->get("SESSION", "account_id"));
            $account->setTheme($theme);
            $this->getDBManager()->update($account);
            $this->getDBManager()->flush();
        }

        $_COOKIE["themeID"] = $theme;

        return new Response("");
    }
}

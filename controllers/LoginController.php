<?php

namespace App\Controller;

require_once('../core/AbstractController.php');

use App\HTTP\Request;
use App\HTTP\Response;
use App\Models\entities\Account;
use App\Models\repositories\AccountRepository;
use App\Service\InputDataChecker;
use App\Service\SessionMgr;

class LoginController extends AbstractController
{
    private string $errors = "";

    public function __construct() {
        parent::__construct();
        $this->routes["/login\/action/"] = "loginAction";
        $this->routes["/monCompte/"] = "monCompte";
        $this->routes["/login/"] = "login";
        $this->routes["/disconnect/"] = "disconnect";
    }

    private function registerProcess(Request $r): bool {
        $out = false;
        $login = $r->get("POST", "login") ?? "";
        $password = $r->get("POST", "password") ?? "";
        $confirm = $r->get("POST", "confirm") ?? "";
        $born = $r->get("POST", "born") ?? "";
        $tel = $r->get("POST", "telephone") ?? "";
        $firstName = $r->get("POST", "firstname") ?? "";
        $lastName = $r->get("POST", "lastname") ?? "";
        $email = $r->get("POST", "mail") ?? "";

        if($password !== $confirm) {
            $this->errors .= "nn t'as pas mis les mêmes mdp idiot <br/>";
            $out = true;
        }
        $checker = $this->get(InputDataChecker::class);

        if(!$checker->canUseEmail($email)) {
            $this->errors .= "nn pour l'email <br/>";
                $out = true;
        }
        if(!$checker->canUseLogin($login)) {
            $this->errors .= "nn pour le login <br/>";
            $out = true;
        }
        if(!$checker->canUsePassword($password)){
            $this->errors .= "nn pour le mot de passe <br/>";
            $out = true;
        }
        if(!$checker->isNameBetween($firstName, 2, 25)) {
            $this->errors .= "nn pour le prénom <br/>";
            $out = true;
        }
        if(!$checker->isNameBetween($lastName, 2, 25)) {
            $this->errors .= "nn pour le nom <br/>";
            $out = true;
        }
        if(!$checker->canUseDate($born)) {
            var_dump($born);
            $this->errors .= "nn pour la date de naissance <br/>";
            $out = true;
        }


        if(!$out) {
            $new = new Account();
            $new->setRank(Account::$ACCOUNT_RANK_GUEST)
            ->setPassword($this->getRepository(AccountRepository::class)->hashPassword($password))
            ->setLogin($login)->setEmail($email)
            ->setBornDate(\DateTime::createFromFormat("Y-m-d", $born))->setRegisterDate(new \DateTime())
            ->setLastname($lastName)->setFirstname($firstName)->setTel($tel);
            $this->getDBManager()->add($new);
            $this->getDBManager()->flush();
        }

        return $out;
    }

    private function loginProcess(Request $r): bool {
        $login = $r->get("POST", "login");
        $pass = $r->get("POST", "password");
        if(!$login || !$pass)
            return true;

        $repo = $this->getRepository(AccountRepository::class);
        $account = $repo->findOneBy([
            "login" => $login,
            "password" => $repo->hashPassword($pass)
            ]);
        if(!$account)
            $account = $repo->findOneBy([
                "email" => $login,
                "password" => $repo->hashPassword($pass)
            ]);

        if(!$account)
            return false;

        $session = $this->get(SessionMgr::class);
        $session->connect($account);

        $this->redirect("home/"); // go to home if connected
        return false;
    }

    public function loginAction(Request $request): Response
    {
        $errors = false;
        if($request->get("POST", "submitLogin"))
            $errors = $this->loginProcess($request);
        elseif($request->get("POST", "submitRegister"))
            $errors = $this->registerProcess($request);

        if(!$errors)
            $this->errors = "pas d'erreur mek gg";
        return $this->login($request);
    }

    public function monCompte(Request $request): Response {
        $response = new Response();

        $response->render("monCompte.html");
        return $response;
    }

    public function login(Request $request): Response {
        $response = new Response();
        $session = $this->get(SessionMgr::class);
        if($session->isConnected())
            $this->redirect("home/");

        $response->render("login.html", ["errors" => $this->errors]);
        return $response;
    }

    public function disconnect(): Response {
        $this->get(SessionMgr::class)->disconnect();
        $this->redirect("home/");
        return new Response();
    }
}
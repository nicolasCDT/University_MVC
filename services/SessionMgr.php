<?php

namespace App\Service;

require_once("../core/AbstractService.php");

use App\Models\entities\AbstractService;
use App\Models\entities\Account;
use App\Models\repositories\AccountRepository;
use DateTime;


class SessionMgr extends AbstractService
{
    public function isConnected(): bool {
        if(empty($_SESSION["account_id"]))
            return false;

        $current_date = new DateTime();
        if($_SESSION["last_activity"]->format("U") < $current_date->format("U")-10800) {
            $this->disconnect();
            return false;
        }

        $_SESSION["last_activity"] = new DateTime();
        return true;
    }

    public function isAdmin(): bool {
        if(!$this->isConnected())
            return false;
        return $this->getRepository(AccountRepository::class)->findOneBy(
            array(
                "id" => $_SESSION["account_id"]
            )
        )->getRank() === Account::$ACC0UNT_RANK_ADMIN;
    }

    public function isMod(): bool {
        if(!$this->isConnected())
            return false;

        return $this->getRepository(AccountRepository::class)->findOneBy(
                array(
                    "id" => $_SESSION["account_id"]
                )
            )->getRank() >= Account::$ACCOUNT_RANK_MOD;
    }

    public function isTeacher(): bool {
        if(!$this->isConnected())
            return false;

        return $this->getRepository(AccountRepository::class)->findOneBy(
                array(
                    "id" => $_SESSION["account_id"]
                )
            )->getRank() === Account::$ACCOUNT_RANK_PROF;
    }

    public function connect(Account $account): bool {
        if($this->isConnected())
            return false;

        $_SESSION["account_id"] = $account->getId();
        $_SESSION["account_login"] = $account->getLogin();
        $_SESSION["account_email"] = $account->getEmail();
        $_SESSION["last_activity"] = new DateTime();
        return true;
    }

    public function disconnect(): bool {
        session_destroy();
        $_SESSION = array();
        return true;
    }
}


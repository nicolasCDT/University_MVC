<?php

namespace App\Service;

require_once("../core/AbstractService.php");

use App\Models\entities\AbstractService;
use App\Models\repositories\AccountRepository;
use DateTime;

class InputDataChecker extends AbstractService
{

    public function isValidEmail(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function canUseEmail(string $email): bool {
        // if is valid address :
        if (!$this->isValidEmail($email))
            return false;
        // if not use
        return !$this->getRepository(AccountRepository::class)->findOneBy(["email" => $email]);
    }

    public function canUseLogin(string $login): bool {
        // Between 5 and 25 chars :
        if(strlen($login) < 5 || strlen($login) > 25)
            return false;
        // is alphanumeric:
        if(!ctype_alnum($login))
            return false;
        // if not use:
        return !$this->getRepository(AccountRepository::class)->findOneBy(["login" => $login]);
    }

    public function canUsePassword(string $password): bool {
        // between 8 and 25 chars:
        if(strlen($password) < 9 || strlen($password) > 25)
            return false;

        // at least one uppercase:
        if(!preg_match('/[A-Z]/', $password))
            return false;

        // at least one lowercase
        if(!preg_match('/[a-z]/', $password))
            return false;
        // at least one number
        if(!preg_match('/\d/', $password))
            return false;

        return true;
    }

    public function isNameBetween(string $string, int $to, int $limit): bool {
        return strlen($string) >= $to || strlen($string) <= $limit;
    }

    public function canUseDate(string $rawDate): bool|DateTime {
        return DateTime::createFromFormat("Y-m-d", $rawDate);
    }

}
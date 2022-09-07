<?php

namespace App\Models\repositories;

use App\Models\entities\Account;
use DateTime;

require_once("../core/EntityRepository.php");
require_once("../models/entities/Account.php");

class AccountRepository extends EntityRepository
{

    public function __construct()
    {
        parent::__construct("account");
    }

    public function makeByArray(array $item): ?Account {
        $needed = ["id", "login", "password", "email", "register_date", "born_date", "rank", "picture_uri",
            "firstname", "lastname", "tel", "theme"];

        foreach($needed as $need)
            if(!array_key_exists($need, $item))
                return null;

        $entity = new Account();
        $entity->setId($item["id"]);
        $entity->setLogin($item["login"]);
        $entity->setPassword($item["password"]);
        $entity->setEmail($item["email"]);
        $rawDate = $item["register_date"];
        $date = DateTime::createFromFormat("Y-m-d H:i:s", $rawDate);
        $entity->setRegisterDate($date);
        $rawDate = $item["born_date"];
        $date = DateTime::createFromFormat("Y-m-d H:i:s", $rawDate);
        $entity->setBornDate($date);
        $entity->setRank(intval($item["rank"]));
        $entity->setPictureUri($item["picture_uri"]);
        $entity->setFirstname($item["firstname"]);
        $entity->setTel($item["tel"]);
        $entity->setLastname($item["lastname"]);
        $entity->setTheme($item["theme"]);
        return $entity;
    }

    /**
     * Retourne si un compte existe avec l'utilisateur précisé en paramètre
     * @param string $login Identifiant du compte à trouver
     * @return bool Si le compte existe
     */
    public function existsLogin(string $login): bool {
        return !is_null($this->findOneBy(
            array(
                "login" => $login,
            )
        ));
    }

    /**
     * Vérifie si un compte existe avec les identifiants passés en paramètre.
     * @param string $login Login du compte
     * @param string $password Mot de passe en clair du compte
     * @return bool Si le compte existe
     */
    public function isValidLogs(string $login, string $password): bool {
        return !is_null($this->findOneBy(
            array(
                "login" => $login,
                "password" => $this->hashPassword($password)
            )
        ));
    }

    /**
     * Génère le hash d'un mot de passe (SHA256 + SALT)
     * @param string $password Chaine à hasher
     * @return string Hash
     */
    public function hashPassword(string $password): string {
        return hash("sha256", $password.$_ENV['SALT']);
    }

}

return new AccountRepository();
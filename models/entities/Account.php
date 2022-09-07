<?php

namespace App\Models\entities;

use APP\Models\SQL\ACTION_TYPE;
use APP\Models\SQL\Query;
use DateTime;

require_once("../core/Entity.php");


class Account extends Entity
{
	private string $login = "";
	private string $password = "";
	private string $email = "";
	private DateTime $registerDate;
	private DateTime $bornDate;
	private int $rank = 0;
	private string $pictureUri = "";
    private string $firstname = "";
    private string $lastname = "";
    private string $tel = "";
    private int $theme = 0;

    public static int $ACCOUNT_RANK_BAN = -1;
    public static int $ACCOUNT_RANK_GUEST = 0;
    public static int $ACCOUNT_RANK_MEMBER = 1;
    public static int $ACCOUNT_RANK_PROF = 2;
    public static int $ACCOUNT_RANK_MOD = 3;
    public static int $ACC0UNT_RANK_ADMIN = 4;

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): Account
    {
        $this->login = $login;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): Account
    {
        $this->password = $password;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): Account
    {
        $this->email = $email;
        return $this;
    }

    public function getRegisterDate(): DateTime
    {
        return $this->registerDate;
    }

    public function setRegisterDate(DateTime $registerDate): Account
    {
        $this->registerDate = $registerDate;
        return $this;
    }

    public function getBornDate(): DateTime
    {
        return $this->bornDate;
    }

    public function setBornDate(DateTime $bornDate): Account
    {
        $this->bornDate = $bornDate;
        return $this;
    }

    public function getRank(): int
    {
        return $this->rank;
    }

    public function setRank(int $rank): Account
    {
        $this->rank = $rank;
        return $this;
    }

    public function getPictureUri(): string
    {
        return $this->pictureUri;
    }

    public function setPictureUri(string $pictureUri): Account
    {
        $this->pictureUri = $pictureUri;
        return $this;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): Account
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): Account
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getTel(): string
    {
        return $this->tel;
    }

    public function setTel(string $tel): Account
    {
        $this->tel = $tel;
        return $this;
    }

    public function setTheme(int $theme): Account
    {
        $this->theme = $theme;
        return $this;
    }

    public function getTheme(): int
    {
        return $this->theme;
    }

    public function toSql(int $mode): Query
    {
        return match ($mode) {
            ACTION_TYPE::DELETE => new Query("DELETE FROM account WHERE id=?", [$this->getId()]),

            ACTION_TYPE::CREATE => new Query(
                "INSERT INTO account (login, password, email, register_date, born_date, rank, picture_uri, firstname, lastname, tel, theme) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
                [
                    $this->getLogin(), $this->getPassword(), $this->getEmail(), $this->getRegisterDate()->format("Y-m-d H:i:s"),
                    $this->getBornDate()->format("Y-m-d H:i:s"), $this->getRank(), $this->getPictureUri(), $this->getFirstname(),
                    $this->getLastname(), $this->getTel(), $this->getTheme()
                ]
            ),

            ACTION_TYPE::UPDATE => new Query(
                "UPDATE account SET login=?, password=?, email=?, register_date=?, born_date=?, rank=?, picture_uri=?, firstname=?, lastname=?, tel=?, theme=? WHERE id=?",
                [
                    $this->getLogin(), $this->getPassword(), $this->getEmail(), $this->getRegisterDate()->format("Y-m-d H:i:s"),
                    $this->getBornDate()->format("Y-m-d H:i:s"), $this->getRank(), $this->getPictureUri(),
                    $this->getFirstname(), $this->getLastname(), $this->getTel(), $this->getTheme(),
                    $this->getId()
                ]
            ),

            default => new Query("") // Default: empty query
        };
    }
    
    public function getAttributes(): array {
        return get_object_vars($this);
    }
}

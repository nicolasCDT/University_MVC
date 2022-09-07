<?php

namespace App\Models\entities;

use APP\Models\SQL\ACTION_TYPE;
use APP\Models\SQL\Query;
use DateTime;

require_once("../core/Entity.php");


class Logs extends Entity
{
	private int $accountId;
	private string $description;
	private DateTime $date;


    public function getAccountId(): int
    {
        return $this->accountId;
    }

    public function setAccountId(int $accountId): Logs
    {
        $this->accountId = $accountId;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Logs
    {
        $this->description = $description;
        return $this;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): Logs
    {
        $this->date = $date;
        return $this;
    }

    public function toSql(int $mode): Query
    {
        return match ($mode) {
            ACTION_TYPE::DELETE => new Query("DELETE FROM logs WHERE id=?", [$this->getId()]),

            ACTION_TYPE::CREATE => new Query(
                "INSERT INTO logs (account_id, description, date) VALUES (?, ?, ?)",
                [
                    $this->getAccountId(), $this->getDescription(), $this->getDate()->format("Y-m-d H:i:s")
                ]
            ),

            ACTION_TYPE::UPDATE => new Query(
                "UPDATE logs SET account_id=?, description=?, date=? WHERE id=?",
                [
                    $this->getAccountId(), $this->getDescription(), $this->getDate()->format("Y-m-d H:i:s"), $this->getId()
                ]
            ),

            default => new Query("") // Default: empty query
        };
    }
    
    public function getAttributes(): array {
        return get_object_vars($this);
    }
}

<?php

namespace App\Models\entities;

use APP\Models\SQL\ACTION_TYPE;
use APP\Models\SQL\Query;
use DateTime;

require_once("../core/Entity.php");


class ActiveSession extends Entity
{
	private int $accountId;
	private string $sessionKey;


    public function getAccountId(): int
    {
        return $this->accountId;
    }

    public function setAccountId(int $accountId): ActiveSession
    {
        $this->accountId = $accountId;
        return $this;
    }

    public function getSessionKey(): string
    {
        return $this->sessionKey;
    }

    public function setSessionKey(string $sessionKey): ActiveSession
    {
        $this->sessionKey = $sessionKey;
        return $this;
    }

    public function toSql(int $mode): Query
    {
        return match ($mode) {
            ACTION_TYPE::DELETE => new Query("DELETE FROM active_session WHERE id=?", [$this->getId()]),

            ACTION_TYPE::CREATE => new Query(
                "INSERT INTO active_session (account_id, session_key) VALUES (?, ?)",
                [
                    $this->getAccountId(), $this->getSessionKey()
                ]
            ),

            ACTION_TYPE::UPDATE => new Query(
                "UPDATE active_session SET account_id=?, session_key=? WHERE id=?",
                [
                    $this->getAccountId(), $this->getSessionKey(), $this->getId()
                ]
            ),

            default => new Query("") // Default: empty query
        };
    }
    
    public function getAttributes(): array {
        return get_object_vars($this);
    }
}

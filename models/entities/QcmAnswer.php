<?php

namespace App\Models\entities;

use APP\Models\SQL\ACTION_TYPE;
use APP\Models\SQL\Query;
use DateTime;

require_once("../core/Entity.php");


class QcmAnswer extends Entity
{
	private int $accountId;
	private string $qcmUri;
	private int $score;
	private DateTime $date;


    public function getAccountId(): int
    {
        return $this->accountId;
    }

    public function setAccountId(int $accountId): QcmAnswer
    {
        $this->accountId = $accountId;
        return $this;
    }

    public function getQcmUri(): string
    {
        return $this->qcmUri;
    }

    public function setQcmUri(string $qcmUri): QcmAnswer
    {
        $this->qcmUri = $qcmUri;
        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): QcmAnswer
    {
        $this->score = $score;
        return $this;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): QcmAnswer
    {
        $this->date = $date;
        return $this;
    }

    public function toSql(int $mode): Query
    {
        return match ($mode) {
            ACTION_TYPE::DELETE => new Query("DELETE FROM qcm_answer WHERE id=?", [$this->getId()]),

            ACTION_TYPE::CREATE => new Query(
                "INSERT INTO qcm_answer (account_id, qcm_uri, score, date) VALUES (?, ?, ?, ?)",
                [
                    $this->getAccountId(), $this->getQcmUri(), $this->getScore(), $this->getDate()->format("Y-m-d H:i:s")
                ]
            ),

            ACTION_TYPE::UPDATE => new Query(
                "UPDATE qcm_answer SET account_id=?, qcm_uri=?, score=?, date=? WHERE id=?",
                [
                    $this->getAccountId(), $this->getQcmUri(), $this->getScore(), $this->getDate()->format("Y-m-d H:i:s"), $this->getId()
                ]
            ),

            default => new Query("") // Default: empty query
        };
    }
    
    public function getAttributes(): array {
        return get_object_vars($this);
    }
}

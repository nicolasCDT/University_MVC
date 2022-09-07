<?php

namespace App\Models\repositories;

use App\Models\entities\QcmAnswer;
use DateTime;

require_once("../core/EntityRepository.php");
require_once("../models/entities/QcmAnswer.php");

class QcmAnswerRepository extends EntityRepository
{

    public function __construct()
    {
        parent::__construct("qcm_answer");
    }

    public function makeByArray(array $item): ?QcmAnswer {
        $needed = ["id", "account_id", "qcm_uri", "date", "score"];
        foreach($needed as $need)
            if(!array_key_exists($need, $item))
                return null;
        $entity = new QcmAnswer();
        $entity->setId($item["id"]);

        $entity->setAccountId(intval($item["account_id"]));
        $entity->setQcmUri($item["qcm_uri"]);
        $entity->setScore(intval($item["score"]));
        $rawDate = $item["date"];
        $date = DateTime::createFromFormat("Y-m-d H:i:s", $rawDate);
        $entity->setDate($date);

        return $entity;
    }
}

return new QcmAnswerRepository();
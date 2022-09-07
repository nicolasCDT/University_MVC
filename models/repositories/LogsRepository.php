<?php

namespace App\Models\repositories;

use App\Models\entities\Logs;
use DateTime;

require_once("../core/EntityRepository.php");
require_once("../models/entities/Logs.php");

class LogsRepository extends EntityRepository
{

    public function __construct()
    {
        parent::__construct("logs");
    }

    public function makeByArray(array $item): ?Logs {
        $needed = ["id", "account_id", "description", "date"];
        foreach($needed as $need)
            if(!array_key_exists($need, $item))
                return null;
        $entity = new Logs();
        $entity->setId($item["id"]);

        $entity->setAccountId(intval($item["account_id"]));
        $entity->setDescription($item["description"]);
        $rawDate = $item["date"];
        $date = DateTime::createFromFormat("Y-m-d H:i:s", $rawDate);
        $entity->setDate($date);


        return $entity;
    }
}

return new LogsRepository();
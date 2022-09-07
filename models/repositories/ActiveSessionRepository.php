<?php

namespace App\Models\repositories;

use App\Models\entities\ActiveSession;
use DateTime;

require_once("../core/EntityRepository.php");
require_once("../models/entities/ActiveSession.php");

class ActiveSessionRepository extends EntityRepository
{

    public function __construct()
    {
        parent::__construct("active_session");
    }

    public function makeByArray(array $item): ?ActiveSession {
        $needed = ["id", "account_id", "session_key"];
        foreach($needed as $need)
            if(!array_key_exists($need, $item))
                return null;
        $entity = new ActiveSession();
        $entity->setId($item["id"]);
        $entity->setAccountId(intval($item["account_id"]));
        $entity->setSessionKey($item["session_key"]);
        return $entity;
    }
}

return new ActiveSessionRepository();
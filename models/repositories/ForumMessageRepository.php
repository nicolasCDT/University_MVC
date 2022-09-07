<?php

namespace App\Models\repositories;

use App\Models\entities\ForumMessage;
use DateTime;

require_once("../core/EntityRepository.php");
require_once("../models/entities/ForumMessage.php");

class ForumMessageRepository extends EntityRepository
{

    public function __construct()
    {
        parent::__construct("forum_message");
    }

    public function makeByArray(array $item): ?ForumMessage {
        $needed = ["id", "author_id", "content", "date", "visible", "thread_id"];
        foreach($needed as $need)
            if(!array_key_exists($need, $item))
                return null;
        $entity = new ForumMessage();
        $entity->setId($item["id"]);

        $entity->setAuthorId(intval($item["author_id"]));
        $entity->setContent($item["content"]);
        $rawDate = $item["date"];
        $date = DateTime::createFromFormat("Y-m-d H:i:s", $rawDate);
        $entity->setDate($date);
        $entity->setVisible(intval($item["visible"]));
        $entity->setThreadId(intval($item["thread_id"]));
        return $entity;
    }
}

return new ForumMessageRepository();
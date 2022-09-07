<?php

namespace App\Models\repositories;

use App\Models\entities\ForumThread;
use DateTime;

require_once("../core/EntityRepository.php");
require_once("../models/entities/ForumThread.php");

class ForumThreadRepository extends EntityRepository
{

    public function __construct()
    {
        parent::__construct("forum_thread");
    }
    
    public function makeByArray(array $item): ?ForumThread {
        $needed = ["name", "createDate", "author"];
        foreach($needed as $need)
            if(!array_key_exists($need, $item))
                return null;
        $entity = new ForumThread();
        $entity->setId($item["id"]);
		$entity->setName($item["name"]);
		$rawDate = $item["create_date"];
		$date = DateTime::createFromFormat("Y-m-d H:i:s", $rawDate);
		$entity->setCreateDate($date);
		$entity->setAuthor(intval($item["author"]));

        return $entity;
    }
}

return new ForumThreadRepository();
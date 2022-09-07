<?php

namespace App\Models\repositories;

use App\Models\entities\ForumCategory;
use DateTime;

require_once("../core/EntityRepository.php");
require_once("../models/entities/ForumCategory.php");

class ForumCategoryRepository extends EntityRepository
{

    public function __construct()
    {
        parent::__construct("forum_category");
    }

    public function makeByArray(array $item): ?ForumCategory {
        $needed = ["id", "name", "min_rank"];
        foreach($needed as $need)
            if(!array_key_exists($need, $item))
                return null;
        $entity = new ForumCategory();
        $entity->setId($item["id"]);
        $entity->setName($item["name"]);
        $entity->setMinRank(intval($item["min_rank"]));
        return $entity;
    }
}

return new ForumCategoryRepository();
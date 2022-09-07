<?php

namespace App\Models\repositories;

use App\Models\entities\Classe;
use DateTime;

require_once("../core/EntityRepository.php");
require_once("../models/entities/Classe.php");

class ClasseRepository extends EntityRepository
{

    public function __construct()
    {
        parent::__construct("classe");
    }

    public function makeByArray(array $item): ?Classe {
        $needed = ["id", "author_id", "content", "attachment", "visible", "date"];
        foreach($needed as $need)
            if(!array_key_exists($need, $item))
                return null;

        $entity = new Classe();
        $entity->setId($item["id"]);
        $entity->setAuthorId(intval($item["author_id"]));
        $entity->setContent($item["content"]);
        $entity->setAttachment($item["attachment"]);
        $rawDate = $item["date"];
        $date = DateTime::createFromFormat("Y-m-d H:i:s", $rawDate);
        $entity->setDate($date);
        $entity->setVisible(intval($item["visible"]));

        return $entity;
    }
}

return new ClasseRepository();
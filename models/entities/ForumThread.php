<?php

namespace App\Models\entities;

use APP\Models\SQL\ACTION_TYPE;
use APP\Models\SQL\Query;
use DateTime;

require_once("../core/Entity.php");


class ForumThread extends Entity
{
	private string $name;
	private DateTime $createDate;
	private int $author;


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ForumThread
    {
        $this->name = $name;
        return $this;
    }

    public function getCreateDate(): DateTime
    {
        return $this->createDate;
    }

    public function setCreateDate(DateTime $createDate): ForumThread
    {
        $this->createDate = $createDate;
        return $this;
    }

    public function getAuthor(): int
    {
        return $this->author;
    }

    public function setAuthor(int $author): ForumThread
    {
        $this->author = $author;
        return $this;
    }

    public function toSql(int $mode): Query
    {
        return match ($mode) {
            ACTION_TYPE::DELETE => new Query("DELETE FROM forum_thread WHERE id=?", [$this->getId()]),

            ACTION_TYPE::CREATE => new Query(
                "INSERT INTO forum_thread (name, create_date, author) VALUES (?, ?, ?)",
                [
                    $this->getName(), $this->getCreateDate()->format("Y-m-d H:i:s"), $this->getAuthor()
                ]
            ),

            ACTION_TYPE::UPDATE => new Query(
                "UPDATE forum_thread SET name=?, create_date=?, author=? WHERE id=?",
                [
                    $this->getName(), $this->getCreateDate()->format("Y-m-d H:i:s"), $this->getAuthor(), $this->getId()
                ]
            ),

            default => new Query("") // Default: empty query
        };
    }
    
    public function getAttributes(): array {
        return get_object_vars($this);
    }
}

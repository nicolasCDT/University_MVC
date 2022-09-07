<?php

namespace App\Models\entities;

use APP\Models\SQL\ACTION_TYPE;
use APP\Models\SQL\Query;
use DateTime;

require_once("../core/Entity.php");


class Classe extends Entity
{
	private int $authorId;
	private string $content;
	private string $attachment;
	private DateTime $date;
	private int $visible;


    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function setAuthorId(int $authorId): Classe
    {
        $this->authorId = $authorId;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): Classe
    {
        $this->content = $content;
        return $this;
    }

    public function getAttachment(): string
    {
        return $this->attachment;
    }

    public function setAttachment(string $attachment): Classe
    {
        $this->attachment = $attachment;
        return $this;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): Classe
    {
        $this->date = $date;
        return $this;
    }

    public function getVisible(): int
    {
        return $this->visible;
    }

    public function setVisible(int $visible): Classe
    {
        $this->visible = $visible;
        return $this;
    }

    public function toSql(int $mode): Query
    {
        return match ($mode) {
            ACTION_TYPE::DELETE => new Query("DELETE FROM classe WHERE id=?", [$this->getId()]),

            ACTION_TYPE::CREATE => new Query(
                "INSERT INTO classe (author_id, content, attachment, date, visible) VALUES (?, ?, ?, ?, ?)",
                [
                    $this->getAuthorId(), $this->getContent(), $this->getAttachment(), $this->getDate()->format("Y-m-d H:i:s"), $this->getVisible()
                ]
            ),

            ACTION_TYPE::UPDATE => new Query(
                "UPDATE classe SET author_id=?, content=?, attachment=?, date=?, visible=? WHERE id=?",
                [
                    $this->getAuthorId(), $this->getContent(), $this->getAttachment(), $this->getDate()->format("Y-m-d H:i:s"), $this->getVisible(), $this->getId()
                ]
            ),

            default => new Query("") // Default: empty query
        };
    }
    
    public function getAttributes(): array {
        return get_object_vars($this);
    }
}

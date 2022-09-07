<?php

namespace App\Models\entities;

use APP\Models\SQL\ACTION_TYPE;
use APP\Models\SQL\Query;
use DateTime;

require_once("../core/Entity.php");


class ForumMessage extends Entity
{
	private int $authorId;
	private string $content;
	private DateTime $date;
	private int $visible;
    private int $threadId;

    public static int $MESSAGE_VISIBLE = 0;
    public static int $MESSAGE_HIDDEN = 1;

    public function getThreadId(): int
    {
        return $this->threadId;
    }

    public function setThreadId(int $id): ForumMessage
    {
        $this->threadId = $id;
        return $this;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function setAuthorId(int $authorId): ForumMessage
    {
        $this->authorId = $authorId;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): ForumMessage
    {
        $this->content = $content;
        return $this;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): ForumMessage
    {
        $this->date = $date;
        return $this;
    }

    public function getVisible(): int
    {
        return $this->visible;
    }

    public function setVisible(int $visible): ForumMessage
    {
        $this->visible = $visible;
        return $this;
    }

    public function toSql(int $mode): Query
    {
        return match ($mode) {
            ACTION_TYPE::DELETE => new Query("DELETE FROM forum_message WHERE id=?", [$this->getId()]),

            ACTION_TYPE::CREATE => new Query(
                "INSERT INTO forum_message (author_id, content, date, visible, thread_id) VALUES (?, ?, ?, ?, ?)",
                [
                    $this->getAuthorId(), $this->getContent(), $this->getDate()->format("Y-m-d H:i:s"), $this->getVisible(), $this->getThreadId()
                ]
            ),

            ACTION_TYPE::UPDATE => new Query(
                "UPDATE forum_message SET author_id=?, content=?, date=?, visible=?, thread_id=? WHERE id=?",
                [
                    $this->getAuthorId(), $this->getContent(), $this->getDate()->format("Y-m-d H:i:s"), $this->getVisible(), $this->getThreadId(),
                    $this->getId()
                ]
            ),

            default => new Query("") // Default: empty query
        };
    }
    
    public function getAttributes(): array {
        return get_object_vars($this);
    }
}

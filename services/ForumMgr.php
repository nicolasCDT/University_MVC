<?php

namespace App\Service;

require_once("../core/AbstractService.php");
require_once("../services/SessionMgr.php");


use App\Models\entities\AbstractService;
use App\Models\entities\ForumMessage;
use App\Models\repositories\ForumThreadRepository;
use DateTime;


class ForumMgr extends AbstractService
{
    public SessionMgr $session;


    public function __construct() {
        $this->session = new SessionMgr();
    }

    public function addMessage(int $threadID, string $content): void {
        // Have to be connected
        if(!$this->session->isConnected())
            return;

        // Get message's author
        $author = $_SESSION["account_id"];

        // Thread have to exists
        if(!$this->getDBManager()->getRepository(ForumThreadRepository::class)->findById($threadID))
            return;

        // Create Message
        $message = new ForumMessage();
        $message->setThreadId($threadID);
        $message->setContent($content);
        $message->setAuthorId($author);
        $message->setDate(new DateTime());
        $message->setVisible(ForumMessage::$MESSAGE_VISIBLE);

        // Insert into Database
        $this->getDBManager()->add($message);
        $this->getDBManager()->flush();
    }

    public function createThread(string $title, string $content): void {

    }




}
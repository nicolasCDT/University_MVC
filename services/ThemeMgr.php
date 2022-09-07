<?php

namespace App\Service;

require_once("../core/AbstractController.php");

use App\Models\entities\AbstractService;
use App\Models\repositories\AccountRepository;

class ThemeMgr extends AbstractService
{
    public array $themes = [0, 1];

    public function changeTheme(int $theme, int $accountID = -1): void
    {
        if(!in_array($theme, $this->themes))
            return;

        if($accountID != 1) {
            if($account = $this->getRepository(AccountRepository::class)->findById($accountID)) {
                $account->setTheme($theme);
                $this->getDBManager()->update($account);
                $this->getDBManager()->flush();
            }
        }

        $_COOKIE["themeID"] = $theme;
    }

    public function getTheme(int $accountID = -1): int
    {
        if($accountID != 1)
            if($account = $this->getRepository(AccountRepository::class)->findById($accountID))
                return $account->getTheme();
        return $_COOKIE["themeID"] ??= 0;
    }

}
<?php

namespace App\Models\entities;

use App\Models\DBManager;
use App\Models\repositories\EntityRepository;

/**
 * Classe abstraite pour les services
 */
abstract class AbstractService
{
    /**
     * @var DBManager Gestionnaire base de données
     */
    private DBManager $dbManager;

    /**
     * Définit le gestionnaire de base de données
     * @param DBManager $db Gestionnaire de base de données
     * @return $this Instance courante (fluent)
     */
    public function setDBManager(DBManager $db): AbstractService {
        $this->dbManager = $db;
        return $this;
    }

    /**
     * Renvoie le gestionnaire de base de données
     * @return DBManager Gestionnaire de base de données
     */
    public function getDBManager(): DBManager {
        return $this->dbManager;
    }

    /**
     * Renvoie un dépôt
     * @param string $class Dépôt voulu
     * @return EntityRepository|null Dépôt ou null si non trouvé
     */
    public function getRepository(string $class): ?EntityRepository
    {
        return $this->dbManager->getRepository($class);
    }
}
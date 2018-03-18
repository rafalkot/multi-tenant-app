<?php

declare (strict_types=1);

namespace App\Service\DatabaseFiller;

use App\Entity\Common\Tenant;
use App\Service\TenantConnectionWrapper;
use Doctrine\DBAL\Connection;

final class TemplateFiller implements FillerInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var TenantConnectionWrapper
     */
    private $tenantConnection;

    /**
     * @var string
     */
    private $templateDatabase;

    /**
     * TemplateFiller constructor.
     * @param Connection $connection
     * @param TenantConnectionWrapper $tenantConnection
     * @param string $templateDatabase
     */
    public function __construct(
        Connection $connection,
        TenantConnectionWrapper $tenantConnection,
        string $templateDatabase
    ) {
        $this->connection = $connection;
        $this->tenantConnection = $tenantConnection;
        $this->templateDatabase = $templateDatabase;
    }

    public function fillDatabaseOfTenant(Tenant $tenant)
    {
        $this->tenantConnection->initTenantConnection($tenant);

        $templateDb = $this->templateDatabase;
        $tenantDb = $tenant->dbConfig()->database();

        $showTablesSql = "SHOW TABLES FROM `{$templateDb}`";

        $tables = $this->connection->executeQuery($showTablesSql)->fetchAll();

        foreach ($tables as $table) {
            $table = array_values($table)[0];

            $showSql = "SHOW CREATE TABLE {$templateDb}.{$table}";
            $createSql = $this->connection->executeQuery($showSql)->fetch()['Create Table'];

            $this->tenantConnection->exec($createSql);

            $insertSql = "INSERT INTO {$tenantDb}.{$table} SELECT * FROM {$templateDb}.{$table}";
            $this->connection->exec($insertSql);
        }
    }
}

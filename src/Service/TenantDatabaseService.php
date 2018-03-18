<?php

declare (strict_types=1);

namespace App\Service;

use App\Entity\Common\Tenant;
use App\Service\DatabaseFiller\FillerInterface;
use Doctrine\DBAL\Connection;

final class TenantDatabaseService
{
    /**
     * @var Tenant
     */
    private $tenant;

    /**
     * @var Connection
     */
    private $commonConnection;

    /**
     * @var FillerInterface
     */
    private $filler;

    /**
     * TenantDatabaseService constructor.
     * @param Connection $commonConnection
     * @param FillerInterface $filler
     */
    public function __construct(
        Connection $commonConnection,
        FillerInterface $filler
    ) {
        $this->commonConnection = $commonConnection;
        $this->filler = $filler;
    }

    public function setupForTenant(Tenant $tenant): void
    {
        $this->tenant = $tenant;

        $this->createDatabase();
        $this->createDatabaseUser();
        $this->fillDatabase();
    }

    private function createDatabase(): void
    {
        $this->commonConnection->getSchemaManager()->createDatabase(
            $this->tenant->dbConfig()->database()
        );
    }

    private function createDatabaseUser(): void
    {
        $user = $this->tenant->dbConfig()->user();
        $database = $this->tenant->dbConfig()->database();
        $password = $this->tenant->dbConfig()->password();

        $sql = <<<SQL
        CREATE USER '{$user}'@'%' IDENTIFIED BY '{$password}';
        GRANT ALL ON {$database}.* TO '{$user}'@'%';
SQL;

        $this->commonConnection->exec($sql);
    }

    private function fillDatabase(): void
    {
        $this->filler->fillDatabaseOfTenant($this->tenant);
    }
}

<?php

declare (strict_types=1);

namespace App\Service;

use App\Entity\Common\Tenant;
use Doctrine\DBAL\Connection;

final class TenantConnectionWrapper extends Connection
{
    public function initTenantConnection(Tenant $tenant)
    {
        $this->close();

        $reflection = new \ReflectionObject($this);
        $refProperty = $reflection->getParentClass()->getProperty('_params');
        $refProperty->setAccessible(true);

        $params = $refProperty->getValue($this);

        $params['host'] = $tenant->dbConfig()->host();
        $params['user'] = $tenant->dbConfig()->user();
        $params['password'] = $tenant->dbConfig()->password();
        $params['dbname'] = $tenant->dbConfig()->database();

        $refProperty->setValue($this, $params);
    }
}

<?php

declare (strict_types=1);

namespace App\Service;

use App\Entity\Common\Tenant;

final class TenantContext
{
    /**
     * @var Tenant
     */
    private $tenant;

    /**
     * @return Tenant
     */
    public function getTenant():? Tenant
    {
        return $this->tenant;
    }

    /**
     * @param Tenant $tenant
     */
    public function setTenant(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }
}

<?php

declare (strict_types=1);


namespace App\Service\DatabaseFiller;

use App\Entity\Common\Tenant;

interface FillerInterface
{
    public function fillDatabaseOfTenant(Tenant $tenant);
}

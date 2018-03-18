<?php

declare (strict_types=1);

namespace App\Service\DatabaseFiller;

use App\Entity\Common\Tenant;

final class NullFiller implements FillerInterface
{
    public function fillDatabaseOfTenant(Tenant $tenant)
    {
        echo 'Filling DB';
    }
}

<?php

declare (strict_types=1);

namespace App\Repository;

use App\Entity\Common\Tenant;

interface TenantRepositoryInterface
{
    public function findById(int $id):? Tenant;

    public function findByDomain(string $domain):? Tenant;

    public function findByName(string $name):? Tenant;

    public function save(Tenant $tenant): void;
}

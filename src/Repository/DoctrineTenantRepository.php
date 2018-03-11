<?php

declare (strict_types=1);

namespace App\Repository;

use App\Entity\Common\Tenant;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineTenantRepository implements TenantRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * DoctrineTenantRepository constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findById(int $id):? Tenant
    {
        return $this->em->find(Tenant::class, $id);
    }

    public function findByDomain(string $domain):? Tenant
    {
        return $this->em
            ->getRepository(Tenant::class)
            ->findOneBy(
                [
                    'domain' => $domain,
                ]
            );
    }

    public function findByName(string $name):? Tenant
    {
        return $this->em
            ->getRepository(Tenant::class)
            ->findOneBy(
                [
                    'name' => $name,
                ]
            );
    }
}

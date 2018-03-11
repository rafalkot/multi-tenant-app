<?php

declare (strict_types=1);

namespace App\Repository;

use App\Entity\Shop\Product;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineProductRepository implements ProductRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * DoctrineProductRepository constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function all(): array
    {
        return $this->em
            ->getRepository(Product::class)
            ->findAll();
    }
}

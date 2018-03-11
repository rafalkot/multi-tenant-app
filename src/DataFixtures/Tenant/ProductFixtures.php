<?php

declare (strict_types=1);

namespace App\DataFixtures\Tenant;

use App\Entity\Shop\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

final class ProductFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $tenant = $this->container->get('app.service.tenant_context')->getTenant();

        $product1 = new Product($tenant->name() . ' product 1');
        $product2 = new Product($tenant->name() . ' product 2');

        $manager->persist($product1);
        $manager->persist($product2);

        $manager->flush();
    }
}

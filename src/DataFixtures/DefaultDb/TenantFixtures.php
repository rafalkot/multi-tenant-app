<?php

declare (strict_types=1);

namespace App\DataFixtures\DefaultDb;

use App\Entity\Common\DatabaseConfig;
use App\Entity\Common\Tenant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

final class TenantFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $dbConfig1 = new DatabaseConfig('db_1', 'db', 'db_user_1', 'password1');
        $tenant1 = new Tenant('tenant1', 'tenant1.myapp.local', $dbConfig1);

        $dbConfig2 = new DatabaseConfig('db_2', 'db', 'db_user_2', 'password2');
        $tenant2 = new Tenant('tenant2', 'tenant2.myapp.local', $dbConfig2);

        $manager->persist($tenant1);
        $manager->persist($tenant2);

        $manager->flush();
    }
}

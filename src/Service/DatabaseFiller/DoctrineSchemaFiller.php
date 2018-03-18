<?php

declare (strict_types=1);

namespace App\Service\DatabaseFiller;

use App\Entity\Common\Tenant;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpKernel\KernelInterface;

final class DoctrineSchemaFiller implements FillerInterface
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * DoctrineSchemaFiller constructor.
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function fillDatabaseOfTenant(Tenant $tenant)
    {
        $consoleApp = new Application($this->kernel);
        $consoleApp->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'doctrine:schema:create',
            '--em' => 'tenant',
            '--tenant' => $tenant->name(),
        ]);

        $consoleApp->run($input, new NullOutput());

        $input = new ArrayInput([
            'command' => 'doctrine:fixtures:load',
            '--em' => 'tenant',
            '--tenant' => $tenant->name(),
            '--fixtures' => 'src/DataFixtures/Tenant/',
            '--no-interaction'
        ]);

        $consoleApp->run($input, new NullOutput());
    }
}

<?php

declare (strict_types=1);

namespace App\Service\DatabaseFiller;

use App\Entity\Common\Tenant;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpKernel\KernelInterface;

final class SqlFileFiller implements FillerInterface
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var array
     */
    private $files = [];

    /**
     * SqlFileFiller constructor.
     * @param KernelInterface $kernel
     * @param array $files
     */
    public function __construct(KernelInterface $kernel, array $files)
    {
        $this->kernel = $kernel;
        $this->files = $files;
    }

    public function fillDatabaseOfTenant(Tenant $tenant)
    {
        $consoleApp = new Application($this->kernel);
        $consoleApp->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'doctrine:database:import',
            'file' => $this->files,
            '--connection' => 'tenant',
            '--tenant' => $tenant->name(),
        ]);

        $consoleApp->run($input, new NullOutput());
    }
}

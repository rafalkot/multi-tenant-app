<?php

declare (strict_types=1);

namespace App\EventListener;

use App\Repository\TenantRepositoryInterface;
use App\Service\TenantConnectionWrapper;
use App\Service\TenantContext;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Input\InputOption;

final class TenantCommandListener
{
    /**
     * @var TenantRepositoryInterface
     */
    private $tenants;

    /**
     * @var TenantConnectionWrapper
     */
    private $tenantConnection;

    /**
     * @var TenantContext
     */
    private $context;

    public function __construct(
        TenantRepositoryInterface $tenants,
        TenantConnectionWrapper $tenantConnection,
        TenantContext $context
    ) {
        $this->tenants = $tenants;
        $this->tenantConnection = $tenantConnection;
        $this->context = $context;
    }

    public function onConsoleCommand(ConsoleCommandEvent $event)
    {
        $command = $event->getCommand();
        $input = $event->getInput();

        $command->addOption('tenant', null, InputOption::VALUE_OPTIONAL);

        $input->bind($command->getDefinition());

        $name = $input->getOption('tenant');

        if (!$name) {
            return;
        }

        $tenant = $this->tenants->findByName($name);

        if (!$tenant) {
            throw new \Exception('Invalid tenant name');
        }

        $this->context->setTenant($tenant);
        $this->tenantConnection->initTenantConnection($tenant);
    }
}

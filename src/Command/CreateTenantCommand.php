<?php

declare (strict_types=1);

namespace App\Command;

use App\Entity\Common\DatabaseConfig;
use App\Entity\Common\Tenant;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

final class CreateTenantCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('tenant:create')
            ->setDescription('Creates a new tenant');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');

        $name = $helper->ask($input, $output, new Question('Name: '));
        $domain = $helper->ask($input, $output, new Question('Domain: '));

        $dbConfig = new DatabaseConfig(
            'db_'.$name,
            'db',
            'db_'.$name,
            bin2hex(random_bytes(10))
        );

        $tenant = new Tenant($name, $domain, $dbConfig);

        $tenantRepository = $this->getContainer()->get('app.repository.tenant_repository');
        $tenantRepository->save($tenant);

        $output->writeln('ID: ' . $tenant->id());
        $output->writeln('Name: ' . $tenant->name());
        $output->writeln('Domain: ' . $tenant->domain());
        $output->writeln('DB user: ' . $tenant->dbConfig()->user());
        $output->writeln('DB name: ' . $tenant->dbConfig()->database());
        $output->writeln('DB host: ' . $tenant->dbConfig()->host());
        $output->writeln('DB password: ' . $tenant->dbConfig()->password());

        $output->writeln('Filling database...');

        $databaseService = $this->getContainer()->get('app.service.tenant_database_service');
        $databaseService->setupForTenant($tenant);

        $output->writeln('Database filled');
    }
}

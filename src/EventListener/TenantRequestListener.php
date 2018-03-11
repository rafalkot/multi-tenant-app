<?php

declare (strict_types=1);

namespace App\EventListener;

use App\Repository\TenantRepositoryInterface;
use App\Service\TenantConnectionWrapper;
use App\Service\TenantContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

final class TenantRequestListener
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

    /**
     * TenantRequestListener constructor.
     *
     * @param TenantRepositoryInterface $tenants
     * @param TenantConnectionWrapper   $tenantConnection
     * @param TenantContext             $context
     */
    public function __construct(
        TenantRepositoryInterface $tenants,
        TenantConnectionWrapper $tenantConnection,
        TenantContext $context
    ) {
        $this->tenants = $tenants;
        $this->tenantConnection = $tenantConnection;
        $this->context = $context;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $domain = $request->getHost();

        $tenant = $this->tenants->findByDomain($domain);

        if (!$tenant) {
            $event->setResponse(new Response('Invalid domain', 404));

            return;
        }

        $this->context->setTenant($tenant);
        $this->tenantConnection->initTenantConnection($tenant);
    }
}

<?php

declare (strict_types=1);

namespace App\Controller;

use App\Repository\ProductRepositoryInterface;
use App\Service\TenantContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class ShopController
{
    /**
     * @var TenantContext
     */
    private $tenantContext;

    /**
     * @var ProductRepositoryInterface
     */
    private $products;

    /**
     * TenantController constructor.
     *
     * @param TenantContext              $tenantContext
     * @param ProductRepositoryInterface $products
     */
    public function __construct(TenantContext $tenantContext, ProductRepositoryInterface $products)
    {
        $this->tenantContext = $tenantContext;
        $this->products = $products;
    }

    /**
     * @Route("/")
     */
    public function index()
    {
        return new JsonResponse($this->tenantContext->getTenant());
    }

    /**
     * @Route("/products")
     */
    public function products()
    {
        return new JsonResponse($this->products->all());
    }
}

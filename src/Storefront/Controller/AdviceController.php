<?php

declare(strict_types=1);

namespace Crehler\Advice\Storefront\Controller;

use Crehler\Advice\Core\Content\Advice\SalesChannel\AbstractAdviceRoute;
use Crehler\Advice\Core\Content\Advice\SalesChannel\AdviceRoute;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route(defaults: ['_routeScope' => ['storefront']])]
class AdviceController extends StorefrontController
{
    public function __construct(
        #[Autowire(service: AdviceRoute::class)] public readonly AbstractAdviceRoute $route
    ) {
    }
    #[Route(
        path: '/widgets/advice/{id}',
        name: 'frontend.crehler.advice',
        options: ['seo' => false],
        defaults: ['XmlHttpRequest' => true],
        methods: ['GET']
    )]
    public function getAdvice(string $id, SalesChannelContext $context): Response
    {
        $response = $this->route->getAdvice($id, $context);

        return new JsonResponse([
            'name' => $response->getAdvice()->getTranslation('name'),
            'advice' => $response->getAdvice()->getTranslation('description'),
        ]);
    }
}

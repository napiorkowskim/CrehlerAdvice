<?php

declare(strict_types=1);

namespace Crehler\Advice\Subscriber;

use Crehler\Advice\Core\Content\Advice\SalesChannel\AbstractAdviceRoute;
use Crehler\Advice\Core\Content\Advice\SalesChannel\AdviceRoute;
use Crehler\Advice\Struct\AdviceStruct;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Storefront\Page\Product\ProductPageLoadedEvent;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

#[Autoconfigure(tags: [['name' => 'kernel.event_subscriber']])]
class ProductSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ProductPageLoadedEvent::class => 'onProductPage'
        ];
    }

    public function __construct(
        #[Autowire(service: AdviceRoute::class)] private AbstractAdviceRoute $route
    ) {
    }

    public function onProductPage(ProductPageLoadedEvent $event): void
    {

        $product = $event->getPage()->getProduct();

        $dataBag = new RequestDataBag();
        $dataBag->set('streamIds', $product->getStreamIds());
        $response = $this->route->searchAdvice($dataBag, $event->getSalesChannelContext());

        if ($response->getAdvice()->firstId() === null) {
            return;
        }

        $product->addExtension(
            AdviceStruct::NAME,
            new AdviceStruct($response->getAdvice()->firstId())
        );
    }
}
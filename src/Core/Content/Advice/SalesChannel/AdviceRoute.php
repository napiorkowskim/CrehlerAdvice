<?php

declare(strict_types=1);

namespace Crehler\Advice\Core\Content\Advice\SalesChannel;

use Crehler\Advice\Exception\AdviceNotFoundException;
use Shopware\Core\Framework\Adapter\Cache\CacheCompressor;
use Shopware\Core\Framework\DataAbstractionLayer\Cache\EntityCacheKeyGenerator;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsAnyFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\MultiFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\IdSearchResult;
use Shopware\Core\Framework\Plugin\Exception\DecorationPatternException;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Routing\Annotation\Route;

#[Route(defaults: ['_routeScope' => ['store-api']])]
class AdviceRoute extends AbstractAdviceRoute
{
    public function __construct(
        #[Autowire(service: 'crehler_advice.repository')] private readonly EntityRepository $adviceRepository,
        #[Autowire(service: 'cache.object')] private readonly TagAwareAdapterInterface $cache,
        private readonly EntityCacheKeyGenerator $generator,
    ) {
    }

    public function getDecorated(): AbstractAdviceRoute
    {
        throw new DecorationPatternException(self::class);
    }

    #[Route(
        path: '/store-api/find-advice',
        name: 'store-api.crehler.find-advice',
        methods: ['POST']
    )]
    public function searchAdvice(RequestDataBag $data, SalesChannelContext $salesChannelContext): SearchAdviceResponse
    {
        $streamIds = $data->get('streamIds');
        if (empty($streamIds)) {
            return new SearchAdviceResponse(new IdSearchResult(0, [], new Criteria(), $salesChannelContext->getContext()));
        }

        $criteria = (new Criteria())
            ->addAssociations(['salesChannels'])
            ->addFilter(new MultiFilter(
                MultiFilter::CONNECTION_AND,
                [
                    new EqualsFilter('salesChannels.id', $salesChannelContext->getSalesChannelId()),
                    new EqualsAnyFilter('productStreamId', $streamIds)
                ]
            ))
            ->setLimit(1);

        $adviceSearchResult = $this->adviceRepository->searchIds($criteria, $salesChannelContext->getContext());

        return new SearchAdviceResponse($adviceSearchResult);
    }

    #[Route(
        path: '/store-api/advice/{id}',
        name: 'store-api.crehler.advice',
        defaults: ['_entity' => 'crehler_advice'],
        methods: ['GET']
    )]
    public function getAdvice(string $id, SalesChannelContext $context): AdviceResponse
    {
        $item = $this->cache->getItem(
            $this->generateKey($id, $context)
        );
        try {
            if ($item->isHit() && $item->get()) {
                return new AdviceResponse(CacheCompressor::uncompress($item));
            }
        } catch (\Throwable) {
        }

        $advice = $this->adviceRepository->search(new Criteria([$id]), $context->getContext())->first();

        if (!$advice) {
            throw new AdviceNotFoundException($id);
        }


        $item = CacheCompressor::compress($item, $advice);
        $item->tag([self::buildName($id)]);
        $this->cache->save($item);

        return new AdviceResponse($advice);
    }

    private function generateKey(string $id, SalesChannelContext $context): string
    {
        return self::buildName($id) . '-' . $this->generator->getSalesChannelContextHash($context);
    }

    public static function buildName(string $id): string
    {
        return 'crehler-advice-' . $id;
    }
}

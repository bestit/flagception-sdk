<?php

namespace FeatureTox\Activator;

use DateInterval;
use FeatureTox\Model\Context;
use Psr\Cache\CacheItemPoolInterface as CachePool;

class CacheActivator implements FeatureActivatorInterface
{
    public const CACHE_KEY = 'FeatureTox';

    /**
     * The origin activator
     */
    private FeatureActivatorInterface $activator;

    private CachePool $cachePool;

    /**
     * Time to live for cache items
     * Valid values are identical to \Psr\Cache\CacheItemInterface
     *
     * @var int|DateInterval|null
     */
    private $cacheTtl;

    /**
     * Short memory request cache
     *
     * @var bool[]
     */
    private array $memory = [];

    public function __construct(FeatureActivatorInterface $activator, CachePool $cachePool, $cacheTtl = 3600)
    {
        $this->activator = $activator;
        $this->cachePool = $cachePool;
        $this->cacheTtl = $cacheTtl;
    }

    public function getActivator(): FeatureActivatorInterface
    {
        return $this->activator;
    }

    public function getName(): string
    {
        return $this->activator->getName();
    }

    public function isActive($name, Context $context): bool
    {
        $hash = static::CACHE_KEY . '#' . $this->getName() . '#' . md5($name . '-' . $context->serialize());

        // Step 1: Try get from memory cache
        if (array_key_exists($hash, $this->memory)) {
            return $this->memory[$hash];
        }

        // Step 2: Try get from (optional) cache
        $cacheItem = null;
        $cacheItem = $this->cachePool->getItem($hash);

        if ($cacheItem->isHit()) {
            $this->memory[$hash] = $cacheItem->get();
            return $this->memory[$hash];
        }

        // Step 3: Get from activators and save to cache
        $this->memory[$hash] = $this->activator->isActive($name, $context);

        // Write result to cache
        if ($cacheItem !== null) {
            $cacheItem->set($this->memory[$hash]);
            $cacheItem->expiresAfter($this->cacheTtl);
            $this->cachePool->save($cacheItem);
        }

        return $this->memory[$hash];
    }
}

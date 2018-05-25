<?php

namespace Flagception\Manager;

use DateInterval;
use Flagception\Activator\FeatureActivatorInterface as Activator;
use Flagception\Decorator\ContextDecoratorInterface as Decorator;
use Flagception\Model\Context;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Class FeatureManager
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Manager
 */
class FeatureManager implements FeatureManagerInterface
{
    /**
     * Cache key
     */
    const CACHE_KEY = 'flagception';

    /**
     * The feature activator
     *
     * @var Activator
     */
    private $activator;

    /**
     * The context decorator
     *
     * @var Decorator|null
     */
    private $decorator;

    /**
     * The cache pool
     *
     * @var CacheItemPoolInterface
     */
    private $cachePool;

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
    private $memory = [];

    /**
     * FeatureManager constructor.
     *
     * @param Activator $activator
     * @param Decorator|null $decorator
     */
    public function __construct(Activator $activator, Decorator $decorator = null)
    {
        $this->activator = $activator;
        $this->decorator = $decorator;
    }

    /**
     * Set a optional cache
     *
     * @param CacheItemPoolInterface $cachePool
     * @param int|DateInterval|null $ttl
     */
    public function setCache(CacheItemPoolInterface $cachePool, $ttl = 3600)
    {
        $this->cachePool = $cachePool;
        $this->cacheTtl = $ttl;
    }

    /**
     * {@inheritdoc}
     */
    public function isActive($name, Context $context = null)
    {
        if ($context === null) {
            $context = new Context();
        }

        if ($this->decorator !== null) {
            $context = $this->decorator->decorate($context);
        }

        $hash = static::CACHE_KEY . '-' . md5($name . '-' . $context->serialize());

        // Step 1: Try get from memory cache
        if (array_key_exists($hash, $this->memory)) {
            return $this->memory[$hash];
        }

        // Step 2: Try get from (optional) cache
        $cacheItem = null;
        if ($this->cachePool !== null) {
            $cacheItem = $this->cachePool->getItem($hash);

            if ($cacheItem->isHit()) {
                $this->memory[$hash] = $cacheItem->get();
                return $this->memory[$hash];
            }
        }

        // Step 3: Get from activators and save to cache
        $this->memory[$hash] = $this->activator->isActive($name, $context);

        // Write result to cache
        if ($this->cachePool !== null && $cacheItem !== null) {
            $cacheItem->set($this->memory[$hash]);
            $cacheItem->expiresAfter($this->cacheTtl);
            $this->cachePool->save($cacheItem);
        }

        return $this->memory[$hash];
    }
}

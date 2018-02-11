<?php

namespace Flagception\Manager;

use DateInterval;
use Flagception\Activator\FeatureActivatorInterface as Activator;
use Flagception\Collector\NullResultCollector;
use Flagception\Collector\ResultCollectorInterface;
use Flagception\Decorator\ContextDecoratorInterface as Decorator;
use Flagception\Model\Context;
use Flagception\Model\Result;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\NullAdapter;

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
    const CACHE_KEY = 'flagception-memory';

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
    private $cachePoolTtl;

    /**
     * Short memory request cache
     * Null if not initiated otherwise an array
     *
     * @var array|null
     */
    private $memory;

    /**
     * Result collector
     *
     * @var ResultCollectorInterface
     */
    private $collector;

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

        $this->cachePool = new NullAdapter();
        $this->collector = new NullResultCollector();
    }

    /**
     * Set a optional cache
     *
     * @param CacheItemPoolInterface $cachePool
     * @param int|DateInterval|null $timeToLive
     */
    public function setCachePool(CacheItemPoolInterface $cachePool, $timeToLive = null)
    {
        $this->cachePool = $cachePool;
        $this->cachePoolTtl = $timeToLive;
    }

    /**
     * Set optional collector
     *
     * @param ResultCollectorInterface $collector
     */
    public function setCollector(ResultCollectorInterface $collector)
    {
        $this->collector = $collector;
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

        $hash = md5($name . '-' . $context->serialize());

        // Load cache if not already done
        $cacheItem = $this->cachePool->getItem(static::CACHE_KEY);
        $this->memory = $this->memory === null && $cacheItem->isHit() ? $cacheItem->get() : [];

        // Check if we have already a cached result
        if (array_key_exists($hash, $this->memory)) {
            $result = $this->memory[$hash];
            $this->collector->add(new Result($name, $result, $context, 'cache'));

            return $result;
        }

        // Request result from activator
        $result = $this->activator->isActive($name, $context);

        if ($result instanceof Result) {
            $this->collector->add($result);
            $this->memory[$hash] = $result->isActive();
        } else {
            $this->collector->add(
                new Result($name, $result, $context, $result ? $this->activator->getName() : null)
            );
            $this->memory[$hash] = $result;
        }

        // Write result to cache
        $cacheItem->set($this->memory);
        $cacheItem->expiresAfter($this->cachePoolTtl);
        $this->cachePool->save($cacheItem);

        return $this->memory[$hash];
    }
}

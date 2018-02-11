<?php

namespace Flagception\Collector;

use Flagception\Model\Result;

/**
 * Class NullResultCollector
 *
 * @author Michel Chowanski <chowanski@bestit-online.de>
 * @package Flagception\Collector
 */
class NullResultCollector implements ResultCollectorInterface
{
    /**
     * {@inheritdoc}
     */
    public function add(Result $result)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
    }
}

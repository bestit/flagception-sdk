<?php

namespace Flagception\Collector;

use Flagception\Model\Result;

/**
 * Class ArrayResultCollector
 *
 * @author Michel Chowanski <chowanski@bestit-online.de>
 * @package Flagception\Collector
 */
class ArrayResultCollector implements ResultCollectorInterface
{
    /**
     * Result array
     *
     * @var Result[]
     */
    private $bag = [];

    /**
     * {@inheritdoc}
     */
    public function add(Result $result)
    {
        $this->bag[] = $result;
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->bag;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->bag = [];
    }
}

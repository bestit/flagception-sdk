<?php

namespace Flagception\Collector;

use Flagception\Model\Result;

/**
 * Interface ResultCollectorInterface
 *
 * @author Michel Chowanski <chowanski@bestit-online.de>
 * @package Flagception\Collector
 */
interface ResultCollectorInterface
{
    /**
     * Add one result
     *
     * @param Result $result
     *
     * @return void
     */
    public function add(Result $result);

    /**
     * Get all results
     *
     * @return Result[]
     */
    public function all();

    /**
     * Clear the bag
     *
     * @return void
     */
    public function clear();
}

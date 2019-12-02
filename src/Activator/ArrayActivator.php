<?php

namespace Flagception\Activator;

use Flagception\Model\Context;

/**
 * Class ArrayActivator
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Activator
 */
class ArrayActivator implements FeatureActivatorInterface
{
    /**
     * Array of features
     *
     * @var array
     */
    private $features;

    /**
     * ArrayActivator constructor.
     *
     * @param array $features
     */
    public function __construct(array $features = [])
    {
        $this->features = $features;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'array';
    }

    /**
     * {@inheritdoc}
     */
    public function isActive($name, Context $context)
    {
        if (array_key_exists($name, $this->features)) {
            return filter_var($this->features[$name], FILTER_VALIDATE_BOOLEAN);
        }

        return in_array($name, $this->features, true);
    }
}

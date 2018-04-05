<?php

namespace Flagception\Activator;

use Flagception\Model\Context;

/**
 * Activator for fetching feature states by cookie
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Activator
 */
class CookieActivator implements FeatureActivatorInterface
{
    /**
     * Allowed features
     *
     * @var array
     */
    private $features;

    /**
     * Cookie name
     *
     * @var string
     */
    private $name;

    /**
     * Cookie separator
     *
     * @var string
     */
    private $separator;

    /**
     * CookieActivator constructor.
     *
     * @param array $features
     * @param string $name
     * @param string $separator
     */
    public function __construct(array $features, $name = 'flagception', $separator = ',')
    {
        $this->features = $features;
        $this->name = $name;
        $this->separator = $separator;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cookie';
    }

    /**
     * {@inheritdoc}
     */
    public function isActive($name, Context $context)
    {
        if (!in_array($name, $this->features, true)) {
            return false;
        }

        if (!array_key_exists($this->name, $_COOKIE)) {
            return false;
        }

        return in_array($name, array_map('trim', explode($this->separator, $_COOKIE[$this->name])), true);
    }
}

<?php

namespace FeatureTox\Model;

use FeatureTox\Exception\AlreadyDefinedException;
use Serializable;

/**
 * Class Context
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package FeatureTox\Model
 */
class Context implements Serializable
{
    /**
     * Storage for all context values
     *
     * @var array
     */
    private $storage = [];

    /**
     * Add a context value. The key must be unique and cannot be replaced
     *
     * @param string $name
     * @param mixed $value
     *
     * @return void
     * @throws AlreadyDefinedException
     */
    public function add($name, $value)
    {
        if (array_key_exists($name, $this->storage)) {
            throw new AlreadyDefinedException(sprintf('Context value with key `%s` already defined', $name));
        }

        $this->storage[$name] = $value;
    }

    /**
     * Replace a context value
     *
     * @param string $name
     * @param mixed $value
     *
     * @return void
     */
    public function replace($name, $value)
    {
        $this->storage[$name] = $value;
    }

    /**
     * Get context value of given string or default value
     *
     * @param string $name
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($name, $default = null)
    {
        return array_key_exists($name, $this->storage) ? $this->storage[$name] : $default;
    }

    /**
     * Get all context values (key => value pairs)
     *
     * @return array
     */
    public function all()
    {
        return $this->storage;
    }

    /**
     * Has given context value
     *
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->storage);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize($this->storage);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $this->storage = unserialize($serialized);
    }

    public function __serialize()
    {
        return [$this->serialize()];
    }

    public function __unserialize(array $data)
    {
        $this->unserialize($data[0]);
    }
}

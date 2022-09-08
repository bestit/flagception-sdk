<?php

namespace FeatureTox\Model;

use FeatureTox\Exception\AlreadyDefinedException;
use Serializable;

class Context implements Serializable
{
    private array $storage = [];

    /**
     * Add a context value. The key must be unique and cannot be replaced
     *
     * @param string $name
     * @param mixed $value
     *
     * @return void
     * @throws AlreadyDefinedException
     */
    public function add(string $name, $value): void
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
    public function replace(string $name, $value): void
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
    public function get(string $name, $default = null)
    {
        return array_key_exists($name, $this->storage) ? $this->storage[$name] : $default;
    }

    /**
     * Get all context values (key => value pairs)
     *
     * @return array
     */
    public function all(): array
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
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->storage);
    }

    public function serialize(): ?string
    {
        return serialize($this->storage);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized): void
    {
        $this->storage = unserialize($serialized);
    }

    public function __serialize(): array
    {
        return [$this->serialize()];
    }

    public function __unserialize(array $data)
    {
        $this->unserialize($data[0]);
    }
}

<?php

namespace FeatureTox\Activator;

use FeatureTox\Exception\InvalidArgumentException;
use FeatureTox\Model\Context;

class CookieActivator implements FeatureActivatorInterface
{
    /**
     * Activator should act as whitelist
     */
    public const WHITELIST = 'whitelist';

    /**
     * Activator should act as blacklist
     */
    public const BLACKLIST = 'blacklist';

    private array $features;

    private string $name;

    private string $separator;

    private string $mode;

    /**
     * @var callable|null
     */
    private $extractor;

    /**
     * CookieActivator constructor.
     *
     * @param array $features
     * @param string $name
     * @param string $separator
     * @param string $mode
     * @param callable|null $extractor
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        array $features,
        string $name = 'FeatureTox',
        string $separator = ',',
        string $mode = self::WHITELIST,
        callable $extractor = null
    ) {
        if (!in_array($mode, [self::BLACKLIST, self::WHITELIST], true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid mode argument for cookie activator: "%s". Expected: "whitelist" or "blacklist"',
                    $mode
                )
            );
        }

        $this->features = $features;
        $this->name = $name;
        $this->separator = $separator;
        $this->mode = $mode;

        // Extractor callable
        $this->extractor = $extractor ? $extractor : function ($name) {
            if (!array_key_exists($name, $_COOKIE)) {
                return null;
            }

            return $_COOKIE[$name];
        };
    }

    public function getName(): string
    {
        return 'cookie';
    }

    public function isActive($name, Context $context): bool
    {
        // Disable features which aren't whitelisted
        if ($this->mode === self::WHITELIST && !in_array($name, $this->features, true)) {
            return false;
        }

        // Disable features which are blacklisted
        if ($this->mode === self::BLACKLIST && in_array($name, $this->features, true)) {
            return false;
        }

        // Enable, if cooke exists and feature is set in cookie
        if ($cookieData = call_user_func($this->extractor, $this->name, $name, $context)) {
            return in_array($name, array_map('trim', explode($this->separator, $cookieData)), true);
        }

        return false;
    }
}

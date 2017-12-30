<?php

namespace Flagception\Factory;

use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Class ExpressionLanguageFactory
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Factory
 */
class ExpressionLanguageFactory
{
    /**
     * The expression language providers
     *
     * @var ExpressionFunctionProviderInterface[]
     */
    private $providers;

    /**
     * Add provider
     *
     * @param ExpressionFunctionProviderInterface $provider
     *
     * @return void
     */
    public function addProvider(ExpressionFunctionProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }

    /**
     * Create expression language
     *
     * @return ExpressionLanguage
     */
    public function create()
    {
        $language = new ExpressionLanguage();

        foreach ($this->providers as $provider) {
            $language->registerProvider($provider);
        }

        return $language;
    }
}

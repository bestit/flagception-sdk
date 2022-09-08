<?php

namespace FeatureTox\Manager;

use FeatureTox\Model\Context;

interface FeatureManagerInterface
{
    public function isActive($name, Context $context = null): bool;
}

ChainActivator
-------------------------
The `ChainActivator` hold multiple other activators and forward the feature request until one activator returns true.
Just create an instance and add some activators. Example:

```php
// MyClass.php
class MyClass
{
    public function doSomething()
    {
        $activator = new ChainActivator();
        $activator->add(new ArrayActivator([
            'feature_foo'
        ]));
        $activator->add(new YourCustomActivator());

        $manager = new FeatureManager($activator);

        // The array activator returns false, so it will request YourCustomActivator.
        if ($manager->isActive('feature_def')) {
            // do something
        }
    }
}
```

The `ChainActivator` use the "first match" strategy. At least one activator must return `true` for activating the feature.
You can change the strategy to "match all". Then **all** activators must return `true` for activating the feature.

Pass your needed strategy via constructor argument ... 

```php
// MyClass.php
class MyClass
{
    public function doSomething()
    {
        $activator = new ChainActivator(ChainActivator::STRATEGY_ALL_MATCH);
        // ...
    }
}
```

... or by context:

```php
// MyClass.php
class MyClass
{
    public function doSomething()
    {
        $activator = new ChainActivator();
        $activator->add(new ArrayActivator([
            'feature_foo'
        ]));
        $activator->add(new YourCustomActivator());

        $manager = new FeatureManager($activator);

        $context = new Context();
        $context->add('chain_strategy', ChainActivator::STRATEGY_ALL_MATCH);

        // The array activator returns false, so it will request YourCustomActivator.
        if ($manager->isActive('feature_def', $context)) {
            // do something
        }
    }
}
```

The strategy defined in context will override the strategy defined in constructor.

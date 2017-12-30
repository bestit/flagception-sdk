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

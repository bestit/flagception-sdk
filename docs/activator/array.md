ArrayActivator
-------------------------
The `ArrayActivator` needs
an array with active feature names as constructor argument. If the requested feature is in array, it will return true
otherwise false. Example:

```php
// MyClass.php
class MyClass
{
    public function doSomething()
    {
        $activator = new ArrayActivator([
            'feature_abc',
            'feature_def',
            'feature_ghi'
        ]);

        $manager = new FeatureManager($activator);

        // Will return true
        if ($manager->isActive('feature_def')) {
            // do something
        }

        // Will return false
        if ($manager->isActive('feature_wxy')) {
            // do something
        }
    }
}
```

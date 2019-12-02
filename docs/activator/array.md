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

In addition, you can pass an associative array with the feature name as key and the feature state as value. Value should
be a `boolean` or a type which can be cast to `boolean` by the `filter_var` method.

```php
// MyClass.php
class MyClass
{
    public function doSomething()
    {
        $activator = new ArrayActivator([
            'feature_abc' => true,          // Activate the feature
            'feature_def' => 'false',       // Disable the feature
            'feature_ghi' => 'yes'          // Activate the feature
            'feature_qwe' => 0              // Disable the feature
        ]);

        $manager = new FeatureManager($activator);

        // Will return true
        if ($manager->isActive('feature_ghi')) {
            // do something
        }

        // Will return false
        if ($manager->isActive('feature_wxy')) {
            // do something
        }
    }
}
```
EnvironmentActivator
-------------------------
The `EnvironmentActivator` will use environment variables for enable or disable a feature. In some cases your environment
variable names does not match your feature names. So you can define a simple map (array) as first constructor argument.

Simple example: You have a feature `foo_bar` but your environment variables looks like `FEATURE_FOO_BAR`. Your class should
be something like this:

```php
// MyClass.php
class MyClass
{
    public function doSomething()
    {
        // Define the map: feature name (as key) => environment name (as value)
        $activator = new EnvironmentActivator([
            'foo_bar' => 'FEATURE_FOO_BAR'
        ]);

        $manager = new FeatureManager($activator);

        // Will return true
        if ($manager->isActive('foo_bar')) {
            // do something
        }

        // Will return false
        if ($manager->isActive('bazz_voo')) {
            // do something
        }
    }
}
```

If you don't need a map because your features names are identical to your environment names, you can skip the map and set
the second constructor argument to `true`. This force the activator for checking the environment variable - equal if you
have set a map or not:

```php
// MyClass.php
class MyClass
{
    public function doSomething()
    {
        // putenv('foo_bar=true');
        $activator = new EnvironmentActivator([], true);

        $manager = new FeatureManager($activator);

        // Will return true
        if ($manager->isActive('foo_bar')) {
            // do something
        }

        // Will return false
        if ($manager->isActive('bazz_voo')) {
            // do something
        }
    }
}
```

Of course, you can set both arguments. In this case, the activator will use the map and, if there is no entry, 
query the environment variables directly:

```php
// MyClass.php
class MyClass
{
    public function doSomething()
    {
        // putenv('feature_abc=true');
        $activator = new EnvironmentActivator([
            'foo_bar' => 'FEATURE_FOO_BAR'
        ], true);

        $manager = new FeatureManager($activator);

        // Will return true
        if ($manager->isActive('foo_bar')) {
            // do something
        }

        // Will return true also
        if ($manager->isActive('feature_abc')) {
            // do something
        }
        
        // Will return false
        if ($manager->isActive('feature_def')) {
            // do something
        }
    }
}
```

ArrayDecorator
-------------------------
The `ArrayDecorator` expect an array with key / value pairs and merge it into the context object. Example:

```php
// MyClass.php
class MyClass
{
    public function doSomething(User $user)
    {
        $activator = new YourCustomDoctrineActivator();
        $decorator = new ArrayDecorator([
            'user_id' => $user->getId()
        ]);

        $manager = new FeatureManager($activator, $decorator);

        // Check the feature with the global defined context         
        if ($manager->isActive('feature_def')) {
            // do something
        }
    }
}
```

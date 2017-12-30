ChainDecorator
-------------------------
The `ChainDecorator` hold multiple other decorators and execute one after another. Example:

```php
// MyClass.php
class MyClass
{
    public function doSomething(User $user)
    {
        $activator = new ArrayActivator();
        $decorator = new ChainActivator();
        $decorator->add(new ArrayDecorator([
            'user_id' => $user->getId(),
            'user_role' => $user->GetRole()
        ]));
        $decorator->add(new YourCustomDecorator();

        $manager = new FeatureManager($activator, $decorator);

        // Check the feature with the global defined context
        if ($manager->isActive('feature_def')) {
            // do something
        }
    }
}
```

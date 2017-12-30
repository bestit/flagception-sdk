ConstraintActivator
-------------------------
The `ConstraintActivator` return true or false by checking a constraint. The constraint is a string
expression for the symfony [expression language](https://symfony.com/doc/current/components/expression_language.html) and must
return true or false. The activator expect an array with feature name as key and the expression as value. Additional, it needs
a constraint resolver which implement the `ConstraintResolverInterface`. Example:

```php
// MyClass.php
class MyClass
{
    public function doSomething(User $user)
    {
        $expressionLanguage = new ExpressionLanguage();
        $constraintResolver = new ConstraintResolver($expressionLanguage);
        
        $features = [
            'feature_foo' => 'user_role === "Admin"',
            'feature_def' => 'user_role === "Guest"',
        ];
        
        $activator = new ConstraintActivator($constraintResolver, $features);

        $context = new Context();
        $context->add('user_role', $user->getRole());
        
        $manager = new FeatureManager($activator);

        // This will return true if user role is 'Guest' otherwise false.
        if ($manager->isActive('feature_def', $context)) {
            // do something
        }
    }
}
```

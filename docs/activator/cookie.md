CookieActivator
-------------------------
The `CookieActivator` is useful if you want to test some parts of your code dynamically by setting a cookie. 
You just need to pass an array with allowed feature names. Only features which are passed in constructor can be enabled
by a cookie. 

Example:

```php
// MyClass.php
class MyClass
{
    public function doSomething()
    {
        $activator = new CookieActivator([
            'feature_abc',
            'feature_ghi'
        ]);

        $manager = new FeatureManager($activator);

        // Will return true, if you have set a cookie called "flagception" with value "feature_abc")
        if ($manager->isActive('feature_abc')) {
            // do something
        }

        // Will return alway false, because this feature is not passed to cookie activator
        if ($manager->isActive('feature_wxy')) {
            // do something
        }
    }
}
```

As default, the cookie must called "flagception" but you can (and should!) set a custom cookie name as second argument.
You can activate several features if you join the features names with a separator (third argument).

Example:

 ```php
 // MyClass.php
 class MyClass
 {
     public function doSomething()
     {
         $activator = new CookieActivator([
             'feature_abc',
             'feature_ghi'
         ], 'my_cookie_name', '|');
 
         $manager = new FeatureManager($activator);
 
         // Will return true, if you have set a cookie called "my_cookie_name" with value "feature_abc|feature_ghi")
         if ($manager->isActive('feature_abc')) {
             // do something
         }
         
         // Will return true, if you have set a cookie called "my_cookie_name" with value "feature_abc|feature_ghi")
         if ($manager->isActive('feature_ghi')) {
             // do something
         }
 
         // Will return alway false, because this feature is not passed to cookie activator
         if ($manager->isActive('feature_wxy')) {
             // do something
         }
     }
 }
 ```
 
The CookieActivator acts as whitelist. You can change this behavior to a blacklist if you set the fourth argument.
 
 Example:
 
  ```php
  // MyClass.php
  class MyClass
  {
      public function doSomething()
      {
          $activator = new CookieActivator([
              'feature_abc',
              'feature_ghi'
          ], 'my_cookie_name', '|', CookieActivator::BLACKLIST);
  
          $manager = new FeatureManager($activator);
          
          // Will return true, if you have set a cookie called "my_cookie_name" with value "feature_wxy|feature_ghi")
          if ($manager->isActive('feature_wxy')) {
              // do something
          }
  
          // Will return always false, because the feature is blacklisted
          if ($manager->isActive('feature_abc')) {
              // do something
          }
          
          // Will return always false, because the feature is blacklisted
          if ($manager->isActive('feature_ghi')) {
              // do something
          }
      }
  }
  ```
 
 ### Beware!
 Cookies are not secure. You should only use this activator for internal stuff. Do not use this for critical or public parts
 of your project.
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

        // Will return true, if you have set a cookie called "FeatureTox" with value "feature_abc")
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

As default, the cookie must called "FeatureTox" but you can (and should!) set a custom cookie name as second argument.
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
  
 ### Cookie extractor
 We extract our cookie content via the global `$_COOKIE`. This should fit the most cases. But some frameworks have their own
 implementation for cookies. You can pass a callable as fifth argument if you want to implement them.
 
Here an example:

   ```php
   // MyClass.php
   class MyClass
   {
       public function doSomething()
       {
           $myCookieHandler = new MyCookieHandler();
       
           $activator = new CookieActivator(
               ['feature_wxy'],
               'my_cookie_name', 
               '|',
               CookieActivator::WHITELIST,
               function ($name) use ($myCookieHandler) {
                    return $myCookieHandler->get($name);
               }
           );
   
           $manager = new FeatureManager($activator);
           
           if ($manager->isActive('feature_wxy')) {
               // do something
           }
       }
   }
   ```
 
 The callable can be an [invoke object](https://www.php.net/manual/en/language.oop5.magic.php#object.invoke) too.
 
 ### Beware!
 Cookies are not secure. You should only use this activator for internal stuff. Do not use this for critical or public parts
 of your project.
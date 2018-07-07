CacheActivator
-------------------------
The `CacheActivator` acts like a decorator for heavy activators. You can use this activator for caching results from
other activators (which requests states via http or other heavy requests).

This activator required an instance of the "decorated" feature activator and an instance of a [PSR-6](https://packagist.org/packages/psr/cache)
 cache. Optionally, you can set the cache time (seconds or `DateInterval`) as third argument (default: 3600 seconds).
 
Simple example:

```php
// MyClass.php
class MyClass
{
    /** @var CacheItemPoolInterface */
    private $cachePool;

    public function doSomething()
    {
        $activator = new CacheActivator(
            new YourHeavyHttpActivator(),       // Your activator
            $this->cachePool,                   // Cache instance
            3600                                // Cache lifetime (default: 3600)
        );

        $manager = new FeatureManager($activator);

        // Will request feature from `YourHeavyHttpActivator`
        if ($manager->isActive('feature_def')) {
            // do something
        }

        // Will return the cache result from first request and does not execute `feature_def`
        if ($manager->isActive('feature_def')) {
            // do something
        }
    }
}
```

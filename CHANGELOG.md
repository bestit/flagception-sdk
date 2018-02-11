## Unreleased
### Added
- Add new `ResultCollectorInterface` for collecting results @migo315
- Add new `NullResultCollector` @migo315
- Add new `ArrayResultCollector` @migo315
- Add optional cache for `FeatureManager` for caching feature results @migo315
- Add optional result collector for `FeatureManager` logging feature results @migo315
- Add new [CookieActivator](docs/activator/cookie.md) @migo315

### Changed
- The method `isActive` from `FeatureActivatorInterface` can also return a `Result` object instead of `bool` @migo315 
- The `ChainActivator` returns now a `Result` object instead of `bool` / no breaking change because `FeatureManager` will handle it @migo315

## [1.1.0]
### Added
- Add new [EnvironmentActivator](docs/activator/environment.md) @migo315
- Add `flagception/contentful-activator` as suggest @migo315

## [1.0.0]
### Added
- Initial commit and release @migo315

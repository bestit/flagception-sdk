## [1.7.0]
### Added
- Add support for PHP8 @Schleuse

### Removed
- Removed Phing as dev dependency @Schleuse

## [1.6.0]
### Added
- \#24 Add `_feature` key with feature name to `Context` instance @ajgarlag

## [1.5.0]
### Changed
- The [EnvironmentActivator](docs/activator/environment.md) looks for values by `$_ENV` and `getenv()` @migo315
- The [ArrayActivator](docs/activator/array.md) accept associative array in addition to numeric arrays @migo315

### Added
- \#19 Add cookie extractor callable for [CookieActivator](docs/activator/cookie.md) @migo315
- \#15 Support PHP7.3 in travics for tests @migo315
- \#13 Add "match all" strategy for [ChainActivator](docs/activator/chain.md) @migo315

## [1.4.0]
### Added
- \#16 Add new blacklist mode for [CookieActivator](docs/activator/cookie.md) @migo315

## [1.3.0]
### Added
- \#1 \#4 Add new [CacheActivator](docs/activator/cache.md) @migo315

## [1.2.0]
### Added
- Add new [CookieActivator](docs/activator/cookie.md) @migo315
- Add getters for activator and decorator bag in chain classes @migo315

## [1.1.0]
### Added
- Add new [EnvironmentActivator](docs/activator/environment.md) @migo315
- Add `flagception/contentful-activator` as suggest @migo315

## [1.0.0]
### Added
- Initial commit and release @migo315

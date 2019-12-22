# cache

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

PublishingKit/Cache is a wrapper around a PSR6-compatible caching library to make it more convenient to work with.

In addition, it also provides factory classes for creating instances of the following caches:

* `tedivm/stash`
* `symfony/cache`

However, the factory classes do not support every driver.

In theory it should also be easy to add support for other PSR6-compatible caches.

## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practices by being named the following.

```
bin/        
build/
docs/
config/
src/
tests/
vendor/
```


## Install

Via Composer

``` bash
$ composer require publishing-kit/cache
```

## Usage

``` php
$wrapper = new PublishingKit\Cache\Services\Cache\Psr6Cache($cache);
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email 450801+matthewbdaly@users.noreply.github.com instead of using the issue tracker.

## Credits

- [Matthew Daly][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/publishing-kit/cache.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/publishing-kit/cache/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/publishing-kit/cache.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/publishing-kit/cache.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/publishing-kit/cache.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/publishing-kit/cache
[link-travis]: https://travis-ci.org/publishing-kit/cache
[link-scrutinizer]: https://scrutinizer-ci.com/g/publishing-kit/cache/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/publishing-kit/cache
[link-downloads]: https://packagist.org/packages/publishing-kit/cache
[link-author]: https://github.com/matthewbdaly
[link-contributors]: ../../contributors

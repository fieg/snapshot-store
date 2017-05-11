# Snapshot Store

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]

Library for storing snapshots

## Installation

```sh
composer require treehouselabs/snapshot-store
```

## Database

Basic SQL schema for snapshot store. Adapt to your needs.

```sql
CREATE TABLE `snapshot_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aggregate_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `version` int(11) NOT NULL,
  `datetime_created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D1F10563D0BBCCBEBF1CD3C3` (`aggregate_id`,`version`)
)
```


## Testing

```bash
composer test
```


## Security

If you discover any security related issues, please email dev@treehouse.nl instead of using the issue tracker.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


## Credits

- [Jeroen Fiege][link-fieg]
- [All Contributors][link-contributors]


[ico-version]: https://img.shields.io/packagist/v/treehouselabs/snapshot-store.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/treehouselabs/snapshot-store/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/treehouselabs/snapshot-store.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/treehouselabs/snapshot-store.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/treehouselabs/snapshot-store.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/treehouselabs/snapshot-store
[link-travis]: https://travis-ci.org/treehouselabs/snapshot-store
[link-scrutinizer]: https://scrutinizer-ci.com/g/treehouselabs/snapshot-store/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/treehouselabs/snapshot-store
[link-downloads]: https://packagist.org/packages/treehouselabs/snapshot-store
[link-author]: https://github.com/treehouselabs
[link-contributors]: ../../contributors
[link-fieg]: https://github.com/fieg

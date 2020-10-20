# Some small helper for customize paginator links.


## Allows to pass route name to paginator for generate custom URLs.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nulltex/laravel-paginator.svg?style=flat-square)](https://packagist.org/packages/nulltex/laravel-paginator)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/nulltex/laravel-paginator/run-tests?label=tests)](https://github.com/nulltex/laravel-paginator/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/nulltex/laravel-paginator.svg?style=flat-square)](https://packagist.org/packages/nulltex/laravel-paginator)

## Installation

You can install the package via composer:

```bash
composer require nulltex/laravel-paginator
```

## Usage

You can use ``setRoute()`` method for set custom route name that will be used for generate pagination links.

Example:
``` php
$query = Model::query();
$paginator = $query->paginate()->setRoute(['route.name'])
```

By default paginator generates relative URL.
If you want to use absolute ones just call ``setRouteAbsoluteUrl()``
``` php
$paginator->setRouteAbsoluteUrl(true)
```

Note: ``$pageName`` (default values is ``page``) will be automatically applied to the route params.
If you want to change it just use ``setPageName()``.

For send some additional params into Route (excepting ``$pageName``) pass them as array in the second item:
``` php
$query = Model::query();
$paginator = $query->paginate()->setRoute(['route.name', ['param' => 'value']])
```


## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [nulltex](https://github.com/nulltex)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


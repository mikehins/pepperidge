# Pepperidge

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Travis](https://img.shields.io/travis/mikehins/Pepperidge.svg?style=flat-square)]()
[![Total Downloads](https://img.shields.io/packagist/dt/mikehins/Pepperidge.svg?style=flat-square)](https://packagist.org/packages/mikehins/Pepperidge)

[![](https://i.imgflip.com/6tmdsq.jpg)]

## Description
A modern classic stack
Setup jquery and bootstrap 5 with vite js or webpack with hot reload
Use Laravel mix/webpack in Laravel 9 with bootstrap 5 and authentification views like in the good old days.

## Install

`composer require mikehins/pepperidge`

## Usage

```bash
php artisan pepperidge:remembers
```

Be sure to add the scripts in your templates
```php
@vite(['resources/sass/app.scss', 'resources/js/app.js'])

- or

<link rel="stylesheet" href="{{ mix('css/app.css') }}">
<script src="{{ mix('js/app.js') }}" defer></script>
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Mike Hins](https://github.com/mikehins)
- [All Contributors](https://github.com/mikehins/Pepperidge/contributors)

## Security

If you discover any security-related issues, please email mike@hins.dev instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](/LICENSE.md) for more information.

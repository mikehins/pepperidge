# Pepperidge for laravel 9

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Travis](https://img.shields.io/travis/mikehins/Pepperidge.svg?style=flat-square)]()
[![Total Downloads](https://img.shields.io/packagist/dt/mikehins/Pepperidge.svg?style=flat-square)](https://packagist.org/packages/mikehins/Pepperidge)
[![wakatime](https://wakatime.com/badge/github/mikehins/pepperidge.svg)](https://wakatime.com/badge/github/mikehins/pepperidge)

[![](https://i.imgflip.com/6tmdsq.jpg)]

## Description

***A modern classic stack***

Ok Boomers !

We worked so hard to be comfortable in our old slippers and now the kids are trying to change our old ways with their javascripting nonsense. Well take that punks !

Bring back the good old stuff !

This package helps you scaffold your application with jQuery, bootstrap and laravel blade authentification.

Comes with vite or webpack with **hot reload** !!!

Embrace the ease and comfort of your old dusty stack with the power of the modern web with one free and easy to use package.

## Install

```
composer require mikehins/pepperidge
```

## Usage

```bash
php artisan pepperidge:remembers
```

```bash
// Vite
npm install && npm run dev

// Webpack
npm install && npm run hot
```

```
Type : 
  [1] Vite
  [2] Webpack

With authentification ?:
  [0] yes
  [1] no
  
  
// We need the next info for webpack hot reload or vite with custom domain name

What is the domain name ?:
 > my-domain.dev

SSL Certificates path:
 > /path/to/ssl/certficate.pem

SSL private key path:
 > /path/to/ssl/private.key
```

That's it there you have it... You have now the same tools that you used when you were young, beautiful and full of potential.

## Troubleshooting

if you get the error `Error: EACCES: permission denied, open '/etc/letsencrypt/live/domain.com/privkey.pem'` create a group, add your user to it and change the permission on the group.

[More info here](https://stackoverflow.com/questions/48078083/lets-encrypt-ssl-couldnt-start-by-error-eacces-permission-denied-open-et#answer-54903098)

```bash
sudo addgroup nodecert
sudo adduser {your username} nodecert
sudo adduser root nodecert

sudo chgrp -R nodecert /etc/letsencrypt/live
sudo chgrp -R nodecert /etc/letsencrypt/archive
sudo chmod -R 750 /etc/letsencrypt/live
sudo chmod -R 750 /etc/letsencrypt/archive
sudo reboot

# You can reset permission with this command
sudo groupdel nodecert
sudo chown -R :root /etc/letsencrypt/live
sudo chown -R :root /etc/letsencrypt/archive

# If it's not working you can try to add your group
sudo chgrp -R {your group} /etc/letsencrypt/live
sudo chgrp -R {your group} /etc/letsencrypt/archive
sudo chmod -R 750 /etc/letsencrypt/live
sudo chmod -R 750 /etc/letsencrypt/archive
sudo reboot
```


## TODO

- [x] Make sass files hot reloadable
- [ ] Make "hot reload" or "custom domain" optional
- [ ] Preset with examples for vue 2.x 3.x
- [ ] Preset with examples for Inertia
- [ ] Change the package name for boomer ??? `php artisan ok:boomer`
- [ ] ...

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
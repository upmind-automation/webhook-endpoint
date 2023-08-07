# [Upmind Automation](https://github.com/upmind-automation) - Webhook Endpoint

[![Latest Version on Packagist](https://img.shields.io/packagist/v/upmind/webhook-endpoint.svg?style=flat-square)](https://packagist.org/packages/upmind/webhook-endpoint)
[![Test](https://github.com/upmind-automation/webhook-endpoint/actions/workflows/test.yml/badge.svg)](https://github.com/upmind-automation/webhook-endpoint/actions/workflows/test.yml)

This PHP library simplifies server implementations for receiving webhooks from Upmind. Refer to the [Upmind Webhooks](https://docs.upmind.com/docs/webhooks) guide to configure your first webhook endpoint.

- [Installation](#installation)
  - [Requirements](#requirements)
- [Usage](#usage)
  - [Quick-start](#quick-start)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)
- [Upmind](#upmind)

## Installation

```bash
composer require upmind/webhook-endpoint
```

### Requirements

- PHP (7.4, 8.0, 8.1, 8.2)
- Composer

## Usage

The [Examples](/examples) directory contains sample code for how to use this library to implement your endpoint and consume Upmind webhooks.

### Quick-start

The following example shows how to consume and authenticate webhooks using plain PHP:

https://github.com/upmind-automation/webhook-endpoint/blob/36ed188d74cde958b59cdedb2d019be40e62352a/examples/vanilla-endpoint.php#L1-L38

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

 - [Harry Lewis](https://github.com/uphlewis)
 - [All Contributors](../../contributors)

## License

GNU General Public License version 3 (GPLv3). Please see [License File](LICENSE.md) for more information.

## Upmind

Sell, manage and support web hosting, domain names, ssl certificates, website builders and more with [Upmind.com](https://upmind.com/start).

# Change Log

All notable changes to this project will be documented in this file.

This projects adheres to [Semantic Versioning](http://semver.org/) and [Keep a CHANGELOG](http://keepachangelog.com/).

## [Unreleased][unreleased]
-

## [4.3.2] - 2023-01-31
### Composer

- Changed `php` from `>=8.0` to `>=7.4`.
Full set of changes: [`4.3.1...4.3.2`][4.3.2]

[4.3.2]: https://github.com/pronamic/wp-pronamic-pay-ideal-advanced-v3/compare/v4.3.1...v4.3.2

## [4.3.1] - 2023-01-18

### Commits

- Error class now extends \Exception class. ([98a3e04](https://github.com/pronamic/wp-pronamic-pay-ideal-advanced-v3/commit/98a3e04482843603911a2ea102fdb063c0772b7d))
- Don't filter all values with `sanitize_text_field()`, this function removes line breaks. ([b532090](https://github.com/pronamic/wp-pronamic-pay-ideal-advanced-v3/commit/b532090bf3c40dcf1b7a84123842463112bbf0d3))
- Ignore `documentation` folder in archive files. ([9f4d75f](https://github.com/pronamic/wp-pronamic-pay-ideal-advanced-v3/commit/9f4d75f724c60e430c6013a56e3154fd8f5aa604))
- Happy 2023. ([08fb979](https://github.com/pronamic/wp-pronamic-pay-ideal-advanced-v3/commit/08fb979cba9d6c7164148c49bc5ad535a6187d0a))

Full set of changes: [`4.3.0...4.3.1`][4.3.1]

[4.3.1]: https://github.com/pronamic/wp-pronamic-pay-ideal-advanced-v3/compare/v4.3.0...v4.3.1

## [4.3.0] - 2022-12-22

### Commits

- Fixed fatal error in gateway settings if function `escapeshellarg()` is undefined. ([0b3d684](https://github.com/pronamic/wp-pronamic-pay-ideal-advanced-v3/commit/0b3d684daca1105941c38dba636bd1cf9934e40f))
- Only print OpenSSL shell command if function `escapeshellarg()` is available. ([48a5318](https://github.com/pronamic/wp-pronamic-pay-ideal-advanced-v3/commit/48a5318bf32b219268500a2501f8b89184347f22))
- Use `pronamic/wp-http` for requests and SimpleXML. ([e532326](https://github.com/pronamic/wp-pronamic-pay-ideal-advanced-v3/commit/e53232633eddecf952fed45389bb9281eb00a2cb))
- Removed usage of deprecated `\FILTER_SANITIZE_STRING` in gateway settings fields. ([7c4d43c](https://github.com/pronamic/wp-pronamic-pay-ideal-advanced-v3/commit/7c4d43ce74f7ecfce6ca8cb90169815136e0ed72))
- No longer use `XMLSecurityDSig` library. ([20bee7c](https://github.com/pronamic/wp-pronamic-pay-ideal-advanced-v3/commit/20bee7ccf1ada278e303464dc11d3175718edc66))

### Composer

- Added `pronamic/wp-http` `^1.1`.
- Changed `php` from `>=5.6.20` to `>=8.0`.
- Changed `wp-pay-gateways/ideal` from `^4.0` to `v4.1.0`.
	Release notes: https://github.com/pronamic/wp-pronamic-pay-ideal/releases/tag/v4.2.0
- Changed `wp-pay/core` from `^4.0` to `v4.6.0`.
	Release notes: https://github.com/pronamic/wp-pay-core/releases/tag/v4.2.0
Full set of changes: [`4.2.0...4.3.0`][4.3.0]

[4.3.0]: https://github.com/pronamic/wp-pronamic-pay-ideal-advanced-v3/compare/v4.2.0...v4.3.0

## [4.2.0] - 2022-09-26
- Updated payment methods registration.
- Rename 'Private Key' and 'Private Certificate' to 'Secret Key' and 'Certificate'.

## [4.1.0] - 2022-04-11
- Removed test.
- Removed gateway error usage, exception should be handled downstream.

## [4.0.0] - 2022-01-11
### Changed
- Updated to https://github.com/pronamic/wp-pay-core/releases/tag/4.0.0.

## [3.0.0] - 2021-08-05
- Updated to `pronamic/wp-pay-core`  version `3.0.0`.
- Updated to `pronamic/wp-money`  version `2.0.0`.
- Switched to `pronamic/wp-coding-standards`.

## [2.1.4] - 2021-04-26
- Happy 2021.

## [2.1.3] - 2020-11-17
- Fix regression in payment status retrieval.

## [2.1.2] - 2020-11-10
- Fix setting acquirer URL.

## [2.1.1] - 2020-03-26
- Fix incomplete gateway settings.

## [2.1.0] - 2020-03-19
- Update setting consumer bank details.
- Extend from AbstractGatewayIntegration class.

## [2.0.5] - 2019-12-22
- Added URL to manual in gateway settings.
- Improved error handling with exceptions.

## [2.0.4] - 2019-08-30
- Removed 'Show details…' toggle link from settings, was no longer working.

## [2.0.3] - 2019-08-27
- Updated packages.

## [2.0.2] - 2018-12-12
- Use issuer field from core gateway.
- Updated deprecated function calls.

## [2.0.1] - 2018-05-16
- Fixed "Fatal error: Uncaught Error: Call to a member function get_amount() on float".

## [2.0.0] - 2018-05-09
- Switched to PHP namespaces.

## [1.1.12] - 2017-12-12
- WordPress Coding Standards improvements.
- Fixed IBAN/BIC typos in comments.

## [1.1.11] - 2017-09-13
- Fix for a incorrect implementation at https://www.ideal-checkout.nl/simulator/.
- Some acquirers only accept fingerprints in uppercase.
- Updated WordPress Coding Standards.

## [1.1.10] - 2017-04-07
- Removed surrounding quotes from subject, these are already added by `escapeshellarg()`.

## [1.1.9] - 2016-11-16
- Simplified settings fields.

## [1.1.8] - 2016-10-28
- Fixed zero days private certificate validity in OpenSSL command.

## [1.1.7] - 2016-10-20
- Added `payment_status_request` feature support.
- Removed schedule status check event, this will be part of the Pronamic iDEAL plugin.

## [1.1.6] - 2016-07-06
- Adjusted check on required distinguished name keys/values.
- Added some early returns + escapeshellarg calls.

## [1.1.5] - 2016-06-08
- Added payment method requirement.
- Simplified the gateway payment start function.

## [1.1.4] - 2016-03-22
- Updated gateway settings, including private key and certificate generation.
- Added error details to error message.

## [1.1.3] - 2016-03-02
- Copied Security class from the wp-pay-gateways/ideal-advanced library.
- No longer use the wp-pay-gateways/ideal-advanced library.
- Extend from the abstract iDEAL gateway integration class.
- Renamed settings id from 'ideal-advanced' to 'ideal-advanced-v3'.
- Moved get_gateway_class() function to the configuration class.
- Removed get_config_class(), no longer required.

## [1.1.2] - 2016-02-01
- Increase expiration period from PT3M30S to PT30M.
- Added new gateway settings system.

## [1.1.1] - 2015-08-04
- Make sure to use the wp-pay/core functions.

## [1.1.0] - 2015-03-09
- Improved support for user defined purchase ID's.

## [1.0.1] - 2015-03-03
- Changed WordPress pay core library requirement from ~1.0.0 to >=1.0.0.
- Changed WordPress pay iDEAL library requirement from ~1.0.0 to >=1.0.0.
- Changed WordPress pay iDEAL Advanced library requirement from `~1.0.0` to `>=1.0.0`.

## 1.0.0 - 2015-01-19
- First release.

[unreleased]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/4.2.0...HEAD
[4.2.0]: https://github.com/pronamic/wp-pronamic-pay-ideal-advanced-v3/compare/4.1.0...4.2.0
[4.1.0]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/4.0.0...4.1.0
[4.0.0]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/3.0.0...4.0.0
[3.0.0]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/2.1.4...3.0.0
[2.1.4]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/2.1.3...2.1.4
[2.1.3]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/2.1.2...2.1.3
[2.1.2]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/2.1.1...2.1.2
[2.1.1]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/2.1.0...2.1.1
[2.1.0]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/2.0.5...2.1.0
[2.0.5]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/2.0.4...2.0.5
[2.0.4]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/2.0.3...2.0.4
[2.0.3]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/2.0.2...2.0.3
[2.0.2]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/2.0.1...2.0.2
[2.0.1]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.12...2.0.0
[1.1.12]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.11...1.1.12
[1.1.11]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.10...1.1.11
[1.1.10]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.9...1.1.10
[1.1.9]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.8...1.1.9
[1.1.8]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.7...1.1.8
[1.1.7]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.6...1.1.7
[1.1.6]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.5...1.1.6
[1.1.5]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.4...1.1.5
[1.1.4]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.3...1.1.4
[1.1.3]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.2...1.1.3
[1.1.2]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.1...1.1.2
[1.1.1]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.0.1...1.1.0
[1.0.1]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.0.0...1.0.1

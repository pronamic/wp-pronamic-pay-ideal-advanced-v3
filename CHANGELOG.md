# Change Log

All notable changes to this project will be documented in this file.

This projects adheres to [Semantic Versioning](http://semver.org/) and [Keep a CHANGELOG](http://keepachangelog.com/).

## [Unreleased][unreleased]
- Fix zero days private certificate validity in OpenSSL command.

## [1.1.7] - 2016-10-20
- Added `payment_status_request` feature support.
- Removed schedule status check event, this will be part of the Pronamic iDEAL plugin.

## [1.1.6] - 2016-07-06
- Adjusted check on required distinguished name keys/values.
- Added some early returns + escapeshellarg calls.

## [1.1.5] - 2016-06-08
- Added payment method requirement.
- Simplified the gateay payment start function.

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
- Changed WordPress pay core library requirment from ~1.0.0 to >=1.0.0.
- Changed WordPress pay iDEAL library requirment from ~1.0.0 to >=1.0.0.
- Changed WordPress pay iDEAL Advanced library requirment from ~1.0.0 to >=1.0.0.

## 1.0.0 - 2015-01-19
- First release.

[unreleased]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.7...HEAD
[1.1.7]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.6...1.1.7
[1.1.6]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.5...1.1.6
[1.1.5]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.4...1.1.5
[1.1.4]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.3...1.1.4
[1.1.3]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.2...1.1.3
[1.1.2]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.1...1.1.2
[1.1.1]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.0.1...1.1.0
[1.0.1]: https://github.com/wp-pay-gateways/ideal-advanced-v3/compare/1.0.0...1.0.1

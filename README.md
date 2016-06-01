# WordPress Pay Gateway: iDEAL Advanced v3

**iDEAL Advanced v3 driver for the WordPress payment processing library.**

[![Build Status](https://travis-ci.org/wp-pay-gateways/ideal-advanced-v3.svg?branch=develop)](https://travis-ci.org/wp-pay-gateways/ideal-advanced-v3)
[![Coverage Status](https://coveralls.io/repos/wp-pay-gateways/ideal-advanced-v3/badge.svg?branch=master&service=github)](https://coveralls.io/github/wp-pay-gateways/ideal-advanced-v3?branch=master)
[![Latest Stable Version](https://poser.pugx.org/wp-pay-gateways/ideal-advanced-v3/v/stable.svg)](https://packagist.org/packages/wp-pay-gateways/ideal-advanced-v3)
[![Total Downloads](https://poser.pugx.org/wp-pay-gateways/ideal-advanced-v3/downloads.svg)](https://packagist.org/packages/wp-pay-gateways/ideal-advanced-v3)
[![Latest Unstable Version](https://poser.pugx.org/wp-pay-gateways/ideal-advanced-v3/v/unstable.svg)](https://packagist.org/packages/wp-pay-gateways/ideal-advanced-v3)
[![License](https://poser.pugx.org/wp-pay-gateways/ideal-advanced-v3/license.svg)](https://packagist.org/packages/wp-pay-gateways/ideal-advanced-v3)
[![Built with Grunt](https://cdn.gruntjs.com/builtwith.png)](http://gruntjs.com/)

## Providers

*	ING
*	Rabobank

## Documentation

| Title                                               | Language | Version | Date    |
| --------------------------------------------------- | -------- | ------- | ------- |
| [iDEAL Merchant Integration Guide][doc-en-feb-2015] | EN       | `3.3.1` | 2015-02 |
| [iDEAL Merchant Integratie Gids][doc-nl-feb-2015]   | NL       | `3.3.1` | 2015-02 |
| [iDEAL Merchant Integration Guide][doc-en-nov-2012] | EN       | `3.3.1` | 2012-11 |

[doc-en-feb-2015]: https://www.pronamic.eu/wp-content/uploads/sites/2/2016/06/Merchant-Integration-Guide-v3-3-1-ENG-February-2015.pdf
[doc-nl-feb-2015]: https://www.pronamic.eu/wp-content/uploads/sites/2/2016/06/iDEAL-Merchant-Integratie-Gids-v3-3-1-NL-Februari-2015.pdf
[doc-en-nov-2012]: https://www.pronamic.nl/wp-content/uploads/2012/12/iDEAL-Merchant-Integration-Guide-ENG-v3.3.1.pdf

## Signing iDEAL messages

All messages that are sent by the Merchant to the Acquirer (DirectoryRequest,
TransactionRequest and StatusRequest) have to be signed by the Merchant. Messages are
signed in accordance with the "XML Signature Syntax and Processing (2<sup>nd</sup> Edition) W3C
Recommendation” of 10 June 2008<sup>4</sup>, with the following settings and restrictions applied:

1.	The entire XML message<sup>5</sup> must be signed.

2.	For the purpose of generating the digest of the main message, the inclusive canonicalization algorithm must be used<sup>6</sup>. This method of canonicalization of the main message is not (always) explicitly indicated in the
iDEAL XML messages. For this reason this transform has not been included in the example
messages in this document. Merchants are not required to explicitly indicate this transform in
their messages.

3.	For the purpose of generating the signature value, the exclusive<sup>7</sup> canonicalization algorithm must be used.

4.	The syntax for an enveloped<sup>8</sup> signature must be used. The signature itself must be removed
	from the XML message using the default transformation prescribed for this purpose.

5.	For hashing purposes the SHA-256<sup>9</sup> algorithm must be used.

6.	For signature purposes the RSAWithSHA256<sup>10</sup> algorithm must be used. RSA keys must be 2,048 bits long.

7.	The public key must be referenced using a fingerprint of an X.509 certificate. The fingerprint
	must be calculated according to the following formula HEX(SHA-1(DER certificate)) <sup>11</sup>.

	**Note:** the key reference is backwards compatible with all previous versions of iDEAL.

	**Note:** According to Base64 specifications line breaks are allowed to be inserted after each
	76 characters using a CR/LF<sup>12</sup>.

In general Merchants don’t need to have extensive knowledge of RSA since most programming
languages have libraries available that implement XML Digital Signature processing. It is strongly
recommended to use these standard libraries. Standard functionality for creation and verification
of RSAWithSHA256 digital signatures is available in commonly used software platforms, from the
following versions and higher: PHP version 5.3.0, Microsoft .NET version 3.5 sp1 en Java version
1.6 u18.

This functionality may also be available in earlier versions of these platforms and in other
platforms (e.g. Python, Ruby).

For information about creating the public and private key pair please refer to paragraph 8.4. 

<sup>4</sup> http://www.w3.org/TR/xmldsig-core/
<sup>5</sup> XML Signature reference to the signed info URI is left blank, see example messages in Appendix B
<sup>6</sup> http://www.w3.org/TR/2001/REC-xml-c14n-20010315
<sup>7</sup> http://www.w3.org/2001/10/xml-exc-c14n
<sup>8</sup> http://www.w3.org/TR/xmldsig-core/#sec-EnvelopedSignature
<sup>9</sup> http://www.w3.org/2001/04/xmlenc#sha256
<sup>10</sup> http://www.w3.org/TR/2002/REC-xmlenc-core-20021210/#sec-SHA256
<sup>11</sup> See example messages in Appendix B
<sup>12</sup> http://tools.ietf.org/html/rfc2045#section-6.8

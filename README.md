# omnipay-payu
Payu gateway for Omnipay V3 payment processing library

<a href="https://github.com/thephpleague/omnipay">Omnipay</a> is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements PayU Online Payment Gateway support for Omnipay.

<p>PayU ALU V3 API <a href="https://payuturkiye.github.io/PayU-Turkiye-Entegrasyon-Dokumani/#alu-v3-api-entegrasyonu" rel="nofollow">documentation</a></p>

#### Installation

Omnipay is installed via <a href="http://getcomposer.org/" rel="nofollow">Composer</a>. To install, simply add it
to your <code>composer.json</code> file:

* There is already a different library named omnipay/payu for Omnipay V2, so we did not add this repo to the packagist.

```json
"require": {
    "omnipay/payu": "*"
  },
  "repositories": [
    {
      "type": "package",
      "package": {
        "name": "omnipay/payu",
        "version": "v0.0.12",
        "type": "package",
        "source": {
          "url": "https://github.com/alegraio/omnipay-payu.git",
          "type": "git",
          "reference": "v0.0.12"
        },
        "autoload": {
          "psr-4": {
            "Omnipay\\PayU\\": "src/"
          }
        }
      }
    }
  ],
```
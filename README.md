# Qenta Checkout Page plugin for WooCommerce

[![License](https://img.shields.io/badge/license-GPLv2-blue.svg)](https://raw.githubusercontent.com/qenta-cee/woocommerce-wcp/master/LICENSE)
[![WordPress](https://img.shields.io/badge/WordPress-v5.8.1-green.svg)](https://wordpress.org/)
[![WooCommerce](https://img.shields.io/badge/WooCommerce-v5.7.1-green.svg)](https://www.woocommerce.com/)
[![PHP v>=7.2](https://img.shields.io/badge/php-v>=7.4-yellow.svg)](http://www.php.net)

>  Tested up to: 5.8.1 (WordPress), 5.7.1 (WooCommerce)
----


Our [Online Guides](https://guides.qenta.com/) provide further information on payment methods and additional features. Please observe our [terms of use](https://guides.qenta.com/shop_plugins/info/) regarding plugins.

***

## Qenta Checkout Page
Qenta Checkout Page is designed to meet the ambitious demands of merchants offering a wide range of payment methods while at the same time fulfilling PCI DSS compliance.

Qenta Checkout Page offers:
- National and international payment methods: credit cards, debit cards, online banking payments, mobile payment solutions and other alternative payment methods.
- One interface for all payment methods.
- Intuitive user interface in more than 25 languages and 120 currencies.
- Layout and design customizable to meet the needs of our merchants (customized look-and-feel).
- Payment page compatible with mobile devices.
- Comprehensive range of effective fraud prevention tools.
- PCI DSS 3 compliant, no PCI certification necessary for merchants.
- Easy to add new payment methods, additional features, languages and currencies, etc.
- Web interface for managing payments (approvals, cancelations, credits, etc.).

***
## Installation
Please refer to our [Installation Guide](https://guides.qenta.com/shop_plugins/qpay/woocommerce/installation/) for installation and configuration instructions. We also provide technical documentation and a list of [supported payment methods](https://guides.qenta.com/shop_plugins/qpay/woocommerce/start/).

### Docker
To quickly start up a WooCommerce Shop with our plugin already installed all you need is to add your [NGROK token](https://ngrok.com/) to the `.env` file and run
```
docker-compose up
```
#### Persistent Installation
For persistent installation it is recommended to use an existing host and pass it via `.env` file
```
WORDPRESS_HOST=782c-213-147-167-8.ngrok.io
```
and run
```
docker-compose -f docker-compose.persistent.yml up
```

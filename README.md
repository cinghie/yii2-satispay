# Yii2 Satispay

![License](https://img.shields.io/packagist/l/cinghie/yii2-satispay.svg)
![Latest Stable Version](https://img.shields.io/github/release/cinghie/yii2-satispay.svg)
![Latest Release Date](https://img.shields.io/github/release-date/cinghie/yii2-satispay.svg)
![Latest Commit](https://img.shields.io/github/last-commit/cinghie/yii2-satispay.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/cinghie/yii2-satispay.svg)](https://packagist.org/packages/cinghie/yii2-satispay)

Yii2 Satispay

- Documentation: https://developers.satispay.com/docs
- SDK: https://github.com/satispay/gbusiness-api-php-sdk

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require cinghie/yii2-satispay "@dev"
```

or add this line to the require section of your `composer.json` file.

```
"cinghie/yii2-satispay": "@dev"
```

## Configuration

Add in your common configuration file:

```
use cinghie\satispay\components\Satispay as SatispayComponent;

'satispay' => [
	'class' => SatispayComponent::class,
	'authenticationPath' => '@webroot', // path for authentication.json
	'endPoint' => 'sandbox', // sandbox | production
	'token' => 'WG5MUC' // Your Satispay TOKEN
],
```

## Use Component

```
\Yii::$app->satispay;
```

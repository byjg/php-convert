---
sidebar_position: 3
---

# Installation

## Requirements

- PHP 8.3 or higher
- Composer

## Install via Composer

Install the package using Composer:

```bash
composer require byjg/convert
```

## Verify Installation

After installation, you can verify the package is installed correctly:

```php
<?php
require 'vendor/autoload.php';

use ByJG\Convert\ToUTF8;
use ByJG\Convert\FromUTF8;

// Test conversion
echo ToUTF8::fromHtmlEntities('&aacute;'); // Should output: á
echo FromUTF8::removeAccent('João'); // Should output: Joao
```

## Autoloading

The package uses PSR-4 autoloading. Once installed via Composer, all classes are automatically available:

```php
<?php
require 'vendor/autoload.php';

// Classes are ready to use
$result = \ByJG\Convert\ToUTF8::fromHtmlEntities($text);
```

## Manual Installation (Not Recommended)

If you cannot use Composer, you can manually download the source files from the [GitHub repository](https://github.com/byjg/php-convert) and include them in your project. However, this approach requires you to manually handle autoloading.

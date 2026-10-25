---
sidebar_key: convert
tags: [php, text-manipulation]
---

# String Conversion Utility

The text conversions UTF-8 code keeps rewriting, in one place: HTML entities, accents, emoji, MIME encoded words and ASCII-only text.

[![Sponsor](https://img.shields.io/badge/Sponsor-%23ea4aaa?logo=githubsponsors&logoColor=white&labelColor=0d1117)](https://github.com/sponsors/byjg)
[![Build Status](https://github.com/byjg/php-convert/actions/workflows/phpunit.yml/badge.svg?branch=master)](https://github.com/byjg/php-convert/actions/workflows/phpunit.yml)
[![Opensource ByJG](https://img.shields.io/badge/opensource-byjg-success.svg)](https://opensource.byjg.com)
[![Install MCP Server](https://img.shields.io/badge/Install-MCP_Server-8A2BE2?logo=modelcontextprotocol&logoColor=white)](https://opensource.byjg.com/docs/ai/mcpserver-byjg-docs/)
[![GitHub source](https://img.shields.io/badge/Github-source-informational?logo=github)](https://github.com/byjg/php-convert/)
[![GitHub license](https://img.shields.io/github/license/byjg/php-convert.svg)](https://opensource.byjg.com/license/)
[![GitHub release](https://img.shields.io/github/release/byjg/php-convert.svg)](https://github.com/byjg/php-convert/releases/)

## Why

Each of these is a small function that every project writes again, usually with a bug for a
character nobody tested: accents in a slug, an email subject with "ç", user text with `:)` or
emoji that a legacy system cannot store.

Convert has them, both ways:

```php
FromUTF8::removeAccent('João');          // "Joao"
FromUTF8::toMimeEncodedWord('João');     // "=?UTF-8?Q?Jo=C3=A3o?=", for email headers
ToUTF8::fromEmoji('Hello :) <3');        // "Hello 😊 ❤️"
FromUTF8::removeEmoji($userInput);
```

## Features

- Convert HTML entities to UTF8 and vice-versa
- Convert ASCII emoticons to emoji characters
- Handle combining characters
- Remove accents from UTF8 text
- Convert text to MIME encoded words (RFC 2047)
- Remove emoji characters
- Convert to ASCII-only text

## Documentation

- [Converting to UTF8](docs/converting-to-utf8.md) - Convert from HTML entities, emoticons, and combining characters
- [Converting from UTF8](docs/converting-from-utf8.md) - Convert to HTML entities, remove accents and emoji, ASCII conversion
- [Installation](docs/installation.md) - How to install and set up the library
- [Examples](docs/examples.md) - Real-world usage examples and common patterns

## Quick Start

```php
<?php
// Convert HTML entities to UTF8
$str = \ByJG\Convert\ToUTF8::fromHtmlEntities('Jo&atilde;o');
echo $str; // João

// Convert UTF8 to HTML entities
$str2 = \ByJG\Convert\FromUTF8::toHtmlEntities('João');
echo $str2; // Jo&atilde;o

// Remove accents
$str3 = \ByJG\Convert\FromUTF8::removeAccent('João');
echo $str3; // Joao

// Convert to MIME encoded word (for email headers)
$str4 = \ByJG\Convert\FromUTF8::toMimeEncodedWord('João');
echo $str4; // =?UTF-8?Q?Jo=C3=A3o?=

// Convert to ASCII only
$str5 = \ByJG\Convert\FromUTF8::onlyAscii('João');
echo $str5; // Joao

// Convert ASCII emoticons to emoji
$str6 = \ByJG\Convert\ToUTF8::fromEmoji('Hello :) How are you? :D');
echo $str6; // Hello 😊 How are you? 😃

// Remove emoji characters
$str7 = \ByJG\Convert\FromUTF8::removeEmoji('Hello 👋 World 🌍');
echo $str7; // Hello  World
```

For more examples and detailed documentation, see the [Examples](docs/examples.md) page.

## Installation

Just type:

```bash
composer require "byjg/convert"
```

## Running Tests

```bash
vendor/bin/phpunit
```

----
[Open source ByJG](https://opensource.byjg.com)

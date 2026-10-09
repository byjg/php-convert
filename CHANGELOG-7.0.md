# Changelog - Version 7.0

> **Status: in development.** This document tracks changes landing on the `7.0` branch.
> Nothing here is released yet, and the contents may still change.

## Breaking Changes

- **`FromUTF8::toIso88591Email()` was removed.** It was deprecated; use `toMimeEncodedWord()`.
- **The conversions now use PHP's own functions** instead of hand-maintained tables (about 2,300
  lines removed). The method names and signatures are unchanged, but some outputs change:

  | Method | Now | Visible change |
  |---|---|---|
  | `ToUTF8::fromHtmlEntities()` | `html_entity_decode(..., ENT_QUOTES \| ENT_HTML5)` | Decodes every HTML5 entity, including `&amp;`, `&lt;`, `&gt;`, `&quot;` and hex ones (`&#x41;`), which were left as they were. `&nbsp;` gives U+00A0 instead of a plain space. `&Utilde;`/`&utilde;` are not decoded: they are not HTML entities. |
  | `FromUTF8::toHtmlEntities()` | `htmlentities()` + `mb_encode_numericentity()` | Characters with no named entity are written as numeric ones (`ũ` → `&#361;`, `✓` → `&#10003;`) instead of `&utilde;` or `?`, so the output is always ASCII. `&`, `<` and `>` are still left as they are. |
  | `FromUTF8::toMimeEncodedWord()` | `mb_encode_mimeheader(..., 'UTF-8', 'Q')` | `=?UTF-8?Q?...?=` instead of `=?utf-8?Q?...?=`, a space is `=20` instead of `_`, only the words that need it are encoded, and a long text is folded into several lines. Mail clients decode both the same way. |
  | `ToUTF8::fromCombiningChar()` | `Normalizer::normalize(..., FORM_C)` | Composes every combination Unicode defines (`z` + `ˇ` → `ž`), not only the 55 Latin-1 ones. |
  | `FromUTF8::removeEmoji()` | `\p{Extended_Pictographic}` regex | Removes emoji added in newer Unicode versions and any flag. Everything the old list removed is still removed. A text that is not valid UTF-8 is returned unchanged. |

- **`FromUTF8::removeAccent()`** writes the letters with no accented form correctly: `ß` → `ss`,
  `Ø`/`ø` → `O`/`o`, `Þ`/`þ` → `TH`/`th`, `ð` → `d` (they were `B`, `0`, `P`/`p` and `o`).
- **`FromUTF8::onlyAscii()`** replaces each character with one `$defaultChar`: `onlyAscii('世界', '?')`
  returns `??`, not `??????` (it was one per byte). Tabs and line breaks are no longer removed. The
  return type is `string` instead of `?string`.

## Bug Fixes

- `ToUTF8::fromEmoji()` converts `>:(`, `>:-(`, `O:)`, `O:-)`, `>:)` and `>:-)`. They used to be read as
  `>` or `O` followed by `:(` or `:)`.

## Requirements

- PHP 8.3, 8.4, 8.5 and 8.6 are now supported: `"php": ">=8.3 <8.7"`.
  The previous `<8.6` upper bound excluded PHP 8.6, since `<8.6` is exclusive.
- The `intl` and `mbstring` extensions are now required.

## Toolchain

- PHPUnit updated to `^12.5`.
- Psalm is installed as `psalm/phar` (`^6.16`) instead of `vimeo/psalm`.

  `vimeo/psalm` lists the PHP versions it supports and no published release includes
  8.6, so as a dev dependency it made `composer install` fail on the 8.6 build job
  before any test ran. `psalm/phar` requires only `php ^8.2` and bundles its own
  dependencies, so it installs on every PHP version in the matrix and cannot conflict
  with the project's. Psalm itself still refuses to *run* on 8.6, which is why the
  Psalm job uses 8.5. `composer psalm` runs it.

  PHPUnit 13 is deliberately **not** used. It requires PHP `>=8.4.1`, which would
  break the 8.3 floor.

## Continuous Integration

- The build matrix now includes PHP 8.6.
- The Psalm job now runs on PHP 8.5. Psalm declares
  `~8.1.31 || ~8.2.27 || ~8.3.16 || ~8.4.3 || ~8.5.0` and therefore does not run on
  PHP 8.6.

## Housekeeping

- `phpunit.xml.dist` renamed to `phpunit.xml`.
- The `gen/` scripts that generated the conversion tables were removed, along with the tables.

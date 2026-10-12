# Changelog - Version 6.0

## Overview

Version 6.0 represents a major update to the PHP Convert library, bringing PHP 8.3+ compatibility, enhanced type safety, new features, and comprehensive documentation improvements.

## New Features

### Emoticon to Emoji Conversion
- **`ToUTF8::fromEmoji()`**: New method to convert ASCII emoticons to their corresponding emoji characters
  - Supports 40+ common emoticons including `:)`, `:D`, `<3`, `XD`, etc.
  - Handles both basic and nose variants (e.g., `:)` and `:-)`)
  - Includes Eastern-style emoticons (`^_^`, `>_<`, etc.)
  - Special emoticons like hearts (`<3` → ❤️), cat faces (`=^.^=` → 😺), and gestures (`\o/` → 🙌)

### Enhanced HTML Entity Support
- Added support for additional HTML entities:
  - `&#360;` / `&Utilde;` for Ũ (Capital u with tilde)
  - `&#361;` / `&utilde;` for ũ (Lowercase u with tilde)

### Improved Type Safety
- Added strict type declarations to all methods:
  - `FromUTF8::toMimeEncodedWord()`: Now requires `string` parameter
  - `FromUTF8::removeEmoji()`: Now requires `string` parameter and returns `string`
  - `FromUTF8::onlyAscii()`: Proper type hints with `string` return type (nullable)
  - All test methods now have proper `void` return type declarations

### Comprehensive Documentation
- New structured documentation in `/docs` folder:
  - **Installation Guide** (`docs/installation.md`)
  - **Converting to UTF8** (`docs/converting-to-utf8.md`)
  - **Converting from UTF8** (`docs/converting-from-utf8.md`)
  - **Examples & Use Cases** (`docs/examples.md`)
- Enhanced README with quick start guide and feature overview
- Real-world examples including URL slug generation, email encoding, and more

### Developer Experience Improvements
- Added composer scripts for common tasks:
  - `composer test`: Run PHPUnit tests
  - `composer psalm`: Run Psalm static analysis
- Improved CI/CD workflow with GitHub Actions enhancements
- Better PHPUnit configuration with detailed error reporting
- Separate Psalm job with SARIF report upload to GitHub Security

## Bug Fixes

- Fixed typos in HTML entity comments:
  - "accute" → "acute" (in multiple entity descriptions)
  - "Congurent" → "Congruent" (for ≅ symbol)
- Minor performance optimization in `toMimeEncodedWord()` by calculating string length once
- Improved code quality and consistency across the codebase

## Breaking Changes

| Aspect | Before (5.x) | After (6.0) | Description |
|--------|-------------|------------|-------------|
| **PHP Version** | `>=8.1 <8.4` | `>=8.3 <8.6` | Minimum PHP version increased to 8.3, added support for PHP 8.4 and 8.5 |
| **PHPUnit** | `^9.6` | `^10.5\|^11.5` | Updated to PHPUnit 10/11 for better PHP 8.3+ compatibility |
| **Psalm** | `^5.9` | `^5.9\|^6.13` | Added Psalm 6.x support for PHP 8.4+ compatibility |
| **Type Safety** | Mixed/loose types | Strict type declarations | All methods now have proper type hints; may break code relying on type coercion |
| **CI/CD** | Basic workflow | Enhanced workflow | Separate Psalm job, updated actions (checkout@v5), improved matrix testing |
| **PHPUnit Config** | Legacy format | Modern format (10.5 schema) | Updated configuration with stricter error handling and new attributes |

## Path to Upgrade from 5.x to 6.x

### 1. Update PHP Version
Ensure your system is running PHP 8.3 or higher:
```bash
php -v  # Should show PHP 8.3.x, 8.4.x, or 8.5.x
```

### 2. Update Dependencies
Update your `composer.json`:
```bash
composer require byjg/convert:^6.0
composer update
```

### 3. Code Changes Required

#### Type Compatibility
If you were passing non-string values to methods, you'll need to explicitly cast them:
```php
// Before (5.x) - may have worked with type coercion
$result = FromUTF8::removeEmoji($someVariable);

// After (6.0) - explicit string type required
$result = FromUTF8::removeEmoji((string) $someVariable);
```

#### Method Return Types
If you're extending classes or implementing interfaces, update method signatures:
```php
// Before (5.x)
public function removeEmoji($text) { ... }

// After (6.0)
public function removeEmoji(string $text): string { ... }
```

### 4. Testing Updates
If you have custom tests, update PHPUnit configuration to match the new format:
- Replace deprecated `convertErrorsToExceptions` with `failOnWarning`/`failOnNotice`
- Update `<filter><whitelist>` to `<source><include>`
- Use PHPUnit 10+ namespace and schema

### 5. New Features to Explore
Take advantage of new functionality:
```php
// Convert emoticons to emoji
$text = ToUTF8::fromEmoji("Hello :) World :D");
// Result: "Hello 😊 World 😃"
```

### 6. Verify Your Installation
Run tests to ensure everything works:
```bash
composer test    # Run PHPUnit
composer psalm   # Run static analysis
```

## Compatibility Matrix

| PHP Version | Version 5.x | Version 6.0 |
|-------------|-------------|-------------|
| PHP 8.1     | ✅ Supported | ❌ Not supported |
| PHP 8.2     | ✅ Supported | ❌ Not supported |
| PHP 8.3     | ✅ Supported | ✅ Supported |
| PHP 8.4     | ❌ Not supported | ✅ Supported |
| PHP 8.5     | ❌ Not supported | ✅ Supported |

## Notes

- This is a major version release with breaking changes
- The API surface remains largely the same, with improvements to type safety
- All existing methods continue to work with proper type hints
- No changes to core conversion logic or functionality
- Extensive new documentation and examples added
- CI/CD improvements for better code quality assurance

## Migration Checklist

- [ ] Verify PHP version is 8.3 or higher
- [ ] Update `composer.json` to require `^6.0`
- [ ] Run `composer update`
- [ ] Review code for type compatibility issues
- [ ] Update any custom test configurations
- [ ] Run test suite to verify compatibility
- [ ] Review and update any extended classes/interfaces
- [ ] Explore new features like `fromEmoji()`
- [ ] Update documentation references if needed

## Credits

This release includes contributions from the ByJG team and community feedback. Special thanks to all contributors who helped improve the library's type safety, documentation, and compatibility with modern PHP versions.

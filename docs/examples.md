---
sidebar_position: 4
---

# Examples

## Common Use Cases

### URL Slug Generation

Create clean, SEO-friendly URL slugs from titles with special characters:

```php
<?php
use ByJG\Convert\FromUTF8;

function createSlug(string $title): string
{
    // Remove accents
    $slug = FromUTF8::removeAccent($title);

    // Convert to lowercase
    $slug = strtolower($slug);

    // Replace spaces and special chars with hyphens
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);

    // Remove leading/trailing hyphens
    $slug = trim($slug, '-');

    return $slug;
}

echo createSlug('Café São Paulo'); // cafe-sao-paulo
echo createSlug('Résumé & CV'); // resume-cv
```

### Email Subject Encoding

Properly encode email subjects with international characters:

```php
<?php
use ByJG\Convert\FromUTF8;

$subject = 'Confirmação de Pedido - João Silva';
$encodedSubject = FromUTF8::toMimeEncodedWord($subject);

// Use in email headers
$headers = [
    'From' => 'noreply@example.com',
    'Subject' => $encodedSubject,
    'Content-Type' => 'text/html; charset=utf-8'
];
```

### HTML Entity Processing

Convert HTML entities in scraped or imported content:

```php
<?php
use ByJG\Convert\ToUTF8;

// Content from HTML source
$htmlContent = 'User: Jo&atilde;o Silva &lt;jo&atilde;o@example.com&gt;';

// Convert to readable UTF-8
$readable = ToUTF8::fromHtmlEntities($htmlContent);
echo $readable; // User: João Silva <joão@example.com>
```

### Social Media Text Processing

Convert emoticons to emoji for social media posts:

```php
<?php
use ByJG\Convert\ToUTF8;

$userPost = "Great service! :) Would definitely recommend! :D <3";
$withEmoji = ToUTF8::fromEmoji($userPost);
echo $withEmoji; // Great service! 😊 Would definitely recommend! 😃 ❤️
```

### Clean Text for Analytics

Remove emoji from user-generated content for text analysis:

```php
<?php
use ByJG\Convert\FromUTF8;

$userReview = "Absolutely amazing! 😍🎉 Best product ever! 👍👍";
$cleanText = FromUTF8::removeEmoji($userReview);
echo $cleanText; // Absolutely amazing!  Best product ever!

// Further processing
$words = str_word_count($cleanText, 1);
// Analyze words without emoji interference
```

### Database Search Normalization

Normalize text for accent-insensitive searches:

```php
<?php
use ByJG\Convert\FromUTF8;

function normalizeForSearch(string $text): string
{
    // Remove accents for search
    $normalized = FromUTF8::removeAccent($text);

    // Convert to lowercase
    $normalized = strtolower($normalized);

    // Remove extra whitespace
    $normalized = preg_replace('/\s+/', ' ', $normalized);

    return trim($normalized);
}

// Search for "joao" will match "João", "Joao", "JOÃO", etc.
$searchTerm = normalizeForSearch($_GET['q']);
$sql = "SELECT * FROM users WHERE LOWER(REPLACE(name, ...)) LIKE ?";
```

### Legacy System Integration

Convert UTF-8 content for systems that only support ASCII:

```php
<?php
use ByJG\Convert\FromUTF8;

// For a system that only accepts ASCII
$userName = "José María";
$asciiName = FromUTF8::onlyAscii($userName);
echo $asciiName; // Jose Maria

// Or replace unsupported chars with placeholder
$asciiWithPlaceholder = FromUTF8::onlyAscii($userName, '?');
echo $asciiWithPlaceholder; // Jos? Mar?a
```

### File Naming

Create safe file names from user input:

```php
<?php
use ByJG\Convert\FromUTF8;

function safeFileName(string $fileName): string
{
    // Get extension
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    $baseName = pathinfo($fileName, PATHINFO_FILENAME);

    // Remove accents
    $safe = FromUTF8::removeAccent($baseName);

    // Remove emoji
    $safe = FromUTF8::removeEmoji($safe);

    // Keep only safe characters
    $safe = preg_replace('/[^a-zA-Z0-9_-]/', '_', $safe);

    return $safe . '.' . $extension;
}

echo safeFileName("Relatório 2024 📊.pdf"); // Relatorio_2024__.pdf
echo safeFileName("São Paulo - Foto.jpg"); // Sao_Paulo___Foto.jpg
```

### HTML to Plain Text Email

Convert HTML with entities to plain text for email:

```php
<?php
use ByJG\Convert\ToUTF8;
use ByJG\Convert\FromUTF8;

$htmlContent = "Ol&aacute;, Jo&atilde;o! Seu pedido foi confirmado 🎉";

// Convert HTML entities to UTF-8
$utf8Text = ToUTF8::fromHtmlEntities($htmlContent);

// Remove emoji for plain text email
$plainText = FromUTF8::removeEmoji($utf8Text);

echo $plainText; // Olá, João! Seu pedido foi confirmado
```

### Combining Characters Normalization

Handle text from systems that use combining diacritics:

```php
<?php
use ByJG\Convert\ToUTF8;

// Text with combining characters (NFD normalization)
$combining = "José" ; // J + o + s + e + combining acute accent

// Convert to composed characters (NFC normalization)
$composed = ToUTF8::fromCombiningChar($combining);

echo $composed; // José (with é as a single character)
```

## Chaining Conversions

You can chain multiple conversions for complex transformations:

```php
<?php
use ByJG\Convert\ToUTF8;
use ByJG\Convert\FromUTF8;

// Start with HTML entities and emoticons
$input = "Ol&aacute;! :) We &hearts; PHP!";

// First: Convert HTML entities
$step1 = ToUTF8::fromHtmlEntities($input);
// Result: "Olá! :) We ♥ PHP!"

// Second: Convert emoticons to emoji
$step2 = ToUTF8::fromEmoji($step1);
// Result: "Olá! 😊 We ♥ PHP!"

// Third: Remove accents
$step3 = FromUTF8::removeAccent($step2);
// Result: "Ola! 😊 We ♥ PHP!"

// Fourth: Remove emoji
$final = FromUTF8::removeEmoji($step3);
// Result: "Ola!  We  PHP!"
```

## Error Handling

The library methods return strings and don't throw exceptions under normal circumstances. However, you should validate input:

```php
<?php
use ByJG\Convert\FromUTF8;

function safeConvert(?string $text): string
{
    if ($text === null || $text === '') {
        return '';
    }

    // Ensure valid UTF-8
    if (!mb_check_encoding($text, 'UTF-8')) {
        // Try to fix encoding
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
    }

    return FromUTF8::removeAccent($text);
}
```

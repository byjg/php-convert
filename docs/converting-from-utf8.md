---
sidebar_position: 2
---

# Converting from UTF8

The `FromUTF8` class provides methods to convert UTF-8 text to various other formats and perform text transformations.

## toHtmlEntities

Convert UTF-8 text to ASCII, writing every other character as an HTML entity: a named one when it
exists (`&atilde;`), otherwise a numeric one (`&#1055;`). `&`, `<` and `>` are left as they are, so
the text may contain markup.

```php
$str = \ByJG\Convert\FromUTF8::toHtmlEntities('João');
echo $str; // Jo&atilde;o

$str = \ByJG\Convert\FromUTF8::toHtmlEntities('Привет');
echo $str; // &#1055;&#1088;&#1080;&#1074;&#1077;&#1090;
```

### Use Cases

- Generating HTML-safe output
- Ensuring compatibility with systems that don't support UTF-8
- Email templates that need entity encoding
- Legacy system integration

## toMimeEncodedWord

Convert UTF-8 text to MIME encoded-word format according to RFC 2047. This is commonly used for encoding non-ASCII characters in email headers (like Subject, From, To).

```php
$str = \ByJG\Convert\FromUTF8::toMimeEncodedWord('João');
echo $str; // =?UTF-8?Q?Jo=C3=A3o?=

$str = \ByJG\Convert\FromUTF8::toMimeEncodedWord('Hello World');
echo $str; // Hello World (unchanged, no encoding needed)
```

### RFC 2047 Format

The output format is: `=?charset?encoding?encoded-text?=`

- **charset**: Always `UTF-8`
- **encoding**: Always `Q` (Quoted-Printable)
- **encoded-text**: The text with special characters encoded as `=XX` where XX is the hexadecimal byte value

### Use Cases

- Email subject lines with special characters
- Email header fields (From, To, CC, etc.)
- Ensuring email compatibility across different mail servers
- Supporting international characters in email metadata

### Notes

- Plain ASCII text is returned unchanged
- Only the words that need it are encoded: `Test ũ` becomes `Test =?UTF-8?Q?=C5=A9?=`
- A long header is folded into several encoded words, one per line, as RFC 2047 requires
- It is `mb_encode_mimeheader($text, 'UTF-8', 'Q')`

## removeAccent

Remove all accents and diacritical marks from UTF-8 text, converting accented characters to their ASCII equivalents.

```php
$str = \ByJG\Convert\FromUTF8::removeAccent('João');
echo $str; // Joao

$str = \ByJG\Convert\FromUTF8::removeAccent('Café résumé');
echo $str; // Cafe resume

$str = \ByJG\Convert\FromUTF8::removeAccent('Zürich');
echo $str; // Zurich
```

### Character Conversions

Some notable conversions:
- `À Á Â Ã Ä Å` → `A`
- `È É Ê Ë` → `E`
- `Ñ` → `N`
- `Ç` → `C`
- `Æ` → `AE`
- `ß` → `ss`
- `Ø` → `O`
- `Þ` → `TH`, `ð` → `d`
- `©` → `(C)`
- `®` → `(R)`
- `°` → `o.`
- `½` → `1/2`

### Use Cases

- Creating URL slugs
- Normalizing search queries
- Database comparisons
- File naming (when special characters are not allowed)
- Generating ASCII-only identifiers
- Legacy system integration that doesn't support UTF-8

## onlyAscii

Convert UTF-8 text to contain only ASCII characters (0-127). Non-ASCII characters can be replaced with a default character.

```php
$str = \ByJG\Convert\FromUTF8::onlyAscii('João');
echo $str; // Joao

$str = \ByJG\Convert\FromUTF8::onlyAscii('Hello 世界', '?');
echo $str; // Hello ?? (one ? per character)

$str = \ByJG\Convert\FromUTF8::onlyAscii('Café 世界', '');
echo $str; // Cafe  (accents removed, the rest dropped)
```

### Parameters

- `$text` (string): The UTF-8 text to convert
- `$defaultChar` (string): Replaces each character that is still not ASCII once the accents and emoji are removed (default: empty string, which removes them). Tabs and line breaks are kept.

### Use Cases

- Strict ASCII-only output requirements
- Systems that cannot handle any non-ASCII characters
- Log files that need to be ASCII-only
- Network protocols with ASCII-only constraints

### Difference from removeAccent

- `removeAccent()`: Converts accented characters to their base form (á → a)
- `onlyAscii()`: Removes or replaces all non-ASCII characters, including those without ASCII equivalents

## removeEmoji

Remove all emoji characters from UTF-8 text, including complex emoji sequences and flag emojis.

```php
$str = \ByJG\Convert\FromUTF8::removeEmoji('Hello 👋 World 🌍');
echo $str; // Hello  World

$str = \ByJG\Convert\FromUTF8::removeEmoji('Great! 😀 I love it ❤️');
echo $str; // Great!  I love it

$str = \ByJG\Convert\FromUTF8::removeEmoji('Visit us in 🇺🇸 or 🇧🇷');
echo $str; // Visit us in  or
```

### What Gets Removed

- Basic emoji (😀, 😊, ❤️, etc.)
- Flag emoji (🇺🇸, 🇧🇷, 🇯🇵, etc.)
- Complex emoji sequences (family emoji, skin tones, etc.)
- Emoji with modifiers

### Use Cases

- Data sanitization for systems that don't support emoji
- Text analytics where emoji would interfere
- Creating plain text versions of content
- SMS systems that don't support emoji
- Database fields with character set limitations
- Search indexing where emoji should be ignored

### Notes

- It matches the Unicode `Extended_Pictographic` property, so emoji added in newer Unicode
  versions are removed too, with no list to keep up to date
- Spaces may remain where emoji were removed

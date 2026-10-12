---
sidebar_position: 1
---

# Converting to UTF8

The `ToUTF8` class provides methods to convert various text formats to UTF-8 encoding.

## fromHtmlEntities

Convert HTML entities (both named and numeric) to UTF-8 characters.

```php
$str = \ByJG\Convert\ToUTF8::fromHtmlEntities('Jo&atilde;o');
echo $str; // João

// Works with numeric entities too
$str = \ByJG\Convert\ToUTF8::fromHtmlEntities('Jo&#227;o');
echo $str; // João
```

### Supported Entities

Every entity HTML5 defines, plus numeric ones: it is
`html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8')`.
- Named entities (`&aacute;`, `&amp;`, `&lt;`, `&quot;`, `&nbsp;`, `&euro;`, …)
- Decimal entities (`&#225;`)
- Hexadecimal entities (`&#xE1;`)

## fromCombiningChar

Convert combining character sequences to proper UTF-8 characters. Combining characters are Unicode characters that modify the preceding character (like adding an accent).

It applies the Unicode Normalization Form C (NFC) with `Normalizer::normalize()`, so it works for
every letter and mark Unicode can compose, not only the Latin-1 ones (`z` + `ˇ` → `ž`).

```php
$combining = 'A' . chr(204) . chr(128); // A + combining grave accent
$str = \ByJG\Convert\ToUTF8::fromCombiningChar($combining);
echo $str; // À
```

### Use Cases

This is particularly useful when dealing with:
- Text from systems that use combining diacritics
- Normalized Unicode forms (NFD) that need to be converted to composed forms (NFC)
- Legacy systems that separate base characters from their accents

## fromEmoji

Convert ASCII emoticons to their corresponding Unicode emoji characters.

```php
// Basic emoticons
$str = \ByJG\Convert\ToUTF8::fromEmoji('Hello :) How are you? :D');
echo $str; // Hello 😊 How are you? 😃

// Hearts
$str = \ByJG\Convert\ToUTF8::fromEmoji('I love you <3 but my heart is </3');
echo $str; // I love you ❤️ but my heart is 💔

// Various expressions
$str = \ByJG\Convert\ToUTF8::fromEmoji('XD :P ;) :( O:) >:(');
echo $str; // 😆 😛 😉 ☹️ 😇 😠
```

### Supported Emoticons

#### Basic Smileys
- `:)` `:-)` → 😊 (Smiley face)
- `:D` `:-D` → 😃 (Big grin)
- `:(` `:-(` → ☹️ (Sad face)
- `;)` `;-)` → 😉 (Winking face)
- `:P` `:-P` `:p` → 😛 (Tongue out)

#### Expressions
- `XD` → 😆 (Laughing)
- `:O` `:-O` `:o` → 😮 (Surprised)
- `>:(` `>:-(` → 😠 (Angry)
- `:*` `:-*` → 😘 (Kissing)
- `:'(` `:'-(` → 😢 (Crying)
- `:')` `:'-)` → 😂 (Tears of joy)

#### Special Faces
- `O:)` `O:-)` → 😇 (Angel)
- `>:)` `>:-)` → 😈 (Evil grin)
- `B)` `B-)` → 😎 (Cool with sunglasses)
- `:3` `=^.^=` → 😺 (Cat face)
- `:S` `:-S` → 😕 (Confused)
- `:$` `:-$` → 😳 (Blushing)
- `:@` `:-@` → 😠 (Angry)
- `:|` `:-|` → 😐 (Straight face)
- `:X` `:-X` `:x` → 🤐 (Sealed lips)

#### Eastern Style
- `-_-` → 😑 (Expressionless)
- `^_^` → 😊 (Happy)
- `>_<` → 😣 (Frustrated)
- `._.` → 😐 (Neutral)

#### Hearts
- `<3` → ❤️ (Heart)
- `</3` → 💔 (Broken heart)

#### Actions
- `\o/` → 🙌 (Hands up/celebration)
- `o/` `\o` → 👋 (Waving hand)

### Notes

- Longer emoticons are matched before shorter ones, so `>:(` is 😠 and not `>` followed by ☹️
- Emoticons are case-sensitive for some variants (e.g., `XD` vs `xd`)
- The conversion is a simple string replacement, so emoticons within words may also be converted

<?php

namespace ByJG\Convert;

use Normalizer;

class FromUTF8
{

    /**
     * Encode a text for an email header, as RFC 2047 "encoded words" in UTF-8.
     * A text that needs no encoding is returned unchanged; a long one is folded into several lines.
     *
     * @param string $text
     * @return string
     */
    public static function toMimeEncodedWord(string $text): string
    {
        return mb_encode_mimeheader($text, 'UTF-8', 'Q');
    }

    /**
     * The Latin letters and symbols Unicode does not decompose into a base letter plus a mark,
     * so removeAccent() has to be told what to write for them.
     */
    private const array NO_DECOMPOSITION = [
        '¡' => '!', '¢' => 'C', '£' => 'pound', '¤' => 'currency', '¥' => 'yen',
        '¦' => '|', '§' => 'section', '¨' => '"', '©' => '(C)', 'ª' => 'a.',
        '«' => '<<', '¬' => '-', "\u{00AD}" => ' ', '®' => '(R)', '¯' => '-',
        '°' => 'o.', '±' => '+-', '²' => '2', '³' => '3', '´' => '`',
        'µ' => 'micro', '¶' => 'paragraph', '·' => '.', '¸' => ',', '¹' => '1',
        'º' => '0.', '»' => '>>', '¼' => '1/4', '½' => '1/2', '¾' => '3/4',
        '¿' => '?', "\u{00A0}" => ' ', '×' => 'x', '÷' => '/',
        'Æ' => 'AE', 'æ' => 'ae', 'Œ' => 'OE', 'œ' => 'oe', 'ß' => 'ss',
        'Ð' => 'D', 'ð' => 'd', 'Đ' => 'D', 'đ' => 'd', 'Þ' => 'TH', 'þ' => 'th',
        'Ø' => 'O', 'ø' => 'o', 'Ł' => 'L', 'ł' => 'l', 'ı' => 'i',
    ];

    /**
     * Remove the accents of the Latin letters: "João" becomes "Joao". It works for a precomposed
     * letter ("é") and for a letter followed by combining marks ("e" + U+0301).
     *
     * Everything else is returned as it is: other scripts, where those marks are part of the
     * letter, symbols and emoji. A text that is not valid UTF-8 is returned unchanged.
     *
     * @param string $text
     * @return string
     */
    public static function removeAccent(string $text): string
    {
        // A Latin letter outside ASCII, or any Latin letter carrying combining marks
        return preg_replace_callback(
            '/(?=[^\x00-\x7F])\p{Latin}\p{Mn}*|\p{Latin}\p{Mn}+/u',
            fn(array $match) => preg_replace(
                '/\p{Mn}+/u',
                '',
                (string)Normalizer::normalize($match[0], Normalizer::FORM_D)
            ) ?? $match[0],
            strtr($text, self::NO_DECOMPOSITION)
        ) ?? $text;
    }

    /**
     * Remove the emoji, including skin tones, flags, keycaps and the sequences joined by U+200D.
     * A text that is not valid UTF-8 is returned unchanged.
     *
     * @param string $text
     * @return string
     */
    public static function removeEmoji(string $text): string
    {
        return preg_replace(
            '/[#*0-9]\x{FE0F}?\x{20E3}'                                 // keycaps: 1️⃣
            . '|[\x{1F1E6}-\x{1F1FF}]'                                   // flags: 🇧🇷
            . '|\p{Extended_Pictographic}[\x{FE0F}\x{1F3FB}-\x{1F3FF}\x{E0020}-\x{E007F}]*\x{200D}?'
            . '|[\x{1F3FB}-\x{1F3FF}]/u',                                // a skin tone on its own
            '',
            $text
        ) ?? $text;
    }

    /**
     * Remove the emoji and the accents, then replace every character still outside printable
     * ASCII with $defaultChar. Tabs and line breaks are kept.
     *
     * @param string $text
     * @param string $defaultChar
     * @return string
     */
    public static function onlyAscii(string $text, string $defaultChar = ''): string
    {
        $text = self::removeAccent(self::removeEmoji($text));

        // One $defaultChar per character; per byte only when the text is not valid UTF-8
        return preg_replace('/[^\x20-\x7E\t\r\n]/u', $defaultChar, $text)
            ?? (string)preg_replace('/[^\x20-\x7E\t\r\n]/', $defaultChar, $text);
    }

    /**
     * Convert a text in UTF8 to ASCII, writing every other character as an HTML entity: a named
     * one when it exists, otherwise a numeric one. "&", "<" and ">" are left as they are, so the
     * text can contain markup.
     *
     * @param string $text
     * @return string
     */
    public static function toHtmlEntities(string $text): string
    {
        $named = htmlspecialchars_decode(
            htmlentities($text, ENT_NOQUOTES | ENT_HTML401 | ENT_SUBSTITUTE, 'UTF-8'),
            ENT_NOQUOTES
        );

        return mb_encode_numericentity($named, [0x80, 0x10FFFF, 0, 0x1FFFFF], 'UTF-8');
    }
}

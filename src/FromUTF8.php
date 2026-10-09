<?php

namespace ByJG\Convert;

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
     * Remove all accents from UTF8 Chars.
     *
     * @param string $text
     * @return string
     */
    public static function removeAccent(string $text): string
    {
        $ASCII_CONV = [
            194 => [
                161=>'!' /*¡*/, 162=>'C' /*¢*/, 163=>'pound' /*£*/, 164=>'currency' /*¤*/, 165=>'yen' /*¥*/,
                166=>'|' /*¦*/, 167=>'section' /*§*/, 168=>'"' /*¨*/, 169=>'(C)' /*©*/, 170=>'a.' /*ª*/,
                171=>'<<' /*«*/, 172=>'-' /*¬*/, 173=>' ' /**/, 174=>'(R)' /*®*/, 175=>'-' /*¯*/,
                176=>'o.' /*°*/, 177=>'+-' /*±*/, 178=>'2' /*²*/, 179=>'3' /*³*/, 180=>'`' /*´*/,
                181=>'micro' /*µ*/, 182=>'paragraph' /*¶*/, 183=>'.' /*·*/, 184=>',' /*¸*/, 185=>'1' /*¹*/,
                186=>'0.' /*º*/, 187=>'>>' /*»*/, 188=>'1/4' /*¼*/, 189=>'1/2' /*½*/, 190=>'3/4' /*¾*/,
                191=>'?' /*¿*/, 160 => ' ' /* */,
            ],
            195 => [
                128=>'A' /*À*/, 129=>'A' /*Á*/, 130=>'A' /*Â*/, 131=>'A' /*Ã*/, 132=>'A' /*Ä*/,
                133=>'A' /*Å*/, 134=>'AE' /*Æ*/, 135=>'C' /*Ç*/, 136=>'E' /*È*/, 137=>'E' /*É*/,
                138=>'E' /*Ê*/, 139=>'E' /*Ë*/, 140=>'I' /*Ì*/, 141=>'I' /*Í*/, 142=>'I' /*Î*/,
                143=>'I' /*Ï*/, 144=>'D' /*Ð*/, 145=>'N' /*Ñ*/, 146=>'O' /*Ò*/, 147=>'O' /*Ó*/,
                148=>'O' /*Ô*/, 149=>'O' /*Õ*/, 150=>'O' /*Ö*/, 151=>'x' /*×*/, 152=>'O' /*Ø*/,
                153=>'U' /*Ù*/, 154=>'U' /*Ú*/, 155=>'U' /*Û*/, 156=>'U' /*Ü*/, 157=>'Y' /*Ý*/,
                158=>'TH' /*Þ*/, 159=>'ss' /*ß*/, 160=>'a' /*à*/, 161=>'a' /*á*/, 162=>'a' /*â*/,
                163=>'a' /*ã*/, 164=>'a' /*ä*/, 165=>'a' /*å*/, 166=>'ae' /*æ*/, 167=>'c' /*ç*/,
                168=>'e' /*è*/, 169=>'e' /*é*/, 170=>'e' /*ê*/, 171=>'e' /*ë*/, 172=>'i' /*ì*/,
                173=>'i' /*í*/, 174=>'i' /*î*/, 175=>'i' /*ï*/, 176=>'d' /*ð*/, 177=>'n' /*ñ*/,
                178=>'o' /*ò*/, 179=>'o' /*ó*/, 180=>'o' /*ô*/, 181=>'o' /*õ*/, 182=>'o' /*ö*/,
                183=>'/' /*÷*/, 184=>'o' /*ø*/, 185=>'u' /*ù*/, 186=>'u' /*ú*/, 187=>'u' /*û*/,
                188=>'u' /*ü*/, 189=>'y' /*ý*/, 190=>'th' /*þ*/, 191=>'y' /*ÿ*/,
            ],
            197 => [
                169=>'u' /*ũ*/, 168=>'U' /*Ũ*/,
            ]
        ];

        return FromUTF8::baseConversion($ASCII_CONV, $text);
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

    /**
     * Base conversion
     *
     * @param array $vector
     * @param string $text
     * @return string
     */
    protected static function baseConversion(array $vector, string $text): string
    {
        $result = "";
        $lenText = strlen($text);
        $keys = array_keys($vector);
        for ($i = 0; $i < $lenText; $i++) {
            if (ord($text[$i]) == 226) {
                $first = ord($text[$i++]);
                $second = ord($text[$i++]);
                $result .=
                    $vector[$first][$second][ord($text[$i])] ?? '?'
                ;
            } elseif (in_array(ord($text[$i]), $keys)) {
                $first = ord($text[$i++]);
                $result .= $vector[$first][ord($text[$i])] ?? '?';
            } else {
                $result .= $text[$i];
            }
        }

        return $result;
    }
}

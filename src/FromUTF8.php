<?php

namespace ByJG\Convert;

class FromUTF8
{

    /**
     * Convert a text in UTF8 to ISO-8859-1 used in emails.
     *
     * @param string $text
     * @param int $wrap
     * @return string
     */
    public static function toIso88591Email($text, $wrap = 0)
    {
        $ISO88591_CONV = [
            194 => [ // C2
                161=>'=A1' /*¡*/, 162=>'=A2' /*¢*/, 163=>'=A3' /*£*/, 164=>'=A4' /*¤*/, 165=>'=A5' /*¥*/,
                166=>'=A6' /*¦*/, 167=>'=A7' /*§*/, 168=>'=A8' /*¨*/, 169=>'=A9' /*©*/, 170=>'=AA' /*ª*/,
                171=>'=AB' /*«*/, 172=>'=AC' /*¬*/, 173=>'=AD' /* */, 174=>'=AE' /*®*/, 175=>'=AF' /*¯*/,
                176=>'=B0' /*°*/, 177=>'=B1' /*±*/, 178=>'=B2' /*²*/, 179=>'=B3' /*³*/, 180=>'=B4' /*´*/,
                181=>'=B5' /*µ*/, 182=>'=B6' /*¶*/, 183=>'=B7' /*·*/, 184=>'=B8' /*¸*/, 185=>'=B9' /*¹*/,
                186=>'=BA' /*º*/, 187=>'=BB' /*»*/, 188=>'=BC' /*¼*/, 189=>'=BD' /*½*/, 190=>'=BE' /*¾*/,
                191=>'=BF' /*¿*/, 160 => '=A0' /* */,
            ],
            195 => [ // C3
                128=>'=C0' /*À*/, 129=>'=C1' /*Á*/, 130=>'=C2' /*Â*/, 131=>'=C3' /*Ã*/, 132=>'=C4' /*Ä*/,
                133=>'=C5' /*Å*/, 134=>'=C6' /*Æ*/, 135=>'=C7' /*Ç*/, 136=>'=C8' /*È*/, 137=>'=C9' /*É*/,
                138=>'=CA' /*Ê*/, 139=>'=CB' /*Ë*/, 140=>'=CC' /*Ì*/, 141=>'=CD' /*Í*/, 142=>'=CE' /*Î*/,
                143=>'=CF' /*Ï*/, 144=>'=D0' /*Ð*/, 145=>'=D1' /*Ñ*/, 146=>'=D2' /*Ò*/, 147=>'=D3' /*Ó*/,
                148=>'=D4' /*Ô*/, 149=>'=D5' /*Õ*/, 150=>'=D6' /*Ö*/, 151=>'=D7' /*×*/, 152=>'=D8' /*Ø*/,
                153=>'=D9' /*Ù*/, 154=>'=DA' /*Ú*/, 155=>'=DB' /*Û*/, 156=>'=DC' /*Ü*/, 157=>'=DD' /*Ý*/,
                158=>'=DE' /*Þ*/, 159=>'=DF' /*ß*/, 160=>'=E0' /*à*/, 161=>'=E1' /*á*/, 162=>'=E2' /*â*/,
                163=>'=E3' /*ã*/, 164=>'=E4' /*ä*/, 165=>'=E5' /*å*/, 166=>'=E6' /*æ*/, 167=>'=E7' /*ç*/,
                168=>'=E8' /*è*/, 169=>'=E9' /*é*/, 170=>'=EA' /*ê*/, 171=>'=EB' /*ë*/, 172=>'=EC' /*ì*/,
                173=>'=ED' /*í*/, 174=>'=EE' /*î*/, 175=>'=EF' /*ï*/, 176=>'=F0' /*ð*/, 177=>'=F1' /*ñ*/,
                178=>'=F2' /*ò*/, 179=>'=F3' /*ó*/, 180=>'=F4' /*ô*/, 181=>'=F5' /*õ*/, 182=>'=F6' /*ö*/,
                183=>'=F7' /*÷*/, 184=>'=F8' /*ø*/, 185=>'=F9' /*ù*/, 186=>'=FA' /*ú*/, 187=>'=FB' /*û*/,
                188=>'=FC' /*ü*/, 189=>'=FD' /*ý*/, 190=>'=FE' /*þ*/, 191=>'=FF' /*ÿ*/,
            ],
            197 => [ // C5
                169=>'u' /*ũ*/, 168=>'U' /*Ũ*/,
            ]
        ];

        $textPre = str_replace("=", "=3D", $text);
        $result = FromUTF8::baseConversion($ISO88591_CONV, $textPre);
        if ($result == $textPre) {
            return $text;
        } else {
            $result = str_replace(" ", "_", $result);
        }

        if ($wrap == 0) {
            return "=?iso-8859-1?Q?".$result."?=";
        } else {
            $newResult = "=?iso-8859-1?Q?";
            $contaLinha = 0;
            $lenResult = strlen($result);
            for ($i = 0; $i < $lenResult; $i++) {
                if (($result[$i] == "=") && ($contaLinha >= ($wrap - 3)) || ($contaLinha >= $wrap)) {
                    $newResult .= "?=\r\n=?iso-8859-1?Q?".$result[$i];
                    $contaLinha = 0;
                } else {
                    $newResult .= $result[$i];
                }


                $contaLinha++;
            }
            $newResult .= "?=";
            return $newResult;
        }
    }

    /**
     * Remove all accents from UTF8 Chars.
     *
     * @param string $text
     * @return string
     */
    public static function removeAccent($text)
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
                148=>'O' /*Ô*/, 149=>'O' /*Õ*/, 150=>'O' /*Ö*/, 151=>'x' /*×*/, 152=>'0' /*Ø*/,
                153=>'U' /*Ù*/, 154=>'U' /*Ú*/, 155=>'U' /*Û*/, 156=>'U' /*Ü*/, 157=>'Y' /*Ý*/,
                158=>'P' /*Þ*/, 159=>'B' /*ß*/, 160=>'a' /*à*/, 161=>'a' /*á*/, 162=>'a' /*â*/,
                163=>'a' /*ã*/, 164=>'a' /*ä*/, 165=>'a' /*å*/, 166=>'ae' /*æ*/, 167=>'c' /*ç*/,
                168=>'e' /*è*/, 169=>'e' /*é*/, 170=>'e' /*ê*/, 171=>'e' /*ë*/, 172=>'i' /*ì*/,
                173=>'i' /*í*/, 174=>'i' /*î*/, 175=>'i' /*ï*/, 176=>'o' /*ð*/, 177=>'n' /*ñ*/,
                178=>'o' /*ò*/, 179=>'o' /*ó*/, 180=>'o' /*ô*/, 181=>'o' /*õ*/, 182=>'o' /*ö*/,
                183=>'/' /*÷*/, 184=>'0' /*ø*/, 185=>'u' /*ù*/, 186=>'u' /*ú*/, 187=>'u' /*û*/,
                188=>'u' /*ü*/, 189=>'y' /*ý*/, 190=>'p' /*þ*/, 191=>'y' /*ÿ*/,
            ],
            197 => [
                169=>'u' /*ũ*/, 168=>'U' /*Ũ*/,
            ]
        ];

        return FromUTF8::baseConversion($ASCII_CONV, $text);
    }

    public static function onlyAscii($text, $defaultChar = '')
    {
        $textWOAccent = self::removeAccent($text);
        return preg_replace('/[[:^print:]]/', $defaultChar, $textWOAccent);
    }

    /**
     * Convert a text in UTF8 to ascii html entities
     *
     * @param string $text
     * @return string
     */
    public static function toHtmlEntities($text)
    {
        $ASCII_CONV = [
            195 => [
                128 => '&Agrave;'  /* À (Capital a with grave accent) */,
                129 => '&Aacute;'  /* Á (Capital a with acute accent) */,
                130 => '&Acirc;'  /* Â (Capital a with circumflex accent) */,
                131 => '&Atilde;'  /* Ã (Capital a with tilde) */,
                132 => '&Auml;'  /* Ä (Capital a with umlaut) */,
                133 => '&Aring;'  /* Å (Capital a with ring) */,
                134 => '&AElig;'  /* Æ (Capital ae) */,
                135 => '&Ccedil;'  /* Ç (Capital c with cedilla) */,
                136 => '&Egrave;'  /* È (Capital e with grave accent) */,
                137 => '&Eacute;'  /* É (Capital e with acute accent) */,
                138 => '&Ecirc;'  /* Ê (Capital e with circumflex accent) */,
                139 => '&Euml;'  /* Ë (Capital e with umlaut) */,
                140 => '&Igrave;'  /* Ì (Capital i with grave accent) */,
                141 => '&Iacute;'  /* Í (Capital i with accute accent) */,
                142 => '&Icirc;'  /* Î (Capital i with circumflex accent) */,
                143 => '&Iuml;'  /* Ï (Capital i with umlaut) */,
                144 => '&ETH;'  /* Ð (Capital eth (Icelandic)) */,
                145 => '&Ntilde;'  /* Ñ (Capital n with tilde) */,
                146 => '&Ograve;'  /* Ò (Capital o with grave accent) */,
                147 => '&Oacute;'  /* Ó (Capital o with accute accent) */,
                148 => '&Ocirc;'  /* Ô (Capital o with circumflex accent) */,
                149 => '&Otilde;'  /* Õ (Capital o with tilde) */,
                150 => '&Ouml;'  /* Ö (Capital o with umlaut) */,
                152 => '&Oslash;'  /* Ø (Capital o with slash) */,
                153 => '&Ugrave;'  /* Ù (Capital u with grave accent) */,
                154 => '&Uacute;'  /* Ú (Capital u with acute accent) */,
                155 => '&Ucirc;'  /* Û (Capital u with circumflex accent) */,
                156 => '&Uuml;'  /* Ü (Capital u with umlaut) */,
                157 => '&Yacute;'  /* Ý (Capital y with acute accent) */,
                158 => '&THORN;'  /* Þ (Capital thorn (Icelandic)) */,
                159 => '&szlig;'  /* ß (Lowercase sharp s (German)) */,
                160 => '&agrave;'  /* à (Lowercase a with grave accent) */,
                161 => '&aacute;'  /* á (Lowercase a with acute accent) */,
                162 => '&acirc;'  /* â (Lowercase a with circumflex accent) */,
                163 => '&atilde;'  /* ã (Lowercase a with tilde) */,
                164 => '&auml;'  /* ä (Lowercase a with umlaut) */,
                165 => '&aring;'  /* å (Lowercase a with ring) */,
                166 => '&aelig;'  /* æ (Lowercase ae) */,
                167 => '&ccedil;'  /* ç (Lowercase c with cedilla) */,
                168 => '&egrave;'  /* è (Lowercase e with grave accent) */,
                169 => '&eacute;'  /* é (Lowercase e with acute accent) */,
                170 => '&ecirc;'  /* ê (Lowercase e with circumflex accent) */,
                171 => '&euml;'  /* ë (Lowercase e with umlaut) */,
                172 => '&igrave;'  /* ì (Lowercase i with grave accent) */,
                173 => '&iacute;'  /* í (Lowercase i with acute accent) */,
                174 => '&icirc;'  /* î (Lowercase i with circumflex accent) */,
                175 => '&iuml;'  /* ï (Lowercase i with umlaut) */,
                176 => '&eth;'  /* ð (Lowercase eth (Icelandic)) */,
                177 => '&ntilde;'  /* ñ (Lowercase n with tilde) */,
                178 => '&ograve;'  /* ò (Lowercase o with grave accent) */,
                179 => '&oacute;'  /* ó (Lowercase o with acute accent) */,
                180 => '&ocirc;'  /* ô (Lowercase o with circumflex accent) */,
                181 => '&otilde;'  /* õ (Lowercase o with tilde) */,
                182 => '&ouml;'  /* ö (Lowercase o with umlaut) */,
                184 => '&oslash;'  /* ø (Lowercase o with slash) */,
                185 => '&ugrave;'  /* ù (Lowercase u with grave accent) */,
                186 => '&uacute;'  /* ú (Lowercase u with acute accent) */,
                187 => '&ucirc;'  /* û (Lowercase u with circumflex accent) */,
                188 => '&uuml;'  /* ü (Lowercase u with umlaut) */,
                189 => '&yacute;'  /* ý (Lowercase y with acute accent) */,
                190 => '&thorn;'  /* þ (Lowercase thorn (Icelandic)) */,
                191 => '&yuml;'  /* ÿ (Lowercase y with umlaut) */,
                151 => '&times;'  /* × (Multiplication) */,
                183 => '&divide;'  /* ÷ (Divide) */,
            ],
            197 => [
                168 => '&Utilde;'  /* Ũ (Capital u with tilde accent) */,
                169 => '&utilde;'  /* ũ (Lowercase u with tilde accent) */,
                146 => '&OElig;'  /* Œ (Uppercase ligature OE) */,
                147 => '&oelig;'  /* œ (Lowercase ligature OE) */,
                160 => '&Scaron;'  /* Š (Uppercase S with caron) */,
                161 => '&scaron;'  /* š (Lowercase S with caron) */,
                184 => '&Yuml;'  /* Ÿ (Capital Y with diaeres) */,
            ],
            194 => [
                161 => '&iexcl;'  /* ¡ (Inverted exclamation mark) */,
                162 => '&cent;'  /* ¢ (Cent) */,
                163 => '&pound;'  /* £ (Pound) */,
                164 => '&curren;'  /* ¤ (Currency) */,
                165 => '&yen;'  /* ¥ (Yen) */,
                166 => '&brvbar;'  /* ¦ (Broken vertical bar) */,
                167 => '&sect;'  /* § (Section) */,
                168 => '&uml;'  /* ¨ (Spacing diaeresis) */,
                169 => '&copy;'  /* © (Copyright) */,
                170 => '&ordf;'  /* ª (Feminine ordinal indicator) */,
                171 => '&laquo;'  /* « (Opening/Left angle quotation mark) */,
                172 => '&not;'  /* ¬ (Negation) */,
                174 => '&reg;'  /* ® (Registered trademark) */,
                175 => '&macr;'  /* ¯ (Spacing macron) */,
                176 => '&deg;'  /* ° (Degree) */,
                177 => '&plusmn;'  /* ± (Plus or minus) */,
                178 => '&sup2;'  /* ² (Superscript 2) */,
                179 => '&sup3;'  /* ³ (Superscript 3) */,
                180 => '&acute;'  /* ´ (Spacing acute) */,
                181 => '&micro;'  /* µ (Micro) */,
                182 => '&para;'  /* ¶ (Paragraph) */,
                184 => '&cedil;'  /* ¸ (Spacing cedilla) */,
                185 => '&sup1;'  /* ¹ (Superscript 1) */,
                186 => '&ordm;'  /* º (Masculine ordinal indicator) */,
                187 => '&raquo;'  /* » (Closing/Right angle quotation mark) */,
                188 => '&frac14;'  /* ¼ (Fraction 1/4) */,
                189 => '&frac12;'  /* ½ (Fraction 1/2) */,
                190 => '&frac34;'  /* ¾ (Fraction 3/4) */,
                191 => '&iquest;'  /* ¿ (Inverted question mark) */,
            ],
            226 => [
                136  => [
                    128 => '&forall;'  /* ∀ (For all) */,
                    130 => '&part;'  /* ∂ (Part) */,
                    131 => '&exist;'  /* ∃ (Exist) */,
                    133 => '&empty;'  /* ∅ (Empty) */,
                    135 => '&nabla;'  /* ∇ (Nabla) */,
                    136 => '&isin;'  /* ∈ (Is in) */,
                    137 => '&notin;'  /* ∉ (Not in) */,
                    139 => '&ni;'  /* ∋ (Ni) */,
                    143 => '&prod;'  /* ∏ (Product) */,
                    145 => '&sum;'  /* ∑ (Sum) */,
                    146 => '&minus;'  /* − (Minus) */,
                    151 => '&lowast;'  /* ∗ (Asterisk (Lowast)) */,
                    154 => '&radic;'  /* √ (Square root) */,
                    157 => '&prop;'  /* ∝ (Proportional to) */,
                    158 => '&infin;'  /* ∞ (Infinity) */,
                    160 => '&ang;'  /* ∠ (Angle) */,
                    167 => '&and;'  /* ∧ (And) */,
                    168 => '&or;'  /* ∨ (Or) */,
                    169 => '&cap;'  /* ∩ (Cap) */,
                    170 => '&cup;'  /* ∪ (Cup) */,
                    171 => '&int;'  /* ∫ (Integral) */,
                    180 => '&there4;'  /* ∴ (Therefore) */,
                    188 => '&sim;'  /* ∼ (Similar to) */,
                ],
                137  => [
                    133 => '&cong;'  /* ≅ (Congurent to) */,
                    136 => '&asymp;'  /* ≈ (Almost equal) */,
                    160 => '&ne;'  /* ≠ (Not equal) */,
                    161 => '&equiv;'  /* ≡ (Equivalent) */,
                    164 => '&le;'  /* ≤ (Less or equal) */,
                    165 => '&ge;'  /* ≥ (Greater or equal) */,
                ],
                138  => [
                    130 => '&sub;'  /* ⊂ (Subset of) */,
                    131 => '&sup;'  /* ⊃ (Superset of) */,
                    132 => '&nsub;'  /* ⊄ (Not subset of) */,
                    134 => '&sube;'  /* ⊆ (Subset or equal) */,
                    135 => '&supe;'  /* ⊇ (Superset or equal) */,
                    149 => '&oplus;'  /* ⊕ (Circled plus) */,
                    151 => '&otimes;'  /* ⊗ (Circled times) */,
                    165 => '&perp;'  /* ⊥ (Perpendicular) */,
                ],
                139  => [
                    133 => '&sdot;'  /* ⋅ (Dot operator) */,
                ],
                128  => [
                    147 => '&ndash;'  /* – (En dash) */,
                    148 => '&mdash;'  /* — (Em dash) */,
                    152 => '&lsquo;'  /* ‘ (Left single quotation mark) */,
                    153 => '&rsquo;'  /* ’ (Right single quotation mark) */,
                    154 => '&sbquo;'  /* ‚ (Single low-9 quotation mark) */,
                    156 => '&ldquo;'  /* “ (Left double quotation mark) */,
                    157 => '&rdquo;'  /* ” (Right double quotation mark) */,
                    158 => '&bdquo;'  /* „ (Double low-9 quotation mark) */,
                    160 => '&dagger;'  /* † (Dagger) */,
                    161 => '&Dagger;'  /* ‡ (Double dagger) */,
                    162 => '&bull;'  /* • (Bullet) */,
                    166 => '&hellip;'  /* … (Horizontal ellipsis) */,
                    176 => '&permil;'  /* ‰ (Per mille) */,
                    178 => '&prime;'  /* ′ (Minutes (Degrees)) */,
                    179 => '&Prime;'  /* ″ (Seconds (Degrees)) */,
                    185 => '&lsaquo;'  /* ‹ (Single left angle quotation) */,
                    186 => '&rsaquo;'  /* › (Single right angle quotation) */,
                    190 => '&oline;'  /* ‾ (Overline) */,
                ],
                130  => [
                    172 => '&euro;'  /* € (Euro) */,
                ],
                132  => [
                    162 => '&trade;'  /* ™ (Trademark) */,
                ],
                134  => [
                    144 => '&larr;'  /* ← (Left arrow) */,
                    145 => '&uarr;'  /* ↑ (Up arrow) */,
                    146 => '&rarr;'  /* → (Right arrow) */,
                    147 => '&darr;'  /* ↓ (Down arrow) */,
                    148 => '&harr;'  /* ↔ (Left right arrow) */,
                    181 => '&crarr;'  /* ↵ (Carriage return arrow) */,
                ],
                140  => [
                    136 => '&lceil;'  /* ⌈ (Left ceiling) */,
                    137 => '&rceil;'  /* ⌉ (Right ceiling) */,
                    138 => '&lfloor;'  /* ⌊ (Left floor) */,
                    139 => '&rfloor;'  /* ⌋ (Right floor) */,
                ],
                151  => [
                    138 => '&loz;'  /* ◊ (Lozenge) */,
                ],
                153  => [
                    160 => '&spades;'  /* ♠ (Spade) */,
                    163 => '&clubs;'  /* ♣ (Club) */,
                    165 => '&hearts;'  /* ♥ (Heart) */,
                    166 => '&diams;'  /* ♦ (Diamond) */,
                ],
            ],
            206 => [
                145 => '&Alpha;'  /* Α (Alpha) */,
                146 => '&Beta;'  /* Β (Beta) */,
                147 => '&Gamma;'  /* Γ (Gamma) */,
                148 => '&Delta;'  /* Δ (Delta) */,
                149 => '&Epsilon;'  /* Ε (Epsilon) */,
                150 => '&Zeta;'  /* Ζ (Zeta) */,
                151 => '&Eta;'  /* Η (Eta) */,
                152 => '&Theta;'  /* Θ (Theta) */,
                153 => '&Iota;'  /* Ι (Iota) */,
                154 => '&Kappa;'  /* Κ (Kappa) */,
                155 => '&Lambda;'  /* Λ (Lambda) */,
                156 => '&Mu;'  /* Μ (Mu) */,
                157 => '&Nu;'  /* Ν (Nu) */,
                158 => '&Xi;'  /* Ξ (Xi) */,
                159 => '&Omicron;'  /* Ο (Omicron) */,
                160 => '&Pi;'  /* Π (Pi) */,
                161 => '&Rho;'  /* Ρ (Rho) */,
                163 => '&Sigma;'  /* Σ (Sigma) */,
                164 => '&Tau;'  /* Τ (Tau) */,
                165 => '&Upsilon;'  /* Υ (Upsilon) */,
                166 => '&Phi;'  /* Φ (Phi) */,
                167 => '&Chi;'  /* Χ (Chi) */,
                168 => '&Psi;'  /* Ψ (Psi) */,
                169 => '&Omega;'  /* Ω (Omega) */,
                177 => '&alpha;'  /* α (alpha) */,
                178 => '&beta;'  /* β (beta) */,
                179 => '&gamma;'  /* γ (gamma) */,
                180 => '&delta;'  /* δ (delta) */,
                181 => '&epsilon;'  /* ε (epsilon) */,
                182 => '&zeta;'  /* ζ (zeta) */,
                183 => '&eta;'  /* η (eta) */,
                184 => '&theta;'  /* θ (theta) */,
                185 => '&iota;'  /* ι (iota) */,
                186 => '&kappa;'  /* κ (kappa) */,
                187 => '&lambda;'  /* λ (lambda) */,
                188 => '&mu;'  /* μ (mu) */,
                189 => '&nu;'  /* ν (nu) */,
                190 => '&xi;'  /* ξ (xi) */,
                191 => '&omicron;'  /* ο (omicron) */,
            ],
            207 => [
                128 => '&pi;'  /* π (pi) */,
                129 => '&rho;'  /* ρ (rho) */,
                130 => '&sigmaf;'  /* ς (sigmaf) */,
                131 => '&sigma;'  /* σ (sigma) */,
                132 => '&tau;'  /* τ (tau) */,
                133 => '&upsilon;'  /* υ (upsilon) */,
                134 => '&phi;'  /* φ (phi) */,
                135 => '&chi;'  /* χ (chi) */,
                136 => '&psi;'  /* ψ (psi) */,
                137 => '&omega;'  /* ω (omega) */,
                145 => '&thetasym;'  /* ϑ (Theta symbol) */,
                146 => '&upsih;'  /* ϒ (Upsilon symbol) */,
                150 => '&piv;'  /* ϖ (Pi symbol) */,
            ],
            198 => [
                146 => '&fnof;'  /* ƒ (Lowercase with hook) */,
            ],
            203 => [
                134 => '&circ;'  /* ˆ (Circumflex accent) */,
                156 => '&tilde;'  /* ˜ (Tilde) */,
            ],
        ];

        return FromUTF8::baseConversion($ASCII_CONV, $text);
    }

    /**
     * Base conversion
     *
     * @param string[] $vector
     * @param string $text
     * @return string
     */
    protected static function baseConversion($vector, $text)
    {
        $result = "";
        $lenText = strlen($text);
        $keys = array_keys($vector);
        for ($i = 0; $i < $lenText; $i++) {
            if (ord($text[$i]) == 226) {
                $first = ord($text[$i++]);
                $second = ord($text[$i++]);
                $result .= isset($vector[$first][$second][ord($text[$i])]) ? $vector[$first][$second][ord($text[$i])] : '?';
            } elseif (in_array(ord($text[$i]), $keys)) {
                $first = ord($text[$i++]);
                $result .= isset($vector[$first][ord($text[$i])]) ? $vector[$first][ord($text[$i])] : '?';
            } else {
                $result .= $text[$i];
            }
        }

        return $result;
    }
}

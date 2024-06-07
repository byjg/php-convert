<?php

namespace ByJG\Convert;

class ToUTF8
{

    /**
     * Convert a ascii html entities to UTF8
     *
     * @param string $text
     * @return string
     */
    public static function fromHtmlEntities(string $text): string
    {
        $HTML_ENTITIES = [
            '&Agrave;' => [195,128]   /* À (Capital a with grave accent) */,
            '&#192;' => [195,128]   /* À (Capital a with grave accent) */,
            '&Aacute;' => [195,129]   /* Á (Capital a with acute accent) */,
            '&#193;' => [195,129]   /* Á (Capital a with acute accent) */,
            '&Acirc;' => [195,130]   /* Â (Capital a with circumflex accent) */,
            '&#194;' => [195,130]   /* Â (Capital a with circumflex accent) */,
            '&Atilde;' => [195,131]   /* Ã (Capital a with tilde) */,
            '&#195;' => [195,131]   /* Ã (Capital a with tilde) */,
            '&Auml;' => [195,132]   /* Ä (Capital a with umlaut) */,
            '&#196;' => [195,132]   /* Ä (Capital a with umlaut) */,
            '&Aring;' => [195,133]   /* Å (Capital a with ring) */,
            '&#197;' => [195,133]   /* Å (Capital a with ring) */,
            '&AElig;' => [195,134]   /* Æ (Capital ae) */,
            '&#198;' => [195,134]   /* Æ (Capital ae) */,
            '&Ccedil;' => [195,135]   /* Ç (Capital c with cedilla) */,
            '&#199;' => [195,135]   /* Ç (Capital c with cedilla) */,
            '&Egrave;' => [195,136]   /* È (Capital e with grave accent) */,
            '&#200;' => [195,136]   /* È (Capital e with grave accent) */,
            '&Eacute;' => [195,137]   /* É (Capital e with acute accent) */,
            '&#201;' => [195,137]   /* É (Capital e with acute accent) */,
            '&Ecirc;' => [195,138]   /* Ê (Capital e with circumflex accent) */,
            '&#202;' => [195,138]   /* Ê (Capital e with circumflex accent) */,
            '&Euml;' => [195,139]   /* Ë (Capital e with umlaut) */,
            '&#203;' => [195,139]   /* Ë (Capital e with umlaut) */,
            '&Igrave;' => [195,140]   /* Ì (Capital i with grave accent) */,
            '&#204;' => [195,140]   /* Ì (Capital i with grave accent) */,
            '&Iacute;' => [195,141]   /* Í (Capital i with accute accent) */,
            '&#205;' => [195,141]   /* Í (Capital i with accute accent) */,
            '&Icirc;' => [195,142]   /* Î (Capital i with circumflex accent) */,
            '&#206;' => [195,142]   /* Î (Capital i with circumflex accent) */,
            '&Iuml;' => [195,143]   /* Ï (Capital i with umlaut) */,
            '&#207;' => [195,143]   /* Ï (Capital i with umlaut) */,
            '&ETH;' => [195,144]   /* Ð (Capital eth (Icelandic)) */,
            '&#208;' => [195,144]   /* Ð (Capital eth (Icelandic)) */,
            '&Ntilde;' => [195,145]   /* Ñ (Capital n with tilde) */,
            '&#209;' => [195,145]   /* Ñ (Capital n with tilde) */,
            '&Ograve;' => [195,146]   /* Ò (Capital o with grave accent) */,
            '&#210;' => [195,146]   /* Ò (Capital o with grave accent) */,
            '&Oacute;' => [195,147]   /* Ó (Capital o with accute accent) */,
            '&#211;' => [195,147]   /* Ó (Capital o with accute accent) */,
            '&Ocirc;' => [195,148]   /* Ô (Capital o with circumflex accent) */,
            '&#212;' => [195,148]   /* Ô (Capital o with circumflex accent) */,
            '&Otilde;' => [195,149]   /* Õ (Capital o with tilde) */,
            '&#213;' => [195,149]   /* Õ (Capital o with tilde) */,
            '&Ouml;' => [195,150]   /* Ö (Capital o with umlaut) */,
            '&#214;' => [195,150]   /* Ö (Capital o with umlaut) */,
            '&Oslash;' => [195,152]   /* Ø (Capital o with slash) */,
            '&#216;' => [195,152]   /* Ø (Capital o with slash) */,
            '&Ugrave;' => [195,153]   /* Ù (Capital u with grave accent) */,
            '&#217;' => [195,153]   /* Ù (Capital u with grave accent) */,
            '&Uacute;' => [195,154]   /* Ú (Capital u with acute accent) */,
            '&#218;' => [195,154]   /* Ú (Capital u with acute accent) */,
            '&Ucirc;' => [195,155]   /* Û (Capital u with circumflex accent) */,
            '&#219;' => [195,155]   /* Û (Capital u with circumflex accent) */,
            '&Uuml;' => [195,156]   /* Ü (Capital u with umlaut) */,
            '&#220;' => [195,156]   /* Ü (Capital u with umlaut) */,
            '&Utilde;' => [197,168]   /* Ũ (Capital u with tilde accent) */,
            '&Yacute;' => [195,157]   /* Ý (Capital y with acute accent) */,
            '&#221;' => [195,157]   /* Ý (Capital y with acute accent) */,
            '&THORN;' => [195,158]   /* Þ (Capital thorn (Icelandic)) */,
            '&#222;' => [195,158]   /* Þ (Capital thorn (Icelandic)) */,
            '&szlig;' => [195,159]   /* ß (Lowercase sharp s (German)) */,
            '&#223;' => [195,159]   /* ß (Lowercase sharp s (German)) */,
            '&agrave;' => [195,160]   /* à (Lowercase a with grave accent) */,
            '&#224;' => [195,160]   /* à (Lowercase a with grave accent) */,
            '&aacute;' => [195,161]   /* á (Lowercase a with acute accent) */,
            '&#225;' => [195,161]   /* á (Lowercase a with acute accent) */,
            '&acirc;' => [195,162]   /* â (Lowercase a with circumflex accent) */,
            '&#226;' => [195,162]   /* â (Lowercase a with circumflex accent) */,
            '&atilde;' => [195,163]   /* ã (Lowercase a with tilde) */,
            '&#227;' => [195,163]   /* ã (Lowercase a with tilde) */,
            '&auml;' => [195,164]   /* ä (Lowercase a with umlaut) */,
            '&#228;' => [195,164]   /* ä (Lowercase a with umlaut) */,
            '&aring;' => [195,165]   /* å (Lowercase a with ring) */,
            '&#229;' => [195,165]   /* å (Lowercase a with ring) */,
            '&aelig;' => [195,166]   /* æ (Lowercase ae) */,
            '&#230;' => [195,166]   /* æ (Lowercase ae) */,
            '&ccedil;' => [195,167]   /* ç (Lowercase c with cedilla) */,
            '&#231;' => [195,167]   /* ç (Lowercase c with cedilla) */,
            '&egrave;' => [195,168]   /* è (Lowercase e with grave accent) */,
            '&#232;' => [195,168]   /* è (Lowercase e with grave accent) */,
            '&eacute;' => [195,169]   /* é (Lowercase e with acute accent) */,
            '&#233;' => [195,169]   /* é (Lowercase e with acute accent) */,
            '&ecirc;' => [195,170]   /* ê (Lowercase e with circumflex accent) */,
            '&#234;' => [195,170]   /* ê (Lowercase e with circumflex accent) */,
            '&euml;' => [195,171]   /* ë (Lowercase e with umlaut) */,
            '&#235;' => [195,171]   /* ë (Lowercase e with umlaut) */,
            '&igrave;' => [195,172]   /* ì (Lowercase i with grave accent) */,
            '&#236;' => [195,172]   /* ì (Lowercase i with grave accent) */,
            '&iacute;' => [195,173]   /* í (Lowercase i with acute accent) */,
            '&#237;' => [195,173]   /* í (Lowercase i with acute accent) */,
            '&icirc;' => [195,174]   /* î (Lowercase i with circumflex accent) */,
            '&#238;' => [195,174]   /* î (Lowercase i with circumflex accent) */,
            '&iuml;' => [195,175]   /* ï (Lowercase i with umlaut) */,
            '&#239;' => [195,175]   /* ï (Lowercase i with umlaut) */,
            '&eth;' => [195,176]   /* ð (Lowercase eth (Icelandic)) */,
            '&#240;' => [195,176]   /* ð (Lowercase eth (Icelandic)) */,
            '&ntilde;' => [195,177]   /* ñ (Lowercase n with tilde) */,
            '&#241;' => [195,177]   /* ñ (Lowercase n with tilde) */,
            '&ograve;' => [195,178]   /* ò (Lowercase o with grave accent) */,
            '&#242;' => [195,178]   /* ò (Lowercase o with grave accent) */,
            '&oacute;' => [195,179]   /* ó (Lowercase o with acute accent) */,
            '&#243;' => [195,179]   /* ó (Lowercase o with acute accent) */,
            '&ocirc;' => [195,180]   /* ô (Lowercase o with circumflex accent) */,
            '&#244;' => [195,180]   /* ô (Lowercase o with circumflex accent) */,
            '&otilde;' => [195,181]   /* õ (Lowercase o with tilde) */,
            '&#245;' => [195,181]   /* õ (Lowercase o with tilde) */,
            '&ouml;' => [195,182]   /* ö (Lowercase o with umlaut) */,
            '&#246;' => [195,182]   /* ö (Lowercase o with umlaut) */,
            '&oslash;' => [195,184]   /* ø (Lowercase o with slash) */,
            '&#248;' => [195,184]   /* ø (Lowercase o with slash) */,
            '&ugrave;' => [195,185]   /* ù (Lowercase u with grave accent) */,
            '&#249;' => [195,185]   /* ù (Lowercase u with grave accent) */,
            '&uacute;' => [195,186]   /* ú (Lowercase u with acute accent) */,
            '&#250;' => [195,186]   /* ú (Lowercase u with acute accent) */,
            '&ucirc;' => [195,187]   /* û (Lowercase u with circumflex accent) */,
            '&#251;' => [195,187]   /* û (Lowercase u with circumflex accent) */,
            '&uuml;' => [195,188]   /* ü (Lowercase u with umlaut) */,
            '&#252;' => [195,188]   /* ü (Lowercase u with umlaut) */,
            '&utilde;' => [197,169]   /* ũ (Lowercase u with tilde accent) */,
            '&yacute;' => [195,189]   /* ý (Lowercase y with acute accent) */,
            '&#253;' => [195,189]   /* ý (Lowercase y with acute accent) */,
            '&thorn;' => [195,190]   /* þ (Lowercase thorn (Icelandic)) */,
            '&#254;' => [195,190]   /* þ (Lowercase thorn (Icelandic)) */,
            '&yuml;' => [195,191]   /* ÿ (Lowercase y with umlaut) */,
            '&#255;' => [195,191]   /* ÿ (Lowercase y with umlaut) */,
            '&nbsp;' => [32]   /*   (Non-breaking space) */,
            '&#160;' => [32]   /*   (Non-breaking space) */,
            '&iexcl;' => [194,161]   /* ¡ (Inverted exclamation mark) */,
            '&#161;' => [194,161]   /* ¡ (Inverted exclamation mark) */,
            '&cent;' => [194,162]   /* ¢ (Cent) */,
            '&#162;' => [194,162]   /* ¢ (Cent) */,
            '&pound;' => [194,163]   /* £ (Pound) */,
            '&#163;' => [194,163]   /* £ (Pound) */,
            '&curren;' => [194,164]   /* ¤ (Currency) */,
            '&#164;' => [194,164]   /* ¤ (Currency) */,
            '&yen;' => [194,165]   /* ¥ (Yen) */,
            '&#165;' => [194,165]   /* ¥ (Yen) */,
            '&brvbar;' => [194,166]   /* ¦ (Broken vertical bar) */,
            '&#166;' => [194,166]   /* ¦ (Broken vertical bar) */,
            '&sect;' => [194,167]   /* § (Section) */,
            '&#167;' => [194,167]   /* § (Section) */,
            '&uml;' => [194,168]   /* ¨ (Spacing diaeresis) */,
            '&#168;' => [194,168]   /* ¨ (Spacing diaeresis) */,
            '&copy;' => [194,169]   /* © (Copyright) */,
            '&#169;' => [194,169]   /* © (Copyright) */,
            '&ordf;' => [194,170]   /* ª (Feminine ordinal indicator) */,
            '&#170;' => [194,170]   /* ª (Feminine ordinal indicator) */,
            '&laquo;' => [194,171]   /* « (Opening/Left angle quotation mark) */,
            '&#171;' => [194,171]   /* « (Opening/Left angle quotation mark) */,
            '&not;' => [194,172]   /* ¬ (Negation) */,
            '&#172;' => [194,172]   /* ¬ (Negation) */,
            '&reg;' => [194,174]   /* ® (Registered trademark) */,
            '&#174;' => [194,174]   /* ® (Registered trademark) */,
            '&macr;' => [194,175]   /* ¯ (Spacing macron) */,
            '&#175;' => [194,175]   /* ¯ (Spacing macron) */,
            '&deg;' => [194,176]   /* ° (Degree) */,
            '&#176;' => [194,176]   /* ° (Degree) */,
            '&plusmn;' => [194,177]   /* ± (Plus or minus) */,
            '&#177;' => [194,177]   /* ± (Plus or minus) */,
            '&sup2;' => [194,178]   /* ² (Superscript 2) */,
            '&#178;' => [194,178]   /* ² (Superscript 2) */,
            '&sup3;' => [194,179]   /* ³ (Superscript 3) */,
            '&#179;' => [194,179]   /* ³ (Superscript 3) */,
            '&acute;' => [194,180]   /* ´ (Spacing acute) */,
            '&#180;' => [194,180]   /* ´ (Spacing acute) */,
            '&micro;' => [194,181]   /* µ (Micro) */,
            '&#181;' => [194,181]   /* µ (Micro) */,
            '&para;' => [194,182]   /* ¶ (Paragraph) */,
            '&#182;' => [194,182]   /* ¶ (Paragraph) */,
            '&cedil;' => [194,184]   /* ¸ (Spacing cedilla) */,
            '&#184;' => [194,184]   /* ¸ (Spacing cedilla) */,
            '&sup1;' => [194,185]   /* ¹ (Superscript 1) */,
            '&#185;' => [194,185]   /* ¹ (Superscript 1) */,
            '&ordm;' => [194,186]   /* º (Masculine ordinal indicator) */,
            '&#186;' => [194,186]   /* º (Masculine ordinal indicator) */,
            '&raquo;' => [194,187]   /* » (Closing/Right angle quotation mark) */,
            '&#187;' => [194,187]   /* » (Closing/Right angle quotation mark) */,
            '&frac14;' => [194,188]   /* ¼ (Fraction 1/4) */,
            '&#188;' => [194,188]   /* ¼ (Fraction 1/4) */,
            '&frac12;' => [194,189]   /* ½ (Fraction 1/2) */,
            '&#189;' => [194,189]   /* ½ (Fraction 1/2) */,
            '&frac34;' => [194,190]   /* ¾ (Fraction 3/4) */,
            '&#190;' => [194,190]   /* ¾ (Fraction 3/4) */,
            '&iquest;' => [194,191]   /* ¿ (Inverted question mark) */,
            '&#191;' => [194,191]   /* ¿ (Inverted question mark) */,
            '&times;' => [195,151]   /* × (Multiplication) */,
            '&#215;' => [195,151]   /* × (Multiplication) */,
            '&divide;' => [195,183]   /* ÷ (Divide) */,
            '&#247;' => [195,183]   /* ÷ (Divide) */,
            '&forall;' => [226,136,128]   /* ∀ (For all) */,
            '&#8704;' => [226,136,128]   /* ∀ (For all) */,
            '&part;' => [226,136,130]   /* ∂ (Part) */,
            '&#8706;' => [226,136,130]   /* ∂ (Part) */,
            '&exist;' => [226,136,131]   /* ∃ (Exist) */,
            '&#8707;' => [226,136,131]   /* ∃ (Exist) */,
            '&empty;' => [226,136,133]   /* ∅ (Empty) */,
            '&#8709;' => [226,136,133]   /* ∅ (Empty) */,
            '&nabla;' => [226,136,135]   /* ∇ (Nabla) */,
            '&#8711;' => [226,136,135]   /* ∇ (Nabla) */,
            '&isin;' => [226,136,136]   /* ∈ (Is in) */,
            '&#8712;' => [226,136,136]   /* ∈ (Is in) */,
            '&notin;' => [226,136,137]   /* ∉ (Not in) */,
            '&#8713;' => [226,136,137]   /* ∉ (Not in) */,
            '&ni;' => [226,136,139]   /* ∋ (Ni) */,
            '&#8715;' => [226,136,139]   /* ∋ (Ni) */,
            '&prod;' => [226,136,143]   /* ∏ (Product) */,
            '&#8719;' => [226,136,143]   /* ∏ (Product) */,
            '&sum;' => [226,136,145]   /* ∑ (Sum) */,
            '&#8721;' => [226,136,145]   /* ∑ (Sum) */,
            '&minus;' => [226,136,146]   /* − (Minus) */,
            '&#8722;' => [226,136,146]   /* − (Minus) */,
            '&lowast;' => [226,136,151]   /* ∗ (Asterisk (Lowast)) */,
            '&#8727;' => [226,136,151]   /* ∗ (Asterisk (Lowast)) */,
            '&radic;' => [226,136,154]   /* √ (Square root) */,
            '&#8730;' => [226,136,154]   /* √ (Square root) */,
            '&prop;' => [226,136,157]   /* ∝ (Proportional to) */,
            '&#8733;' => [226,136,157]   /* ∝ (Proportional to) */,
            '&infin;' => [226,136,158]   /* ∞ (Infinity) */,
            '&#8734;' => [226,136,158]   /* ∞ (Infinity) */,
            '&ang;' => [226,136,160]   /* ∠ (Angle) */,
            '&#8736;' => [226,136,160]   /* ∠ (Angle) */,
            '&and;' => [226,136,167]   /* ∧ (And) */,
            '&#8743;' => [226,136,167]   /* ∧ (And) */,
            '&or;' => [226,136,168]   /* ∨ (Or) */,
            '&#8744;' => [226,136,168]   /* ∨ (Or) */,
            '&cap;' => [226,136,169]   /* ∩ (Cap) */,
            '&#8745;' => [226,136,169]   /* ∩ (Cap) */,
            '&cup;' => [226,136,170]   /* ∪ (Cup) */,
            '&#8746;' => [226,136,170]   /* ∪ (Cup) */,
            '&int;' => [226,136,171]   /* ∫ (Integral) */,
            '&#8747;' => [226,136,171]   /* ∫ (Integral) */,
            '&there4;' => [226,136,180]   /* ∴ (Therefore) */,
            '&#8756;' => [226,136,180]   /* ∴ (Therefore) */,
            '&sim;' => [226,136,188]   /* ∼ (Similar to) */,
            '&#8764;' => [226,136,188]   /* ∼ (Similar to) */,
            '&cong;' => [226,137,133]   /* ≅ (Congurent to) */,
            '&#8773;' => [226,137,133]   /* ≅ (Congurent to) */,
            '&asymp;' => [226,137,136]   /* ≈ (Almost equal) */,
            '&#8776;' => [226,137,136]   /* ≈ (Almost equal) */,
            '&ne;' => [226,137,160]   /* ≠ (Not equal) */,
            '&#8800;' => [226,137,160]   /* ≠ (Not equal) */,
            '&equiv;' => [226,137,161]   /* ≡ (Equivalent) */,
            '&#8801;' => [226,137,161]   /* ≡ (Equivalent) */,
            '&le;' => [226,137,164]   /* ≤ (Less or equal) */,
            '&#8804;' => [226,137,164]   /* ≤ (Less or equal) */,
            '&ge;' => [226,137,165]   /* ≥ (Greater or equal) */,
            '&#8805;' => [226,137,165]   /* ≥ (Greater or equal) */,
            '&sub;' => [226,138,130]   /* ⊂ (Subset of) */,
            '&#8834;' => [226,138,130]   /* ⊂ (Subset of) */,
            '&sup;' => [226,138,131]   /* ⊃ (Superset of) */,
            '&#8835;' => [226,138,131]   /* ⊃ (Superset of) */,
            '&nsub;' => [226,138,132]   /* ⊄ (Not subset of) */,
            '&#8836;' => [226,138,132]   /* ⊄ (Not subset of) */,
            '&sube;' => [226,138,134]   /* ⊆ (Subset or equal) */,
            '&#8838;' => [226,138,134]   /* ⊆ (Subset or equal) */,
            '&supe;' => [226,138,135]   /* ⊇ (Superset or equal) */,
            '&#8839;' => [226,138,135]   /* ⊇ (Superset or equal) */,
            '&oplus;' => [226,138,149]   /* ⊕ (Circled plus) */,
            '&#8853;' => [226,138,149]   /* ⊕ (Circled plus) */,
            '&otimes;' => [226,138,151]   /* ⊗ (Circled times) */,
            '&#8855;' => [226,138,151]   /* ⊗ (Circled times) */,
            '&perp;' => [226,138,165]   /* ⊥ (Perpendicular) */,
            '&#8869;' => [226,138,165]   /* ⊥ (Perpendicular) */,
            '&sdot;' => [226,139,133]   /* ⋅ (Dot operator) */,
            '&#8901;' => [226,139,133]   /* ⋅ (Dot operator) */,
            '&Alpha;' => [206,145]   /* Α (Alpha) */,
            '&#913;' => [206,145]   /* Α (Alpha) */,
            '&Beta;' => [206,146]   /* Β (Beta) */,
            '&#914;' => [206,146]   /* Β (Beta) */,
            '&Gamma;' => [206,147]   /* Γ (Gamma) */,
            '&#915;' => [206,147]   /* Γ (Gamma) */,
            '&Delta;' => [206,148]   /* Δ (Delta) */,
            '&#916;' => [206,148]   /* Δ (Delta) */,
            '&Epsilon;' => [206,149]   /* Ε (Epsilon) */,
            '&#917;' => [206,149]   /* Ε (Epsilon) */,
            '&Zeta;' => [206,150]   /* Ζ (Zeta) */,
            '&#918;' => [206,150]   /* Ζ (Zeta) */,
            '&Eta;' => [206,151]   /* Η (Eta) */,
            '&#919;' => [206,151]   /* Η (Eta) */,
            '&Theta;' => [206,152]   /* Θ (Theta) */,
            '&#920;' => [206,152]   /* Θ (Theta) */,
            '&Iota;' => [206,153]   /* Ι (Iota) */,
            '&#921;' => [206,153]   /* Ι (Iota) */,
            '&Kappa;' => [206,154]   /* Κ (Kappa) */,
            '&#922;' => [206,154]   /* Κ (Kappa) */,
            '&Lambda;' => [206,155]   /* Λ (Lambda) */,
            '&#923;' => [206,155]   /* Λ (Lambda) */,
            '&Mu;' => [206,156]   /* Μ (Mu) */,
            '&#924;' => [206,156]   /* Μ (Mu) */,
            '&Nu;' => [206,157]   /* Ν (Nu) */,
            '&#925;' => [206,157]   /* Ν (Nu) */,
            '&Xi;' => [206,158]   /* Ξ (Xi) */,
            '&#926;' => [206,158]   /* Ξ (Xi) */,
            '&Omicron;' => [206,159]   /* Ο (Omicron) */,
            '&#927;' => [206,159]   /* Ο (Omicron) */,
            '&Pi;' => [206,160]   /* Π (Pi) */,
            '&#928;' => [206,160]   /* Π (Pi) */,
            '&Rho;' => [206,161]   /* Ρ (Rho) */,
            '&#929;' => [206,161]   /* Ρ (Rho) */,
            '&Sigma;' => [206,163]   /* Σ (Sigma) */,
            '&#931;' => [206,163]   /* Σ (Sigma) */,
            '&Tau;' => [206,164]   /* Τ (Tau) */,
            '&#932;' => [206,164]   /* Τ (Tau) */,
            '&Upsilon;' => [206,165]   /* Υ (Upsilon) */,
            '&#933;' => [206,165]   /* Υ (Upsilon) */,
            '&Phi;' => [206,166]   /* Φ (Phi) */,
            '&#934;' => [206,166]   /* Φ (Phi) */,
            '&Chi;' => [206,167]   /* Χ (Chi) */,
            '&#935;' => [206,167]   /* Χ (Chi) */,
            '&Psi;' => [206,168]   /* Ψ (Psi) */,
            '&#936;' => [206,168]   /* Ψ (Psi) */,
            '&Omega;' => [206,169]   /* Ω (Omega) */,
            '&#937;' => [206,169]   /* Ω (Omega) */,
            '&alpha;' => [206,177]   /* α (alpha) */,
            '&#945;' => [206,177]   /* α (alpha) */,
            '&beta;' => [206,178]   /* β (beta) */,
            '&#946;' => [206,178]   /* β (beta) */,
            '&gamma;' => [206,179]   /* γ (gamma) */,
            '&#947;' => [206,179]   /* γ (gamma) */,
            '&delta;' => [206,180]   /* δ (delta) */,
            '&#948;' => [206,180]   /* δ (delta) */,
            '&epsilon;' => [206,181]   /* ε (epsilon) */,
            '&#949;' => [206,181]   /* ε (epsilon) */,
            '&zeta;' => [206,182]   /* ζ (zeta) */,
            '&#950;' => [206,182]   /* ζ (zeta) */,
            '&eta;' => [206,183]   /* η (eta) */,
            '&#951;' => [206,183]   /* η (eta) */,
            '&theta;' => [206,184]   /* θ (theta) */,
            '&#952;' => [206,184]   /* θ (theta) */,
            '&iota;' => [206,185]   /* ι (iota) */,
            '&#953;' => [206,185]   /* ι (iota) */,
            '&kappa;' => [206,186]   /* κ (kappa) */,
            '&#954;' => [206,186]   /* κ (kappa) */,
            '&lambda;' => [206,187]   /* λ (lambda) */,
            '&#955;' => [206,187]   /* λ (lambda) */,
            '&mu;' => [206,188]   /* μ (mu) */,
            '&#956;' => [206,188]   /* μ (mu) */,
            '&nu;' => [206,189]   /* ν (nu) */,
            '&#957;' => [206,189]   /* ν (nu) */,
            '&xi;' => [206,190]   /* ξ (xi) */,
            '&#958;' => [206,190]   /* ξ (xi) */,
            '&omicron;' => [206,191]   /* ο (omicron) */,
            '&#959;' => [206,191]   /* ο (omicron) */,
            '&pi;' => [207,128]   /* π (pi) */,
            '&#960;' => [207,128]   /* π (pi) */,
            '&rho;' => [207,129]   /* ρ (rho) */,
            '&#961;' => [207,129]   /* ρ (rho) */,
            '&sigmaf;' => [207,130]   /* ς (sigmaf) */,
            '&#962;' => [207,130]   /* ς (sigmaf) */,
            '&sigma;' => [207,131]   /* σ (sigma) */,
            '&#963;' => [207,131]   /* σ (sigma) */,
            '&tau;' => [207,132]   /* τ (tau) */,
            '&#964;' => [207,132]   /* τ (tau) */,
            '&upsilon;' => [207,133]   /* υ (upsilon) */,
            '&#965;' => [207,133]   /* υ (upsilon) */,
            '&phi;' => [207,134]   /* φ (phi) */,
            '&#966;' => [207,134]   /* φ (phi) */,
            '&chi;' => [207,135]   /* χ (chi) */,
            '&#967;' => [207,135]   /* χ (chi) */,
            '&psi;' => [207,136]   /* ψ (psi) */,
            '&#968;' => [207,136]   /* ψ (psi) */,
            '&omega;' => [207,137]   /* ω (omega) */,
            '&#969;' => [207,137]   /* ω (omega) */,
            '&thetasym;' => [207,145]   /* ϑ (Theta symbol) */,
            '&#977;' => [207,145]   /* ϑ (Theta symbol) */,
            '&upsih;' => [207,146]   /* ϒ (Upsilon symbol) */,
            '&#978;' => [207,146]   /* ϒ (Upsilon symbol) */,
            '&piv;' => [207,150]   /* ϖ (Pi symbol) */,
            '&#982;' => [207,150]   /* ϖ (Pi symbol) */,
            '&OElig;' => [197,146]   /* Œ (Uppercase ligature OE) */,
            '&#338;' => [197,146]   /* Œ (Uppercase ligature OE) */,
            '&oelig;' => [197,147]   /* œ (Lowercase ligature OE) */,
            '&#339;' => [197,147]   /* œ (Lowercase ligature OE) */,
            '&Scaron;' => [197,160]   /* Š (Uppercase S with caron) */,
            '&#352;' => [197,160]   /* Š (Uppercase S with caron) */,
            '&scaron;' => [197,161]   /* š (Lowercase S with caron) */,
            '&#353;' => [197,161]   /* š (Lowercase S with caron) */,
            '&Yuml;' => [197,184]   /* Ÿ (Capital Y with diaeres) */,
            '&#376;' => [197,184]   /* Ÿ (Capital Y with diaeres) */,
            '&fnof;' => [198,146]   /* ƒ (Lowercase with hook) */,
            '&#402;' => [198,146]   /* ƒ (Lowercase with hook) */,
            '&circ;' => [203,134]   /* ˆ (Circumflex accent) */,
            '&#710;' => [203,134]   /* ˆ (Circumflex accent) */,
            '&tilde;' => [203,156]   /* ˜ (Tilde) */,
            '&#732;' => [203,156]   /* ˜ (Tilde) */,
            '&ndash;' => [226,128,147]   /* – (En dash) */,
            '&#8211;' => [226,128,147]   /* – (En dash) */,
            '&mdash;' => [226,128,148]   /* — (Em dash) */,
            '&#8212;' => [226,128,148]   /* — (Em dash) */,
            '&lsquo;' => [226,128,152]   /* ‘ (Left single quotation mark) */,
            '&#8216;' => [226,128,152]   /* ‘ (Left single quotation mark) */,
            '&rsquo;' => [226,128,153]   /* ’ (Right single quotation mark) */,
            '&#8217;' => [226,128,153]   /* ’ (Right single quotation mark) */,
            '&sbquo;' => [226,128,154]   /* ‚ (Single low-9 quotation mark) */,
            '&#8218;' => [226,128,154]   /* ‚ (Single low-9 quotation mark) */,
            '&ldquo;' => [226,128,156]   /* “ (Left double quotation mark) */,
            '&#8220;' => [226,128,156]   /* “ (Left double quotation mark) */,
            '&rdquo;' => [226,128,157]   /* ” (Right double quotation mark) */,
            '&#8221;' => [226,128,157]   /* ” (Right double quotation mark) */,
            '&bdquo;' => [226,128,158]   /* „ (Double low-9 quotation mark) */,
            '&#8222;' => [226,128,158]   /* „ (Double low-9 quotation mark) */,
            '&dagger;' => [226,128,160]   /* † (Dagger) */,
            '&#8224;' => [226,128,160]   /* † (Dagger) */,
            '&Dagger;' => [226,128,161]   /* ‡ (Double dagger) */,
            '&#8225;' => [226,128,161]   /* ‡ (Double dagger) */,
            '&bull;' => [226,128,162]   /* • (Bullet) */,
            '&#8226;' => [226,128,162]   /* • (Bullet) */,
            '&hellip;' => [226,128,166]   /* … (Horizontal ellipsis) */,
            '&#8230;' => [226,128,166]   /* … (Horizontal ellipsis) */,
            '&permil;' => [226,128,176]   /* ‰ (Per mille) */,
            '&#8240;' => [226,128,176]   /* ‰ (Per mille) */,
            '&prime;' => [226,128,178]   /* ′ (Minutes (Degrees)) */,
            '&#8242;' => [226,128,178]   /* ′ (Minutes (Degrees)) */,
            '&Prime;' => [226,128,179]   /* ″ (Seconds (Degrees)) */,
            '&#8243;' => [226,128,179]   /* ″ (Seconds (Degrees)) */,
            '&lsaquo;' => [226,128,185]   /* ‹ (Single left angle quotation) */,
            '&#8249;' => [226,128,185]   /* ‹ (Single left angle quotation) */,
            '&rsaquo;' => [226,128,186]   /* › (Single right angle quotation) */,
            '&#8250;' => [226,128,186]   /* › (Single right angle quotation) */,
            '&oline;' => [226,128,190]   /* ‾ (Overline) */,
            '&#8254;' => [226,128,190]   /* ‾ (Overline) */,
            '&euro;' => [226,130,172]   /* € (Euro) */,
            '&#8364;' => [226,130,172]   /* € (Euro) */,
            '&trade;' => [226,132,162]   /* ™ (Trademark) */,
            '&#8482;' => [226,132,162]   /* ™ (Trademark) */,
            '&larr;' => [226,134,144]   /* ← (Left arrow) */,
            '&#8592;' => [226,134,144]   /* ← (Left arrow) */,
            '&uarr;' => [226,134,145]   /* ↑ (Up arrow) */,
            '&#8593;' => [226,134,145]   /* ↑ (Up arrow) */,
            '&rarr;' => [226,134,146]   /* → (Right arrow) */,
            '&#8594;' => [226,134,146]   /* → (Right arrow) */,
            '&darr;' => [226,134,147]   /* ↓ (Down arrow) */,
            '&#8595;' => [226,134,147]   /* ↓ (Down arrow) */,
            '&harr;' => [226,134,148]   /* ↔ (Left right arrow) */,
            '&#8596;' => [226,134,148]   /* ↔ (Left right arrow) */,
            '&crarr;' => [226,134,181]   /* ↵ (Carriage return arrow) */,
            '&#8629;' => [226,134,181]   /* ↵ (Carriage return arrow) */,
            '&lceil;' => [226,140,136]   /* ⌈ (Left ceiling) */,
            '&#8968;' => [226,140,136]   /* ⌈ (Left ceiling) */,
            '&rceil;' => [226,140,137]   /* ⌉ (Right ceiling) */,
            '&#8969;' => [226,140,137]   /* ⌉ (Right ceiling) */,
            '&lfloor;' => [226,140,138]   /* ⌊ (Left floor) */,
            '&#8970;' => [226,140,138]   /* ⌊ (Left floor) */,
            '&rfloor;' => [226,140,139]   /* ⌋ (Right floor) */,
            '&#8971;' => [226,140,139]   /* ⌋ (Right floor) */,
            '&loz;' => [226,151,138]   /* ◊ (Lozenge) */,
            '&#9674;' => [226,151,138]   /* ◊ (Lozenge) */,
            '&spades;' => [226,153,160]   /* ♠ (Spade) */,
            '&#9824;' => [226,153,160]   /* ♠ (Spade) */,
            '&clubs;' => [226,153,163]   /* ♣ (Club) */,
            '&#9827;' => [226,153,163]   /* ♣ (Club) */,
            '&hearts;' => [226,153,165]   /* ♥ (Heart) */,
            '&#9829;' => [226,153,165]   /* ♥ (Heart) */,
            '&diams;' => [226,153,166]   /* ♦ (Diamond) */,
            '&#9830;' => [226,153,166]   /* ♦ (Diamond) */,
        ];

        return ToUTF8::baseConversion($HTML_ENTITIES, $text);
    }

    /**
     * Base convert based on array
     *
     * @param array $vector
     * @param string $text
     * @return string
     */
    protected static function baseConversion(array $vector, string $text): string
    {
        foreach ($vector as $key => $value) {
            $char = $value;
            if (is_array($value)) {
                $char = "";
                foreach ($value as $ascii) {
                    $char .= chr($ascii);
                }
            }
            $text = str_replace($key, $char, $text);
        }

        return $text;
    }

    public static function fromCombiningChar(string $text): string
    {
        $HTML_ENTITIES = [
            'A' . chr(204) . chr(128) => [195, 128]   /*À*/,
            'A' . chr(204) . chr(129) => [195, 129]   /*Á*/,
            'A' . chr(204) . chr(130) => [195, 130]   /*Â*/,
            'A' . chr(204) . chr(131) => [195, 131]   /*Ã*/,
            'A' . chr(204) . chr(136) => [195, 132]   /*Ä*/,
            'A' . chr(204) . chr(138) => [195, 133]   /*Å*/,
            'C' . chr(204) . chr(167) => [195, 135]   /*Ç*/,
            'E' . chr(204) . chr(128) => [195, 136]   /*È*/,
            'E' . chr(204) . chr(129) => [195, 137]   /*É*/,
            'E' . chr(204) . chr(130) => [195, 138]   /*Ê*/,
            'E' . chr(204) . chr(136) => [195, 139]   /*Ë*/,
            'I' . chr(204) . chr(128) => [195, 140]   /*Ì*/,
            'I' . chr(204) . chr(129) => [195, 141]   /*Í*/,
            'I' . chr(204) . chr(130) => [195, 142]   /*Î*/,
            'I' . chr(204) . chr(136) => [195, 143]   /*Ï*/,
            'N' . chr(204) . chr(131) => [195, 145]   /*Ñ*/,
            'O' . chr(204) . chr(128) => [195, 146]   /*Ò*/,
            'O' . chr(204) . chr(129) => [195, 147]   /*Ó*/,
            'O' . chr(204) . chr(130) => [195, 148]   /*Ô*/,
            'O' . chr(204) . chr(131) => [195, 149]   /*Õ*/,
            'O' . chr(204) . chr(136) => [195, 150]   /*Ö*/,
            'U' . chr(204) . chr(128) => [195, 153]   /*Ù*/,
            'U' . chr(204) . chr(129) => [195, 154]   /*Ú*/,
            'U' . chr(204) . chr(130) => [195, 155]   /*Û*/,
            'U' . chr(204) . chr(136) => [195, 156]   /*Ü*/,
            'Y' . chr(204) . chr(129) => [195, 157]   /*Ý*/,
            'a' . chr(204) . chr(128) => [195, 160]   /*à*/,
            'a' . chr(204) . chr(129) => [195, 161]   /*á*/,
            'a' . chr(204) . chr(130) => [195, 162]   /*â*/,
            'a' . chr(204) . chr(131) => [195, 163]   /*ã*/,
            'a' . chr(204) . chr(136) => [195, 164]   /*ä*/,
            'a' . chr(204) . chr(138) => [195, 165]   /*å*/,
            'c' . chr(204) . chr(167) => [195, 167]   /*ç*/,
            'e' . chr(204) . chr(128) => [195, 168]   /*è*/,
            'e' . chr(204) . chr(129) => [195, 169]   /*é*/,
            'e' . chr(204) . chr(130) => [195, 170]   /*ê*/,
            'e' . chr(204) . chr(136) => [195, 171]   /*ë*/,
            'i' . chr(204) . chr(128) => [195, 172]   /*ì*/,
            'i' . chr(204) . chr(129) => [195, 173]   /*í*/,
            'i' . chr(204) . chr(130) => [195, 174]   /*î*/,
            'i' . chr(204) . chr(136) => [195, 175]   /*ï*/,
            'n' . chr(204) . chr(131) => [195, 177]   /*ñ*/,
            'o' . chr(204) . chr(128) => [195, 178]   /*ò*/,
            'o' . chr(204) . chr(129) => [195, 179]   /*ó*/,
            'o' . chr(204) . chr(130) => [195, 180]   /*ô*/,
            'o' . chr(204) . chr(131) => [195, 181]   /*õ*/,
            'o' . chr(204) . chr(136) => [195, 182]   /*ö*/,
            'u' . chr(204) . chr(128) => [195, 185]   /*ù*/,
            'u' . chr(204) . chr(129) => [195, 186]   /*ú*/,
            'u' . chr(204) . chr(130) => [195, 187]   /*û*/,
            'u' . chr(204) . chr(136) => [195, 188]   /*ü*/,
            'y' . chr(204) . chr(129) => [195, 189]   /*ý*/,
            'y' . chr(204) . chr(136) => [195, 191]   /*ÿ*/,
            'u' . chr(204) . chr(131) => [197, 169]   /*ũ*/,
            'U' . chr(204) . chr(131) => [197, 168]   /*Ũ*/,
        ];

        return ToUTF8::baseConversion($HTML_ENTITIES, $text);
    }
}

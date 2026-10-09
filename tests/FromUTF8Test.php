<?php

namespace Tests;

use ByJG\Convert\FromUTF8;
use PHPUnit\Framework\TestCase;

class FromUTF8Test extends TestCase
{
    public function testToMimeEncodedWord(): void
    {
        $this->assertEquals(
            "=?UTF-8?Q?Libert=C3=A9=20Egalit=C3=A9=20Fraternit=C3=A9?=",
            FromUTF8::toMimeEncodedWord("Liberté Egalité Fraternité")
        );

        $this->assertEquals(
            "=?UTF-8?Q?=C3=A1=C3=A9=C3=AD=C3=B3=C3=BA?=",
            FromUTF8::toMimeEncodedWord("áéíóú")
        );

        // Only the words that need it are encoded
        $this->assertEquals(
            "Test =?UTF-8?Q?=C5=A9=C5=A8?=",
            FromUTF8::toMimeEncodedWord("Test ũŨ")
        );

        // A long header is folded into several encoded words
        $this->assertEquals(
            "=?UTF-8?Q?=D0=AF=D0=BA=20=D1=82=D0=B8=20=D0=BF=D0=BE=D0=B6=D0=B8=D0=B2?=\r\n"
            . " =?UTF-8?Q?=D0=B0=D1=94=D1=88=3F?=",
            FromUTF8::toMimeEncodedWord("Як ти поживаєш?")
        );

        $this->assertEquals("plain ascii", FromUTF8::toMimeEncodedWord("plain ascii"));
    }

    public function testRemoveAccent(): void
    {
        $this->assertEquals(
            "Liberte Egalite Fraternite",
            FromUTF8::removeAccent("Liberté Egalité Fraternité")
        );

        $this->assertEquals(
            "aeiou",
            FromUTF8::removeAccent("áéíóú")
        );

        $this->assertEquals(
            "jUnior😉",
            FromUTF8::removeAccent("jÚnior😉")
        );

        $this->assertEquals(
            'Teste de validacao de email titulo de email para ver se funciona',
            FromUTF8::removeAccent("Teste de validação de email titulo de email para ver se funciona")
        );

        $this->assertEquals(
            "Test uU",
            FromUTF8::removeAccent("Test ũŨ")
        );
    }

    public function testToHtmlEntities(): void
    {
        $this->assertEquals(
            "Libert&eacute; Egalit&eacute; Fraternit&eacute;",
            FromUTF8::toHtmlEntities("Liberté Egalité Fraternité")
        );

        $this->assertEquals(
            "&aacute;&eacute;&iacute;&oacute;&uacute;",
            FromUTF8::toHtmlEntities("áéíóú")
        );

        $this->assertEquals(
            "j&Uacute;nior",
            FromUTF8::toHtmlEntities("jÚnior")
        );

        $this->assertEquals(
            'Teste de valida&ccedil;&atilde;o de email t&iacute;tulo de email para ver se funciona',
            FromUTF8::toHtmlEntities("Teste de validação de email título de email para ver se funciona")
        );

        $this->assertEquals(
            "Test &#361;&#360;",
            FromUTF8::toHtmlEntities("Test ũŨ")
        );
    }

    public function testOnlyAscii(): void
    {
        $this->assertEquals(
            "Liberte Egalite Fraternite",
            FromUTF8::onlyAscii("Liberte ﾠEgalite FraterniteƀƁƂƃƄƅƆƇƈƉƊƋƌƍƎƏƐƑƒƓƔƕƖƗƘƙƚƛƜƝƞƟ")
        );

        // One "?" per character: 1 for "ﾠ", 32 for "ƀ...Ɵ"
        $this->assertEquals(
            "Liberte ?Egalite Fraternite" . str_repeat('?', 32),
            FromUTF8::onlyAscii("Liberte ﾠEgalite FraterniteƀƁƂƃƄƅƆƇƈƉƊƋƌƍƎƏƐƑƒƓƔƕƖƗƘƙƚƛƜƝƞƟ", '?')
        );

        $this->assertEquals("Hello ??", FromUTF8::onlyAscii("Hello 世界", '?'));
        $this->assertEquals("line 1\n\tline 2", FromUTF8::onlyAscii("line 1\n\tline 2"));
    }

    public function testInvalidUtf8IsNotLost(): void
    {
        $invalid = "abc\xFF\xFEdef";

        $this->assertEquals($invalid, FromUTF8::removeEmoji($invalid));
        $this->assertEquals("abc??def", FromUTF8::onlyAscii($invalid, '?'));
    }

    public function testRemoveEmoji(): void
    {
        $this->assertEquals(
            "Segue la tambem  artigos sobre o Canada ",
            FromUTF8::onlyAscii("Segue lá também 😉 artigos sobre o Canadá 🙂")
        );

        $this->assertEquals(
            "Segue lá também  artigos sobre o Canadá ",
            FromUTF8::removeEmoji("Segue lá também 😉 artigos sobre o Canadá 🙂")
        );
    }

    public function testAllChars(): void
    {
        $text1 = 'À Á Â Ã Ä Å Æ Ç È É '
            . 'Ê Ë Ì Í Î Ï Ð Ñ Ò Ó '
            . 'Ô Õ Ö Ø Ù Ú Û Ü Ũ Ý '
            . 'Þ ß à á â ã ä å æ ç '
            . 'è é ê ë ì í î ï ð ñ '
            . 'ò ó ô õ ö ø ù ú û ü '
            . 'ũ ý þ ÿ   ¡ ¢ £ ¤ ¥ '
            . '¦ § ¨ © ª « ¬ ® ¯ ° '
            . '± ² ³ ´ µ ¶ ¸ ¹ º » '
            . '¼ ½ ¾ ¿ × ÷ ∀ ∂ ∃ ∅ '
            . '∇ ∈ ∉ ∋ ∏ ∑ − ∗ √ ∝ '
            . '∞ ∠ ∧ ∨ ∩ ∪ ∫ ∴ ∼ ≅ '
            . '≈ ≠ ≡ ≤ ≥ ⊂ ⊃ ⊄ ⊆ ⊇ '
            . '⊕ ⊗ ⊥ ⋅ Α Β Γ Δ Ε Ζ '
            . 'Η Θ Ι Κ Λ Μ Ν Ξ Ο Π '
            . 'Ρ Σ Τ Υ Φ Χ Ψ Ω α β '
            . 'γ δ ε ζ η θ ι κ λ μ '
            . 'ν ξ ο π ρ ς σ τ υ φ '
            . 'χ ψ ω ϑ ϒ ϖ Œ œ Š š '
            . 'Ÿ ƒ ˆ ˜ – — ‘ ’ ‚ “ '
            . '” „ † ‡ • … ‰ ′ ″ ‹ '
            . '› ‾ € ™ ← ↑ → ↓ ↔ ↵ '
            . '⌈ ⌉ ⌊ ⌋ ◊ ♠ ♣ ♥ ♦ ';

        $text2 = '&Agrave; &Aacute; &Acirc; &Atilde; &Auml; &Aring; &AElig; &Ccedil; &Egrave; &Eacute; '
            . '&Ecirc; &Euml; &Igrave; &Iacute; &Icirc; &Iuml; &ETH; &Ntilde; &Ograve; &Oacute; '
            . '&Ocirc; &Otilde; &Ouml; &Oslash; &Ugrave; &Uacute; &Ucirc; &Uuml; &#360; &Yacute; '
            . '&THORN; &szlig; &agrave; &aacute; &acirc; &atilde; &auml; &aring; &aelig; &ccedil; '
            . '&egrave; &eacute; &ecirc; &euml; &igrave; &iacute; &icirc; &iuml; &eth; &ntilde; '
            . '&ograve; &oacute; &ocirc; &otilde; &ouml; &oslash; &ugrave; &uacute; &ucirc; &uuml; '
            . '&#361; &yacute; &thorn; &yuml; &nbsp; &iexcl; &cent; &pound; &curren; &yen; '
            . '&brvbar; &sect; &uml; &copy; &ordf; &laquo; &not; &reg; &macr; &deg; '
            . '&plusmn; &sup2; &sup3; &acute; &micro; &para; &cedil; &sup1; &ordm; &raquo; '
            . '&frac14; &frac12; &frac34; &iquest; &times; &divide; &forall; &part; &exist; &empty; '
            . '&nabla; &isin; &notin; &ni; &prod; &sum; &minus; &lowast; &radic; &prop; '
            . '&infin; &ang; &and; &or; &cap; &cup; &int; &there4; &sim; &cong; '
            . '&asymp; &ne; &equiv; &le; &ge; &sub; &sup; &nsub; &sube; &supe; '
            . '&oplus; &otimes; &perp; &sdot; &Alpha; &Beta; &Gamma; &Delta; &Epsilon; &Zeta; '
            . '&Eta; &Theta; &Iota; &Kappa; &Lambda; &Mu; &Nu; &Xi; &Omicron; &Pi; '
            . '&Rho; &Sigma; &Tau; &Upsilon; &Phi; &Chi; &Psi; &Omega; &alpha; &beta; '
            . '&gamma; &delta; &epsilon; &zeta; &eta; &theta; &iota; &kappa; &lambda; &mu; '
            . '&nu; &xi; &omicron; &pi; &rho; &sigmaf; &sigma; &tau; &upsilon; &phi; '
            . '&chi; &psi; &omega; &thetasym; &upsih; &piv; &OElig; &oelig; &Scaron; &scaron; '
            . '&Yuml; &fnof; &circ; &tilde; &ndash; &mdash; &lsquo; &rsquo; &sbquo; &ldquo; '
            . '&rdquo; &bdquo; &dagger; &Dagger; &bull; &hellip; &permil; &prime; &Prime; &lsaquo; '
            . '&rsaquo; &oline; &euro; &trade; &larr; &uarr; &rarr; &darr; &harr; &crarr; '
            . '&lceil; &rceil; &lfloor; &rfloor; &loz; &spades; &clubs; &hearts; &diams; ';

        $this->assertEquals($text2, FromUTF8::toHtmlEntities($text1));
    }

    public function testToHtmlEntitiesLeavesMarkupAndUsesNumericEntitiesForTheRest(): void
    {
        $this->assertEquals(
            '<b class="x">caf&eacute; &amp; &lt;tag&gt;</b> & 5 > 3',
            FromUTF8::toHtmlEntities('<b class="x">café &amp; &lt;tag&gt;</b> & 5 > 3')
        );

        // No named entity exists for these, so the output is still pure ASCII
        $this->assertEquals("&#10003; &#256; &#128578;", FromUTF8::toHtmlEntities("✓ Ā 🙂"));
    }

    public function testRemoveAccentWritesLettersWithoutAnAccentedForm(): void
    {
        $this->assertEquals("Strasse", FromUTF8::removeAccent("Straße"));
        $this->assertEquals("Oslo oy", FromUTF8::removeAccent("Øslo øy"));
        $this->assertEquals("THorn thorn", FromUTF8::removeAccent("Þorn þorn"));
        $this->assertEquals("dad", FromUTF8::removeAccent("ðað"));
    }

    public function testRemoveEmojiSequences(): void
    {
        $this->assertEquals("flag: ", FromUTF8::removeEmoji("flag: 🇧🇷"));
        $this->assertEquals("skin tone: ", FromUTF8::removeEmoji("skin tone: 👋🏽"));
        $this->assertEquals("family: ", FromUTF8::removeEmoji("family: 👨‍👩‍👧‍👦"));
        $this->assertEquals("keycap: ", FromUTF8::removeEmoji("keycap: 1️⃣"));
        $this->assertEquals("recent: ", FromUTF8::removeEmoji("recent: 🫠"));
        $this->assertEquals(
            "Preço: 123,45 # item * → ✓ 日本語",
            FromUTF8::removeEmoji("Preço: 123,45 # item * → ✓ 日本語")
        );
    }
}

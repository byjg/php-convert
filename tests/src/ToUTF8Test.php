<?php

namespace ByJG\Convert;

// backward compatibility
if (!class_exists('\PHPUnit\Framework\TestCase')) {
    class_alias('\PHPUnit_Framework_TestCase', '\PHPUnit\Framework\TestCase');
}

class ToUTF8Test extends \PHPUnit\Framework\TestCase
{

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers ByJG\Convert\ToUTF8::fromHtmlEntities
     * @todo   Implement testFromHtmlEntities().
     */
    public function testFromHtmlEntities()
    {
        $this->assertEquals(
            "Liberté Egalité Fraternité",
            ToUTF8::fromHtmlEntities("Libert&eacute; Egalit&eacute; Fraternit&eacute;")
        );

        $this->assertEquals(
            "áéíóú",
            ToUTF8::fromHtmlEntities("&aacute;&eacute;&iacute;&oacute;&uacute;")
        );

        $this->assertEquals(
            "jÚnior",
            ToUTF8::fromHtmlEntities("j&Uacute;nior")
        );

        $this->assertEquals(
            "Teste de validação de email título de email para ver se funciona",
            ToUTF8::fromHtmlEntities('Teste de valida&ccedil;&atilde;o de email t&iacute;tulo de email para ver se funciona')
        );
    }

    public function testCombiningChar()
    {
        $fileCombining = file_get_contents(__DIR__ . "/../sample.txt");

        $fileRemovedCombining = ToUTF8::fromCombiningChar($fileCombining);

        $this->assertEquals(
            "desconheço professor (de escola básica) " .
            "que não seja outra coisa além de ser professor de escola básica em tempo integral.\n" .
            "Vou à praia.\n" .
            "Vovô.\n" .
            "Müller.\n",
            $fileRemovedCombining
        );
    }

    public function testAllChars()
    {
        $text1 = 'À Á Â Ã Ä Å Æ Ç È É '
            . 'Ê Ë Ì Í Î Ï Ð Ñ Ò Ó '
            . 'Ô Õ Ö Ø Ù Ú Û Ü Ũ Ý '
            . 'Þ ß à á â ã ä å æ ç '
            . 'è é ê ë ì í î ï ð ñ '
            . 'ò ó ô õ ö ø ù ú û ü '
            . 'ũ ý þ ÿ   ¡ ¢ £ ¤ ¥ '
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
             . '&Ocirc; &Otilde; &Ouml; &Oslash; &Ugrave; &Uacute; &Ucirc; &Uuml; &Utilde; &Yacute; '
             . '&THORN; &szlig; &agrave; &aacute; &acirc; &atilde; &auml; &aring; &aelig; &ccedil; '
             . '&egrave; &eacute; &ecirc; &euml; &igrave; &iacute; &icirc; &iuml; &eth; &ntilde; '
             . '&ograve; &oacute; &ocirc; &otilde; &ouml; &oslash; &ugrave; &uacute; &ucirc; &uuml; '
             . '&utilde; &yacute; &thorn; &yuml; &nbsp; &iexcl; &cent; &pound; &curren; &yen; '
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

        $this->assertEquals($text1, ToUTF8::fromHtmlEntities($text2));
    }
}

<?php

namespace ByJG\Convert;

// backward compatibility
if (!class_exists('\PHPUnit\Framework\TestCase')) {
    class_alias('\PHPUnit_Framework_TestCase', '\PHPUnit\Framework\TestCase');
}

class FromUTF8Test extends \PHPUnit\Framework\TestCase
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
     * @covers ByJG\Convert\FromUTF8::toIso88591Email
     */
    public function testToIso88591Email()
    {
        $this->assertEquals(
            "=?iso-8859-1?Q?Libert=E9_Egalit=E9_Fraternit=E9?=",
            FromUTF8::toIso88591Email("Liberté Egalité Fraternité")
        );

        $this->assertEquals(
            "=?iso-8859-1?Q?=E1=E9=ED=F3=FA?=",
            FromUTF8::toIso88591Email("áéíóú")
        );

        $this->assertEquals(
            '=?iso-8859-1?Q?Teste_de_valida=E7=E3o_de_emai?=' . "\r\n" .
            '=?iso-8859-1?Q?l_t=EDtulo_de_email_para_ver_s?=' . "\r\n" .
            '=?iso-8859-1?Q?e_funciona?=',
            FromUTF8::toIso88591Email("Teste de validação de email título de email para ver se funciona", 30)
        );

        $this->assertEquals(
            "=?iso-8859-1?Q?Test_uU?=",
            FromUTF8::toIso88591Email("Test ũŨ")
        );
    }

    /**
     * @covers ByJG\Convert\FromUTF8::removeAccent
     */
    public function testRemoveAccent()
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
            "jUnior",
            FromUTF8::removeAccent("jÚnior")
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

    /**
     * @covers ByJG\Convert\FromUTF8::toHtmlEntities
     * @todo   Implement testToHtmlEntities().
     */
    public function testToHtmlEntities()
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
            "Test &utilde;&Utilde;",
            FromUTF8::toHtmlEntities("Test ũŨ")
        );
    }

}

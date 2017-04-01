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
}

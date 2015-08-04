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
	public static function fromHtmlEntities($text)
	{
		$HTML_ENTITIES = [
            "&aacute;"=>161 /*á*/, "&eacute;"=>169 /*é*/, "&iacute;"=>173 /*í*/, "&oacute;"=>179 /*ó*/, "&uacute;"=>186 /*ú*/,
            "&agrave;"=>160 /*à*/, "&egrave;"=>168 /*è*/, "&igrave;"=>172 /*ì*/, "&ograve;"=>178 /*ò*/, "&ugrave;"=>185 /*ù*/,
            "&atilde;"=>163 /*ã*/, "&otilde;"=>181 /*õ*/, "&ntilde;"=>177 /*ñ*/, "&acirc;"=>162  /*â*/, "&ecirc;"=>170  /*ê*/,
            "&icirc;"=>174  /*î*/, "&ocirc;"=>180  /*ô*/, "&ucirc;"=>187  /*û*/, "&ccedil;"=>167 /*ç*/, "&Aacute;"=>129 /*Á*/,
            "&Eacute;"=>137 /*É*/, "&Iacute;"=>141 /*Í*/, "&Oacute;"=>147 /*Ó*/, "&Uacute;"=>154 /*Ú*/, "&Agrave;"=>128 /*À*/,
            "&Egrave;"=>136 /*È*/, "&Igrave;"=>140 /*Ì*/, "&Ograve;"=>146 /*Ò*/, "&Ugrave;"=>153 /*Ù*/, "&Atilde;"=>131 /*Ã*/,
            "&Otilde;"=>149 /*Õ*/, "&Ntilde;"=>145 /*Ñ*/, "&Acirc;"=>130  /*Â*/, "&Ecirc;"=>138  /*Ê*/, "&Icirc;"=>142  /*Î*/,
            "&Ocirc;"=>148  /*Ô*/, "&Ucirc;"=>155  /*Û*/, "&Ccedil;"=>135 /*Ç*/, "&uuml;"=>188   /*ü*/, "&Uuml;"=>156   /*Ü*/,
            "&Auml;"=>132   /*Ä*/, "&Aring;"=>133  /*Å*/, "&AElig;"=>134  /*Æ*/, "&Euml;"=>139   /*Ë*/, "&Iuml;"=>143   /*Ï*/,
            "&ETH;"=>144    /*Ð*/, "&Ocirc;"=>148  /*Ô*/, "&Ouml;"=>150   /*Ö*/, "&Oslash;"=>152 /*Ø*/, "&Uring;"=>155  /*Û*/,
            "&Uuml;"=>156   /*Ü*/, "&Yacute;"=>157 /*Ý*/, "&THORN;"=>158  /*Þ*/, "&szlig;"=>159  /*ß*/, "&auml;"=>164   /*ä*/,
            "&aring;"=>165  /*å*/, "&aelig;"=>166  /*æ*/, "&euml;"=>171   /*ë*/, "&iuml;"=>175   /*ï*/, "&eth;"=>176    /*ð*/,
            "&ouml;"=>182   /*ö*/, "&oslash;"=>184 /*ø*/, "&uml;"=>188    /*ü*/, "&yacute;"=>189 /*ý*/, "&yuml;"=>191   /*ÿ*/,
            "&thorn;"=>190 /*þ*/,
        ];

		return ToUTF8::baseConversion($HTML_ENTITIES, $text);
	}


	/**
	 * Base convert based on array
	 *
	 * @param string[] $vector
	 * @param string $text
	 * @return string
	 */
	protected static function baseConversion($vector, $text)
	{
		foreach ($vector as $key=>$value)
		{
			$text = str_replace($key, chr(195).chr($value), $text);
		}

		return $text;
	}

}

<?php

namespace ByJG\Convert;

use Normalizer;

class ToUTF8
{

    /**
     * Convert HTML entities, named or numeric, to UTF8
     *
     * @param string $text
     * @return string
     */
    public static function fromHtmlEntities(string $text): string
    {
        return html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Join a letter followed by a combining mark ("e" + U+0301) into the single precomposed
     * character ("é"), the Unicode Normalization Form C.
     *
     * @param string $text
     * @return string
     */
    public static function fromCombiningChar(string $text): string
    {
        $normalized = Normalizer::normalize($text, Normalizer::FORM_C);
        return $normalized === false ? $text : $normalized;
    }

    /**
     * Convert ASCII emoticons to their corresponding emoji characters
     *
     * @param string $text The text containing emoticons to convert
     * @return string The text with emoticons converted to emoji
     */
    public static function fromEmoji(string $text): string
    {
        $EMOTICONS = [
            ':-)' => '😊',   /* Basic smiley face */
            ':)' => '😊',    /* Simple smiley face */
            ':D' => '😃',    /* Big grin face */
            ':-D' => '😃',   /* Big grin face */
            ':(' => '☹️',    /* Sad face */
            ':-(' => '☹️',   /* Sad face */
            ';)' => '😉',    /* Winking face */
            ';-)' => '😉',   /* Winking face */
            ':P' => '😛',    /* Sticking tongue out */
            ':-P' => '😛',   /* Sticking tongue out */
            ':p' => '😛',    /* Sticking tongue out */
            'XD' => '😆',    /* Laughing with closed eyes */
            ':O' => '😮',    /* Surprised face */
            ':-O' => '😮',   /* Surprised face */
            ':o' => '😮',    /* Surprised face */
            '>:(' => '😠',   /* Angry face */
            '>:-(' => '😠',  /* Angry face */
            ':3' => '😺',    /* Cat face */
            '=^.^=' => '😺', /* Happy cat face */
            '<3' => '❤️',    /* Heart */
            '</3' => '💔',   /* Broken heart */
            ':*' => '😘',    /* Kissing face */
            ':-*' => '😘',   /* Kissing face */
            ":')" => '😂',   /* Tears of joy */
            ":'-)" => '😂',  /* Tears of joy */
            ":'(" => '😢',   /* Crying face */
            ":'-(" => '😢',  /* Crying face */
            '-_-' => '😑',   /* Expressionless face */
            '^_^' => '😊',   /* Happy face (Eastern style) */
            '>_<' => '😣',   /* Frustrated face */
            '._.' => '😐',   /* Neutral face */
            ':v' => '😃',    /* Pacman */
            'O:)' => '😇',   /* Angel face */
            'O:-)' => '😇',  /* Angel face */
            '>:)' => '😈',   /* Evil grin */
            '>:-)' => '😈',  /* Evil grin */
            ':S' => '😕',    /* Confused face */
            ':-S' => '😕',   /* Confused face */
            ':$' => '😳',    /* Blushing face */
            ':-$' => '😳',   /* Blushing face */
            ':@' => '😠',    /* Angry face */
            ':-@' => '😠',   /* Angry face */
            ':|' => '😐',    /* Straight face */
            ':-|' => '😐',   /* Straight face */
            ':X' => '🤐',    /* Sealed lips */
            ':-X' => '🤐',   /* Sealed lips */
            ':x' => '🤐',    /* Sealed lips */
            'B)' => '😎',    /* Cool face with sunglasses */
            'B-)' => '😎',   /* Cool face with sunglasses */
            '\o/' => '🙌',   /* Hands up in celebration */
            'o/' => '👋',    /* Waving hand */
            '\o' => '👋'     /* Waving hand */
        ];

        // strtr() tries the longest emoticon first, so ">:(" is not read as ">" followed by ":("
        return strtr($text, $EMOTICONS);
    }
}

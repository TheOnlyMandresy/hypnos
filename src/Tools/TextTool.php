<?php

namespace System\Tools;

use System;

/**
 * Text's convertissor
 */

class TextTool
{
    /**
     * Transform first letter to uppercase (especially for special chars)
     * @param string $text
     * @return string
     */
    public static function specialUcFirst ($text, $encode = 'UTF-8')
    {
        $start = mb_strtoupper(mb_substr($text, 0, 1, $encode), $encode);
        $end = mb_strtolower(mb_substr($text, 1, mb_strlen($text, $encode), $encode), $encode);
    
        $text = $start.$end;
        return $text;
    }

    /**
     * Be sure that human's entries won't be a trouble
     * @param string $text
     * @param string $type : post | decode | get | hash | convertPass
     * @return string
     */
    public static function security ($text, $type = 'post')
    {
        switch ($type)
        {
            case 'post':
                return htmlentities(htmlspecialchars(trim($text)));

            case 'decode':
                return html_entity_decode(str_replace("\n",'<br />', $text));

            case 'get':
                return htmlspecialchars($text);

            case 'hash':
                return md5(sha1($text));

            case 'convertPass':
                return password_hash($text, PASSWORD_DEFAULT);
        }
    }

    /**
     * Edit window tab's title
     * @param string $text
     * @return string
     */
    public static function setTitle ($text)
    {
        return ucfirst(System::getSystemInfos('website')). ' : ' .self::specialUcFirst($text);
    }

    /**
     * Get name of the website
     */
    public static function getName ()
    {
        return ucfirst(System::getSystemInfos('website'));
    }

    /**
     * Shorten text
     * @param string $str
     * @param int $len
     * @return string
     */
    public static function shorten ($str, $len)
    {
        if (strlen($str) > $len) return substr($str, 0, $len) . '...';
        return $str;
    }
}
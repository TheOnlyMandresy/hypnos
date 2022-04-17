<?php

namespace System\Tools;

use System\Tools\DateTool;

/**
 * Form generator
 */

class FormTool
{
    /**
     * @param string $type
     * @param string $name
     * @param string $ph
     * @return string
     */
    public static function input ($type, $name, $ph)
    {
        return '<input type="' .$type. '" name="' .$name. '" placeholder="' .$ph. '" />';
    }

    /**
     * @param string $name
     * @param string $ph
     * @return string
     */
    public static function textarea ($name, $ph)
    {
        return '<textarea name="' .$name. '" placeholder="' .$ph. '"></textarea>';
    }

    /**
     * @param string $name
     * @param string $text
     * @param array $datas
     * @param int $datas
     * @return string
     */
    public static function select ($name, $text, $datas, $select = null)
    {
        $html = '<select name="' .$name. '">';
            $html .= '<optgroup label="' .$text. '">';

                foreach ($datas as $key => $value) {
                    if (!is_null($select) && intval($select) === $key) {
                        $html .= '<option selected value="' .$key. '">' .$value. '</option>';
                        continue;
                    }
                    $html .= '<option value="' .$key. '">' .$value. '</option>';
                }

            $html .= '</optgroup>';
        $html .= '</select>';

        return $html;
    }

    /**
     * @param string $text
     * @param string $action Action of the treatment
     * @param string $type Classe name
     * @return string
     */
    public static function button ($text, $action, $type)
    {
        return '<button type="button" name="submit" class="btn-' .$type. '"><span><a name="' .$action. '">' .$text. '</a></span></button>';
    }

    /**
     * @param string $name
     * @param string $text
     * @param string $date
     * @return string
     */
    public static function date ($name, $text, $date = null)
    {
        $tomorrow = DateTool::dateFormat(time(), 'tomorrow');
        $id = uniqid();

        $html = '<div class="date">';
            $html .= '<label for="' .$id. '">' .$text. '</label>';
            $html .= '<input id="' .$id. '" type="date" name="' .$name. '" min="' .$tomorrow. '"';
            if (!is_null($date)) $html .= ' value="' .DateTool::dateFormat($date). '"';
            $html .= ' />';
        $html .= '</div>';

        return $html;
    }
}
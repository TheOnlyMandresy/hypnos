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
    public static function input ($type, $name, $ph, $default = null)
    {
        return '<input type="' .$type. '" name="' .$name. '" placeholder="' .$ph. '" value="' .$default. '" />';
    }

    /**
     * @param string $name
     * @param string $ph
     * @return string
     */
    public static function textarea ($name, $ph, $default = null)
    {
        return '<textarea name="' .$name. '" placeholder="' .$ph. '">' .$default. '</textarea>';
    }

    /**
     * @param string $name
     * @param string $text
     * @param array $datas
     * @param int $datas
     * @return string
     */
    public static function select ($name, $text, $datas, $default = null)
    {
        $html = '<select name="' .$name. '">';
            $html .= '<optgroup label="' .$text. '">';

                foreach ($datas as $key => $value) {
                    if (!is_null($default) && intval($default) === $key) {
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
    public static function button ($text, $action, $type, $data = null)
    {
            $html = '<button type="button" name="submit" class="btn-' .$type. '"><span><a name="' .$action. '"';
            if ($data) $html .= ' data-infos="' .$data. '" ';
            $html .= '>' .$text. '</a></span></button>';
        return $html;
    }

    /**
     * @param string $name
     * @param string $text
     * @param string $date
     * @return string
     */
    public static function date ($name, $text, $default = null)
    {
        $tomorrow = DateTool::dateFormat(DateTool::dateFormat(time(), 'tomorrow'), 'datetime');
        $id = uniqid();

        $html = '<div class="date">';
            $html .= '<label for="' .$id. '">' .$text. '</label>';
            $html .= '<input id="' .$id. '" type="datetime-local" name="' .$name. '" min="' .$tomorrow. '"';
            if (!is_null($default)) $html .= ' value="' .DateTool::dateFormat($default, 'datetime'). '"';
            $html .= ' />';
        $html .= '</div>';

        return $html;
    }

    public static function images ($ph, $multiple = true) {
        
        $id = uniqid();
        
        $html = '<div class="img">';
            $html .= '<label for="' .$id. '">' .$ph. '</label>';
            $html .= '<input accept="image/png, image/jpeg" id="' .$id. '" type="file" ';
            $html .= ($multiple)? 'name="image[]" multiple />': 'name="image" />';
        $html .= '</div>';
        
        return $html;
    }
}
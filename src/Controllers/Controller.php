<?php

namespace System;

use System;
use System\Tools\TextTool;

class Controller
{
    protected $compact = [];

    /**
     * Rendering page
     * @param string $name Page to load
     * @param array $vars
     * @param bool $api Is an api data
     */
    protected function render ($name, $vars = [], $api = false)
    {
        ob_start();
            $isOnline = self::isOnline();
            // if ($isOnline) $myDatas = Users::getMyDatas();

            extract($vars);

            // Metas
            if (!isset($metaDesc)) $metaDesc = system::getSystemInfos('meta_desc');
            if (!isset($metaImg)) $metaImg = system::getSystemInfos('meta_img');

        $load = ob_end_clean();

        require_once System::root(1). 'Views/Templates/Head.php';
        echo '<main class="' .$page. '">';
        require_once System::root(1). 'Views/Pages/' .ucfirst($name). '.php';
        if (str_contains($page, 'template')) require_once System::root(1). 'Views/Templates/General.php';
        echo '</main>';

        unset($_SESSION['flash']);
    }
    
    /**
     * All systems errors
     * @param int $code
     */
    protected static function error ($code)
    {
        switch ($code)
        {
            case 403:
                return header('Location: /403'); 
            case 404:
                return header('Location: /404'); 
            case 405:
                return header('Location: /405'); 
        }
    }
    
    /** 
     * Add unexpected datas
     * @param array $array Variables
     * @param bool $delete Start a new list
     * @return array
     */
    protected function compact ($array = null, $delete = false)
    {
        if ($delete === true) $this->compact = [];

        if ($array !== null) {
            foreach ($array as $var) {
                $this->compact[] = $var;
            }
        }

        return $this->compact;
    }
    
    /**
     * Flash alerts
     * @param array $datas type, message
     * @param string $link
     */
    protected static function flash ($datas, $link)
    {
        $_SESSION['flash'] = [
            'type' => $datas['type'],
            'message' => TextTool::specialUcFirst($datas['message'])
        ];

        return header('Location: ' .$link);
    }

    /**
     * Visitor is connected to the platform
     * @return bool
     */
    protected static function isOnline ()
    {
        return isset($_SESSION['user']);
    }
}
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
            if (!isset($metaDesc)) $metaDesc = "Hypnos est un groupe hôtelier fondé en 2004. Propriétaire de 7 établissements dans les quatre
            coins de l’hexagone, chacun de ces hôtels s’avère être une destination idéale pour les couples
            en quête d’un séjour romantique à deux.";
            if (!isset($metaImg)) $metaImg = 'logo.png';

        $load = ob_end_clean();
        
        require_once System::root(1). 'Views/Templates/Head.php';
        echo '<main class="' .$page. '">';
        require_once System::root(1). 'Views/Pages/' .ucfirst($name). '.php';
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
                header('HTTP/1.0 403 forbidden');
                die('Acces interdit');
            case 404:
                header('HTTP/1.0 404 Not Found');
                die('Page introuvable');
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
    
    /**
     * Load JS file
     * @param array $pages Path to files to upload
     * @return array
     */
    private static function loadJS ($pages)
    {
        $scripts = [];

        foreach ($pages as $page) {
            $scripts[] = '<script type = "text/javascript" src="/js/' .$page. '.js';
        }

        return $scripts;
    }
}
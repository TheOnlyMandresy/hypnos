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
            extract($vars);

            // Metas
            if (!isset($metaDesc)) $metaDesc = system::getSystemInfos('meta_desc');
            if (!isset($metaImg)) $metaImg = system::getSystemInfos('meta_img');

        $load = ob_end_clean();

        if (!$api) {
            require_once System::root(1). 'Views/Templates/Head.php';
            echo '<main class="' .$page. '">';
        }
        
        require_once System::root(1). 'Views/Pages/' .ucfirst($name). '.php';
        
        if (!$api) {
            if (str_contains($page, 'template')) require_once System::root(1). 'Views/Templates/General.php';
            echo '</main>';
        }

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
                echo json_encode(403);
                break; 
            case 404:
                echo json_encode(404);
                break; 
            case 405:
                echo json_encode(405);
                break;
            case 1:
                return 'Adresse mail incorrect';
            case 2:
                return 'Les mot de passes ne se correspondent pas';
            case 3:
                return 'Un compte avec cet adresse mail existe déjà';
            case 4:
                return 'Veuillez renseigner tous les champs';
            case 5:
                return 'Votre mot de passe est trop court';
            case 6:
                return 'Aucun compte trouvé';
            case 7:
                return 'Mot de passe incorrect';
            case 8:
                return 'Une erreur est survenue. Veuillez réessayer';
            case 9:
                return 'L\'hôtel sélectionné n\'existe pas';
            case 10:
                return 'Cet utilisateur n\'est pas un membre de l\'équipe';
            case 11:
                return 'Cette institution possède déjà un gérant';
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
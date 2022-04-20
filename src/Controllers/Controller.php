<?php

namespace System;

use System;
use System\Database\Tables\UsersTable as Users;
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
            $isOnline = (Users::isLogged()) ? true : false;

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
    }
    
    /**
     * All systems errors
     * @param int $code
     */
    protected static function error ($code)
    {
        switch ($code)
        {
            case 0:
                echo json_encode(-1);
                break;
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
                return 'Un compte avec cette adresse mail existe déjà';
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
            case 12:
                return 'Recherche introuvable';
            case 13:
                return 'Cet utilisateur est déjà un membre de l\'équipe';
            case 14:
                return 'Une image est trop volumineuse';
            case 15:
                return 'Seuls les fichier de type JPEG/PNG sont acceptés';
            case 16:
                return 'Une erreur est survenue lors de l\'upload des images';
            case 17:
                return 'Un fichier envoyé n\'est pas une image';
            case 18:
                return 'Dates de réservation indisponibles';
            case 19:
                return 'La date d\'arrivée doit être de 24h minimum';
            case 20:
                return 'La date de départ doit être supérier à celle d\'arrivée';
            case 21:
                return 'Aucun fichier trouver';
            case 22:
                return 'Une erreur est survenue lors de la supression des fichiers';
            case 23:
                return 'Un compte est relié à cet adresse mail, veuillez vous connectez s\'il sagit de vous';
            case 24:
                return 'Cette entité ne vous appartient pas';
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
}
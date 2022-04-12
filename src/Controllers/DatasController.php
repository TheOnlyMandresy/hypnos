<?php

namespace System\Controllers;

use System\Database\Tables\UsersTable as Users;
use System\Controller;
use System\Tools\TextTool;

/**
 * Api loader
 */
class DatasController extends Controller
{
    private static $entries = ['register', 'login'];
    
    public function __construct ()
    {
        if (!isset($_POST['submit']) && !in_array($_POST['submit'], self::$entries)) return $this->error(405);
        $load = $_POST['submit'];
        return $this->$load();
    }

    private function register ()
    {
        $firstname = TextTool::security($_POST['firstname'], 'post');
        $lastname = TextTool::security($_POST['lastname'], 'post');
        $email = TextTool::security($_POST['email'], 'post');
        $password1 = TextTool::security($_POST['password1'], 'post');
        $password2 = TextTool::security($_POST['password2'], 'post');
        $isEmpty = [$firstname, $lastname, $email, $password1, $password2];

        if (in_array('', $isEmpty)) {
            $api = $this->error(4);
        } else {
            if (!preg_match('/^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/', $email)) $api = $this->error(1);
            if ($password1 !== $password2) $api = $this->error(2);
            if (Users::isUserExist($email)) $api = $this->error(3);
            if (!isset($api)) $api = Users::generalAdd([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'password' => TextTool::security($password1, 'convertPass')
            ]);
        }

        $json = json_encode($api);
        return $this->render('api', compact($this->compact(['json'])), true);
    }

    private function login ()
    {
        $json = 'OK';
        return $this->render('api', compact($this->compact(['json'])), true);
    }
}
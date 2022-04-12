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

        if (in_array('', $isEmpty)) $api = $this->error(4);
        elseif (Users::isUserExist($email)) $api = $this->error(3);
        elseif (!preg_match('/^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/', $email)) $api = $this->error(1);
        elseif (strlen($password1) <= 7) $api = $this->error(5);
        elseif ($password1 !== $password2) $api = $this->error(2);
        else {
            $send = Users::generalAdd([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'password' => TextTool::security($password1, 'convertPass')
            ]);
            $api = (isset($send)) ? 'session' : $this->error(8);
        }

        $datas = [
            'infos' => $api,
            'link' => false
        ];

        $json = json_encode($datas);
        return $this->render('api', compact($this->compact(['json'])), true);
    }

    private function login ()
    {
        $email = TextTool::security($_POST['email'], 'post');
        $password = TextTool::security($_POST['password'], 'post');
        $isEmpty = [$email, $password];

        if (in_array('', $isEmpty)) $api = $this->error(4);
        elseif (!Users::isUserExist($email)) $api = $this->error(6);
        elseif (!Users::isPasswordCorrect($email, $password)) $api = $this->error(7);
        elseif (!Users::login($email)) $api = $this->error(8);
        else $api = 'session';

        $datas = [
            'infos' => $api,
            'link' => false
        ];
        $json = json_encode($datas);

        return $this->render('api', compact($this->compact(['json'])), true);
    }

    private function logout ()
    {
        session_destroy($_SESSION['user']);
        return true;
    }
}
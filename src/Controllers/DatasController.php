<?php

namespace System\Controllers;

use System\Database\Tables\AdminTable as Admin;
use System\Database\Tables\UsersTable as Users;
use System\Database\Tables\InstitutionsTable as Institutions;
use System\Controller;
use System\Tools\TextTool;

/**
 * Datas treatment
 */
class DatasController extends Controller
{
    private static $entries = ['register', 'login', 'adminMemberNew'];
    
    public function __construct ()
    {
        if ((!isset($_POST['submit']) && !isset($_GET['logout'])) && !in_array($_POST['submit'], self::$entries)) return static::error(405);

        if (isset($_GET['logout'])) return $this->logout();

        $load = $_POST['submit'];
        return $this->$load();
    }

    private function register ()
    {
        if (Users::isLogged()) return static::error(405);

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

            if (isset($send)) Users::register();
    
            $api = (isset($send)) ? 'session' : $this->error(8);
        }

        $datas = [
            'infos' => $api,
            'reload' => true,
            'admin' => false
        ];

        $json = json_encode($datas);
        return $this->render('api', compact($this->compact(['json'])), true);
    }

    private function login ()
    {
        if (Users::isLogged()) return static::error(405);

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
            'reload' => true,
            'admin' => false
        ];
        $json = json_encode($datas);

        return $this->render('api', compact($this->compact(['json'])), true);
    }

    private function logout ()
    {
        if (!Users::isLogged()) return static::error(405);
        unset($_SESSION['user']);
        return true;
    }

    private function adminMemberNew ()
    {
        $email = TextTool::security($_POST['email'], 'post');
        $institutionId = TextTool::security($_POST['institutionId']);

        if (!Users::isUserExist($email)) $api = static::error(6);
        elseif (!Institutions::getInstitution($institutionId)) $api = static::error(9);
        else {
            Admin::addMember($email, $institutionId);
            $api = true;
        }

        $datas = [
            'infos' => $api,
            'reload' => true,
            'admin' => true
        ];
        $json = json_encode($datas);

        return $this->render('api', compact($this->compact(['json'])), true);
    }
}
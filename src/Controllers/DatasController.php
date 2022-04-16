<?php

namespace System\Controllers;

use System\Database\Tables\AdminTable as Admin;
use System\Database\Tables\UsersTable as Users;
use System\Database\Tables\InstitutionsTable as Institutions;
use System\Database\Tables\RoomsTable as Rooms;
use System\Controller;
use System\Tools\TextTool;

/**
 * Datas treatment
 */
class DatasController extends Controller
{
    private static $entries = [
        'register', 'login', 'adminTeamNew', 'adminTeamEdit', 'adminTeamDelete',
        'adminInstitutionGet', 'adminInstitutionDel'
    ];
    
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

        $firstname = TextTool::security($_POST['firstname']);
        $lastname = TextTool::security($_POST['lastname']);
        $email = TextTool::security($_POST['email']);
        $password1 = TextTool::security($_POST['password1']);
        $password2 = TextTool::security($_POST['password2']);
        $isEmpty = [$firstname, $lastname, $email, $password1, $password2];

        if (in_array('', $isEmpty)) $state = $this->error(4);
        elseif (Users::isUserExist($email)) $state = $this->error(3);
        elseif (!preg_match('/^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/', $email)) $state = $this->error(1);
        elseif (strlen($password1) <= 7) $state = $this->error(5);
        elseif ($password1 !== $password2) $state = $this->error(2);
        else {
            $send = Users::generalAdd([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'password' => TextTool::security($password1, 'convertPass')
            ]);

            if (isset($send)) Users::register();
    
            $state = (isset($send)) ? true : $this->error(8);
        }

        $datas = [
            'state' => $state,
            'infos' => false,
            'reload' => true,
            'link' => -1
        ];

        $json = json_encode($datas);
        return $this->render('api', compact($this->compact(['json'])), true);
    }

    private function login ()
    {
        if (Users::isLogged()) return static::error(405);

        $email = TextTool::security($_POST['email']);
        $password = TextTool::security($_POST['password']);
        $isEmpty = [$email, $password];

        if (in_array('', $isEmpty)) $state = $this->error(4);
        elseif (!Users::isUserExist($email)) $state = $this->error(6);
        elseif (!Users::isPasswordCorrect($email, $password)) $state = $this->error(7);
        elseif (!Users::login($email)) $state = $this->error(8);
        else $state = true;

        $datas = [
            'state' => $state,
            'infos' => false,
            'reload' => true,
            'link' => -1
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

    private function adminTeamNew ()
    {
        if (!Admin::isAdministrator(Users::$myDatas->email)) return static::error(405);

        $email = TextTool::security($_POST['email']);
        $institutionId = TextTool::security($_POST['institutionId']);
        $api = false;

        if (!Users::isUserExist($email)) $state = static::error(6);
        elseif (Admin::isUserExist($email)) $state = static::error(13);
        elseif (!Institutions::getInstitution($institutionId)) $state = static::error(9);
        elseif (Institutions::isManaged($institutionId)) $state = static::error(11);
        else {
            Admin::addMember($email, $institutionId);

            $userId = Users::getId($email);
            $user = Users::getUser($userId);

            $state = true;
            $api = [
                'iId' => $institutionId,
                'userId' => $user->id,
                'name' => $user->lastname. ' ' .$user->firstname,
                'email' => $user->email
            ];
        }

        $datas = [
            'state' => $state,
            'infos' => json_encode($api),
            'reload' => false,
            'link' => false
        ];
        $json = json_encode($datas);

        return $this->render('api', compact($this->compact(['json'])), true);
    }

    private function adminTeamEdit ()
    {
        if (!Admin::isAdministrator(Users::$myDatas->email)) return static::error(405);

        $email = TextTool::security($_POST['email']);
        $institutionId = TextTool::security($_POST['institutionId']);

        if (!Users::isUserExist($email)) $state = static::error(6);
        elseif (!Admin::isUserExist($email)) $state = static::error(10);
        elseif (!Institutions::getInstitution($institutionId)) $state = static::error(9);
        elseif (Institutions::isManaged($institutionId)) $state = static::error(11);
        else {
            Admin::editMember($email, $institutionId);
            $state = true;
        }

        $datas = [
            'state' => $state,
            'infos' => false,
            'reload' => false,
            'link' => false
        ];
        $json = json_encode($datas);

        return $this->render('api', compact($this->compact(['json'])), true);
    }

    private function adminTeamDelete ()
    {
        if (!Admin::isAdministrator(Users::$myDatas->email)) return static::error(405);

        $email = TextTool::security($_POST['email']);
        $userId = Users::getId($email);
        $institution = Institutions::getManagerInstitution($userId);

        if (!Users::isUserExist($email)) $state = static::error(6);
        elseif (!Admin::isUserExist($email)) $state = static::error(10);
        else {
            Admin::delMember($email);
            $state = true;
            $api = [
                'userId' => $userId,
                'iId' => $institution->id,
                'iName' => $institution->name
            ];
        }

        $datas = [
            'state' => $state,
            'infos' => json_encode($api),
            'reload' => false,
            'link' => false
        ];
        $json = json_encode($datas);

        return $this->render('api', compact($this->compact(['json'])), true);
    }

    private function adminInstitutionGet ()
    {
        if (isset($_POST['id'])) $id = TextTool::security($_POST['id']);
        if (isset($_POST['email'])) $email = TextTool::security($_POST['email']);


        $api = (isset($id)) ? Institutions::getInstitution($id) : Institutions::getManagerInstitution(Users::getId($email));
        
        if (!$api) {
            $api = false;
            $state = static::error(12);
        }
        else $state = true;

        $datas = [
            'state' => $state,
            'infos' => json_encode($api),
            'reload' => false,
            'link' => false
        ];
        $json = json_encode($datas);

        return $this->render('api', compact($this->compact(['json'])), true);
    }

    private function adminInstitutionDel ()
    {
        
        $id = TextTool::security($_POST['id']);

        if (!Institutions::getInstitution($id)) $state = static::error(12);
        else {
            Institutions::generalDelete($id);
            Admin::roomsDelete($id);
            $state = true;
        }

        $datas = [
            'state' => $state,
            'infos' => $state,
            'reload' => false,
            'link' => false
        ];
        $json = json_encode($datas);

        return $this->render('api', compact($this->compact(['json'])), true);
    }
}
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
        'adminInstitutionGet', 'adminInstitutionDel', 'adminInstitutionNew', 'adminInstitutionEdit',
        'adminRoomGet', 'adminRoomDel', 'adminRoomNew', 'adminRoomEdit',

    ];
    
    public function __construct ()
    {
        if ((!isset($_POST['submit']) && !isset($_GET['logout'])) && !in_array($_POST['submit'], self::$entries)) return static::error(405);

        if (isset($_GET['logout'])) return $this->logout();

        $this->compact(['json'], true);
        $load = $_POST['submit'];
        return $this->$load();
    }

    /**
     * Send datas
     * @param bool $isForm Is it a form
     * @param $state State of the request
     * @param $infos Aditionnal informations
     * @param bool $reload Reload website
     * @param $link Url to go to [false: stay in page] [-1: to go back]
     */
    private function datas ($isForm, $state, $infos, $reload, $link = -1)
    {
        $array = [
            'isForm' => $isForm,
            'state' => $state,
            'infos' => json_encode($infos),
            'reload' => $reload,
            'link' => $link
        ];

        return json_encode($array);
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

        if (in_array('', $isEmpty)) $state = static::error(4);
        elseif (Users::isUserExist($email)) $state = static::error(3);
        elseif (!preg_match('/^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/', $email)) $state = static::error(1);
        elseif (strlen($password1) <= 7) $state = static::error(5);
        elseif ($password1 !== $password2) $state = static::error(2);
        else {
            $send = Users::generalAdd([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'password' => TextTool::security($password1, 'convertPass')
            ]);

            if (isset($send)) Users::register();
    
            $state = (isset($send)) ? true : static::error(8);
        }

        $json = self::datas(true, $state, false, true);
        return $this->render('api', compact($this->compact()), true);
    }

    private function login ()
    {
        if (Users::isLogged()) return static::error(405);

        $email = TextTool::security($_POST['email']);
        $password = TextTool::security($_POST['password']);
        $isEmpty = [$email, $password];

        if (in_array('', $isEmpty)) $state = static::error(4);
        elseif (!Users::isUserExist($email)) $state = static::error(6);
        elseif (!Users::isPasswordCorrect($email, $password)) $state = static::error(7);
        elseif (!Users::login($email)) $state = static::error(8);
        else $state = true;

        $json = self::datas(true, $state, false, true);

        return $this->render('api', compact($this->compact()), true);
    }

    // DONT FORGET
    private function logout ()
    {
        if (!Users::isLogged()) return static::error(405);
        unset($_SESSION['user']);
        return true;
    }

    // ADMIN
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

        $json = self::datas(true, $state, $api, false, false);

        return $this->render('api', compact($this->compact()), true);
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

        $json = self::datas(true, $state, false, false, false);

        return $this->render('api', compact($this->compact()), true);
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

        $json = self::datas(false, $state, $api, false, false);

        return $this->render('api', compact($this->compact()), true);
    }

    private function adminInstitutionNew ()
    {
        $name = TextTool::security($_POST['name']);
        $city = TextTool::security($_POST['city']);
        $address = TextTool::security($_POST['address']);
        $description = TextTool::security($_POST['description']);
        $entertainment = TextTool::security($_POST['entertainment']);
        $isEmpty = [$name, $city, $address, $description, $entertainment];
        $api = false;

        if (in_array('', $isEmpty)) $state = static::error(4);
        else {
            Institutions::generalAdd([
                'name' => $name,
                'city' => $city,
                'address' => $address,
                'description' => $description,
                'entertainment' => $entertainment
            ]);
            
            $state = true;
            $api = [
                'name' => $name,
                'id' => Institutions::lastId()
            ];
        }

        $json = self::datas(true, $state, $api, false, false);

        return $this->render('api', compact($this->compact()), true);
    }

    private function adminInstitutionEdit ()
    {
        $id = TextTool::security($_POST['id']);
        $name = TextTool::security($_POST['name']);
        $city = TextTool::security($_POST['city']);
        $address = TextTool::security($_POST['address']);
        $description = TextTool::security($_POST['description']);
        $entertainment = TextTool::security($_POST['entertainment']);
        $isEmpty = [$id, $name, $city, $address, $description, $entertainment];
        $api = false;

        if (in_array('', $isEmpty)) $state = static::error(4);
        elseif (!Institutions::getInstitution($id)) $state = static::error(12);
        else {
            Institutions::generalEdit([
                'datas' => [
                    'name' => $name,
                    'city' => $city,
                    'address' => $address,
                    'description' => $description,
                    'entertainment' => $entertainment
                ],
                'ids' => ['id' => $id]
            ]);
            
            $state = true;
        }

        $json = self::datas(true, $state, false, false, false);

        return $this->render('api', compact($this->compact()), true);
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

        $json = self::datas(false, $state, $api, false, false);

        return $this->render('api', compact($this->compact()), true);
    }

    private function adminInstitutionDel ()
    {
        $id = TextTool::security($_POST['id']);

        if (!Institutions::getInstitution($id)) $state = static::error(12);
        else {
            if (Institutions::isManaged($id)) {
                $user = Institutions::getInstitution($id);
                Users::generalEdit([
                    'datas' => ['rank' => 0],
                    'ids' => ['id' => $user->managerId]
                ]);
            }
            Institutions::generalDelete($id);
            Admin::roomsDelete($id);
            $state = true;
        }

        $json = self::datas(false, $state, $state, false, false);

        return $this->render('api', compact($this->compact()), true);
    }

    private function adminRoomGet ()
    {
        $id = TextTool::security($_POST['id']);
        $room = Rooms::getRoom($id);
        $api = false;

        if (!$room) $state = static::error(12);
        else {
            $state = true;
            $api = $room;
        }

        $sjon = self::datas(false, $state, $api, false, false);
        return $this->render('api', compact($this->compact()), true);
    }

    private function adminRoomNew ()
    {
        $institutionId = TextTool::security($_POST['institutionId']);
        $title = TextTool::security($_POST['title']);
        $imgFront = Rooms::generalImage($_FILES['imgFront']);
        $description = TextTool::security($_POST['description']);
        $price = TextTool::security($_POST['price']);
        $images = Rooms::generalImage($_FILES['images']);
        $link = TextTool::security($_POST['link']);
        $isEmpty = [$institutionId, $title, $imgFront, $description, $price, $images, $link];
        $api = false;

        if (in_array('', $isEmpty)) $state = static::error(4);
        elseif (is_int($imgFront)) $state = static::error($imgFront);
        elseif (is_int($images)) $state = static::error($images);
        else {
            Rooms::generalAdd([
                'institutionId' => $institutionId,
                'title' => $title,
                'imgFront' => $imgFront,
                'description' => $description,
                'price' => $price,
                'images' => $images,
                'link' => $link,
            ]);
            
            $state = true;
            $api = [
                'name' => $title,
                'id' => Rooms::lastId()
            ];
        }

        $json = self::datas(true, $state, $api, false, false);
        return $this->render('api', compact($this->compact()), true);
    }
}
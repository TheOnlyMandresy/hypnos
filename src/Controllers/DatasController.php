<?php

namespace System\Controllers;

use System\Database\Tables\AdminTable as Admin;
use System\Database\Tables\UsersTable as Users;
use System\Database\Tables\InstitutionsTable as Institutions;
use System\Database\Tables\RoomsTable as Rooms;
use System\Database\Tables\SupportTable as Support;
use System\Controller;
use System\Tools\TextTool;
use System\Tools\DateTool;

/**
 * Datas treatment
 */
class DatasController extends Controller
{
    private static $entries = [
        'register', 'login', 'adminTeamNew', 'adminTeamEdit', 'adminTeamDelete',
        'adminInstitutionGet', 'adminInstitutionDel', 'adminInstitutionNew', 'adminInstitutionEdit',
        'adminRoomGet', 'adminRoomDel', 'adminRoomNew', 'adminRoomEdit', 'bookingNew',
        'ticketNew', 'ticketAdd', 'ticketClose'
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

    private function ticketNew ()
    {

        $firstname = (Users::isLogged()) ? Users::$myDatas->firstname : TextTool::security($_POST['firstname']);
        $lastname = (Users::isLogged()) ? Users::$myDatas->lastname : TextTool::security($_POST['lastname']);
        $email = (Users::isLogged()) ? Users::$myDatas->email : TextTool::security($_POST['email']);
        $topic = TextTool::security($_POST['topic']);
        $title = TextTool::security($_POST['title']);
        $message = TextTool::security($_POST['message']);
        $isEmpty = [$firstname, $lastname, $email, $topic, $message];
        $link = '/';

        if (in_array('', $isEmpty)) $state = static::error(4);
        elseif (Users::isUserExist($email) && !Users::isLogged()) {
            $state = static::error(23);
            $_SESSION['support'] = [
                'topic' => $topic,
                'message' => $message,
                'title' => $title
            ];
        }
        else {
            if (isset($_SESSION['support'])) unset($_SESSION['support']);
            if (Users::isLogged()) $link = '/support';

            $userId = (Users::isLogged()) ? Users::$myDatas->id : 0;

            Support::generalAdd([
                'userId' => $userId,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'topic' => $topic,
                'title' => $title,
                'message' => $message
            ]);

            $state = true;
        }

        $json = self::datas(true, $state, false, false, $link);

        return $this->render('api', compact($this->compact()), true);
    }

    private function ticketAdd ()
    {
        $message = TextTool::security($_POST['message']);
        $id = TextTool::security($_POST['supportId']);
        $api = false;

        if ($message === '') $state = static::error(4);
        else {
            Support::generalAdd([
                'message' => $message,
                'userId' => Users::$myDatas->id,
                'supportId' => $id
            ], '_messages');

            $date = Support::getMessage(Support::lastId());

            $state = true;
            $api = [
                'message' => $message,
                'name' => Users::$myDatas->firstname. ' ' .Users::$myDatas->lastname,
                'date' => DateTool::dateFormat($date->dateSend, 'full')
            ];
        }

        $json = self::datas(true, $state, $api, false, false);

        return $this->render('api', compact($this->compact()), true);
    }

    private function bookingNew ()
    {
        $institutionId = TextTool::security($_POST['institutionId']);
        $roomId = TextTool::security($_POST['roomId']);
        $dateStart = DateTool::dateFormat(TextTool::security($_POST['dateStart']), 'sql');
        $dateEnd = DateTool::dateFormat(TextTool::security($_POST['dateEnd']), 'sql');
        
        $isEmpty = [$institutionId, $roomId, $dateStart, $dateEnd];
        $isBooked = Rooms::isBooked($roomId, $dateStart, $dateEnd);
        $tomorrow = DateTool::dateFormat(DateTool::dateFormat(time(), 'tomorrow'), 'timestamp');
        $tomorrowStart = DateTool::dateFormat(DateTool::dateFormat($dateStart, 'tomorrow'), 'timestamp');

        $isForm = true;
        $link = '/reservations';

        if (in_array('', $isEmpty) || in_array('1970-01-01 01:00:00', $isEmpty)) $state = static::error(4);
        elseif (DateTool::dateFormat($dateEnd, 'timestamp') <= DateTool::dateFormat($dateStart, 'timestamp')) $state = static::error(20);
        elseif ($isBooked) $state = static::error(18);
        elseif ($tomorrowStart <= $tomorrow) $state = static::error(19);
        elseif (!Institutions::getInstitution($institutionId)) $state = static::error(9);
        elseif (!Rooms::getRoom($roomId)) $state = static::error(12);
        elseif (!Users::isLogged()) {
            $_SESSION['booking'] = [
                'institutionId' => $institutionId,
                'roomId' => $roomId,
                'dateStart' => $dateStart,
                'dateEnd' => $dateEnd
            ];
            
            $state = true;
            $isForm = false;
            $link = '/login';
        } else {
            if (isset($_SESSION['booking'])) unset($_SESSION['booking']);

            Rooms::generalAdd([
                'userId' => Users::$myDatas->id,
                'roomId' => $roomId,
                'dateStart' => $dateStart,
                'dateEnd' => $dateEnd
            ], '_booked');

            $state = true;
        }
        
        $json = self::datas($isForm, $state, false, false, $link);
        return $this->render('api', compact($this->compact()), true);
    }



            //     _____  __  __ _____ _   _ 
            //     /\   |  __ \|  \/  |_   _| \ | |
            //    /  \  | |  | | \  / | | | |  \| |
            //   / /\ \ | |  | | |\/| | | | | . ` |
            //  / ____ \| |__| | |  | |_| |_| |\  |
            // /_/    \_\_____/|_|  |_|_____|_| \_|

    /**
     * 
     */
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
            Admin::roomsDelete($id);
            Institutions::generalDelete($id);
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

    private function ticketClose ()
    {
        $id = TextTool::security($_POST['supportId']);

        if (!Support::get($id)) $state = static::error(12);
        else {
            Support::generalEdit([
                'datas' => ['state' => 1],
                'ids' => ['id' => $id]
            ]);
            $state = true;
        }

        $json = self::datas(false, $state, false, false, false);
        return $this->render('api', compact($this->compact()), true);
    }
}
<?php

namespace System\Controllers;

use System;
use System\Controller;
use System\Database\Tables\AdminTable as Admin;
use System\Database\Tables\UsersTable as Users;
use System\Database\Tables\RoomsTable as Rooms;
use System\Database\Tables\InstitutionsTable as Institutions;
use System\Database\Tables\SupportTable as Support;
use System\Tools\TextTool;

class AdminController extends Controller
{
    private static $isAdministrator;
    private static $isManager;

    public function __construct ($page)
    {
        if (!Users::isLogged()) return static::error(405);
        if (intval(Users::getMyDatas()->rank) === 0) return static::error(405);

        if (is_null(self::$isAdministrator)) self::$isAdministrator = Admin::isAdministrator(Users::$myDatas->email);
        if (is_null(self::$isManager)) self::$isManager = Admin::isUserExist(Users::$myDatas->email);

        $this->compact(['title', 'h1', 'page'], true);
        $load = $page[1];

        if (isset($page[2])) return $this->$load($page[2]);

        return $this->$load();
    }

    private function team ()
    {
        if (!self::$isAdministrator) return static::error(405);

        $page = 'admin-team small';
        $title = TextTool::setTitle('équipe');
        $h1 = 'L\'équipe de ' .TextTool::getName();

        $team = Admin::all();
        $datas = Institutions::withNoManager();
        $institutions = [];
        foreach ($datas as $value) {
            $institutions[$value->id] = $value->name;
        }

        return $this->render('admin/Team', compact($this->compact(['institutions', 'team'])));
    }

    private function views ()
    {
        if (!self::$isAdministrator && !self::$isManager) return static::error(405);

        $page = 'admin-views small';
        $title = TextTool::setTitle('Le site');
        $h1 = 'Vue d\'ensemble';

        $current = 'index';
        $institutions = Institutions::all();
        $rooms = Rooms::all();
        $booked = Rooms::bookedAll();

        return $this->render('admin/Views', compact($this->compact(['current', 'institutions', 'rooms', 'booked'])));
    }

    private function institutions ()
    {
        if (!self::$isAdministrator) return static::error(405);

        $page = 'admin-views admin-institutions undersection small';
        $title = TextTool::setTitle('les hôtels');
        $h1 = 'Les hôtels de ' .TextTool::getName();

        $current = 'institutions';
        $institutions = Institutions::all();

        return $this->render('admin/Views', compact($this->compact(['current', 'institutions'])));
    }

    private function rooms ()
    {
        if (!self::$isAdministrator && !self::$isManager) return static::error(405);

        $page = 'admin-views admin-rooms undersection small';
        $title = TextTool::setTitle('Les suites');
        $h1 = 'Les suites';

        $current = 'rooms';
        $datas = Institutions::all();
        $institutions = [];
        foreach ($datas as $value) {
            $institutions[$value->id] = $value->name;
        }
        
        $rooms = Rooms::all();

        return $this->render('admin/Views', compact($this->compact(['current', 'institutions', 'rooms'])));
    }

    private function reservations ()
    {
        if (!self::$isAdministrator && !self::$isManager) return static::error(405);

        $page = 'admin-views admin-reservations undersection small';
        $title = TextTool::setTitle('Les réservations');
        $h1 = 'Les réservations';

        $current = 'reservations';
        $datas = Rooms::bookedAll();

        return $this->render('admin/Views', compact($this->compact(['current', 'datas'])));
    }

    private function support ()
    {
        if (!self::$isAdministrator) return static::error(405);

        $page = 'admin-support small';
        $title = TextTool::setTitle('Le support technique');
        $h1 = 'Les tickets';

        $current = 'index';
        $datas = Support::all();
        $topics = System::getSystemInfos('support');

        return $this->render('admin/Support', compact($this->compact(['current', 'datas', 'topics'])));
    }

    private function ticket ($id)
    {
        if (!self::$isAdministrator) return static::error(405);
        $page = 'admin-support contact-ticket small';
        $title = TextTool::setTitle('ticket - ' .$id);
        

        $current = 'ticket';
        $datas = Support::get($id);
        $h1 = $datas['infos']->title;

        return $this->render('admin/Support', compact($this->compact(['current', 'datas'])));
    }
}
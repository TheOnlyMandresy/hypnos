<?php

namespace System\Controllers;

use System\Controller;
use System\Database\Tables\AdminTable as Admin;
use System\Database\Tables\UsersTable as Users;
use System\Database\Tables\RoomsTable as Rooms;
use System\Database\Tables\InstitutionsTable as Institutions;
use System\Tools\TextTool;

class AdminController extends Controller
{
    public function __construct ($page)
    {
        if (!Users::isLogged()) return static::error(405);
        if (intval(Users::getMyDatas()->rank) === 0) return static::error(405);

        $this->compact(['title', 'h1', 'page'], true);
        $load = $page[1];

        return $this->$load();
    }

    private function team ()
    {
        if (!Admin::isAdministrator(Users::$myDatas->email)) return static::error(405);

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
}
<?php

namespace System\Controllers;

use System\Controller;
use System\Database\Tables\InstitutionsTable as Institutions;
use System\Database\Tables\RoomsTable as Rooms;
use System\Tools\TextTool;

/**
 * Api loader
 */
class ApiController extends Controller
{
    public function __construct ($page)
    {
        $this->compact(['title'], true);
        $load = $page[1];
        
        if ($load === 'room') return $this->room($page[2]);
        if ($load === 'institution') return $this->room($page[2]);

        return $this->$load();
    }
    
    /**
     * All the institutions
     */
    private function institutions ()
    {
        $title = TextTool::setTitle('institutions');

        $datas = Institutions::all();
        $api = array('datas' => $datas);
        $json = json_encode($api);
        return $this->render('api', compact($this->compact(['json'])), true);
    }

    /**
     * Get one institution
     */
    private function institution ($id)
    {
        $id = intval(TextTool::security($id, 'get'));
        $title = TextTool::setTitle('institution');

        $datas = Institutions::getInstitution($id);
        $json = json_encode($datas);
        return $this->render('api', compact($this->compact(['json'])), true);
    }

    /**
     * All the rooms
     * GET : current_page, per_page, institution
     */
    private function rooms ()
    {
        if (isset($_GET['current_page'])) $current = intval(TextTool::security($_GET['current_page'], 'get'));
        if (isset($_GET['per_page'])) $per = intval(TextTool::security($_GET['per_page'], 'get'));
        if (isset($_GET['institution'])) {
            $id = intval(TextTool::security($_GET['institution'], 'get'));
            $datas = Rooms::byInstitution($id);
        } else {
            $datas = Rooms::all();
        }

        $title = TextTool::setTitle('suites');
        $api = [
            'total' => ($datas) ? count($datas) : false,
            'current_page' => (isset($current)) ? $current : 1,
            'per_page' => (isset($per)) ? $per : 10,
            'datas' => $datas
        ];
        $json = json_encode($api);

        return $this->render('api', compact($this->compact(['json'])), true);
    }

    /**
     * Get one room
     */
    private function room ($id)
    {
        $id = intval(TextTool::security($id, 'get'));
        $title = TextTool::setTitle('suite');

        $datas = Rooms::getRoom($id);
        $json = json_encode($datas);
        return $this->render('api', compact($this->compact(['json'])), true);
    }
}
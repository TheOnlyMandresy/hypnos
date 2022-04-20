<?php

namespace System\Controllers;

use System\Database\Tables\InstitutionsTable as Institutions;
use System\Database\Tables\RoomsTable as Rooms;
use System\Controller;
use System\Tools\TextTool;

class InstitutionsController extends Controller
{
    public function __construct ($page)
    {
        $this->compact(['title', 'h1', 'page', 'description'], true);

        $load = (isset($page[1])) ? $page[1] : $page[0];
        
        switch ($load) {
            case 'get':
                return $this->get($page[2]);
            default:
                return static::error(404);
        }
    }

    /**
     * See an institution
     */
    private function get ($id)
    {
        $id = intval(TextTool::security($id, 'get'));
        if (!is_int($id)) static::error(404);

        (Institutions::getInstitution($id)) ? $data = Institutions::getInstitution($id) : static::error(404);
        $rooms = (Rooms::byInstitution($id)) ?  Rooms::byInstitution($id) : false;

        $page = 'institution-one template';
        $title = TextTool::setTitle($data->name);
        $h1 = $data->name;
        $description = $data->description;
        $entertainment = explode('.', $data->entertainment);

        if ($rooms !== false) {
            foreach ($rooms as $room) {
                $room->title = ucfirst($room->title);
                $room->description = TextTool::shorten($room->description, 220);
            }
            $this->compact(['rooms']);
        }

        for ($i = 0; $i < count($entertainment); $i++) {
            $entertainment[$i] = ucfirst($entertainment[$i]);
        }
        
        return $this->render('institution', compact($this->compact(['data', 'entertainment'])));
    }
}
<?php

namespace System\Controllers;

use System\Database\Tables\RoomsTable as Rooms;
use System\Database\Tables\InstitutionsTable as Institutions;
use System\Controller;
use System\Tools\TextTool;

class RoomsController extends Controller
{
    public function __construct ($page)
    {
        $this->compact(['title', 'h1', 'page', 'description'], true);

        $load = (isset($page[1])) ? $page[1] : $page[0];

        switch ($load) {
            case 'get':
                return $this->get($page[2]);
            default:
                return $this->index();
        }
    }
    
    /**
     * Get all rooms
     */
    private function index ()
    {
        $current = 'rooms';
        $page = 'room-all template';
        $title = TextTool::setTitle('Suites');
        $h1 = 'Toutes nos Suites';
        $description = 'Lorem ipsum dolor sit amet. Et unde architecto hic ducimus voluptatem eum blanditiis beatae in itaque facere hic recusandae numquam et enim esse. Non enim sunt a tempora odio quo nihil molestias. Et alias autem aut soluta consequatur in nostrum excepturi non galisum repudiandae et excepturi ducimus et dignissimos quaerat? Aut adipisci internos est temporibus veritatis est optio dolorem hic fuga suscipit qui nihil eligendi ut dolores culpa et eius sunt?';

        $datas = Rooms::all();
        foreach ($datas as $data) {
            $data->description = TextTool::shorten($data->description, 220);
        }

        $institutionsDatas = Institutions::all();
        $institutions = [];
        foreach ($institutionsDatas as $value) {
            $institutions[$value->id] = $value->name;
        }

        return $this->render('all', compact($this->compact(['current', 'datas', 'institutions'])));
    }

    /**
     * See a room
     */
    private function get ($id)
    {
        $page = 'room-one template';

        $datas = Rooms::getRoom($id);

        $title = TextTool::setTitle($datas->title);
        $h1 = $datas->title;
        $description = null;
        $images = explode(',', $datas->images);

        return $this->render('room', compact($this->compact(['datas', 'images'])));
    }
}
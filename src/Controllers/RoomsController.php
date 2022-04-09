<?php

namespace System\Controllers;

use System\Controller;
use System\Tools\TextTool;

class RoomsController extends Controller
{
    public function __construct ($page)
    {
        $this->compact(['title', 'h1', 'page'], true);

        $load = (isset($page[1])) ? $page[1] : $page[0];

        switch ($load) {
            case 'get':
                return $this->get($page[2]);
            case 'filter':
                return $this->filter($page[2]);
            default:
                return $this->index();
        }
    }
    
    /**
     * Get all rooms
     */
    private function index ()
    {
        $page = 'room-all';
        $title = TextTool::setTitle('Suites');
        $h1 = 'Toutes nos Suites';

        return $this->render('all', compact($this->compact()));
    }

    /**
     * See a room
     */
    private function get ($id)
    {
        $page = 'room-one';
        $title = TextTool::setTitle('NAME');
        $h1 = 'Notre suite';

        return $this->render('room', compact($this->compact()));
    }

    /**
     * See a room by Institution
     */
    private function filter ($id)
    {
        $page = 'room-all';
        $title = TextTool::setTitle('Suites chez NAME');
        $h1 = 'Suites de X Hotel';

        return $this->render('all', compact($this->compact()));
    }
}
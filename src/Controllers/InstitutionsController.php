<?php

namespace System\Controllers;

use System\Controller;
use System\Tools\TextTool;

class InstitutionsController extends Controller
{
    public function __construct ($page)
    {
        $this->compact(['title', 'h1', 'page'], true);

        $load = (isset($page[1])) ? $page[1] : $page[0];

        switch ($load) {
            case 'get':
                return $this->get($page[2]);
            default:
                return $this->index();
        }
    }
    
    /**
     * All Institutions
     */
    private function index ()
    {
        $page = 'institution-all';
        $title = TextTool::setTitle('institutions');
        $h1 = 'Tous nos bâtiments';

        return $this->render('all', compact($this->compact()));
    }

    /**
     * See an institution
     */
    private function get ($id)
    {
        $page = 'institution-one';
        $title = TextTool::setTitle('NAME');
        $h1 = 'Notre bâtiment';

        return $this->render('institution', compact($this->compact()));
    }
}
<?php

namespace System\Controllers;

use System\Controller;
use System\Tools\TextTool;

class InstitutionsController extends Controller
{
    public function __construct ($page)
    {
        $this->compact(['title', 'h1', 'page'], true);
        return $this->index();
    }
    
    private function index ()
    {
        $page = 'institution-all';
        $title = TextTool::setTitle('institutions');
        $h1 = 'Tous nos bâtiments';

        return $this->render('institution', compact($this->compact()));
    }
}
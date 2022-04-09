<?php

namespace System\Controllers;

use System\Controller;
use System\Tools\TextTool;

class IndexController extends Controller
{
    public function __construct ($page)
    {
        $this->compact(['title', 'h1', 'page'], true);

        if ($page === 'index') return $this->index();
    }
    
    private function index ()
    {
        $page = 'index';
        $title = TextTool::setTitle('accueil');
        $h1 = 'Bienvenue sur ' .TextTool::getName();

        return $this->render('index', compact($this->compact()));
    }
}
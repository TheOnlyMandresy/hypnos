<?php

namespace System\Controllers;

use System\Controller;
use System\Tools\TextTool;

class IndexController extends Controller
{
    public function __construct ($page)
    {
        $this->compact(['title', 'h1', 'page'], true);

        $load = (isset($page[1])) ? $page[1] : $page[0];

        switch ($load) {
            case 'index':
            default:
                return $this->index();
            case '404':
                return $this->notFound();
            case '405':
                return $this->denied();
        }
    }
    
    private function index ()
    {
        $page = 'index';
        $title = TextTool::setTitle('accueil');
        $h1 = 'Bienvenue sur ' .TextTool::getName();

        return $this->render('index', compact($this->compact()));
    }
    
    private function notFound ()
    {
        $page = 'error';
        $title = TextTool::setTitle('Introuvable');
        $h1 = 'Bienvenue sur ' .TextTool::getName();

        return $this->render('errors/404', compact($this->compact()));
    }
    
    private function denied ()
    {
        $page = 'error';
        $title = TextTool::setTitle('Accès interdit');
        $h1 = 'Bienvenue sur ' .TextTool::getName();

        return $this->render('errors/405', compact($this->compact()));
    }
}
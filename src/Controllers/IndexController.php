<?php

namespace System\Controllers;

use System\Controller;
use System\Tools\TextTool;

class IndexController extends Controller
{
    public function __construct ($page)
    {
        $this->compact(['title', 'h1'], true);

        if ($page[0] === 'index') return $this->index();
    }
    
    private function index ()
    {
        $title = TextTool::setTitle('accueil');
        $h1 = 'Hello World';

        return $this->render('index', compact($this->compact()));
    }
}
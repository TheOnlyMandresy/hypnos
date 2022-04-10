<?php

namespace System\Controllers;

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
                return $this->index();
        }
    }
    
    /**
     * All Institutions
     */
    private function index ()
    {
        $page = 'institution-all template';
        $title = TextTool::setTitle('institutions');
        $h1 = 'Tous nos bâtiments';
        $description = 'Lorem ipsum dolor sit amet. Et unde architecto hic ducimus voluptatem eum blanditiis beatae in itaque facere hic recusandae numquam et enim esse. Non enim sunt a tempora odio quo nihil molestias. Et alias autem aut soluta consequatur in nostrum excepturi non galisum repudiandae et excepturi ducimus et dignissimos quaerat? Aut adipisci internos est temporibus veritatis est optio dolorem hic fuga suscipit qui nihil eligendi ut dolores culpa et eius sunt?';

        return $this->render('all', compact($this->compact()));
    }

    /**
     * See an institution
     */
    private function get ($id)
    {
        $page = 'institution-one template';
        $title = TextTool::setTitle('NAME');
        $h1 = 'Notre bâtiment';
        $description = 'Lorem ipsum dolor sit amet. Et unde architecto hic ducimus voluptatem eum blanditiis beatae in itaque facere hic recusandae numquam et enim esse. Non enim sunt a tempora odio quo nihil molestias. Et alias autem aut soluta consequatur in nostrum excepturi non galisum repudiandae et excepturi ducimus et dignissimos quaerat? Aut adipisci internos est temporibus veritatis est optio dolorem hic fuga suscipit qui nihil eligendi ut dolores culpa et eius sunt?';

        return $this->render('institution', compact($this->compact()));
    }
}
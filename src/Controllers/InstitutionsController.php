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
                return $this->index();
        }
    }
    
    /**
     * All Institutions
     */
    private function index ()
    {
        $page = 'institution-all template';
        $title = TextTool::setTitle('hôtels');
        $h1 = 'Tous nos hôtels';
        $description = 'Lorem ipsum dolor sit amet. Et unde architecto hic ducimus voluptatem eum blanditiis beatae in itaque facere hic recusandae numquam et enim esse. Non enim sunt a tempora odio quo nihil molestias. Et alias autem aut soluta consequatur in nostrum excepturi non galisum repudiandae et excepturi ducimus et dignissimos quaerat? Aut adipisci internos est temporibus veritatis est optio dolorem hic fuga suscipit qui nihil eligendi ut dolores culpa et eius sunt?';

        return $this->render('all', compact($this->compact()));
    }

    /**
     * See an institution
     */
    private function get ($id)
    {
        $id = intval(TextTool::security($id, 'get'));
        if (!is_int($id)) $this->error(404);

        (Institutions::getInstitution($id)) ? $data = Institutions::getInstitution($id) : $this->error(404);
        $rooms = (Rooms::byInstitution($id)) ?  Rooms::byInstitution($id) : false;

        $page = 'institution-one template';
        $title = TextTool::setTitle($data->name);
        $h1 = $data->name;
        $description = $data->description;
        $entertainment = explode('.', $data->entertainment);

        for ($i = 0; $i < count($entertainment); $i++) {
            $entertainment[$i] = ucfirst($entertainment[$i]);
        }
        
        return $this->render('institution', compact($this->compact(['data', 'rooms', 'entertainment'])));
    }
}
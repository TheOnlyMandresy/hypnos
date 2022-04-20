<?php

namespace System\Controllers;

use System\Database\Tables\InstitutionsTable as Institutions;
use System\Database\Tables\RoomsTable as Rooms;
use System\Database\Tables\UsersTable as Users;
use System\Database\Tables\SupportTable as Support;
use System\Controller;
use System\Tools\TextTool;
use System\Tools\DateTool;

class UsersController extends Controller
{
    public function __construct ($page)
    {
        $this->compact(['title', 'h1', 'page'], true);

        switch ($page[1]) {
            case 'login':
                if (Users::isLogged()) return static::error(0);
                return $this->login();
            case 'register':
                if (Users::isLogged()) return static::error(0);
                return $this->register();
            case 'contact':
                return $this->contact();
            case 'tickets':
                if (!Users::isLogged()) return static::error(405);
                return $this->tickets();
            case 'ticket':
                if (!Users::isLogged()) return static::error(405);
                return $this->ticket($page[2]);
            case 'booking':
                return $this->booking();
            case 'reserved':
                if (!Users::isLogged()) return static::error(405);
                return $this->reserved();
        }
    }

    private function login ()
    {
        $page = 'login small';
        $title = TextTool::setTitle('Connexion');
        $h1 = 'Se connecter';

        return $this->render('user/Login', compact($this->compact()));
    }

    private function register ()
    {
        $page = 'register small';
        $title = TextTool::setTitle('Inscription');
        $h1 = 'Inscrits-toi';

        return $this->render('user/Register', compact($this->compact()));
    }

    /**
     * Create a new ticket
     */
    private function contact ()
    {
        $page = 'contact-new small';
        $title = TextTool::setTitle('Contact');
        $h1 = 'Formulaire de contact';
        
        $message = (isset($_SESSION['support'])) ? $_SESSION['support']['message'] : null;
        $topic = (isset($_SESSION['support'])) ? $_SESSION['support']['topic'] : null;
        $title = (isset($_SESSION['support'])) ? $_SESSION['support']['title'] : null;

        return $this->render('contact', compact($this->compact(['message', 'topic', 'title'])));
    }

    /**
     * See all my created tickets
     */
    private function tickets ()
    {
        $page = 'contact-all template';
        $title = TextTool::setTitle('Mes tickets');
        $h1 = 'Vos tickets';
        $description = 'Lorem ipsum dolor sit amet. Et unde architecto hic ducimus voluptatem eum blanditiis beatae in itaque facere hic recusandae numquam et enim esse. Non enim sunt a tempora odio quo nihil molestias. Et alias autem aut soluta consequatur in nostrum excepturi non galisum repudiandae et excepturi ducimus et dignissimos quaerat? Aut adipisci internos est temporibus veritatis est optio dolorem hic fuga suscipit qui nihil eligendi ut dolores culpa et eius sunt?';

        $all = Support::getMyAll(Users::$myDatas->id);

        return $this->render('user/Contact', compact($this->compact(['description', 'all'])));
    }

    /**
     * See a created ticket that I own
     */
    private function ticket ($id)
    {
        $page = 'contact-ticket small';
        $title = TextTool::setTitle('ticket - ' .$id);

        $datas = Support::get($id);
        $all = Support::getMyAll(Users::$myDatas->id);
        $h1 = $datas['infos']->title;

        return $this->render('user/Contact', compact($this->compact(['datas', 'all'])));
    }

    /**
     * Create a new reservation
     */
    private function booking ()
    {
        $page = 'book-new small';
        $title = TextTool::setTitle('Faites un réservation');
        $h1 = 'Nouvelle réservation';
        $institutionsDatas = Institutions::all();
        $roomsDatas = Rooms::all();

        $institutions = [];
        foreach ($institutionsDatas as $value) {
            $institutions[$value->id] = $value->name;
        }
        $rooms = [];
        foreach ($roomsDatas as $value) {
            $rooms[$value->id] = $value->title;
        }

        $institutionId = (isset($_SESSION['booking'])) ? $_SESSION['booking']['institutionId'] : null;
        $roomId = (isset($_SESSION['booking'])) ? $_SESSION['booking']['roomId'] : null;
        $dateStart = (isset($_SESSION['booking'])) ? $_SESSION['booking']['dateStart'] : null;
        $dateEnd = (isset($_SESSION['booking'])) ? $_SESSION['booking']['dateEnd'] : null;

        return $this->render('booking', compact($this->compact(['institutions', 'rooms', 'institutionId', 'roomId', 'dateStart', 'dateEnd'])));
    }

    /**
     * See all my reservations
     */
    private function reserved ()
    {
        $page = 'book-all template';
        $title = TextTool::setTitle('Mes réservations');
        $h1 = 'Vos réservations';
        $description = 'Lorem ipsum dolor sit amet. Et unde architecto hic ducimus voluptatem eum blanditiis beatae in itaque facere hic recusandae numquam et enim esse. Non enim sunt a tempora odio quo nihil molestias. Et alias autem aut soluta consequatur in nostrum excepturi non galisum repudiandae et excepturi ducimus et dignissimos quaerat? Aut adipisci internos est temporibus veritatis est optio dolorem hic fuga suscipit qui nihil eligendi ut dolores culpa et eius sunt?';

        $current = 'booked';
        $datas = Rooms::MyBooked(Users::$myDatas->id);

        if ($datas) {
            foreach ($datas as $data):
                $data->dateStart = DateTool::dateFormat($data->dateStart, 'd/m/y'). ' à ' .DateTool::dateFormat($data->dateStart, 'time');
                $data->dateEnd = DateTool::dateFormat($data->dateEnd, 'd/m/y'). ' à ' .DateTool::dateFormat($data->dateEnd, 'time');
            endforeach;
        }

        return $this->render('all', compact($this->compact(['current', 'datas', 'description'])));
    }
}
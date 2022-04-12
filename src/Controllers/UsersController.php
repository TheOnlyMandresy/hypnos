<?php

namespace System\Controllers;

use System\Database\Tables\InstitutionsTable as Institutions;
use System\Database\Tables\RoomsTable as Rooms;
use System\Controller;
use System\Tools\TextTool;

class UsersController extends Controller
{
    public function __construct ($page)
    {
        $this->compact(['title', 'h1', 'page'], true);

        switch ($page[1]) {
            case 'login':
                if (isset($_SESSION['user'])) return $this->error(405);
                return $this->login();
            case 'register':
                if (isset($_SESSION['user'])) return $this->error(405);
                return $this->register();
            case 'contact':
                return $this->contact();
            case 'tickets':
                if (!isset($_SESSION['user'])) return $this->error(405);
                return $this->tickets();
            case 'ticket':
                if (!isset($_SESSION['user'])) return $this->error(405);
                return $this->ticket($page[2]);
            case 'booking':
                return $this->booking();
            case 'reserved':
                if (!isset($_SESSION['user'])) return $this->error(405);
                return $this->reserved();
            case 'booked':
                if (!isset($_SESSION['user'])) return $this->error(405);
                return $this->booked($page[2]);
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
        $description = 'Lorem ipsum dolor sit amet. Et unde architecto hic ducimus voluptatem eum blanditiis beatae in itaque facere hic recusandae numquam et enim esse. Non enim sunt a tempora odio quo nihil molestias. Et alias autem aut soluta consequatur in nostrum excepturi non galisum repudiandae et excepturi ducimus et dignissimos quaerat? Aut adipisci internos est temporibus veritatis est optio dolorem hic fuga suscipit qui nihil eligendi ut dolores culpa et eius sunt?';

        return $this->render('contact', compact($this->compact(['description'])));
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

        return $this->render('user/Contact', compact($this->compact(['description'])));
    }

    /**
     * See a created ticket that I own
     */
    private function ticket ($id)
    {
        $page = 'contact-ticket';
        $title = TextTool::setTitle('ticket -' .$id);
        $h1 = 'Votre ticket';
        $description = 'Lorem ipsum dolor sit amet. Et unde architecto hic ducimus voluptatem eum blanditiis beatae in itaque facere hic recusandae numquam et enim esse. Non enim sunt a tempora odio quo nihil molestias. Et alias autem aut soluta consequatur in nostrum excepturi non galisum repudiandae et excepturi ducimus et dignissimos quaerat? Aut adipisci internos est temporibus veritatis est optio dolorem hic fuga suscipit qui nihil eligendi ut dolores culpa et eius sunt?';

        return $this->render('user/Contact', compact($this->compact(['description'])));
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

        return $this->render('booking', compact($this->compact(['institutions', 'rooms'])));
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

        return $this->render('user/All', compact($this->compact(['description'])));
    }

    /**
     * See a created reservation
     */
    private function booked ($id)
    {
        $page = 'book-get template';
        $title = TextTool::setTitle('Réservation -' .$id);
        $h1 = 'Votre réservation';
        $description = 'Lorem ipsum dolor sit amet. Et unde architecto hic ducimus voluptatem eum blanditiis beatae in itaque facere hic recusandae numquam et enim esse. Non enim sunt a tempora odio quo nihil molestias. Et alias autem aut soluta consequatur in nostrum excepturi non galisum repudiandae et excepturi ducimus et dignissimos quaerat? Aut adipisci internos est temporibus veritatis est optio dolorem hic fuga suscipit qui nihil eligendi ut dolores culpa et eius sunt?';

        return $this->render('user/Booked', compact($this->compact(['description'])));
    }
}
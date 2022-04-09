<?php

namespace System\Controllers;

use System\Controller;
use System\Tools\TextTool;

class UsersController extends Controller
{
    public function __construct ($page)
    {
        $this->compact(['title', 'h1', 'page'], true);

        switch ($page[1]) {
            case 'login':
                return $this->login();
            case 'register':
                return $this->register();
            case 'contact':
                return $this->contact();
            case 'tickets':
                return $this->tickets();
            case 'ticket':
                return $this->ticket($page[2]);
            case 'booking':
                return $this->booking();
            case 'reserved':
                return $this->reserved();
            case 'booked':
                return $this->booked($page[2]);
    }
    }

    private function login ()
    {
        $page = 'login';
        $title = TextTool::setTitle('Connexion');
        $h1 = 'Se connecter';

        return $this->render('user/Login', compact($this->compact()));
    }

    private function register ()
    {
        $page = 'register';
        $title = TextTool::setTitle('Inscription');
        $h1 = 'Inscrits-toi';

        return $this->render('user/Register', compact($this->compact()));
    }

    /**
     * Create a new ticket
     */
    private function contact ()
    {
        $page = 'contact-new';
        $title = TextTool::setTitle('Contact');
        $h1 = 'Créer un ticket';

        return $this->render('contact', compact($this->compact()));
    }

    /**
     * See all my created tickets
     */
    private function tickets ()
    {
        $page = 'contact-all';
        $title = TextTool::setTitle('Mes tickets');
        $h1 = 'Vos tickets';

        return $this->render('user/Contact', compact($this->compact()));
    }

    /**
     * See a created ticket that I own
     */
    private function ticket ($id)
    {
        $page = 'contact-ticket';
        $title = TextTool::setTitle('ticket -' .$id);
        $h1 = 'Votre ticket';

        return $this->render('user/Contact', compact($this->compact()));
    }

    /**
     * Create a new reservation
     */
    private function booking ()
    {
        $page = 'book-new';
        $title = TextTool::setTitle('Faites un réservation');
        $h1 = 'Nouvelle réservation';

        return $this->render('booking', compact($this->compact()));
    }

    /**
     * See all my reservations
     */
    private function reserved ()
    {
        $page = 'book-all';
        $title = TextTool::setTitle('Mes réservations');
        $h1 = 'Vos réservations';

        return $this->render('user/All', compact($this->compact()));
    }

    /**
     * See a created reservation
     */
    private function booked ($id)
    {
        $page = 'book-get';
        $title = TextTool::setTitle('Réservation -' .$id);
        $h1 = 'Votre réservation';

        return $this->render('user/Booked', compact($this->compact()));
    }
}
<?php

namespace System\Controllers;

use System\Controller;
use System\Tools\TextTool;

class UsersController extends Controller
{
    public function __construct ($page)
    {
        $this->compact(['title', 'h1', 'page', 'description'], true);

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
        $page = 'contact-new template';
        $title = TextTool::setTitle('Contact');
        $h1 = 'Créer un ticket';
        $description = 'Lorem ipsum dolor sit amet. Et unde architecto hic ducimus voluptatem eum blanditiis beatae in itaque facere hic recusandae numquam et enim esse. Non enim sunt a tempora odio quo nihil molestias. Et alias autem aut soluta consequatur in nostrum excepturi non galisum repudiandae et excepturi ducimus et dignissimos quaerat? Aut adipisci internos est temporibus veritatis est optio dolorem hic fuga suscipit qui nihil eligendi ut dolores culpa et eius sunt?';

        return $this->render('contact', compact($this->compact()));
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

        return $this->render('user/Contact', compact($this->compact()));
    }

    /**
     * See a created ticket that I own
     */
    private function ticket ($id)
    {
        $page = 'contact-ticket template';
        $title = TextTool::setTitle('ticket -' .$id);
        $h1 = 'Votre ticket';
        $description = 'Lorem ipsum dolor sit amet. Et unde architecto hic ducimus voluptatem eum blanditiis beatae in itaque facere hic recusandae numquam et enim esse. Non enim sunt a tempora odio quo nihil molestias. Et alias autem aut soluta consequatur in nostrum excepturi non galisum repudiandae et excepturi ducimus et dignissimos quaerat? Aut adipisci internos est temporibus veritatis est optio dolorem hic fuga suscipit qui nihil eligendi ut dolores culpa et eius sunt?';

        return $this->render('user/Contact', compact($this->compact()));
    }

    /**
     * Create a new reservation
     */
    private function booking ()
    {
        $page = 'book-new template';
        $title = TextTool::setTitle('Faites un réservation');
        $h1 = 'Nouvelle réservation';
        $description = 'Lorem ipsum dolor sit amet. Et unde architecto hic ducimus voluptatem eum blanditiis beatae in itaque facere hic recusandae numquam et enim esse. Non enim sunt a tempora odio quo nihil molestias. Et alias autem aut soluta consequatur in nostrum excepturi non galisum repudiandae et excepturi ducimus et dignissimos quaerat? Aut adipisci internos est temporibus veritatis est optio dolorem hic fuga suscipit qui nihil eligendi ut dolores culpa et eius sunt?';

        return $this->render('booking', compact($this->compact()));
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

        return $this->render('user/All', compact($this->compact()));
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

        return $this->render('user/Booked', compact($this->compact()));
    }
}
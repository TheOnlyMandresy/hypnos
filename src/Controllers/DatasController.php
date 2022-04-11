<?php

namespace System\Controllers;

use System\Controller;

/**
 * Api loader
 */
class DatasController extends Controller
{
    public function __construct ($page)
    {
        $this->compact(['title'], true);
        $load = $page[1];

        return $this->$load();
    }
}
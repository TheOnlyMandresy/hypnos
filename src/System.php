<?php

use System\Settings;
use System\Database;

class System extends Settings
{
    private static $db;
    private $page;

    /**
     * URL processing
     */
    public function __construct ()
    {
        $page = $_SERVER['REQUEST_URI'];
        $if = ['page', 'api', 'datas'];
        $json =explode('/', $page)[1];

        if (!in_array($json, $if) && !str_contains($json, '?')) return require_once '../src/Views/Templates/Base.php';;

        if (str_contains($page, '?')) {
            $pageExplode = explode('?', $page);
            $page = $pageExplode[0];
        }
        
        $this->page = explode('/', $page);
        array_shift($this->page);
        if ($this->page[0] !== 'api' && $this->page[0] !== 'datas') array_shift($this->page);
        
        // if (reset($this->page) === 'admin') {
        //     return $this->pageAdmin();
        // }
        return $this->page();
    }

    /**
     * Find root path
     * @param int $back : How far we want to go back
     * @return string
     */
    public static function root ($back = 2)
    {
        return realpath( dirname( __FILE__ , $back) ).'/';
    }

    /**
     * Load corresponding page
     */
    private function page ()
    {
        $page = (is_array($this->page)) ? reset($this->page) : $this->page;
        $new = '\System\Controllers\\' .ucfirst($page). 'Controller';
        $controller = new $new($this->page);
    }

    /**
     * Load corresponding admin page
     */
    private function pageAdmin ()
    {
        $extract = array_shift($this->page);
        $page = (reset($this->page) !== null)? reset($this->page) : 'index';
        $load = ($page === 'index')? $page : end($this->page);

        if ($page === 'index') {
            $new = new \Systeme\Controller\Admin\SystemeController();
        } else {
            $new = '\Systeme\Controller\Admin\\' .ucfirst($page). 'Controller';
        }

        new $new($this->page);
    }

    /**
     * Get settings
     * @param string $name : Constant name
     * @return
     */
    public static function getSystemInfos ($name)
    {
        $load = strtoupper($name);
        $r = new ReflectionClass(__CLASS__);

        return $r->getConstant($load);
    }

    /**
     * Get Database
     */
    public static function getDb ()
    {
        if (self::$db === null) self::$db = new Database(self::DB_NAME, self::DB_HOST, self::DB_USER, self::DB_PASS);
        
        return self::$db;
    }
}
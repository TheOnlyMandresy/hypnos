<?php

namespace System\Database\Tables;

use System\Database\Tables;
use System\Tools\TextTool;

class UsersTable extends Tables
{
    protected static $table = 'users';

    private static function statement ()
    {
        return [];
    }

    public static function all ()
    {
        $statement = self::statement();

        return static::find($statement, null, true);
    }

    public static function getUser ($id)
    {
        $statement = self::statement();
        $statement['where'] = 'id = ?';
        $statement['att'] = $id;
        
        return static::find($statement);
    }

    public static function isUserExist ($email)
    {
        $statement = self::statement();
        $statement['where'] = 'email = ?';
        $statement['att'] = $email;
        
        $data = static::find($statement);

        return ($data) ? true : false;
    }

    public static function isPasswordCorrect ($email, $password)
    {
        $statement = self::statement();
        $statement['select'] = 'password';
        $statement['where'] = 'email = ?';
        $statement['att'] = $email;
        $datas = static::find($statement);

        return password_verify($password, $datas->password);
    }

    public static function isLogged ()
    {
        return isset($_SESSION['user']);
    }

    public static function login ($email)
    {
        if (self::isLogged()) return true;

        $statement = self::statement();
        $statement['where'] = 'email = ?';
        $statement['att'] = $email;

        $datas = static::find($statement);

        if ($datas) {
            $_SESSION['user'] = $datas->id;
            return true;
        }

        return false;
    }
}
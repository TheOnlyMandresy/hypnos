<?php

namespace System\Database\Tables;

use System\Database\Tables;

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
        
        $data = static::find($statement, null, true);

        return ($data) ? true : false;
    }
}
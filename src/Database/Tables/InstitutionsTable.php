<?php

namespace System\Database\Tables;

use System\Database\Tables;

class InstitutionsTable extends Tables
{
    protected static $table = 'institutions';

    private static function statement ()
    {
        return [];
    }

    public static function all ()
    {
        $statement = self::statement();

        return static::find($statement, null, true);
    }

    public static function getInstitution ($id)
    {
        $statement = self::statement();
        $statement['where'] = 'id = ?';
        $statement['att'] = $id;
        
        return static::find($statement);
    }

    public static function getManagerInstitution ($id)
    {
        $statement = self::statement();
        $statement['select'] = "
            i.*,
            u.email as userEmail
        ";
        $statement['join'] = " as i
            INNER JOIN users u
            ON i.managerId = u.id
        ";
        $statement['where'] = 'i.managerId = ?';
        $statement['att'] = $id;
        
        return static::find($statement);
    }

    public static function withNoManager ()
    {
        $statement = self::statement();
        $statement['where'] = 'managerId IS NULL';

        $datas = static::find($statement, null, true);
        
        return ($datas) ? $datas : false;
    }

    public static function isManaged ($id)
    {
        $statement = self::statement();
        $statement['where'] = 'id = ? AND managerId IS NULL';
        $statement['att'] = $id;

        return (static::find($statement)) ? false : true;
    }
}
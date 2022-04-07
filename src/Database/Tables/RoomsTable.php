<?php

namespace System\Database\Tables;

use System\Database\Tables;

class RoomsTable extends Tables
{
    protected static $table = 'rooms';

    private static function statement ()
    {
        return [
            'select' => "
                r.*,
                i.name as institutionName
            ",
            'join' => " as r
                INNER JOIN institutions i
                ON r.institutionId = i.id
            "
        ];
    }

    public static function all ()
    {
        $statement = static::statement();

        return static::find($statement, null, true);
    }

    public static function getRoom ($id)
    {
        $statement = static::statement();
        $statement['where'] = 'r.id = ?';
        $statement['att'] = $id;
        
        return static::find($statement);
    }

    public static function byInstitution ($id)
    {
        $statement = static::statement();
        $statement['where'] = 'r.institutionId = ?';
        $statement['att'] = $id;

        return static::find($statement, null, true);
    }
}
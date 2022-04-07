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
        $statement = static::statement();

        return static::find($statement, null, true);
    }

    public static function getInstitution ($id)
    {
        $statement = static::statement();
        $statement['where'] = 'g.id = ?';
        $statement['att'] = $id;
        
        return static::find($statement);
    }
}
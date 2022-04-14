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
        
        $datas = static::find($statement);

        if ($datas) return $datas;
        return false;
    }

    public static function withNoManager ()
    {
        $statement = self::statement();
        $statement['where'] = 'managerId IS NULL';

        return static::find($statement, null, true);
    }
}
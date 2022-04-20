<?php

namespace System\Database\Tables;

use System\Database\Tables;
use System\Tools\TextTool;

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

        $datas = static::find($statement, null, true);

        if ($datas) {
        foreach ($datas as $data):
            $data->name = TextTool::security($data->name, 'decode');
            $data->city = TextTool::security($data->city, 'decode');
            $data->address = TextTool::security($data->address, 'decode');
            $data->description = TextTool::security($data->description, 'decode');
            $data->entertainment = TextTool::security($data->entertainment, 'decode');    
        endforeach;
        }

        return $datas;
    }

    public static function getInstitution ($id)
    {
        $statement = self::statement();
        $statement['where'] = 'id = ?';
        $statement['att'] = $id;
        
        $datas = static::find($statement);

        if ($datas) {
            $datas->name = TextTool::security($datas->name, 'decode');
            $datas->city = TextTool::security($datas->city, 'decode');
            $datas->address = TextTool::security($datas->address, 'decode');
            $datas->description = TextTool::security($datas->description, 'decode');
            $datas->entertainment = TextTool::security($datas->entertainment, 'decode');    
        }

        return $datas;
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
        
        $datas = static::find($statement);

        if ($datas) {
            $datas->name = TextTool::security($datas->name, 'decode');
            $datas->city = TextTool::security($datas->city, 'decode');
            $datas->address = TextTool::security($datas->address, 'decode');
            $datas->description = TextTool::security($datas->description, 'decode');
            $datas->entertainment = TextTool::security($datas->entertainment, 'decode');
        }

        return $datas;
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
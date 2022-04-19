<?php

namespace System\Database\Tables;

use System\Database\Tables;
use System\Tools\DateTool;

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

    public static function isBooked ($id, $start, $end)
    {
        $start = DateTool::dateFormat($start, 'timestamp');
        $end = DateTool::dateFormat($end, 'timestamp');

        $statement = [];
        $statement['where'] = 'roomId = ?';
        $statement['att'] = [$id];

        $datas = static::find($statement, '_booked', true);

        if ($datas) {
            foreach ($datas as $data)
            {
                $dateStart = DateTool::dateFormat($data->dateStart, 'timestamp');
                $dateEnd = DateTool::dateFormat($data->dateEnd, 'timestamp');
    
                if ($dateStart <= $start && $start <= $dateEnd) return true;
                elseif ($dateStart <= $end && $end <= $dateEnd) return true;
                elseif ($dateStart >= $start && $dateEnd <= $end) return true;
            }
        }

        return false;
    }

    public static function bookedAll ()
    {
        $statement ['select'] = "
            b.*,
            r.institutionId as institutionId,
            r.title as title,
            i.name as institutionName
        ";
        $statement ['join'] = " as b
            INNER JOIN rooms r
            ON b.roomId = r.id
            INNER JOIN institutions i
            ON r.institutionId = i.id
        ";

        return static::find($statement, '_booked', true);
    }
}
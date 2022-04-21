<?php

namespace System\Database\Tables;

use System\Database\Tables;
use System\Tools\DateTool;
use System\Tools\TextTool;

class RoomsTable extends Tables
{
    protected static $table = 'rooms';

    private static function statement ($type = null)
    {
        switch ($type) {
            case 'booked':
                return [
                    'select' =>"
                        b.*,
                        r.institutionId as institutionId,
                        r.title as title,
                        i.name as institutionName,
                        i.address as address
                    ",
                    'join' => " as b
                        INNER JOIN rooms r
                        ON b.roomId = r.id
                        INNER JOIN institutions i
                        ON r.institutionId = i.id
                    "
                ];
            default:
                return [
                    'select' => "
                        r.*,
                        i.name as institutionName,
                        i.address as address,
                        i.city as city
                    ",
                    'join' => " as r
                        INNER JOIN institutions i
                        ON r.institutionId = i.id
                    "
                ];
        }
    }

    public static function all ()
    {
        $statement = static::statement();

        $datas = static::find($statement, null, true);

        if ($datas) {
        foreach ($datas as $data):
            $data->institutionName = TextTool::security($data->institutionName, 'decode');
            $data->city = TextTool::security($data->city, 'decode');
            $data->address = TextTool::security($data->address, 'decode');
            $data->description = TextTool::security($data->description, 'decode');
            $data->title = TextTool::security($data->title, 'decode'); 
            $data->link = TextTool::security($data->link, 'decode');  
        endforeach;
        }

        return $datas;
    }

    public static function getRoom ($id)
    {
        $statement = static::statement();
        $statement['where'] = 'r.id = ?';
        $statement['att'] = $id;
        
        $datas = static::find($statement);

        if ($datas) {
            $datas->institutionName = TextTool::security($datas->institutionName, 'decode');
            $datas->city = TextTool::security($datas->city, 'decode');
            $datas->address = TextTool::security($datas->address, 'decode');
            $datas->description = TextTool::security($datas->description, 'decode');
            $datas->title = TextTool::security($datas->title, 'decode'); 
            $datas->link = TextTool::security($datas->link, 'decode');  
        }

        return $datas;
    }

    public static function byInstitution ($id)
    {
        $statement = static::statement();
        $statement['where'] = 'r.institutionId = ?';
        $statement['att'] = $id;

        $datas = static::find($statement, null, true);

        if ($datas) {
        foreach ($datas as $data):
            $data->institutionName = TextTool::security($data->institutionName, 'decode');
            $data->city = TextTool::security($data->city, 'decode');
            $data->address = TextTool::security($data->address, 'decode');
            $data->description = TextTool::security($data->description, 'decode');
            $data->title = TextTool::security($data->title, 'decode'); 
            $data->link = TextTool::security($data->link, 'decode');  
        endforeach;
        }

        return $datas;
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
        $statement = self::statement('booked');

        $datas = static::find($statement, '_booked', true);

        if ($datas) {
        foreach ($datas as $data):
            $data->institutionName = TextTool::security($data->institutionName, 'decode');
            $data->address = TextTool::security($data->address, 'decode');
            $data->title = TextTool::security($data->title, 'decode'); 
        endforeach;
        }

        return $datas;
    }

    public static function MyBooked ($id)
    {
        $statement = self::statement('booked');
        $statement['where'] = 'userId = ?';
        $statement['att'] = $id;

        $datas = static::find($statement, '_booked', true);

        if ($datas) {
        foreach ($datas as $data):
            $data->institutionName = TextTool::security($data->institutionName, 'decode');
            $data->address = TextTool::security($data->address, 'decode');
            $data->title = TextTool::security($data->title, 'decode'); 
        endforeach;
        }

        return $datas;
    }

    public static function getBooked ($id)
    {
        $statement = self::statement('booked');
        $statement['where'] = 'b.id = ?';
        $statement['att'] = $id;

        $datas = static::find($statement, '_booked');

        if ($datas) {
            $datas->institutionName = TextTool::security($datas->institutionName, 'decode');
            $datas->address = TextTool::security($datas->address, 'decode');
            $datas->title = TextTool::security($datas->title, 'decode'); 
        }

        return $datas;
    }
}
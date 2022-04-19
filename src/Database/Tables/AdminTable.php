<?php

namespace System\Database\Tables;

use System\Database\Tables;
use System\Database\Tables\UsersTable as Users;
use System\Database\Tables\InstitutionsTable as Institutions;
use System\Database\Tables\RoomsTable as Rooms;

class AdminTable extends Tables
{
    protected static $table = 'users';

    private static function statement ($join = true)
    {
        if ($join) return [
            'select' => "
                u.*,
                i.name as iName,
                i.id as iId
            ",
            'join' => " as u
                INNER JOIN institutions i
                ON u.id = i.managerId
            ",
            'where' => 'u.rank = 1'
        ];

        return [];
    }

    public static function all ()
    {
        $statement = self::statement();

        return static::find($statement, null, true);
    }

    public static function addMember ($email, $institutionId)
    {
        $userId = Users::getId($email);

        Users::generalEdit([
            'datas' => ['rank' => 1],
            'ids' => ['id' => $userId]
        ]);
        
        Institutions::generalEdit([
            'datas' => ['managerId' => $userId],
            'ids' => ['id' => $institutionId]
        ]);
    }

    public static function editMember ($email, $institutionId)
    {
        $userId = Users::getId($email);
        
        Institutions::generalEdit([
            'datas' => ['managerId' => NULL],
            'ids' => ['managerId' => $userId]
        ]);

        Institutions::generalEdit([
            'datas' => ['managerId' => $userId],
            'ids' => ['id' => $institutionId]
        ]);
    }

    public static function delMember ($email)
    {
        $userId = Users::getId($email);
        
        Institutions::generalEdit([
            'datas' => ['managerId' => NULL],
            'ids' => ['managerId' => $userId]
        ]);

        Users::generalEdit([
            'datas' => ['rank' => 0],
            'ids' => ['id' => $userId]
        ]);
    }

    public static function isUserExist ($email)
    {
        $statement = self::statement(false);
        $statement['where'] = 'rank = 1 AND email = ?';
        $statement['att'] = $email;
    
        return (static::find($statement)) ? true : false;
    }

    public static function isAdministrator ($email)
    {
        $statement = self::statement(false);
        $statement['where'] = 'rank = 2 AND email = ?';
        $statement['att'] = $email;
    
        return (static::find($statement)) ? true : false;
    }

    public static function roomsDelete ($id)
    {
        $datas = Rooms::byInstitution($id);
        if ($datas):
        foreach ($datas as $data):
            Rooms::delete([
                'where' => 'roomId = ?',
                'att' => [$data->id]
            ], '_booked');
            
            $deleteFront = static::deleteImg($data->imgFront);
            $deleteImages = static::deleteImg($data->images);

            if (is_int($deleteFront)) return $deleteFront;
            if (is_int($deleteImages)) return $deleteImages;
        endforeach;
        endif;

        Rooms::delete([
            'where' => 'institutionId = ?',
            'att' => [$id]
        ]);
    }
}
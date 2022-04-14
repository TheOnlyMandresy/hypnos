<?php

namespace System\Database\Tables;

use System\Database\Tables;
use System\Database\Tables\UsersTable as Users;
use System\Database\Tables\InstitutionsTable as Institutions;

class AdminTable extends Tables
{
    protected static $table = 'users';

    private static function statement ()
    {
        return [
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
    }

    public static function all ()
    {
        $statement = self::statement();

        $datas = static::find($statement, null, true);

        if ($datas) return $datas;
        return false;
    }

    public static function addMember ($email, $institutionId)
    {
        $userId = Users::getId($email);

        Users::generalEdit([
            'datas' => ['rank' => 1],
            'id' => $userId
        ]);
        
        Institutions::generalEdit([
            'datas' => ['managerId' => $userId],
            'id' => $institutionId
        ]);
    }
}
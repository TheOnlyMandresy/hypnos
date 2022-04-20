<?php

namespace System\Database\Tables;

use System;
use System\Database\Tables;
use System\Tools\DateTool;
use System\Tools\TextTool;

class SupportTable extends Tables
{
    protected static $table = 'support';

    private static function statement ()
    {
        return [];
    }

    public static function all ()
    {
        $statement = static::statement();

        $datas = static::find($statement, null, true);

        if ($datas) {
        foreach ($datas as $data):
            $data->title = TextTool::security($data->title, 'decode');
            $data->message = TextTool::security($data->message, 'decode');
            $data->dateCreate = DateTool::dateFormat($data->dateCreate, 'full');
        endforeach;
        }

        return $datas;
    }

    public static function getMyAll ($id)
    {
        $statement['where'] = 'userId = ?';
        $statement['att'] = $id;
        $datas = static::find($statement, null, true);

        if ($datas) {
            foreach ($datas as $data):
                $data->title = TextTool::security($data->title, 'decode');
                $data->message = TextTool::security($data->message, 'decode');
                $data->dateCreate = DateTool::dateFormat($data->dateCreate, 'full');

                $data->dateCreate = DateTool::dateFormat($data->dateCreate, 'full');
                $data->topic = System::getSystemInfos('support')[$data->topic];

                if (intval($data->state) === 0) $data->stateTxt = strtoupper('OUVERT');
                elseif (intval($data->state) === 1) $data->stateTxt = strtoupper('FERMER');
                elseif (intval($data->state) === 2) $data->stateTxt = strtoupper('EN ATTENTE DE REPONSE');
            endforeach;
        }

        return $datas;
    }

    public static function get ($id)
    {
        $statement['where'] = 'id = ?';
        $statement['att'] = $id;

        $ticket = static::find($statement);

        if ($ticket) {
            $ticket->title = TextTool::security($ticket->title, 'decode');
            $ticket->message = TextTool::security($ticket->message, 'decode');
            $ticket->dateCreate = DateTool::dateFormat($ticket->dateCreate, 'full');
            $ticket->dateCreate = DateTool::dateFormat($ticket->dateCreate, 'full');
            $ticket->topic = System::getSystemInfos('support')[$ticket->topic];
            if (intval($ticket->state) === 0) $ticket->stateTxt = strtoupper('OUVERT');
            elseif (intval($ticket->state) === 1) $ticket->stateTxt = strtoupper('FERMER');
            elseif (intval($ticket->state) === 2) $ticket->stateTxt = strtoupper('EN ATTENTE DE REPONSE');
        }

        $statement['select'] = "
            s.*,
            u.firstname as firstname,
            u.lastname as lastname
        ";
        $statement['join'] = " as s
            INNER JOIN users u
            ON s.userId = u.id
        ";
        $statement['order'] = 'id DESC';
        $statement['where'] = 'supportId = ?';
        $statement['att'] = $id;

        $messages = static::find($statement, '_messages', true);

        if ($messages) {
        foreach ($messages as $data):
            $data->message = TextTool::security($data->message, 'decode');
            $data->dateSend = DateTool::dateFormat($data->dateSend, 'full');
        endforeach;
        }
        $datas = [
            'infos' => $ticket,
            'messages' => ($messages) ? $messages : null
        ];

        return $datas;
    }

    public static function getMessage ($id)
    {
        $statement['where'] = 'id = ?';
        $statement['att'] = $id;

        $datas = static::find($statement, '_messages');

        if ($datas) $datas->message = TextTool::security($datas->message, 'decode');

        return $datas;
    }
}
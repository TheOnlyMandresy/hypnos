<?php

namespace System\Database;

use System;

/**
 * SQL requests
 */

class Tables
{
    protected static $table;

    /**
     * Translate datas to query or prepare request
     */
    private static function query ($statement, $attributes = null, $all = true)
    {
        if ($attributes) {
            return System::getDb()->prepare($statement, $attributes, get_called_class(), $all);
        } else {
            return System::getDb()->query($statement, get_called_class(), $all);
        }
    }

    /**
     * Update in a table
     * @param array $statement
     * @param string $underSection : Go to table's child
     */
    public static function update ($statement, $underSection = null)
    {
        $set = null;
        $count =  array_keys($statement['set']);
        $where = $statement['where'];
        $att = array_values($statement['att']);
        
        for ($i = 0; $i <= count($count) - 1; $i++) {
            if ($i === count($count) - 1) {
                $set .= $count[$i]. ' = ?';
            } else {
                $set .= $count[$i]. ' = ?, ';
            }
        }

        $statement = 'UPDATE ' .static::$table . $underSection. ' ';
        $statement .= 'SET ' .$set. ' ';
        $statement .= 'WHERE ' .$where;

        return (static::query($statement, $att)) ? true : false;
    }

    /**
     * Insert in a table
     * @param array $statement
     * @param string $underSection : Go to table's child
     */
    public static function insert ($statement, $underSection = null)
    {
        $insert = $statement['insert'];
        $att = array_values($statement['att']);
        $values = null;
        
        for ($i = 1; $i <= count($insert); $i++) {
            if ($i === count($insert)) {
                $values .= '?';
            } else {
                $values .= '?,';
            }
        }

        $insert = implode(', ', array_keys($statement['insert']));

        $statement = 'INSERT INTO ' .static::$table . $underSection. ' ';
        $statement .= '(' .$insert. ') ';
        $statement .= 'VALUES (' .$values. ')';

        return static::query($statement, $att);
    }

    /**
     * Delete in a table
     * @param array $statement
     * @param string $underSection : Go to table's child
     */
    public static function delete ($statement, $underSection = null)
    {
        $where = $statement['where'];
        $att = (is_array($statement['att']))? $statement['att'] : [$statement['att']];

        $statement = 'DELETE FROM ' .static::$table . $underSection. ' ';
        $statement .= 'WHERE ' .$where;

        return static::query($statement, $att);
    }

    /**
     * Get datas in a table
     * @param array $statement
     * @param string $underSection : Go to table's child
     * @param bool $all : Get all matching
     */
    public static function find ($datas = [], $underSection = null, $all = false)
    {
        $select = (isset($datas['select']))? 'SELECT ' .$datas['select']. ' ' : 'SELECT * ';
        $join = (isset($datas['join']))? $datas['join'] : null;
        $where = (isset($datas['where']))? ' WHERE ' .$datas['where'] : null;
        $att = (isset($datas['att']))? $datas['att']  : null;
        $order = (isset($datas['order']))? ' ORDER BY ' .$datas['order'] : null;
        
        $limit = null;
        if (isset($datas['limit'])) {
            $limit = ' LIMIT ' .$datas['limit']['start'];

            if (isset($datas['limit']['end'])) {
                $limit = ' LIMIT ' .$datas['limit']['start']. ', ' .$datas['limit']['end'];
            }
        }

        $statement = $select;
        $statement .= 'FROM ' .static::$table . $underSection . $join;
        $statement .= $where . $order . $limit;

        $attributes = null;
        if ($att !== null) $attributes = (!is_array($att)) ? [$att] : $att;

        $datas = static::query($statement, $attributes, $all);

        return ($datas) ? $datas : false;
    }

    /**
     * Add datas in a table
     * @param array $statement
     * @param string $underSection : Go to table's child
     */
    public static function generalAdd ($datas, $underSection = null)
    {
        $statement = [
            'insert' => $datas,
            'att' => $datas
        ];

        return static::insert($statement, $underSection);
    }

    /**
     * Edit datas in a table
     * @param array $statement
     * @param string $underSection : Go to table's child
     */
    public static function generalEdit ($datas, $underSection = null)
    {
        $att = $datas['datas'];
        $where = null;

        foreach ($datas['ids'] as $key => $value) {
            $and = ($key === array_key_last($datas['ids'])) ? null : ' AND ';
            $where .= $key . ' = ?' . $and;

            if (array_key_exists($key, $att)) {
                $key .= uniqid();
                $att['2'] = $value;
                continue;
            }
            $att['2'] = $value;
        }

        $statement = [
            'set' => $datas['datas'],
            'where' => $where,
            'att' => $att
        ];

        return static::update($statement, $underSection);
    }

    public static function generalDelete ($id, $underSection = null)
    {
        $statement = [
            'where' => 'id = ?',
            'att' => [$id]
        ];

        return static::delete($statement, $underSection);
    }

    /**
     * 
     */
    public static function generalImage ($file)
    {
        if (empty($file['name'][0])) { return 17; }

        $target_dir = System::root(2) . 'public' .System::getSystemInfos('img_room'). '/';
        
        if (count($file['name']) > 1) {
            $names = null;
            for ($i = 0; $i < count($file['name']); $i++) {                   

                $name = uniqid() . basename($file['name'][$i]);
                
                $target_file = $target_dir . $name;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $check = getimagesize($file['tmp_name'][$i]);

                if ($check !== false) {
                    if ($file['size'][$i] > 500000) return 14;
                    if($imageFileType != 'png' && $imageFileType != 'jpeg') return 15;
                    if (move_uploaded_file($file['tmp_name'][$i], $target_file)) {
                        $names .= $name;
                        if ($i !== count($file['name']) - 1) $names .=  ',';
                    }
                    else return 16;
                } else return 17;

            }
            return $names;
        }
        
        $name = uniqid() . basename($file['name'][0]);

        $target_file = $target_dir . $name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($file['tmp_name'][0]);

        if ($check !== false) {
            if ($file['size'][0] > 500000) return 14;
            if($imageFileType != 'png' && $imageFileType != 'jpeg') return 15;
            if (move_uploaded_file($file['tmp_name'][0], $target_file)) return $name;
            else return 16;
        } else return 17;
<<<<<<< HEAD
    }

    public static function deleteImg ($img)
    {
        $target_dir = System::root(2) . 'public' .System::getSystemInfos('img_room'). '/';
        $path = $target_dir . $img;
        if (str_contains($img, ',')) $img = explode(',', $img);

        if (is_array($img)):
            for ($i = 0; $i < count($img); $i++) {
                $path = $target_dir . $img[$i];
                if (file_exists($path)) unlink($path);
                else return 21;
            }
        else:
            if (file_exists($path)) unlink($path);
            else return 21;
        endif;
=======
>>>>>>> 47c4b2edc51af249e7ea62d3ac2bd61c2f1ed01c
    }

    /**
     * Get all datas in a table
     */
    public static function all ()
    {
        $statement = "
            SELECT *
            FROM " .static::$table. "
            ORDER BY id DESC
        ";

        return static::query($statement);
    }

    /**
     * Get last id registered
     */
    public static function lastId ()
    {
        return System::getDb()->lastId();
    }
}
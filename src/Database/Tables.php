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

        return static::query($statement, $att);
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
        if ($att !== null) {
            $attributes = [$att];

            if (is_array($att)) {
                $attributes = $att;
            }
        }

        return static::query($statement, $attributes, $all);
    }

    /**
     * Get datas in a table
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

    public static function generalEdit ($datas, $underSection = null)
    {
        $where = 'id = ?';
        $att = $datas['datas'];
        
        (isset($datas['id']))? $att['id'] = $datas['id'] : null;

        if (isset($datas['ids'])) {
            $where = null;

            foreach ($datas['ids'] as $key => $data) {
                if ($key === array_key_last($datas['ids'])) {
                    $where .= $key. ' = ?';
                } else {
                    $where .= $key. ' = ? AND ';
                }
                $att[$key] .= $data;
            }
        }

        $statement = [
            'set' => $datas['datas'],
            'where' =>$where,
            'att' => $att
        ];

        $datas = static::update($statement, $underSection);
        
        if ($datas) return true;
        return false;
    }

    public static function generalDelete ($id, $underSection = null)
    {
        $statement = [
            'where' => 'id = ?',
            'att' => [$id]
        ];

        return static::delete($statement, $underSection);
    }

    //
    //
    // URL ISSUE
    //
    public static function generalImage ($file)
    {
        if (empty($_FILES['image']['name'][0])) { return null; }
        
        $target_dir = System::root(3) . "public" .static::$urlBackground;
        $name = uniqid() . basename($file["image"]["name"]);

        $target_file = $target_dir . $name;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $check = getimagesize($file["image"]["tmp_name"]);

        if($check !== false) {
            if ($file["image"]["size"] > 500000) {
                // Trop volumineux
                return 'error-2';
            }

            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                // only JPG, JPEG, PNG & GIF
                return 'error-3';
            }

            if (move_uploaded_file($file["image"]["tmp_name"], $target_file)) {
                return $name;
            } else {
                // error uploading your file.
                return 'error-4';
            }
        } else {
            // Ce n'est pas une image
            return 'error-1';
        }
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
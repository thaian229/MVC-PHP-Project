<?php

require_once 'dao/base_dao.php';

class Categories extends BaseDAO
{
    static function all()
    {
        $list = [];

        self::requireModel('Category');

        $db = DB::getInstance();
        $req = $db->query(
            'SELECT * FROM `categories`'
        );

        foreach ($req->fetchAll() as $item) {
            $list[] = Category::createFromDB($item);
        }

        return $list;
    }

    static function find($id)
    {
        self::requireModel('Category');

        $db = DB::getInstance();
        $req = $db->prepare(
            'SELECT * FROM `categories` 
            WHERE id = :id'
        );
        $req->execute(array(
            'id' => $id
        ));

        $item = $req->fetch();
        if (isset($item['id'])) {
            return Category::createFromDB($item);
        }
        return null;
    }

    static function add($name)
    {
        $db = DB::getInstance();
        $req = $db->prepare(
            'INSERT INTO `categories` (`id`, `name`) 
            VALUES (NULL, :name)'
        );
        $status = $req->execute(array(
            'name' => $name
        ));

        if (!$status)
        {
            // Notify error
            return -1;
        }
        else
        {
            return self::find($db->lastInsertId());
        }
    }
}
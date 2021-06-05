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

    static function getCategoriesOfVideo($video_id)
    {
        self::requireModel('Category');

        $list = [];
        $db = DB::getInstance();

        $req = $db->prepare(
            'SELECT c.id, c.name FROM categories as c
            INNER JOIN videos_categories as vc ON c.id = vc.cat_id
            INNER JOIN videos as v ON vc.video_id = v.id
            WHERE v.id = :video_id'
        );
        $status = $req->execute(array(
            'video_id' => $video_id
        ));

        if (!$status)
        {
            // Notify error
            return null;
        }
        else
        {
            foreach ($req->fetchAll() as $item) {
                $list[] = Category::createFromDB($item);
            }
            return $list;
        }
    }

    static function removeAllCategoriesOfVideo($video_id)
    {
        $db = DB::getInstance();

        $req = $db->prepare(
            'DELETE FROM `videos_categories` 
            WHERE `videos_categories`.`video_id` = :video_id'
        );
        $status = $req->execute(array(
            'video_id' => $video_id
        ));

        if (!$status)
        {
            // Notify error
            return -1;
        }
        else
        {
            return $video_id;
        }
    }

    static function addCategoryToVideo($video_id, $cat_id)
    {
        $db = DB::getInstance();

        $req = $db->prepare(
            'INSERT INTO `videos_categories` (`video_id`, `cat_id`) 
            VALUES (:video_id, :cat_id)'
        );
        $status = $req->execute(array(
            'video_id' => $video_id,
            'cat_id' => $cat_id
        ));

        if (!$status)
        {
            // Notify error
            return -1;
        }
        else
        {
            return $video_id;
        }
    }
}
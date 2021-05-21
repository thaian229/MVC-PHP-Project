<?php
require_once 'dao/base_dao.php';

class Videos extends BaseDAO
{
    // Browse videos with pagination (page start from 1):
    static function browseVideosWithPagination($page) 
    {
        $tableName = 'videos';
        $startPagination = ($page - 1)  * 8;
        $list = [];
        
        self::requireModel('video');

        $db = DB::getInstance();
        $req = null;
        $req = $db->query(
            'SELECT * FROM ' . $tableName . 
            ' LIMIT ' . $startPagination . ', 8'
        );
        
        foreach ($req->fetchAll() as $item)
        {
            $list[] = Video::createFromDB($item);
        }
        return $list;
    }

    // Search for videos by title with pagination:
    static function searchVideosByTitle($key, $page)
    {
        $tableName = 'videos';
        $startPagination = ($page - 1)  * 8;
        $list = [];
        
        self::requireModel('video');

        $db = DB::getInstance();
        $req = $db->query(
            'SELECT * FROM ' . $tableName .
            ' WHERE title LIKE \'%' . $key . '%\'' .
            ' LIMIT ' . $startPagination . ', 8'
        );
        
        foreach ($req->fetchAll() as $item)
        {
            $list[] = Video::createFromDB($item);
        }
        return $list;
    }

    // Get videos by category:
    static function browseVideosByCategory($category, $page)
    {
        $startPagination = ($page - 1)  * 8;
        $list = [];
        
        self::requireModel('video');

        $db = DB::getInstance();
        $req = $db->query(
            'SELECT v.id, v.title, v.video_url, v.thumbnail_url, v.created_time, v.views, v.upvotes, v.downvotes 
            FROM videos as v 
            INNER JOIN videos_categories as vc 
            ON v.id = vc.video_id 
            INNER JOIN categories as c 
            ON vc.cat_id = c.id 
            WHERE c.name LIKE \'%' . $category . '%\' LIMIT ' . $startPagination . ', 8'
        );

        foreach ($req->fetchAll() as $item)
        {
            $list[] = Video::createFromDB($item);
        }
        return $list;
    }

    // Get favourite video:
    static function browseFavouriteVideos($user_id, $page)
    {
        $startPagination = ($page - 1)  * 8;
        $list = [];
        
        self::requireModel('video');

        $db = DB::getInstance();
        $req = $db->prepare(
            'SELECT v.id, v.title, v.video_url, v.thumbnail_url, v.created_time, v.views, v.upvotes, v.downvotes
            FROM favourites as f 
            INNER JOIN videos as v 
            ON f.video_id = v.id
            WHERE f.acc_id = :user_id 
            LIMIT ' . $startPagination . ', 8'
        );
        $req->execute(array('user_id' => $user_id));

        foreach ($req->fetchAll() as $item)
        {
            $list[] = Video::createFromDB($item);
        }
        return $list;
    }
}
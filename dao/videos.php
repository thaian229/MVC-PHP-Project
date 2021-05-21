<?php
require_once 'dao/base_dao.php';

class Videos extends BaseDAO
{
    // Upload new video
    static function uploadVideo($title, $videoUrl, $thumbnailUrl = '')
    {
        self::requireModel('video');
        
        $db = DB::getInstance();
        
        $req = $db->prepare(
            'INSERT INTO `videos` (`id`, `title`, `video_url`, `thumbnail_url`, `created_time`, `views`, `upvotes`, `downvotes`) 
            VALUES (NULL, :title, :video_url, :thumbnail_url, current_timestamp(), \'0\', \'0\', \'0\')'
        );
        $req->execute(array(
            'title' => $title,
            'video_url' => $videoUrl,
            'thumbnail_url' => $thumbnailUrl
        ));

        if (!$db->lastInsertId())
        {
            // Notify error
        }

        return $db->lastInsertId();
    }

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

    // Check if a video has already in fav list of a user
    static function isVideoInFavourite($video_id, $user_id)
    {
        $db = DB::getInstance();
        $req = $db->prepare(
            'SELECT * FROM favourites as f
            WHERE f.acc_id = :acc_id AND f.video_id = :video_id'
        );
        $req->execute(array(
            'acc_id' => $user_id,
            'video_id' => $video_id
        ));

        $rs = $req->fetch();
        if ($rs['acc_id'] != null)
        {
            return true;
        }
        return false;
    }

    // Add vid to fav list
    static function addVideosToFavourite($video_id, $user_id)
    {
        if (self::isVideoInFavourite($video_id, $user_id))
        {
            // Notify error
            return null;
        }
        $db = DB::getInstance();
        $req = $db->prepare(
            'INSERT INTO \`favourites\` (\`acc_id\`, \`video_id\`) 
            VALUES (:acc_id, :video_id)'
        );
        $req->execute(array(
            'acc_id' => $user_id,
            'video_id' => $video_id
        ));
    }

    // Remove vid from fav list
    static function removeVideosFromFavourite($video_id, $user_id)
    {
        if (!self::isVideoInFavourite($video_id, $user_id))
        {
            // Notify error
            return null;
        }
        $db = DB::getInstance();
        $req = $db->prepare(
            'DELETE FROM favourites 
            WHERE acc_id = :acc_id AND video_id = :video_id '
        );
        $req->execute(array(
            'acc_id' => $user_id,
            'video_id' => $video_id
        ));
    }
}
<?php

require_once 'dao/base_dao.php';

class Videos extends BaseDAO
{
    // Upload new video
    static function uploadVideo($title, $videoUrl, $thumbnailUrl = '')
    {
        self::requireModel('Video');
        
        $db = DB::getInstance();
        
        $req = $db->prepare(
            'INSERT INTO `videos` (`id`, `title`, `video_url`, `thumbnail_url`, `created_time`, `views`, `upvotes`, `downvotes`) 
            VALUES (NULL, :title, :video_url, :thumbnail_url, current_timestamp(), \'0\', \'0\', \'0\')'
        );
        $status = $req->execute(array(
            'title' => $title,
            'video_url' => $videoUrl,
            'thumbnail_url' => $thumbnailUrl
        ));

        if (!$status)
        {
            // Notify error
            return -1;
        }

        return $db->lastInsertId();
    }

    // Update video
    static function updateVideo($video_id, $title, $videoUrl, $thumbnailUrl)
    {
        self::requireModel('Video');

        $db = DB::getInstance();
        
        $req = $db->prepare(
            'UPDATE `videos` 
            SET `title` = :title, `video_url` = :video_url, `thumbnail_url` = :thumbnail_url, `created_time` = current_timestamp() 
            WHERE `videos`.`id` = :video_id'
        );
        $status = $req->execute(array(
            'title' => $title,
            'video_url' => $videoUrl,
            'thumbnail_url' => $thumbnailUrl,
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

    // Count total number of videos (for pagination)
    static function countVideos()
    {
        $db = DB::getInstance();

        $req = $db->query('
            SELECT COUNT(*) as `videos_count` FROM videos
        ');

        if (!$req)
        {
            // Notify error
            return -1;
        }
        else
        {
            $count = $req->fetch()[0];
            return $count;
        }
    }

    static function countVideosByCategory($category)
    {
        $db = DB::getInstance();

        $category = '\%' . $category . '\%';

        $req = $db->prepare('
            SELECT COUNT(*) as `videos_count`
            FROM videos as v 
            INNER JOIN videos_categories as vc 
            ON v.id = vc.video_id 
            INNER JOIN categories as c 
            ON vc.cat_id = c.id 
            WHERE c.name LIKE :category
        ');

        $req->execute(array(
            'category' => $category,
        ));

        if (!$req)
        {
            // Notify ercountror
            return 0;
        }
        else
        {
            $count = $req->fetch()[0];
            return $count;
        }
    }

    static function countVideosByFavourite($userId)
    {
        $db = DB::getInstance();

        $req = $db->prepare(
            'SELECT COUNT(*) as `videos_count `FROM favourites as f
            WHERE f.acc_id = :acc_id'
        );

        $req->execute(array(
            'acc_id' => $userId,
        ));

        if (!$req)
        {
            // Notify ercountror
            return 0;
        }
        else
        {
            $count = $req->fetch()[0];
            return $count;
        }
    }

    // Browse videos with pagination (page start from 1):
    static function browseVideosWithPagination($page) 
    {
        $tableName = 'videos';
        $startPagination = ($page - 1)  * 8;
        $list = [];
        
        self::requireModel('Video');

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
        
        self::requireModel('Video');

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

    // Search for videos by title without pagination:
    static function searchVideosByTitleNoPagination($key)
    {
        $tableName = 'videos';
        $list = [];
        
        self::requireModel('Video');

        $db = DB::getInstance();
        $req = $db->query(
            'SELECT * FROM ' . $tableName .
            ' WHERE title LIKE \'%' . $key . '%\''
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
        
        self::requireModel('Video');

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
        
        self::requireModel('Video');

        $db = DB::getInstance();
        $req = $db->prepare(
            'SELECT v.id, v.title, v.video_url, v.thumbnail_url, v.created_time, v.views, v.upvotes, v.downvotes
            FROM favourites as f 
            INNER JOIN videos as v 
            ON f.video_id = v.id
            WHERE f.acc_id = :user_id 
            LIMIT ' . $startPagination . ', 8'
        );
        $req->execute(array(
            'user_id' => $user_id
        ));

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
        if ($rs != null)
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
            return -1;
        }
        $db = DB::getInstance();
        $req = $db->prepare(
            'INSERT INTO `favourites` (`acc_id`, `video_id`) 
            VALUES (:acc_id, :video_id)'
        );
        $status = $req->execute(array(
            'acc_id' => $user_id,
            'video_id' => $video_id
        ));

        if (!$status)
        {
            // Notify error
            return -1;
        }

        return $video_id;
    }

    // Remove vid from fav list
    static function removeVideosFromFavourite($video_id, $user_id)
    {
        if (!self::isVideoInFavourite($video_id, $user_id))
        {
            // Notify error
            return -1;
        }
        $db = DB::getInstance();
        $req = $db->prepare(
            'DELETE FROM favourites 
            WHERE acc_id = :acc_id AND video_id = :video_id '
        );
        $status = $req->execute(array(
            'acc_id' => $user_id,
            'video_id' => $video_id
        ));

        if (!$status)
        {
            // Notify error
            return -1;
        }
        return $video_id;
    }

    // Increase Views of a video
    static function increaseView($video_id)
    {
        $db = DB::getInstance();
        $req = $db->prepare(
            'UPDATE `videos` SET `views` = `views` + 1 
            WHERE `videos`.`id` = :video_id'
        );
        $status = $req->execute(array(
            'video_id' => $video_id
        ));

        if (!$status)
        {
            // Notify error
            return -1;
        }
        return $video_id;
    }
}
<?php

require_once 'dao/base_dao.php';

class Comments extends BaseDAO 
{
    static function addCommentToVideo($acc_id, $video_id, $content)
    {
        self::requireModel('Comment');
        
        $db = DB::getInstance();
        
        $req = $db->prepare(
            'INSERT INTO `comments` (`id`, `acc_id`, `video_id`, `contents`, `created_time`) 
            VALUES (NULL, :acc_id, :video_id, :content, current_timestamp())'
        );
        $status = $req->execute(array(
            'acc_id' => $acc_id,
            'video_id' => $video_id,
            'content' => $content
        ));

        if (!$status)
        {
            // Notify error
            return -1;
        }

        return $db->lastInsertId();
    }

    static function getCommentsInVideo($video_id)
    {
        $list = [];
        
        self::requireModel('Video');

        $db = DB::getInstance();
        $req = null;
        $req = $db->prepare(
            'SELECT c.id, c.acc_id, a.username, a.ava_url, c.video_id, c.contents FROM comments as c 
            INNER JOIN accounts as a ON c.acc_id = a.id 
            WHERE c.video_id = :video_id'
        );
        $req->execute(array(
            'video_id' => $video_id
        ));
        
        foreach ($req->fetchAll() as $item)
        {
            $list[] = Comment::createFromDB($item);
        }
        return $list;
    }
}
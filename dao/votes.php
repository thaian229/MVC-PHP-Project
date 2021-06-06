<?php

require_once 'dao/base_dao.php';
require_once 'dao/videos.php';

class Votes extends BaseDAO 
{
    static function getVotedTypeVideo($acc_id, $video_id)
    {
        $db = DB::getInstance();
        $req = $db->prepare(
            'SELECT * FROM votes as f
            WHERE f.acc_id = :acc_id AND f.video_id = :video_id'
        );
        $req->execute(array(
            'acc_id' => $acc_id,
            'video_id' => $video_id
        ));

        $rs = $req->fetch();
        if ($rs != null)
        {
            return $rs['vote_type'];
        }
        // not voted
        return -1;
    }

    // Upvote --> 1, Downvote --> 0
    static function voteVideo($acc_id, $video_id, $vote_type)
    {
        if ($vote_type != 0 && $vote_type != 1) 
        {
            return false;
        }
        
        $current_vote_type = self::getVotedTypeVideo($acc_id, $video_id);

        if ($current_vote_type != -1)
        {
            self::removeVoteVideo($acc_id, $video_id);
            // case unvote:
            if ($current_vote_type == $vote_type)
            {
                return true;
            }
        }
        
        // case switch vote:
        
        $db = DB::getInstance();
        $req = $db->prepare(
            'INSERT INTO `votes` (`acc_id`, `video_id`, `vote_type`) 
            VALUES (:acc_id, :video_id, :vote_type)'
        );
        $status = $req->execute(array(
            'acc_id' => $acc_id,
            'video_id' => $video_id,
            'vote_type' => $vote_type
        ));

        if (!$status)
        {
            return false;
        }

        if ($vote_type == 1)
        {
            self::changeUpvote($video_id, true);
        }
        elseif ($vote_type == 0)
        {
            self::changeDownvote($video_id, true);
        }

        return true;
    }

    static function removeVoteVideo($acc_id, $video_id)
    {
        $vote_type = self::getVotedTypeVideo($acc_id, $video_id);
        if ($vote_type == -1)
        {
            return null;
        }

        $db = DB::getInstance();
        $req = $db->prepare(
            'DELETE FROM `votes` 
            WHERE `votes`.`acc_id` = :acc_id AND `votes`.`video_id` = :video_id'
        );
        $status = $req->execute(array(
            'acc_id' => $acc_id,
            'video_id' => $video_id
        ));

        if (!$status)
        {
            return null;
        }

        if ($vote_type == 1)
        {
            self::changeUpvote($video_id, false);
        }
        elseif ($vote_type == 0)
        {
            self::changeDownvote($video_id, false);
        }
    }

    static function changeUpvote($video_id, $is_increase)
    {
        $inc = 0;
        if ($is_increase) 
        {
            $inc = 1;
        }
        else 
        {
            $inc = -1;
        }
        $db = DB::getInstance();
        $req = $db->prepare(
            'UPDATE `videos` 
            SET `upvotes` = `upvotes` + :inc 
            WHERE `videos`.`id` = :video_id'
        );
        $req->execute(array(
            'video_id' => $video_id,
            'inc' => $inc
        )); 
    }

    static function changeDownvote($video_id, $is_increase)
    {
        $inc = 0;
        if ($is_increase) 
        {
            $inc = 1;
        }
        else 
        {
            $inc = -1;
        }
        $db = DB::getInstance();
        $req = $db->prepare(
            'UPDATE `videos` 
            SET `downvotes` = `downvotes` + :inc 
            WHERE `videos`.`id` = :video_id'
        );
        $req->execute(array(
            'video_id' => $video_id,
            'inc' => $inc
        ));
    }

    // Recalculate downvotes and upvotes of all videos
    static function syncVote()
    {
        $db = DB::getInstance();
        $status = $db->query(
            'UPDATE videos as vd
            SET vd.upvotes = (
                SELECT COUNT(*) FROM votes as v1
                WHERE v1.video_id = vd.id AND v1.vote_type = 1
            ), vd.downvotes = (
                SELECT COUNT(*) FROM votes as v2 
                WHERE v2.video_id = vd.id AND v2.vote_type = 0
            )'
        );

        if (!$status)
        {
            // Notify error
            return -1;
        }
        return 1;
    }
}
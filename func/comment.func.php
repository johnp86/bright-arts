<?php
//add a comment to a selected album
    function create_comment($album_id, $comment){
        $album_id = (int)$album_id;
        $comment = mysql_real_escape_string($comment);

        mysql_query("INSERT INTO comments (album_id, user_id, comment, timestamp) VALUES ($album_id, ".  $_SESSION['user_id'] .", '$comment', UNIX_TIMESTAMP()) ");
        
    }
//show comments on a specific album
    function view_comments($album_id){
        $album_id = (int)$album_id;
        $comments = array();
        $query = mysql_query("SELECT * FROM comments WHERE album_id = $album_id");

        while($comment_row = mysql_fetch_assoc($query)){
            $comments[] = array(
                'id' => $comment_row['comment_id'],
                'user_id' => $comment_row['user_id'],
                'comment' => $comment_row['comment'],
                'timestamp' => $comment_row['timestamp']
            );
        }
        return $comments;
    }
//logged in user can delete album
    function delete_comment($comment_id){
        $comment_id = (int)$comment_id;

        mysql_query("DELETE FROM comments WHERE comment_id = $comment_id");
    }

?>

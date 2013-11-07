<?php
/*top 2 functions are security checks
 * The first one checks if the image actually exists and someone is not creating a false like
 */

    function image_exists($image_id){
        //image_id is modifiaby users by using firebug and source code checkers
        //casting variable into a integer, if an SQL injection is being attempted it will change that value to an integer
        $image_id = (int)$image_id;
        //if statement on one line, returning true or false
        return (mysql_result(mysql_query("SELECT COUNT(image_id) FROM images WHERE image_id=$image_id"), 0) == 0)?false : true;
    }
        //return the number of likes for an image by the logged in user
        //if the response is 0 then they can continue with the like
    function previously_liked($image_id){
        $image_id = (int)$image_id;
        return (mysql_result(mysql_query("SELECT COUNT(like_id) FROM likes WHERE user_id = ". $_SESSION['user_id'] ." AND image_id = $image_id"), 0) == 0)?false : true;
    }

    function like_count($image_id){
        $image_id = (int)$image_id;
        return (int)mysql_result(mysql_query("SELECT image_likes FROM images WHERE image_id=$image_id"), 0, 'image_likes');
    }

    function add_like($image_id){
        $image_id = (int)$image_id;
        //add one to selected image likes
        mysql_query("UPDATE images SET image_likes = image_likes + 1 WHERE image_id = $image_id");
        mysql_query("INSERT INTO likes (user_id, image_id) VALUES (". $_SESSION['user_id'] .", $image_id)");
    }

?>

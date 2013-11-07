<?php
//upload cover image for an album
function upload_cover_image($image_temp, $image_ext, $album_id){
    $album_id = (int)$album_id;
    mysql_query("INSERT INTO `images` (user_id, album_id, timestamp, ext, cover_image, image_likes) VALUES (". $_SESSION['user_id'] .",$album_id, UNIX_TIMESTAMP(),'$image_ext', 1, 0)");
    $image_id = mysql_insert_id();
    $image_file = $image_id.'.'.$image_ext;
    
    move_uploaded_file($image_temp, 'uploads/' . $album_id . '/' . $image_file);
    
    //create different sizes for that image
    create_cover('uploads/' . $album_id . '/', $image_file, 'uploads/cover_images/' . $album_id . '/');
    create_thumb('uploads/' . $album_id . '/', $image_file, 'uploads/thumbs/' . $album_id . '/');
    create_small_thumb('uploads/' . $album_id . '/', $image_file, 'uploads/small_thumbs/' . $album_id . '/');
}

//upload images to an album
function upload_image($image_temp, $image_ext, $album_id){
    $album_id = (int)$album_id;
    mysql_query("INSERT INTO `images` (user_id, album_id, timestamp, ext, cover_image, image_likes) VALUES (". $_SESSION['user_id'] .",$album_id,UNIX_TIMESTAMP(),'$image_ext', 0, 0)");
    $image_id = mysql_insert_id();
    $image_file = $image_id.'.'.$image_ext;
    //move file into a specific folder
    move_uploaded_file($image_temp, 'uploads/' . $album_id . '/' . $image_file);
    //create a thumb nail for that image
    create_cover('uploads/' . $album_id . '/', $image_file, 'uploads/cover_images/' . $album_id . '/');
    create_thumb('uploads/' . $album_id . '/', $image_file, 'uploads/thumbs/' . $album_id . '/');
    create_small_thumb('uploads/' . $album_id . '/', $image_file, 'uploads/small_thumbs/' . $album_id . '/');
}

//return the image data for images that belong to the logged in user
function get_images($album_id){
    $album_id = (int)$album_id;
    $images = array();
    
    $image_query = mysql_query("SELECT image_id, album_id, timestamp, ext FROM images WHERE album_id = $album_id AND user_id = " . $_SESSION['user_id']);
    while($images_row = mysql_fetch_assoc($image_query)){
        $images[] = array(
            'id' => $images_row['image_id'],
            'album' => $images_row['album_id'],
            'timestamp' => $images_row['timestamp'],
            'ext' => $images_row['ext']
        );
    }  
    return $images;
}

//get images for a specific album
function get_album_images($album_id){
    $album_id = (int)$album_id;
    $images = array();
    //check the image is not the cover image
    $image_query = mysql_query("SELECT image_id, album_id, timestamp, ext FROM images WHERE album_id =" . $album_id ." AND cover_image = 0");
    while($images_row = mysql_fetch_assoc($image_query)){
        $images[] = array(
            'id' => $images_row['image_id'],
            'album' => $images_row['album_id'],
            'timestamp' => $images_row['timestamp'],
            'ext' => $images_row['ext']
        );
    }
    return $images;
}

//get cover images for a specific album
function get_cover_images($album_id){
    $album_id = (int)$album_id;
    $images = array();
    //check the image is not the cover image
    $image_query = mysql_query("SELECT image_id, album_id, timestamp, ext FROM images WHERE album_id =" . $album_id ." AND cover_image = 1");
    while($images_row = mysql_fetch_assoc($image_query)){
        $images[] = array(
            'id' => $images_row['image_id'],
            'album' => $images_row['album_id'],
            'timestamp' => $images_row['timestamp'],
            'ext' => $images_row['ext']
        );
    }
    return $images;
}

//shows xx amount of images on the home page
function get_all_images($page_num){
    $start_from = ($page_num-1) * 9;
    $query = mysql_query("SELECT * FROM images WHERE cover_image = 1 ORDER BY image_likes DESC LIMIT $start_from , 9");
    while($query_row = mysql_fetch_assoc($query)){
            $images[] = array(
                'id' => $query_row['image_id'],
                'album' => $query_row['album_id'],
                'timestamp' => $query_row['timestamp'],
                'ext' => $query_row['ext'],
                'likes' => $query_row['image_likes']
            );
        }
        return $images;
}

// check how many pages are required on the home page to hold all the images
function count_cover_image(){
    $query = mysql_query("SELECT COUNT(image_id) FROM images WHERE cover_image = 1");
    $row = mysql_fetch_row($query);
    $total_records = $row[0];
    $total_pages = ceil($total_records / 9);

    return $total_pages;
}

//check image belongs to logged in user
function image_check($image_id){
    $image_id = (int)$image_id;
    $query = mysql_query("SELECT COUNT(image_id) FROM images WHERE image_id = $image_id AND user_id =" . $_SESSION['user_id']);
    return (mysql_result($query, 0) == 0) ? false : true;
}

//user can delete an image
function delete_image($image_id){
    $image_id = (int)$image_id;
//check image belongs to logged in user and return the fields
    $image_query = mysql_query("SELECT album_id, ext FROM images WHERE image_id = $image_id AND user_id = ". $_SESSION['user_id']);
    $image_result = mysql_fetch_assoc($image_query);
    
    $album_id = $image_result['album_id'];
    $image_ext = $image_result['ext'];
//cdelete images from album
    unlink('uploads/' . $album_id . '/' . $image_id . '.' . $image_ext);
    unlink('uploads/thumbs/' . $album_id . '/' . $image_id . '.' . $image_ext);
//delete image information from the database
    mysql_query("DELETE FROM images WHERE image_id=$image_id AND user_id=" . $_SESSION['user_id']);
}
?>

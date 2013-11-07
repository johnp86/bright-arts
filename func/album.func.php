<?php
// create album by inserting the information into the database
function create_album($album_name, $album_description){
    //stops use of any html inputs
    $album_name = mysql_real_escape_string(htmlentities($album_name));
    $album_description = mysql_real_escape_string(htmlentities($album_description));   
    mysql_query("INSERT INTO `albums` (user_id, timestamp, name, description) VALUES ('" . $_SESSION['user_id'] . "', UNIX_TIMESTAMP(), '$album_name', '$album_description')");
    $insert_id = mysql_insert_id();
    //create folder in uploads folder
    mkdir('uploads/'.mysql_insert_id());
    mkdir('uploads/cover_images/'.mysql_insert_id());
    mkdir('uploads/small_thumbs/'.mysql_insert_id());
    mkdir('uploads/thumbs/'.mysql_insert_id());
    header("Location:edit_album.php?id=" . $insert_id);
}
// return the data on the passed in album
function album_data($album_id){
 $album_id = (int)$album_id;

 $args = func_get_args();
 unset($args[0]);
    $fields = '`' . implode('`, `',$args) . '`';

    $query = mysql_query("SELECT $fields FROM albums WHERE album_id = $album_id");
    $query_result = mysql_fetch_assoc($query);
    foreach ($args as $field){
        $args[$field] = $query_result[$field];
    }
    return $args;
}
// security check: return true or false if user able is owned by logged in user
function album_check($album_id){
    $album_id = (int)$album_id;
    $query = mysql_query("SELECT COUNT(album_id) FROM albums WHERE album_id = '$album_id' AND user_id = " . $_SESSION['user_id']);
    return (mysql_result($query, 0) == 1) ? true : false;
}
// return the albums of the logged in user
function get_albums(){
    $albums = array();
    
    $albums_query = mysql_query("
        SELECT albums . album_id, albums . timestamp, albums . name, albums . description, images . image_id
        FROM albums
        LEFT JOIN images
        ON albums . album_id = images . album_id
        WHERE albums . user_id = " . $_SESSION['user_id'] . "
        GROUP BY  albums . album_id   
    ");
 //fetch all the information on that album
    while ($albums_row = mysql_fetch_assoc($albums_query)){
        $albums[] = array(
            'id' => $albums_row['album_id'],
            'timestamp' => $albums_row['timestamp'],
            'name' => $albums_row['name'],
            'description' => $albums_row['description'],
            'count' => $albums_row['image_count']
        );
    }
    
    return $albums;
}
// return all the albums in the database, mainly for home pages
function get_all_albums(){
    $users = array();
    //return all users
    $all_users = get_users();
    foreach($all_users as $user){
        $query = mysql_query("SELECT album_id FROM albums WHERE user_id=" . $user['id'] );
        while($query_row = mysql_fetch_assoc($query)){
            $users[] = array(
              'id' => $query_row['album_id']
            );
        }
    }

    return $users;
}
//return albums for profile page
function get_profile_albums($user){
    $albums = array();

    $albums_query = mysql_query("
        SELECT albums . album_id, albums . timestamp, albums . name, albums . description, images . image_id
        FROM albums
        LEFT JOIN images
        ON albums . album_id = images . album_id
        WHERE albums . user_id = " . $user . "
        GROUP BY  albums . album_id
    ");
 //fetch all the information on that album
    while ($albums_row = mysql_fetch_assoc($albums_query)){
        $albums[] = array(
            'id' => $albums_row['album_id'],
            'timestamp' => $albums_row['timestamp'],
            'name' => $albums_row['name'],
            'description' => $albums_row['description']
        );
    }

    return $albums;
}
// change the information on a selected album
function edit_album($album_id, $album_name, $album_description){
    $album_id = (int)$album_id;
    $album_name = mysql_real_escape_string($album_name);
    $album_description = mysql_real_escape_string($album_description);
//album must relate to logged in user
    mysql_query("UPDATE albums SET name = '$album_name', description = '$album_description' WHERE album_id = '$album_id' AND user_id = " . $_SESSION['user_id']);
}
//if album belongs to the logged in user, they can delete an album
function delete_album($album_id){
    $album_id = (int)$album_id;
    mysql_query("DELETE FROM albums WHERE album_id = '$album_id' AND user_id = " . $_SESSION['user_id']);
    mysql_query("DELETE FROM images WHERE album_id = '$album_id' AND user_id = " . $_SESSION['user_id']);
}
?>

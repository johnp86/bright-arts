<?php
    include 'init.php';
    
    if(!isset($_GET['album_id']) || empty($_GET['album_id']) || album_check($_GET['album_id'])===false){
        header ("Location:profile.php");
        exit();
    }
    
    include 'template/header.php';

    $album_id = $_GET['album_id'];
    $album_data = album_data($album_id, 'name', 'description');
    
    echo '<h3>', $album_data['name'] ,'</h3> <p>', $album_data['description'] ,'</p>';


    $images = get_images($album_id);
    
    if(empty($images)){
        echo 'There are no images in this album';
    }
    else{
        foreach($images as $image){
            echo '<a href="uploads/', $image['album'],'/', $image['id'], '.', $image['ext'],'"><img src="uploads/thumbs/', $image['album'],'/', $image['id'], '.', $image['ext'], '" title="Uploaded ',date('D M Y / h:i',$image['timestamp']) ,'" /></a> <a href="delete_image.php?image_id=', $image['id'],'">[x]</a>';
        }
    }

    include 'template/footer.php';
?>
<?php
include '../init.php';
//check if user_id, user logged in and the image exists
if(isset($_POST['image_id'], $_SESSION['user_id'])&&  image_exists($_POST['image_id'])){
    // show the amount of likes for that image
    echo like_count($_POST['image_id']);
}
else{
    echo 'you need to be logged in';
}
?>

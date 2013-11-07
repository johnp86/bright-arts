<?php
include '../init.php';
//check if user_id, user logged in and the image exists
if(isset($_POST['image_id'], $_SESSION['user_id'])&&  image_exists($_POST['image_id'])){
    $image_id = $_POST['image_id'];

    //dont allow if previos clicked the like button
    if(previously_liked($image_id) === true){
        echo 'Youve already liked';
    }
    else{
    //if they havent liked, run add_liked function passing through the image id
        add_like($image_id);
        echo 'success';
    }
}
?>

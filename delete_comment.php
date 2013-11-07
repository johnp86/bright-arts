<?php
include 'init.php';


    if(!logged_in){
        header("Location:index.php");
        exit();
    }

    if(isset($_GET['comment_id'])){
        delete_comment($_GET['comment_id']);
        header("Location:" . $_SERVER['HTTP_REFERER']);
        exit();
    }

?>

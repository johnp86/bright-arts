<!-- This is the Home page. This page displays the first 12 cover images-->
<?php
include 'init.php';
include 'template/header.php';

if(logged_in()){
    echo 'Welcome Back! why not <a href="create_album.php">add a new project</a> or <a href="upload_image.php">edit a project</a>?<br />';
    $session_id = $_SESSION['user_id'];
}
else{

}

/* check if page is included in the url
 * If not add ?page=1 to the end of the url and call all the images
 */
if(isset($_GET['page'])){
    $page = $_GET['page'];
    $all_images = get_all_images($page);
}
else{
    $_GET['page'] = 1;
    $page = $_GET['page'];
    $all_images = get_all_images($page);
}

/* once the images are called. Loop through the images
 * the images and add them to the page */
foreach($all_images as $images){
    ?>
    <div class="mid_image">
    <?php
        echo '<a href="project.php?album_id=' . $images['album'] . '"><img src="uploads/thumbs/'. $images['album'] .'/'.$images['id']. '.' . $images['ext'] . ' " /></a>';

        $get_albums = album_data($images['album'], 'user_id');
        $user_id = $get_albums['user_id'];
        $user_data = show_user_data($user_id, 'name');
        $user_name = $user_data['name'];
        
        foreach($tags as $display_tags){
            echo '<h1>',$display_tags['id'],'</h1>';
        }
    ?>
        <div class="info_ribbon">
            <?php
                echo '<a href="profile.php?id='.$user_id.'" class="user_name"><h2>'. $user_name . '</h2></a>';
                echo '<a href="#" class="likes" onclick="like_add(', $images['id'] ,')">Likes: <span id="image_', $images['id'] ,'_likes">', $images['likes'] , '</span></a>';
            ?>
        </div>

    </div>
   
<?php
};
?>

<p class="clearfloat"></p>
<?php

    /*this is the next and previous buttons allowing the user to view the next/previous 12 images
     *Once the button is pressed it checks the url to see if 'page' is included
     *If not, set page to 1 and add one or subtract 1. If it is less than 1 do not display the previous button
     */
    $total_pages = count_cover_image();
    if($page < $total_pages){
        $next = $page + 1;
        echo '<a href="index.php?page='. $next .'" class="btn_input right">Next</a>';
    }
    if(isset($page) && $page > 1){
        $prev = $page - 1;
        echo '<a href="index.php?page='. $prev .'" class="btn_input right">Previous</a>';
    }

include 'template/footer.php';
?>
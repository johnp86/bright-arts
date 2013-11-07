<?php
    include 'init.php';
    include 'template/header.php';

    $user_id = $_GET['id'];
    $user_data = show_user_data($user_id, 'name', 'description', 'email', 'portfolio', 'twitter', 'facebook');
?>



<section class="profile_info">
    <div class="contact_details">
        <?php
            echo '<h1>', $user_data['name'], '</h1>';
            echo '<img src="images/profile_holder.gif" />';
            if(!empty($user_data['twitter'])){echo '<p><a href="https://twitter.com/', $user_data['twitter'], '">twitter</a></p>';}
            if(!empty($user_data['facebook'])){echo '<p><a href="http://www.facebook.com/', $user_data['facebook'], '">facebook</a></p>';}
            if(!empty($user_data['portfolio'])){echo '<p><a href="http://', $user_data['portfolio'], '">portfolio</a></p>';}
            if(!empty($user_data['google'])){echo '<p><a href="http://', $user_data['google'], '">google+</a></p>';}
            if(!empty($user_data['linkedin'])){echo '<p><a href="http://', $user_data['linkedin'], '">linkedin</a></p>';
    }
        ?>
    </div>
    <div class="about">
        <?php
            echo '<p>', $user_data['description'] , '</p>';
        ?>
    </div>
</section>

    <p class="clearfloat"></p>
<?php

if($user_id == $_SESSION['user_id']){
    echo '<a href="edit_profile.php" class="btn_input right">edit profile</a>';
    echo '<a href="create_album.php" class="btn_input right">+ add project</a>';
}

$albums = get_profile_albums($user_id);

if(empty($albums)){
    echo "<p>you have no albums</p>";
}
else{
    foreach($albums as $album){
        echo '<div class="project_image_container"><div class="info_container"><a href="project.php?album_id=' . $album['id'] . '"><h3>'. $album['name'] .'</h3></a>
                ' . $album['description'] . '</div>
                    <div class="profile_image_container">
            ';

        $cover_image = get_cover_images($album['id']);
        $album_images = get_album_images($album['id']);


        foreach($cover_image as $image){
            echo '<div class="album_cover"><a href="project.php?album_id=' . $album['id'] . '"><img src="uploads/thumbs/'. $image['album'] .'/'. $image['id'] . '.' . $image['ext'].'" class="mid_img left" /></a></div>';
        };
        foreach($album_images as $images){
            echo '<img src="uploads/thumbs/'. $images['album'] .'/'. $images['id'] . '.' . $images['ext'].'" class="small_image left" /></a>';
        };
            echo '<p class="clearfloat"></p>';
        if($user_id == $_SESSION['user_id']){
            echo '<p><a href="edit_album.php?album_id='.$album['id'].'">edit project</a> | <a href="project_in.php?album_id='.$album['id'].'">delete image</a> | <a href="delete_album.php?album_id='.$album['id'].'">remove album</a></p>';
        }
        echo '</div></div><p class="clearfloat"></p>';
    }
}

    include 'template/footer.php';
?>
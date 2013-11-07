<?php
    include 'init.php';
    include 'template/header.php';

    $user_id = $_GET['id'];
    $user_data = show_user_data($user_id, 'name', 'description');
?>



<section class="profile_info">
    <div class="contact_details">
        <?php
            echo '<h1>', $user_data['name'], '</h1>';
        ?>
        <a href="#"><img src="uploads/users/ben.jpg" class="userImage" alt="student1" style="width: 50px;"/></a>
        <h3>find me on: </h3>
        <form action="" method="POST">
            twitter: @BBint<br />
            facebook: iamBenBint<br />
            linkedin: Benjamin Bint<br />
            email: Benjamin@Bint.com<br />
        </form>
    </div>
    <div class="about">
        <?php

            echo '<p>', $user_data['description'] , '</p>';

        ?>
    </div>
    <p class="clearfloat"></p>
</section>
<?php

$albums = get_profile_albums($user_id);

if(empty($albums)){
    echo "<p>you have no albums</p>";
}
else{
    foreach($albums as $album){
        //echo '<div class="project_image_container"><div class="info_container"><a href="project.php?album_id=' . $album['id'] . '"><h3>'. $album['name'] .'</h3></a>, '. $album['count'] .' images<br />
        echo '<div class="project_image_container"><div class="info_container"><a href="project.php?album_id=' . $album['id'] . '"><h3>'. $album['name'] .'</h3></a>
                ' . $album['description'] . '</div>
                    <div class="profile_image_container">
            ';

        //$cover_image = get_cover_images($album['id']);
        $album_images = get_album_images($album['id']);


        /*foreach($cover_image as $image){
            echo '<div class="album_cover"><img src="uploads/thumbs/'. $image['album'] .'/'. $image['id'] . '.' . $image['ext'].'" /></div>';
        };*/
        foreach($album_images as $images){
            echo '<img src="uploads/thumbs/'. $images['album'] .'/'. $images['id'] . '.' . $images['ext'].'" class="small_image" />';
        };
        echo '</div></div><p class="clearfloat"></p>';
    }
}

    include 'template/footer.php';
?>
<?php
    include 'init.php';
    if(!logged_in()){
        header("Location:index.php");
        exit();
    }
    include 'template/header.php';
?>

<div id="edit_about">
        <a href="#"><img src="uploads/users/ben.jpg" class="userImage" alt="student1" /></a>
        <h2>About You</h2>
        <form>
            <textarea class="text_input" rows="8" cols="42">Top Cat! The most effectual Top Cat!Who's intellectual close friends get to call him T.C., providing it's with dignity. Top Cat!</textarea>
       </form>
        <p class="clearfloat"></p>
    </div>
    <div id="edit_contact">
        <h3>ways to contact you:</h3>
        <form action="" method="POST">
            edit:<br>
            twitter: <input type="text" class="text_input" value="@BBint" />
            facebook: <input type="text" class="text_input" value="iamBenBint" />
            linkedin: <input type="text" class="text_input" value="Benjamin Bint" />
            email: <input type="text" class="text_input" value="Benjamin@Bint.com" />
        </form>
    </div>
    <p class="clearfloat"></p>
<a href="create_album.php">+ Add Project</a>
<?php

$albums = get_albums();

if(empty($albums)){
    echo "<p>you have no albums</p>";
}
else{
    foreach($albums as $album){
        echo '<p><a href="view_album.php?album_id=' . $album['id'] . '">'. $album['name'] .'</a>, '. $album['count'] .' images<br />
                ' . $album['description'] . '...<br/>
                    
                <a href="upload_image.php">Upload Image</a> /
                <a href="edit_album.php?album_id=' . $album['id'] . '">Edit</a> / <a href="delete_album.php?album_id=' . $album['id'] . '">Delete</a>
            </p>';

        $album_images = get_images($album['id']);

        foreach($album_images as $images){
            echo '<img src="uploads/thumbs/'. $images['album'] .'/'. $images['id'] . '.' . $images['ext'].'" />';
        };
        '<p></p>';
    }
}

    include 'template/footer.php';
?>
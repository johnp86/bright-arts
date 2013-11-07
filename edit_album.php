<?php
    include 'init.php';
    if(!logged_in()){
        header("Location:index.php");
        exit();
    }

    if(!isset($_GET['album_id']) || empty($_GET['album_id']) || album_check($_GET['album_id']) === false){
        header("Location: index.php");
        exit();
    }

    $album_id = $_GET['album_id'];
    $album_data = album_data($album_id, 'name', 'description');

    include 'template/header.php';
?>

<h1>Edit Album</h1>
<p>for best results, please upload images with a ratio of 4:3 or size of 400px X 300px</p>

<?php
echo $get_images['ext'];

    if(isset($_POST['upload_cover'], $_FILES['image'], $_GET['album_id'])){
        $image_name = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_temp = $_FILES['image']['tmp_name'];

        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'psd');
        $image_ext = strtolower(end(explode(".", $image_name)));

        $album_id = $_GET['album_id'];

        $errors = array();

        if(empty($image_name) || empty($album_id)){
            $errors[] = "Something is missing";
        }
        else{
            if(in_array($image_ext, $allowed_ext) === false){
                $errors[] = "File type not allowed";
            }

            if($image_size > 2097152){
                $errors[] = "Maximum file size is 2mb";
            }

            if(album_check($album_id) === false){
                $errors[] = "Couldn't upload to that album";
            }
        }

        if(!empty($errors)){
            foreach($errors as $error){
                echo '<h2>' .$error . '!</h2>';
            }
        }
        else{
            upload_cover_image($image_temp, $image_ext, $album_id);
           // header('Location: view_album.php?album_id='.$album_id);
            //exit();
        }
    }

    $albums = get_albums();

    if(empty($albums)){
        echo "<p>You don't have any albums</p>";
    }
    else{
?>
<div class="edit_project_form">
    <form action="" method="POST" enctype="multipart/form-data" >
        <h2>Add/Change Cover Image</h2>
        <p>Choose a file:<br /><input type="file" name="image" /></p>
        <p><input type="submit" value="Upload" name="upload_cover" class="btn_input right" /></p>
    </form>
<?php

    $cover_image = get_cover_images($album_id);
    if(!empty($cover_image)){
        foreach ($cover_image as $cover){
            echo '<img src="uploads/small_thumbs/' . $album_id . '/' . $cover['id'] . '.' . $cover['ext'] . ' " />';
        }
    }
    else{
        echo '<h2>You must include a cover image to ensure this project is visible to viewers</h2>';
    }

?>
</div>

<?php
//finish else statement
}

    if(isset($_POST['upload_image'], $_FILES['image'], $_GET['album_id'])){
        $image_name = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_temp = $_FILES['image']['tmp_name'];

        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'psd');
        $image_ext = strtolower(end(explode(".", $image_name)));

        $album_id = $_GET['album_id'];

        $errors = array();

        if(empty($image_name) || empty($album_id)){
            $errors[] = "Something is missing";
        }
        else{
            if(in_array($image_ext, $allowed_ext) === false){
                $errors[] = "File type not allowed";
            }

            if($image_size > 2097152){
                $errors[] = "Maximum file size is 2mb";
            }

            if(album_check($album_id) === false){
                $errors[] = "Couldn't upload to that album";
            }
        }

        if(!empty($errors)){
            foreach($errors as $error){
                echo $error . '<br />';
            }
        }
        else{
            upload_image($image_temp, $image_ext, $album_id);
            //header('Location: view_album.php?album_id='.$album_id);
            //exit();
        }
    }

    $albums = get_albums();

    if(empty($albums)){
        echo "<p>You don't have any albums</p>";
    }
    else{
?>
<div class="edit_project_form">
    <form action="" method="POST" enctype="multipart/form-data">
        <h2>Add/Change Images</h2>
        <p>Choose a file:<br /><input type="file" name="image" /></p>
        <p><input type="submit" value="Upload" name="upload_image" class="btn_input right" /></p>
        
    </form>
    
<?php
    $album_images = get_album_images($album_id);
    foreach ($album_images as $image){
        echo '<img src="uploads/small_thumbs/' . $album_id . '/' . $image['id'] . '.' . $image['ext'] . ' " />';
    }

?>

</div>

<?php 
}
    if(isset($_POST['album_name'], $_POST['album_description'] )){
        $album_name = $_POST['album_name'];
        $album_description = $_POST['album_description'];

        $errors = array();

        if(empty($album_name) || empty($album_description)){
            $errors[] = "Album name and description required";
        }
        else{
            if(strlen($album_name) > 55 || strlen($album_name) > 255){
                $errors[] = "One or more fields contains too many characters";
            }
        }

        if(!empty($errors)){
            foreach($errors as $error){
                echo $error;
            }   
        }
        else{
            edit_album($album_id, $album_name, $album_description);
            header("Location:profile.php?id=".$_SESSION['user_id']);
            exit();
        }
    }
 ?>

<form action="<?php echo "?album_id=" . $album_id ?>" method="POST" class="edit_project_form">
    <h2>Edit Project Information</h2>
    <p>Name: <br /><input type="text" name="album_name" maxlength="55" class="text_input" value="<?php echo $album_data['name']; ?>" /></p>
    <p>Description: <br /><textarea name="album_description" rows="6" cols="35" maxlength="255"><?php echo $album_data['description']; ?></textarea></p>
    <p><input type="submit" value="Edit" class="btn_input right" /></p>
</form>

<?php
    include 'template/footer.php';
?>

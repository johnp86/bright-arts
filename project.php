<?php
    include 'init.php';
    if(!isset($_GET['album_id']) || empty($_GET['album_id'])){
        header ("Location:index.php");
        exit();
    }


    
    include 'template/header.php';

    $album_id = $_GET['album_id'];
    $album_data = album_data($album_id, 'user_id', 'description');
    $user_id = $album_data['user_id'];
    $user_data = show_user_data($user_id, 'name', 'description', 'email', 'portfolio', 'twitter', 'facebook', 'google', 'linkedin');

    echo '<div class="profile_info" style="width: 20%;">';
            echo '<h1>', $user_data['name'], '</h1>';
            echo '<p><a href="profile.php?id=', $user_id ,'" >view profile>></a></p>';
            echo '<img src="images/profile_holder.gif" />';
            if(!empty($user_data['twitter'])){echo '<p><a href="https://twitter.com/', $user_data['twitter'], '">twitter</a></p>';}
            if(!empty($user_data['facebook'])){echo '<p><a href="http://www.facebook.com/', $user_data['facebook'], '">facebook</a></p>';}
            if(!empty($user_data['portfolio'])){echo '<p><a href="http://', $user_data['portfolio'], '">portfolio</a></p>';}
            if(!empty($user_data['google'])){echo '<p><a href="http://', $user_data['google'], '">google+</a></p>';}
            if(!empty($user_data['linkedin'])){echo '<p><a href="http://', $user_data['linkedin'], '">linkedin</a></p>';
    }
    echo '</div>';


    $cover_image = get_cover_images($album_id);
    $images = get_album_images($album_id);
?>

<div id="project_container">

<?php

    if(empty($cover_image) && empty($images)){
        echo 'There are no images in this album';
    }
    else{
        foreach($cover_image as $cover){
            echo '<a href="profile.php?id= ' . $album_data['user_id'] . '"><img src="uploads/cover_images/', $cover['album'],'/', $cover['id'], '.', $cover['ext'], '" title="Uploaded ',date('D M Y / h:i',$image['timestamp']) ,'" class="cover_image" /></a>';
        }

        foreach($images as $image){
            echo '<a href="profile.php?id= ' . $album_data['user_id'] . '"><img src="uploads/small_thumbs/', $image['album'],'/', $image['id'], '.', $image['ext'], '" title="Uploaded ',date('D M Y / h:i',$image['timestamp']) ,' " class="small_image" /></a>';
        }
    }
?>
<h2>Comments</h2>
<?php
    $comments = view_comments($album_id);
    if(!empty($comments)){
        foreach($comments as $comment){
            $comment_by = show_user_data($comment['user_id'], 'name');
            echo'<article class="comments"><a href="profile.php?id='. $comment['user_id'] .'"><h3>', $comment_by['name'],'</h3></a>', date('d/m/Y  h:i',$comment['timestamp']), ' <p> ', $comment['comment'] ,'</p></article>';
            if($album_data['user_id'] == $_SESSION['user_id']){
                echo'<a href="delete_comment.php?comment_id=', $comment['id'] ,'"><h3>[x] Delete Comment</h3></a>';
            }
        }
    }
    else{
        echo "<h3>No comment, Why don't you be the first?</h3>";
    }

    if($_SESSION['user_id']){
        if(isset($_POST['comment']) && $_POST['comment'] != ''){
            if(strlen($_POST['comment']) < 200){
                create_comment($album_id, $_POST['comment']);
                echo '<h3>comment added</h3>';
            }
            else{
                echo'message too long, must be no more thn 200 characters. Please shorten or email student';
            }
        }
        else{
            echo'<h3>Please enter a comment</h3>';
        }

        ?>

        <form action="" method="POST">
            <textarea cols="60" rows="6" name="comment"></textarea>
            <input type="submit" value="comment" class="btn_input btn_comment" />
        </form>


<?php
    }
echo'</div>';
    include 'template/footer.php';
?>
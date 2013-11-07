<?php
    include 'init.php';
    include 'template/header.php';

    if(!logged_in()){
        header('Location:index.php');
    }

?>

<h2>Edit Profile</h2>

<?php

    $user_id = $_SESSION['user_id'];
    
    if(isset($_FILES['profile_image'], $_POST['information'])){
        $album_id = $user_id;
        upload_photo($image_temp, $image_ext, $album_id); 

        $about = $_POST['about'];
        $portfolio = $_POST['portfolio_url'];
        $twitter = $_POST['twitter_url'];
        $fb = $_POST['fb_url'];
        $google = $_POST['google_url'];
        $linkedin = $_POST['linkedin_url'];
        edit_user_data($about, $portfolio, $twitter, $fb, $google, $linkedin);

        echo 'your information has been updated';
    }
    $user_data = show_user_data($user_id, 'description', 'email', 'portfolio', 'twitter', 'facebook', 'google', 'linkedin');
?>

<form action="" method="POST" enctype="multipart/form-data">
    <div class="edit_profile">
        <h3>Edit Profile Picture</h3>
        <p>Choose a photo:<br /><input type="file" name="profile_image" /></p>
    </div>
    <div class="edit_profile">
        <h3>Edit Contact Details</h3>
        <div id="email_folio">
            <ul>
                <li>Portfolio</li>
                <li><input type="text" name="portfolio_url" value="<?php echo $user_data['portfolio']; ?>" /></li>
            </ul>
            <ul>
                <li>Email Address</li>
                <li><input type="text" name="email_url" value="<?php echo $user_data['email']; ?>" /></li>
            </ul>
        </div>
        <div id="social">
            <ul>
                <li>Twitter</li>
                <li><input type="text" name="twitter_url" value="<?php echo $user_data['twitter']; ?>" /></li>
            </ul>
            <ul>
                <li>Facebook</li>
                <li><input type="text" name="fb_url" value="<?php echo $user_data['facebook']; ?>" /></li>
            </ul>
            <ul>
                <li>Google+</li>
                <li><input type="text" name="google_url" value="<?php echo $user_data['google']; ?>" /></li>
            </ul>
            <ul>
                <li>LinkedIn</li>
                <li><input type="text" name="linkedin_url" value="<?php echo $user_data['linkedin']; ?>" /></li>
            </ul>
        </div>
    </div>
    <p></p>
<div class="edit_profile">
    <h3>Edit 'About Me'</h3>
    <textarea rows="6" cols="60" name="about"><?php echo $user_data['description']; ?></textarea>
    <p><input type="submit" value="Update" name="information" class="btn_input right" /></p>
</div>
</form>

<?php

    include 'template/footer.php';

?>
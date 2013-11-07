<!--
    This is the main navigation setup. If the user is not logged in
    then only show the user the home, login and register links
-->

<a href="index.php">HOME</a>

<?php
    if(!logged_in ()){
?>
    <a href="register.php">REGISTER</a>
    <a href="#" id="loginButton" class="end"><span>LOG IN</span><em></em></a>
    <?php include("widgets/login.php"); ?>
<?php
    }
    else{
?>

    <?php echo'<a href="profile.php?id=' . $_SESSION['user_id'] . '">PROJECTS</a>' ?>
    <a href="edit_profile.php">EDIT PROFILE</a>
    <a href="logout.php" class="end">LOG OUT</a>
<?php
    }
?>
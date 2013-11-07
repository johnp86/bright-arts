<!--
    This is the login form which is opened once the link is pressed in the main 
    navigation links
-->
<?php
if(logged_in ()){
    $user_data = user_data('name');
    echo "Hello ", $user_data['name'];
}
else{
?>

 <!--the html login form-->
<div id="loginBox">
    <form action="" method="POST" id="loginForm">
        <fieldset id="body">
            <fieldset>
                <label for="email">Email Address</label>
                <input type="email" name="login_email" />
            </fieldset>
            <fieldset>
                <label for="password">Password</label>
                <input type="password" name="login_password" />
            </fieldset>
                <input type="submit" value="login" />
        </fieldset>
    </form>
</div>
<?php
}
/*this function checks to see if the user has filled the login form
 * If so check to make sure there are no errors and if there are
 * no errors set up a session id and log the user in
*/
if(isset($_POST['login_email'], $_POST['login_password'])){
    $login_email = $_POST['login_email'];
    $login_password = $_POST['login_password'];

    $errors = array();
    if(empty($login_email) || empty($login_password)){
        $errors[] = "Email and Password required";
    }
    else{
        $login = login_check($login_email, $login_password);

        if($login === false){
            $errors[] = "Unable to log in";
        }
    }

    if(!empty($errors)){
        foreach($errors as $error){
            echo $error, "<br />";
        }
    }
    else{
        $_SESSION['user_id'] = $login;
        header("Location: index.php");
        exit();
    }
}
?>

<?php
include'init.php';

if(logged_in ()){
    header('Location: index.php');
    exit();
}

include'template/header.php';
?>

<h1>Register</h1>

<?php
    if(isset($_POST['register_email'], $_POST['register_name'], $_POST['register_password']) ){
        $register_email = $_POST['register_email'];
        $register_name = $_POST['register_name'];
        $register_password = $_POST['register_password'];

        $errors = array();

        if(empty($register_email) || empty($register_name) || empty($register_password)){
            $errors[] = 'All fields required';
        }
        else{
            if(!strstr($register_email, "uni.brighton.ac.uk")){
                $errors[] = 'You must use your University of Brighton email account';
            }

            if(filter_var($register_email, FILTER_VALIDATE_EMAIL) === false){
                $errors[] = 'Email address not valid';
            }

            if(strlen($register_email) > 255 || strlen($register_name) >35 || strlen($register_password)>35){
                $errors[] = 'One or more fields contains too many characters';
            }

            if(user_exists($register_email)===true){
                $errors[] = 'That email has already been registered';
            }
        }

        if(!empty($errors)){
            foreach ($errors as $error){
                echo $error, '<br />';
            }
        }
        else{
            $register = user_register($register_email, $register_name, $register_password);
            $_SESSION['user_id'] = $register;
            echo $_SESSION['user_id'];
            header('Location: index.php');
            exit();
        }
    }
?>

<form action="" method="POST" id="register">
    <p>Full Name: <br /> <input type="text" name="register_name" maxlength="35" class="text_input" /></p>
    <p>Email: <br /> <input type="text" name="register_email" maxlength="255" class="text_input" /></p>
    <p>Password: <br /> <input type="password" name="register_password" maxlength="35" class="text_input" /></p>
    <p><input type="submit" value="register" class="btn_input"/></p>
</form>

<?php
include'template/footer.php';
?>

<?php
function logged_in(){
    return isset($_SESSION['user_id']);
}
//check if use is logged in
function login_check($email, $password){
    $email = mysql_real_escape_string($email);
    $login_query = mysql_query("SELECT COUNT(user_id) as count, user_id FROM users WHERE email = '$email' AND password = '" . md5($password) . "'");
    return (mysql_result($login_query,0) == 1) ? mysql_result($login_query, 0, 'user_id'):  false;//if a email + password match then we return user_id
}
//return the information on the logged in user
function user_data(){
    $args = func_get_args();
    $fields = '`' . implode('`, `',$args) . '`';
    $query = mysql_query("SELECT $fields FROM users WHERE user_id = ".$_SESSION['user_id']);
    $query_result = mysql_fetch_assoc($query);
    foreach ($args as $field){
        $args[$field] = $query_result[$field];
    }
    return $args;
}
//return the information on the logged in user
function show_user_data($user_id){
    $user_id = (int)$user_id;
    $args = func_get_args();
    unset($args[0]);
    $fields = '`' . implode('`, `',$args) . '`';

    $query = mysql_query("SELECT $fields FROM users WHERE user_id = ".$user_id);
    $query_result = mysql_fetch_assoc($query);
    foreach ($args as $field){
        $args[$field] = $query_result[$field];
    }
    return $args;
}
//add user to the database
function user_register($email, $name, $password){
    $email = mysql_real_escape_string($email);
    $name = mysql_real_escape_string($name);
    mysql_query("INSERT INTO users VALUES('0', '$email', '$name', '', '" . md5($password) . "', '', '', '', '', '')");
    return mysql_insert_id();
}
//check if user exists
function user_exists($email){
    $email = mysql_real_escape_string($email);//sanitising email to stop mysql injection
    $query = mysql_query("SELECT COUNT(user_id) FROM users WHERE email='$email'");
    return (mysql_result($query, 0) == 1)? true : false;//(inline if statement) if equal to 1 return true else if not return false
}
//return all users in the database
function get_users(){
    $users = array();
    $query = mysql_query("SELECT * FROM users");
    
    while($query_row = mysql_fetch_assoc($query)){
        $users[] = array(
            'id' => $query_row['user_id']
        );
    };
    return $users;
}
//change information on the logged in user
function edit_user_data($about, $portfolio, $twitter, $fb, $google, $linkedin){
    $about = mysql_real_escape_string($about);
    mysql_query("
            UPDATE users SET description = '$about', portfolio = '$portfolio',
            twitter = '$twitter', facebook = '$fb', google = '$google', linkedin = '$linkedin' WHERE user_id=" . $_SESSION['user_id']);
}
//upload photo of user
function upload_photo($image_temp, $image_ext, $album_id){
    $album_id = (int)$album_id;
    $image_file = $image_id.'.'.$image_ext;
    move_uploaded_file($image_temp, 'uploads/users/' . $album_id . '/' . $image_file);
    echo $image_file;
}
//upload photo of user

?>

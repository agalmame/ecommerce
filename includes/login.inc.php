<?php 
$login_errors = array();
if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
    $e = escape_data($_POST['email'],$dbc);
}else{
    $login_errors['email'] = 'Please enter a valid email address!';
}

if(!empty($_POST['pass'])){
    $p = $_POST['pass'];
}else{
    $login_error['pass'] = 'Please enter your password!';
}


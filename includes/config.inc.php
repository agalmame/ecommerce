<?php
if(!defined('LIVE'))
    define('LIVE',false);

define('CONTACT_EMAIL','agalmameyassine.com');
define('BASE_URI','/opt/lampp/htdocs/ecommerce/');
define('BASE_URL','www.exemple.com/');
define('MYSQL',BASE_URI.'includes/mysql.inc.php');

function my_error_handler($e_number,$e_message,$e_file,$e_line,$e_vars){
   $message = "An error occurred in script '$e_file' on line
   $e_line:\n$e_message\n";
   $message .="<pre>".print_r(debug_backtrace(),1)."</pre>\n";
   if(!LIVE){
       echo '<div class="alert alert-danger">'.nb2br($message).'</div>';
    }else{
        error_log($message,1,CONTACT_EMAIL,'From:agalmameyassine@gmail.com');
        if($e_number!=E_NOTICE){
            echo'<div class="alert alert-danger">A system error occurred. We
                apologize for the inconvenience.</div>';
        }
    }
}

function redirect_invalid_user($check='user_id',$destination='index.php',$protocol='http://'){
    if(!headers_sent()){
        if(!isset($_SESSION[$check])){
            $url = $protocol.BASE_URL.$destination;
            header("Location:$url");
            exit();
        }
    }else{
        include_once('./includes/header.html');
        trigger_error('You do not have permission to access this page, Please log in and try again');
        include_once('./inludes/footer.html');
    }
}

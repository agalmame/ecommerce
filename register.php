<?php
require './includes/config.inc.php';
require MYSQL ;
$page_title = 'Registration';
include('./includes/header.html');
include_once ('./includes/form_function.inc.php');
?>

<h1>Register</h1>
<p>Access to the site's content is available to registered users at a cost of
$10.00 (US) per year. Use the form below to begin the registration process
<strong>Note: All fields are required.</strong>After completing this form,
you'll be presented with the opportunity to securely pay for your yearly
subscription via<a href="http://www.paypal.com">PayPal</a>.</p>
<form action="register.php" method="post" accept-charset="utf-8">
    <?php
    $reg_errors= array();
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(preg_match('/^[A-Z \'.-]{2,45}$/i',$_POST['first_name'])){
            $fn = escape_data($_POST['first_name'],$dbc);
        }else{
            $reg_errors['first-name'] = 'Please enter your first name!'; 
        }
        if(preg_match('/^[A-Z \'.-]{2,45}$/i',$_POST['last_name'])){
            $ln = escape_data($_POST['last_name'],$dbc);
        }else{
            $reg_errors['last-name'] = 'Please enter your last name!'; 
        }
        if(preg_match('/^[A-Z0-9]{2,45}$/i',$_POST['username'])){
            $u = escape_data($_POST['username'],$dbc);
        }else{
            $reg_errors['username'] = 'Please enter your Username!'; 
        }
        if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
            $e = escape_data($_POST['email'],$dbc);
        }else{
            $reg_errors['email'] = 'Please enter your email address!'; 
        }
        if(preg_match('/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[a-Z]\w*){6,}$/',$_POST['pass1'])){
            if($_POST['pass1']===$_POST['pass2']){
                $p=$_POST['pass1'];
            }else{
                $reg_errors="your password didn't match";
            }
        }else{
            $reg_errors="Please enter a valide password!";
        }
        if(empty($reg_errors)){
            $q = "SELECT email, username FROM users WHERE email ='$e' OR username='$u'";
            $r = mysqli_query($dbc,$q);
            $rows = mysqli_num_rows($r);
            if($rows===0){
                $q = "INSERT INTO users (username,email,first_name,last_name,date_expires) VALUES ('$u','$e,'".password_hash($p,
                    PASSWORD_BCRYPT)."','$fn','$ln',ADDDATE(NOW(),INTERVAL 1 MONTH)";
                    $r = mysqli_query($dbc,$q);
                if(mysqli_affected_rows($dbc)===1){
                    echo '<div class = "alert alert-success"><h3>Thanks!</h3><p>Thank you for registring!
                    you now log in and access the site\'s content.</p></div>';
                    $body = "Thank you for registration at <our website> Blah blah.\n\n";
                    mail($_POST['email'],'Registration Confirmation',$body,'from:agalmameyassine@gmail.com');
                    include('./includes/footer.html');
                    exit();
                }else{
                    trigger_error('You could not be registred due to system error,
                    We apologize for any inconvenience. We will correct the error ASAP.');
                }
            }
            if($rows===2){
                $reg_errors['email'] = 'this email address has already registred. If
                                        you have forgotten your password, use the link at left to have your
                                        password sent to you';
                $reg_errors['username'] = 'This username has already been registered please try another';
            }else{
                $row = mysqli_fetch_array($r,MYSQLI_NUM);
                if(($row[0] === $_POST['email']) && ($row[1] === $_POST['username'])){
                    $reg_errors['email'] = "This email address has already been registred. if you have
                            forgotten your password, se the link at left to have your password sent to you.";
                    $reg_errors['username'] = "This username has already been registred. if you have
                            forgotten your password, se the link at left to have your password sent to you.";
                }elseif($row[0]===$_POST['email']){
                    $reg_errors['email'] = "This email address has already been registred. if you have
                    forgotten your password, se the link at left to have your password sent to you.";
                }elseif($row[1]===$_POST['username']){
                    $reg_errors['username'] = "This username has already been registred. if you have
                    forgotten your password, se the link at left to have your password sent to you.";
                }
            }
        }
    }
    

    create_form_input('first_name','text','First Name',$reg_errors);
    create_form_input('last_name','text','Last Name',$reg_errors);
    create_form_input('username','text','Desired Username',$reg_errors);
    echo '<span class="help-blok">Only letters and numbers are allowed.</span>';
    create_form_input('email','email','Email Address',$reg_errors);
    create_form_input('pass1','password','Password ',$reg_errors);
    echo '<span class="help-block">Must be at least 6 characters long, with at
    least one lowercase letter, one uppercase letter, and one number.</span>';
    create_form_input('pass2','password','Confirme Password',$reg_errors);
    ?>
    <input type="susbmit" name="submit_button" value="Next &rarr;" id="subit_button"
     class="btn btn-default"/>
</form>
<?php include ('./includes/footer.html');?>

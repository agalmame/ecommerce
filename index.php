
<?php
require './includes/config.inc.php';
require MYSQL;
if($_SERVER['REQUEST_METHOD']==='POST'){
    include('./includes/login.inc.php')
}
$_SESSION['user_id']=1;
$_SESSION['user_admin']=false;

include './includes/header.html';
?>
<h3>Welcome</h3>
<p class="lead">Lorem ipsum dolor sit amet consectetur
    adipisicing elit. Consectetur asperiores odio 
    facere quae vitae, dolore dolores. Unde necessitatibus 
    fugit sunt autem sequi minus!
    Modi at, ab corporis nam natus ex?
</p>

<?php
include './includes/footer.html';
?>


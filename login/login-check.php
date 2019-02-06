
<?
require_once('main.php');

$userName = $_POST['userName'];
$password = $_POST['password'];

if (!$session = is_logged_in($userName,$password)){
  $message = _user_not_registered;
  require_once("msg-fail.php");
  exit;
} else {
    //echo $session;
    //we have to set cookie and work on links
   // setcookie("session", $session, time()+3600, "/","192.168.99.124", 0);
 //   setcookie("userName", $userName, time()+3600, "/","192.168.99.124", 0);
    ?>
    <html>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="css/style.css">
    <body>
<div class="tac">

<section class="banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <span class="text_1">Welcome to Election</span>

             

<a href=<?php echo "http://192.168.99.130:8087/index.php?userName=".$userName."&session=".$session;?> class="btn standard-btn" >click here</a>

                <div class="bg_hover">
                </div>
                </span>
            
            </div>
        </div>
    </div>

</section>



</div>

    </body>
    </html>



    <?
}

?>

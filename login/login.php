<?
//not required
require_once('main.php');

if (isset($_SESSION['email'])){
  $message = _already_logged_in . ' ' . $_SESSION['email'];
  require_once('msg-success.php');
  exit;
}
?>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="base.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div>
  <div class="tac">
    <img src="image/notes.png"><br><br>

    <form action="login-check.php" method="post">
      <input type="text" class="ltr" placeholder="<?=_ph_email?>" name="email"><br>
      <br>
      <input type="password" class="ltr" placeholder="<?=_ph_password?>" name="password"><br>
      <br>
      <br>
      <button type="submit" class="btn-blue"><?=_btn_login?></button>
    </form>

    <br>
    <br>
    <br>
    <a href="register.php" class="link-gray"><?=_btn_signup?></a>
  </div>
</div>
<?
?>
</body>
</html>

<?
require_once('main.php');
?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="css/style.css">

        <link href="css/bootstrap.min.css" rel="stylesheet"/>
        <script src="js/bootstrap.min.js"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
</head>
<body>



  <div class="login-wrap">
	<div class="login-html">
		<input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">ثبت نام کاربر جدید</label>
		<input id="tab-2" type="radio" name="tab" class="for-pwd"><label for="tab-2" class="tab"></label>
		<div class="login-form">
			  <form action="register-check.php" method="post">
			<div class="sign-in-htm">
				<div class="group">
				
					<input id="user" type="text" class="input" placeholder="<?=_ph_studentNumber?>" name="studentNumber">
				</div>
				<div class="group">
					
					<input id="pass" type="password" class="input" data-type="password" placeholder="<?=_ph_password?>" name="password1">
				</div>
				<div class="group">
					
					<input id="pass" type="password" class="input" data-type="password" placeholder="<?=_ph_confirm_password?>" name="password2">
				</div>

				<div class="group">
				
					<input  type="text" class="input" placeholder="<?=_ph_fieldName?>" name="fieldName">
				</div>

				<div class="group">
					
					<input  type="text" class="input" placeholder="<?=_ph_name?>" name="name">
				</div>

				<div class="group">
					
					<input  type="text" class="input" placeholder="<?=_ph_lastName?>" name="lastName">
				</div>

				<div class="group">
					
					<input  type="text" class="input" placeholder="<?=_ph_nationalNumber?>" name="nationalNumber">
				</div>

				<div class="group">
			
					<input  type="text" class="input" placeholder="<?=_ph_phoneNumber?>" name="phoneNumber">
				</div>

				<div class="group">
					<input type="submit" class="button" value="<?=_btn_register?>">
				</div>
		
				<div class="hr"></div>
			</div>
		</form>
		
		</div>
	</div>
</div>

</body>
</html>

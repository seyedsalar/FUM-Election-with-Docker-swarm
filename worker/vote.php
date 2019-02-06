<?
require_once('common.php');

$userName = $_COOKIE["userName"];
$session = $_COOKIE["session"];


$choice = $_POST["choice"];

$data = url_get_contents2("http://172.24.36.51:8088/slim/public/vote?studentId=".$userName."&token=".$session."&subElectionId=".$choice);
//dump($data);
$data = json_decode($data,true);
//dump($result['successful']);
?>
<html>

<head>
  <meta charset="UTF-8">

  <link rel="stylesheet" href="css/style.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.1/css/font-awesome.css" rel="stylesheet">
</head>

<body>

<div class="tac">



<div class="col-md-12">
  <div class="row">
             
    </div>
</div>
</br>
<div class=" row col-md-12">

<?
if($data['successful']){
    echo "<h2>انتخاب شما با موفقیت ثبت شد</h2>";
}else{

    echo "<h2>انتخاب ناموفق شما قبلا در انتخابات این بخش شرکت کردید</h2>";
}?>

</div>

 <a href="exit.php"  class="btn btn-xlarge" /><i class="fa fa-sign-out  fa-5x" ></i></a>








</div>
</div>






</body>
</html>

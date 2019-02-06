<?


require_once('common.php');

$userName = $_COOKIE["userName"];
$session = $_COOKIE["session"];

//$userName = 9623430025;
//$session = 1212;
$Id = $_GET["Id"];
?>




<html>
<head>
  <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <link href="css/bootstrap.min.css" rel="stylesheet"/>

</head>
<body>
<div class="form-wrapper">

	<p>یک گزینه را انتخاب کنید و سپس بر روی تایید کلیک کنید.</p>

        <?

        $data = url_get_contents2('http://172.24.36.51:8088/slim/public/subElectionList?studentId='.$userName.'&token='.$session.'&electionId='.$Id );
        $data = json_decode($data, true);
        if($data['successful']){?>
    <form action=<?echo "vote.php";?> method="post">
            <?
        foreach ($data['result'] as $result){
            ?>
        <label for="choice-1">
			<input type="radio" id="choice-1" name="choice" value=<?echo $result['Id'];?> />
			<div>
                <?echo $result['name'];?>
                <span>أیا اطمینان دارید؟</span>
			</div>
		</label>

		<?}?>
        <button type="submit">تایید</button>
    </form>
        <?}else{?>
            <span>دوباره وارد شوید</span>
        <?}?>

</div>

</body>
</html>





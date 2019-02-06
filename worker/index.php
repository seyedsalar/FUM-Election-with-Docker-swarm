<?

require_once('common.php');
$userName = $_COOKIE["userName"];
$session = $_COOKIE["session"];


?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">

    <link href="css/bootstrap.min.css" rel="stylesheet"/>

</head>
<body>


<div id="home_quicklinks">

    <?
    $data = url_get_contents2('http://172.24.36.51:8088/slim/public/electionList?studentId='.$userName.'&token='.$session );
    $data = json_decode($data, true);
    if($data['successful']){
        foreach ($data['result'] as $result){
            ?>
            <a class="quicklink link1" href=<?echo"Election.php?Id=" .$result['Id'];?>>
                                    <span class="ql_caption">
                                        <span class="outer">
                                            <span class="inner">
                                                <h2><?echo $result['Election_name'];?></h2>
                                            </span>
                                        </span>
                                    </span>
                <span class="ql_top"></span>
                <span class="ql_bottom"></span>
            </a>
            <?
        }
    }else{
        ?>
        <h2>مجددا وارد شوید</h2>
    <?}?>






</div>



</body>
</html>





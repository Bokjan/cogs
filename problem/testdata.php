<?php
require_once("../include/header.php");
gethead(1,"查看数据","查看数据");
?>
<div class='container'>
<iframe src="testdata<?if($_GET['problem']) echo "/{$_GET['problem']}";?>" class='table span12' height='400px'>
</iframe>
</div>
<?php
include_once("../include/footer.php");
?>

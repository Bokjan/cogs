<?php
require_once("../include/header.php");
gethead(1,"参数设置","参数设置");
$p=new DataAccess();
?>
<div class='container'>
<table class='table table-striped table-condensed table-bordered fiexd'>
  <tr>
    <th width=10%>修改</th>
    <th width=20%>参数</th>
    <th>值</th>
  </tr>
<?php
	$sql="select * from settings";
	$cnt=$p->dosql($sql);
	for ($i=0;$i<$cnt;$i++)
	{
		$d=$p->rtnrlt($i);
?>
  <tr>
    <td>
    <a href="settings/editkey.php?sname=<?php echo $d['name'] ?>&method=html">富文本</a>
    <a href="settings/editkey.php?sname=<?php echo $d['name'] ?>&method=text">纯文本</a>
    </td>
    <td><code><?php echo $d['name'] ?></code></td>
    <td><?php echo $d['value'] ?></td>
  </tr>
<?php
	}
?>
</table>
</div>
<?php
require_once("../include/footer.php");
?>

<?php
require_once("../../include/stdhead.php");
gethead(1,"修改比赛","修改比赛");
?>

<body>
<a href="../settings.php?settings=comp">比赛基本管理</a>
<?php
$p=new DataAccess();
if ($_GET[action]=='edit') {
	$sql="select * from compbase where cbid={$_GET[cbid]} ";
	$cnt=$p->dosql($sql);
	$d=$p->rtnrlt(0);
	$pbs=explode(":",$d['contains']);
	$pbs=array_flip($pbs);
}
?>
<form method="post" action="doeditcompbase.php?action=<?=$_GET[action] ?>&cbid=<?=$_GET[cbid]; ?>" class='form-inline'>
<table>
  <tr>
    <td>CBID</td>
    <td><?=$d[cbid] ?></td>
  </tr>
  <tr>
    <td>比赛名</td>
    <td>
      <input name="cname" type="text" value="<?=$d[cname] ?>" /></td>
  </tr>
  <tr>
    <td>关联题目</td>
    <td>
	<ul class='nav nav-pills'>
	<?php
	$sql="select pid,probname from problem order by pid";
	$cnt=$p->dosql($sql);
	for ($i=0;$i<$cnt;$i++) {
		$d=$p->rtnrlt($i);
?>
<li><input name="cons[<?=$d[pid]?>]" type="checkbox" id="cons[<?=$d[pid]?>]" value="<?=$d[pid]?>" <?php if (is_numeric($pbs[$d[pid]])) echo 'checked="checked"' ?> /><label for="cons[<?=$d[pid]?>]"><?=$d[pid]?>.<a href="../../problem/problem.php?pid=<?=$d[pid] ?>" target="_blank"><?=$d['probname'] ?></a></label></li>
<?php
	}
?>
</ul></td>
  </tr>
<tr><td></td><td>
<button type="submit" class='btn btn-primary'>提交修改</button>
</td></tr>
</table>
</form>

<?php
	include_once("../../include/stdtail.php");
?>

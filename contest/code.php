<?php
require_once("../include/header.php");
gethead(1,"sess","代码");
$LIB->dpshhl();
?>

<?php
$p=new DataAccess();
$sql="select problem.filename,problem.probname,userinfo.uid,userinfo.nickname,userinfo.realname,compscore.ctid,compscore.subtime,comptime.endtime,compscore.score,compscore.result,compscore.lang from problem,compscore,comptime,userinfo where compscore.pid=problem.pid and comptime.ctid=compscore.ctid and userinfo.uid=compscore.uid and compscore.csid={$_GET[csid]}";
$cnt=$p->dosql($sql);
if ($cnt) {
	$d=$p->rtnrlt(0);
if(time() < $d['endtime'] && !$_SESSION['admin'])
异常("比赛未结束！");
	if ($d[lang]==0) $ext="pas"; else
	if ($d[lang]==1) $ext="c"; else
	if ($d[lang]==2) $ext="cpp"; 
	$fp=fopen("{$SET['dir_competition']}{$d[ctid]}/{$d[uid]}/{$d[filename]}.{$ext}","r");
	if (is_resource($fp)) {
		$code=rfile($fp);
	}
	fclose($fp);
    $code=mb_convert_encoding($code, "utf-8", "gbk");
} else 异常("提交记录不存在");

?>
<div class='container-fluid'>
<div class='span3'>
<table id="submitdetail" class='fixed'>
  <tr>
    <th width="60px">比赛</th>
    <td><?=$_GET['csid']?></td>
  <tr>
    <th>题目名称</th>
    <td><a href="problem.php?pid=<?php echo $d['pid']; ?>" target="_blank"><?php echo $d['probname']; ?></a></td>
</tr>
  <tr>
    <th>用户昵称</th>
    <td><a href="../user/detail.php?uid=<?php echo $d['uid']; ?>" target="_blank"><?php echo $d['nickname']; ?></a></td>
  </tr>
  <tr>
    <th>最终得分</th>
    <td><?php echo $d['score'] ?></td>
  </tr>
  <tr>
    <th>评测结果</th>
    <td class='wrap'><?php 评测结果($d['result']) ?></td>
  </tr>
  <tr>
    <th>代码语言</th>
    <td><?=$STR['lang'][$d['lang']]?></td>
  </tr>
  <tr>
    <th>是否通过</th>
    <td><?php echo $d['accepted']?"<span class='ok'>通过":"<span class='no'>未通过"; ?></span></td>
  </tr>
  <tr>
    <th>提交时间</th>
    <td><?php echo date('Y-m-d H:i:s',$d[subtime]); ?></td>
  </tr>
</table>
</div>
<div class='span9'>
<?    if($d['lang']==0) $langstr="pascal";
    else if($d['lang']==1) $langstr="c";
    else if($d['lang']==2) $langstr="cpp";
?>
<pre class="brush: <?=$langstr?>;"><?=htmlspecialchars($code)?></pre>
</div>
</div>

<script type="text/javascript">SyntaxHighlighter.all();</script>

<?php
	include_once("../include/footer.php");
?>

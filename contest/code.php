<?php
require_once("../include/header.php");
$p=new DataAccess();
$sql="select compbase.cname,problem.pid,problem.filename,problem.probname,userinfo.uid,userinfo.nickname,userinfo.realname,comptime.endtime,compscore.* from problem,compscore,comptime,compbase,userinfo where compscore.pid=problem.pid and comptime.ctid=compscore.ctid and userinfo.uid=compscore.uid and compscore.csid={$_GET[csid]} and compbase.cbid=comptime.cbid";
$cnt=$p->dosql($sql);
if ($cnt) {
	$d=$p->rtnrlt(0);
    if(!有此权限("查看比赛") && (time() < $d['endtime'] && $_SESSION['ID'] != $d['uid']))
        异常("比赛未结束！", 取路径("contest/index.php"));
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
gethead(1,"sess","比赛代码", $d['uid']);
$LIB->hlighter();

?>
<div class='row-fluid'>
<table class='table table-striped table-condensed table-bordered fiexd'>
<tr>
    <th width="60px">比赛</th>
    <td><b><?=$d['cname']?></b></td>
    <th width="60px">评测结果</th>
    <td class='wrap'><?php 评测结果($d['result'], 100) ?></td>
</tr>
<tr>
    <th>题目名称</th>
    <td><a href="problem.php?ctid=<?=$d['ctid']?>&pid=<?php echo $d['pid']; ?>"><?php echo $d['probname']; ?></a></td>
    <th>最终得分</th>
    <td><?php echo $d['score'] ?></td>
</tr>
<tr>
    <th>用户昵称</th>
    <td><a href="../user/detail.php?uid=<?php echo $d['uid']; ?>" target="_blank"><?php echo $d['nickname']; ?></a></td>
    <th>运行时间</th>
    <td><?php printf("%.3f",$d['runtime']/1000.0) ?> s </td>
</tr>
<tr>
    <th>代码语言</th>
    <td><?=$STR['lang'][$d['lang']]?></td>
    <th>内存使用</th>
    <td><?php printf("%.2f",$d['memory']/1024) ?> MiB </td>
</tr>
<tr>
    <th>提交时间</th>
    <td colspan='3'><?php echo date('Y-m-d H:i:s',$d[subtime]); ?></td>
</tr>
<tr>
</tr>
</table>
<?    if($d['lang']==0) $langstr="pascal";
    else if($d['lang']==1) $langstr="c";
    else if($d['lang']==2) $langstr="cpp";
?>
<pre class="prettyprint linenums lang-<?=$langstr?>"><?=htmlspecialchars($code)?></pre>
</div>
<?php
	include_once("../include/footer.php");
?>

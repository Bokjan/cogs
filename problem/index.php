<?php
require_once("../include/stdhead.php");
gethead(1,"","题目列表");
$p=new DataAccess();
$q=new DataAccess();
?>

<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){
eval(targ+".location='?diff=<?php echo $_GET['diff'] ?>&caid=<?php echo $_GET['caid'] ?>&key=<?php echo $_GET['key'] ?>&page="+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
function MM_jumpMenu_2(targ,selObj,restore){
eval(targ+".location='?caid=<?php echo $_GET['caid'] ?>&key=<?php echo $_GET['key'] ?>&diff="+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<?php if ($_GET['caid']!="") {
    $sql="select * from category where caid={$_GET['caid']}";
    $cnt=$p->dosql($sql);
    $d=$p->rtnrlt(0);
?>

<span id="cate_detail">当前分类：<span style="font-size:20px;"><?php echo $d['cname'] ?></span>（<?php echo nl2br(sp2n(htmlspecialchars($d['memo']))) ?>）</span>
<?php } ?>
<?php if(有此权限('修改题目')) { ?>
<span class="admin big"><a href="../admin/problem/editprob.php?action=add">添加新题目</a></span>
<?php } ?>

<?php
$sql="select problem.* from problem";
if($_GET['caid'])
$sql.=",tag where tag.pid=problem.pid and tag.caid={$_GET['caid']}";
else
$sql .= " where problem.readforce>=0";

if ($_GET['key'] == "随机题目") {
    echo '<script>document.location="'.路径("problem/random.php").'"</script>';
    exit;
}
if ($_GET['key']!="")
$sql.=" and (problem.probname like '%{$_GET[key]}%' or problem.pid ='{$_GET[key]}' or problem.filename like '%{$_GET[key]}%')";

if ($_GET['diff']!="")
$sql.=" and problem.difficulty='{$_GET['diff']}'";

if($_GET['rank'])
$sql.=" order by problem.".$_GET['rank']." asc";
else
$sql.=" order by problem.pid asc";

$cnt=$p->dosql($sql);
$totalpage=(int)(($cnt-1)/$SET['style_pagesize'])+1;
if(!$_GET['page']) {
    $_GET['page']=1;
    $st=0;
} else {
    if ($_GET[page]<1 || $_GET[page]>$totalpage)
        异常("页面错误！");
    else
        $st=(($_GET[page]-1)*$SET['style_pagesize']);
}
?>
<form method="get" action="" class='center'>
<a href="random.php" title="随机选择一道你没有通过的题目" class='btn' >随机题目</a>
<input name="caid" type="hidden" value="<?=$_GET['caid']?>" />
难度 
<select name="diff" onchange="MM_jumpMenu_2('parent',this,0)" class='input-medium'>
<option value="" selected="selected" <?php if ($_GET['diff']=="") {?> selected="selected"<?php } ?> >全部</option>
<?php for ($i=1;$i<=10;$i++) { ?>
<option value="<?php echo $i;?>" <?php if ($_GET['diff']==$i) {?> selected="selected"<?php } ?> ><?php echo 难度($i);?></option>
<?php } ?>
</select>
搜索题目
<input name="key" type="text" class='search-query input-medium' value='<?=$_GET['key']?>' title='输入关键字按回车搜索题目，保持默认则为随机题目'/>
<button type="submit" class='btn'>搜索</button>
<p />
<button name="rank" class='btn' value='probname'>按题目名称排序</button>
<button name="rank" class='btn' value='filename'>按文件名称排序</button>
<button name="rank" class='btn' value='plugin'>按评测方式排序</button>
<button name="rank" class='btn' value='timelimit'>按时间限制排序</button>
<button name="rank" class='btn' value='memorylimit'>按空间限制排序</button>
<button name="rank" class='btn' value='difficulty'>按题目难度排序</button>
<button name="rank" class='btn' value='acceptcnt'>按通过次数排序</button>
<?php if(有此权限('查看题目')) { ?>
<button name="rank" class='btn' value='submitable'>按可否提交排序</button>
<? } ?>
</form>
<? 分页($cnt, $_GET['page'], '?caid='.$_GET['caid'].'&diff='.$_GET['diff'].'&key='.$_GET['key'].'&rank='.$_GET['rank'].'&'); ?>
<table id="problist" class='table table-condensed'>
<thead><tr>
<th>PID</th>
<th onclick="sortTable('problist', 0, 'int')">题目名称</th>
<th>文件名称</th>
<th>时间限制</th>
<th>空间限制</th>
<th>难度</th>
<th onclick="sortTable('problist', 6, 'int')">通过</th>
<th onclick="sortTable('problist', 7, 'int')">提交</th>
<th onclick="sortTable('problist', 8, 'int')">通过率</th>
<?php if(有此权限('查看题目')) { ?>
<th class=admin>标识</th>
<th class=admin>权限</th>
<?php } ?>
<?php if(有此权限('修改题目')) { ?>
<th class=admin>编辑</th>
<?php } ?>
</tr></thead>
<?php
if (!$err) for ($i=$st;$i<$cnt && $i<$st+$SET['style_pagesize'] ;$i++) {
    $d=$p->rtnrlt($i);
    if($_GET['key'] && $cnt == 1)
        echo "<script language='javascript'>location='problem.php?pid={$d['pid']}';</script>";
    if (!$d['submitable'] && !有此权限('查看题目')) continue;
    if ($d['readforce']>$_SESSION['readforce'] && !有此权限('查看题目')) continue;
?>
<tr>
<td align=center><?php echo $d['pid'] ?></td>
<td><? 是否通过($d['pid'], $q);?><b><a href="problem.php?pid=<?=$d['pid'] ?>"><?=$d['probname'] ?></a></b></td>
<td align=center><?php echo $d['filename']; ?></td>
<td align=center><?php echo $d['timelimit']/1000 . " s"; ?></td>
<td align=center><?php echo $d['memorylimit'] . " MiB"; ?></td>
<td><?php echo 难度($d['difficulty']); ?></td>
<td align=center><?php echo $d['acceptcnt']; ?></td>
<td align=center><?php echo $d['submitcnt']; ?></td>
<td align=center><?php echo @round($d['acceptcnt']/$d['submitcnt']*100,2); ?>%</td>
<?php if(有此权限('查看题目')) { ?>
<td class=admin align=center>
<?php if ($d['submitable']) echo "<span class=ok>可提交</span>"; else echo "<span class=no>不可提交</span>"; ?>
</td>
<td class=admin align=center><?=$d['readforce']?></td>
<?php } ?>
<?php if(有此权限('修改题目')) { ?>
<td class=admin align=center><a href="../admin/problem/editprob.php?action=edit&pid=<?=$d['pid']; ?>">修改</a></td>
<?php } ?>
</tr>
<?php } ?>
</table>

<?php
include_once("../include/stdtail.php");
?>

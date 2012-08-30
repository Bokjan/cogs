<?php
require_once("../include/header.php");
gethead(1,"","题目列表");
$p=new DataAccess();
$q=new DataAccess();
?>

<div class='container-fluid'>
<script type="text/JavaScript">
function MM_jumpMenu(targ,selObj,restore){
eval(targ+".location='?diff=<?php echo $_GET['diff'] ?>&caid=<?php echo $_GET['caid'] ?>&key=<?php echo $_GET['key'] ?>&page="+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
function MM_jumpMenu_2(targ,selObj,restore){
eval(targ+".location='?caid=<?php echo $_GET['caid'] ?>&key=<?php echo $_GET['key'] ?>&diff="+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
</script>

<?php if(有此权限('修改题目')) { ?>
<a href="editprob.php?action=add" class="btn btn-info pull-left">添加新题目</a>
<?php } ?>
<a href="catelist.php" class='btn btn-success pull-left'><i class="icon-tags icon-white"></i>题目分类列表</a>
<?php if ($_GET['caid']!="") {
    $sql="select * from category where caid={$_GET['caid']}";
    $cnt=$p->dosql($sql);
    $d=$p->rtnrlt(0);
?>

<span id="cate_detail">当前分类：<span class="big"><?php echo $d['cname'] ?></span>（<?php echo nl2br(sp2n(htmlspecialchars($d['memo']))) ?>）</span>
<?php } ?>

<?php
$sql="select problem.* from problem";
if($_GET['caid'])
$sql.=",tag where tag.pid=problem.pid and tag.caid={$_GET['caid']}";
else
$sql .= " where problem.readforce>=0";

if ($_GET['key']!="")
$sql.=" and (problem.probname like '%{$_GET[key]}%' or problem.pid ='{$_GET[key]}' or problem.filename like '%{$_GET[key]}%')";

if ($_GET['diff']!="")
$sql.=" and problem.difficulty='{$_GET['diff']}'";

if($_GET['rank'])
$sql.=" order by {$_GET['rank']} {$_GET['order']}";
else
$sql.=" order by problem.pid asc";

$cnt=$p->dosql($sql);
$st=检测页面($cnt, $_GET['page']);
?>
<form method="get" action="" class='form-search center'>
<a href="random.php" title="随机选择一道你没有通过的题目" class='btn btn-danger' >随机题目</a>
<input name="caid" type="hidden" value="<?=$_GET['caid']?>" />
<input name="order" type="hidden" value="<?=$_GET['order']=='asc'?'desc':'asc'?>" />
难度 
<select name="diff" onchange="MM_jumpMenu_2('parent',this,0)" class='input-medium'>
<option value="" selected="selected" <?php if ($_GET['diff']=="") {?> selected="selected"<?php } ?> >全部</option>
<?php for ($i=1;$i<=10;$i++) { ?>
<option value="<?php echo $i;?>" <?php if ($_GET['diff']==$i) {?> selected="selected"<?php } ?> ><?php echo 难度($i);?></option>
<?php } ?>
</select>
<div class='input-append pull-right'>
<input name="key" type="text" class='search-query input-medium' value='<?=$_GET['key']?>' title='输入关键字按回车搜索题目' placeholder='搜索题目'/>
<button type='submit' class='btn'><i class='icon icon-search'></i></button>
</div>
<p />排序方法：
<button name="rank" class='btn' value='probname'>题目名称</button>
<button name="rank" class='btn' value='filename'>文件名称</button>
<button name="rank" class='btn' value='timelimit'>时间限制</button>
<button name="rank" class='btn' value='memorylimit'>空间限制</button>
<button name="rank" class='btn' value='difficulty'>题目难度</button>
<button name="rank" class='btn' value='plugin'>评测方式</button>
<button name="rank" class='btn' value='acceptcnt'>通过次数</button>
<?php if(有此权限('查看题目')) { ?>
<button name="rank" class='btn' value='submitable'>标识</button>
<? } ?>
</form>
<script language=javascript>
function okic(name) {
    if(confirm("你确定要更改 "+name+" 的提交属性吗？"))
        return true;
    return false;
}
</script>
<table id="problist" class='table table-striped table-condensed table-bordered fiexd'>
<thead><tr>
<th width='20px'>PID</th>
<th onclick="sortTable('problist', 0, 'int')">题目名称</th>
<th>文件名称</th>
<th>时间</th>
<th>空间</th>
<th>难度</th>
<th>评测方式</th>
<th onclick="sortTable('problist', 6, 'int')">通过</th>
<th onclick="sortTable('problist', 7, 'int')">提交</th>
<th onclick="sortTable('problist', 8, 'int')">通过率</th>
<?php if(有此权限('查看题目')) { ?>
<th class=admin>作者</th>
<th class=admin>标识</th>
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
<td><?php echo $d['pid'] ?></td>
<td><? 是否通过($d['pid'], $q);?><b><a href="problem.php?pid=<?=$d['pid'] ?>"><?=$d['probname'] ?></a></b></td>
<td><code><?php echo $d['filename']; ?></code></td>
<td><?php echo $d['timelimit']/1000 . " s"; ?></td>
<td><?php echo $d['memorylimit'] . " MiB"; ?></td>
<td><?php echo 难度($d['difficulty']); ?></td>
<td><?=$STR['plugin'][$d['plugin']]?></td>
<td><?php echo $d['acceptcnt']; ?></td>
<td><?php echo $d['submitcnt']; ?></td>
<td><?php echo @round($d['acceptcnt']/$d['submitcnt']*100,2); ?>%</td>
<?php if(有此权限('查看题目')) { ?>
<td><a href="../user/detail.php?uid=<?=$d['addid']?>"><?=$d['addid']?></a></td>
<td>
<a href="doeditprob.php?action=change&pid=<?=$d['pid']?>" onclick="return okic('<?=$d['probname']?>')">
<?php if ($d['submitable']) echo "<span class='label label-success'>可用</span>"; else echo "<span class='label label-important'>禁用</span>"; ?>
</a>
</td>
<?php } ?>
<?php if(有此权限('修改题目')) { ?>
<td><a href="editprob.php?action=edit&pid=<?=$d['pid']?>">修改</a></td>
<?php } ?>
</tr>
<?php } ?>
</table>
<? 分页($cnt, $_GET['page'], '?caid='.$_GET['caid'].'&diff='.$_GET['diff'].'&key='.$_GET['key'].'&rank='.$_GET['rank'].'&'); ?>
</div>

<?php
include_once("../include/footer.php");
?>

<?php
require_once("../../include/stdhead.php");
gethead(1,"admin","修改题目");
include("../../include/fckeditor/fckeditor.php") ;
?>

<script type="text/javascript">
function FCKeditor_OnComplete( editorInstance )
{
var oCombo = document.getElementById( 'cmbToolbars' ) ;
oCombo.value = editorInstance.ToolbarSet.Name ;
oCombo.style.visibility = '' ;
}
</script>

<script type = "text/javascript">
function checkprobname(){
var probname = $("#probname").val();
$.get("checkprobname.php",{name: probname},function(txt){
if(txt == 0){$("#msg1").html(probname+" - 名称可以使用");}
else {$("#msg1").html(probname+" - <span style='color:red;'>名称已被使用，请换一个！</span>");}
});
}
function checkfilename(){
var filename = $("#filename").val();
$.get("checkfilename.php",{name: filename},function(txt){
if(txt == 0){$("#msg2").html(filename+" - 名称可以使用");}
else {$("#msg2").html(filename+" - <span style='color:red;'>名称已被使用，请换一个！</span>");}
});
}
</script>
<p>
<?php
if ($_GET[action]=='del')
{
echo "确认要删除该题目及与该题目相关所有内容吗(无法恢复)？<p><a href='doeditprob.php?action=del&pid={$_GET[pid]}'>确认删除</a>";
exit;
}
$p=new DataAccess();
$q=new DataAccess();
if ($_GET[action]=='edit')
{
$sql="select * from problem where pid={$_GET[pid]}";
$cnt=$p->dosql($sql);
}
if ($cnt) {
$d=$p->rtnrlt(0);
$ddetail=$d['detail'];
} else {
if ($_GET[action]=='add') {
$d=array();
$d['submitable']=1;
$d['datacnt']=10;
$d['timelimit']=1000;
$d['memorylimit']=128;
$d['difficulty']=2;
$d['readforce']=0;
$d['plugin']=1;
$d['group']=0;
$ddetail="请在此键入题目内容";
}
else echo '<script>document.location="../../error.php?id=12"</script>';
}
?>
<form action="doeditprob.php" method="post">
<table width="100%" border="1"  bordercolor=#000000 cellspacing=0 cellpadding=4>
<tr>
<td width="10%" valign="top" scope="col">PID</td>
<td width="90%" scope="col"><?php echo $d[pid] ?>
<input name="pid" type="hidden" id="pid" value="<?php echo $d['pid'] ?>" /></td>
</tr>
<tr>
<td valign="top">题目名</td>
<td><input name="probname" type="text" id="probname" onchange="checkprobname()" value="<?php echo $d[probname] ?>" class="InputBox" /><div id="msg1"></div></td>
</tr>
<tr>
<td valign="top">文件名</td>
<td><input name="filename" type="text" id="filename" onchange="checkfilename()" value="<?php echo $d[filename] ?>" class="InputBox" /><div id="msg2"></div></td>
</tr>
<tr>
<td valign="top">阅读权限</td>
<td><input name="readforce" type="number" id="readforce" value="<?php echo $d['readforce'] ?>" class="InputBox" /></td>
</tr>
<tr>
<td valign="top">可提交</td>
<td><input name="submitable" type="checkbox" id="submitable" value="1" <?php if ($d['submitable']) echo 'checked="checked"'; ?> class="InputBox" /></td>
</tr>
<tr>
<td valign="top">测点数目</td>
<td><input name="datacnt" type="number" id="datacnt" value="<?php echo $d[datacnt] ?>" class="InputBox" />
<!--【暂不可用】测试数据打包zip(文件包含一个以该题目命名的文件夹，其中为in和ans数据)：
<input type="file" name="file" id="file" class="Button"/>
<input type="hidden" name="MAX_FILE_SIZE" value="102400">
-->
</td>
</tr>
<tr>
<td valign="top">时间限制</td>
<td><input name="timelimit" type="number" id="timelimit" value="<?php echo $d[timelimit] ?>" class="InputBox" /> 毫秒(ms)</td>
</tr>
<tr>
<td valign="top">内存限制</td>
<td><input name="memorylimit" type="number" id="memorylimit" value="<?php echo $d['memorylimit'] ?>" class="InputBox" /> 兆字节(MiB, 1024进制)</td>
</tr>
<tr>
<td valign="top">难度等级</td>
<td><input name="difficulty" type="number" id="difficulty" value="<?php echo $d['difficulty'] ?>" class="InputBox" /></td>
</tr>
<tr>
<td valign="top">开放分组</td>
<td><select name="group" id="group" class="InputBox">
<?php
$sql="select * from groups order by gname";
$c=$q->dosql($sql);
for ($j=0;$j<$c;$j++)
{
$e=$q->rtnrlt($j);
?>
<option value="<?php echo $e['gid'] ?>" <?php if($e['gid']==$d['group']) echo 'selected="selected"' ?>>[<?php echo $e['gname'] ?>]</option>
<?php }?>
</select></td>
</tr>
<tr>
<td valign="top">对比方式</td>
<td><select name="plugin" id="plugin" class="InputBox">
<option value="-1"<?php if ($d['plugin']==-1){ ?> selected="selected"<?php } ?>>交互式</option>
<option value="1"<?php if ($d['plugin']==1){ ?> selected="selected"<?php } ?>>简单对比</option>
<option value="2"<?php if ($d['plugin']==2){ ?> selected="selected"<?php } ?>>逐字节对比</option>
<option value="0"<?php if ($d['plugin']==0){ ?> selected="selected"<?php } ?>>评测插件</option>
</select>                </td>
</tr>
<tr>
<td valign="top"><!--<a href="javascript:{switchhide('bc');switchhide('bctip')}">-->所属分类<!--</a>--></td>
<td><!--<div id="bctip">点击左边链接显示</div>-->
<?php
if ($_GET[pid]) {
$sql="select caid from tag where pid={$_GET[pid]}";
$cnt=$p->dosql($sql);
for ($i=0;$i<=$cnt-1;$i++) {
$d=$p->rtnrlt($i);
$hash[$d[caid]]=true;
}
}


$sql="select * from category order by cname";
$cnt=$p->dosql($sql);
if ($cnt)
{
$table_width=9;
?>

<table border="1" id="bc">
<tr>
<?php
$last=0;
$linecnt=0;
$line=1;
for ($i=0;$i<$cnt;$i++)
{
$d=$p->rtnrlt($i);
$last=$d['pid'];
$linecnt++;
?>
<td><input name="cate[<?php echo $d[caid] ?>]" type="hidden" value="0" />
<input name="cate[<?php echo $d[caid] ?>]" type="checkbox" id="cate[<?=$d[caid]?>]" value="1" 
<?php if ($hash[$d[caid]]) echo 'checked="checked"';?>  /><label for="cate[<?=$d[caid]?>]"> <?php echo $d['cname'] ?></label></td>
<?php
if ($linecnt==$table_width)
{
    $linecnt=0;
    $line++;
    ?>
        </tr>
        <tr>
        <?php
}
}
if ($linecnt>0 && $line>1)
{
for ($i=$linecnt;$i<$table_width;$i++)
{
?>
    <td>&nbsp;</td>
    <?php
}
}
?>
</tr>
</table><script language="javascript">switchhide('bc')</script>
<?php
}
?>
</td>
</tr>
<tr>
<td valign="top">题目内容</td>
<td><?php
$oFCKeditor = new FCKeditor('detail') ;
$oFCKeditor->BasePath = "../../include/fckeditor/" ;

if ( isset($_GET['Toolbar']) )
$oFCKeditor->ToolbarSet = htmlspecialchars($_GET['Toolbar']);

$oFCKeditor->Value =$ddetail;
$oFCKeditor->Create() ;
?></td>
</tr>
</table>
<br>
<input type="submit" value="提交" class="Button">
<input name="action" type="hidden" id="action" value="<?php echo $_GET[action] ?>" />
</form>

<?php
include_once("../../include/stdtail.php");
?>

<?php
require_once("../include/header.php");
gethead(1,"","用户列表");
?>
<?php
    $p=new DataAccess();
    $q=new DataAccess();
    $r=new DataAccess();
    $sql="select userinfo.*,groups.gname from userinfo,groups where groups.gid=userinfo.gbelong ";

    if ($_GET['gid']=="")
        $_GET['gid']=0;
    $sql1="select * from groups where gid={$_GET['gid']}";
    $cnt=$p->dosql($sql1);
    $d=$p->rtnrlt(0);
    
    $subgroup=$LIB->getsubgroup($p,$_GET['gid']);
    
    $sql.=" and ( userinfo.gbelong={$_GET['gid']} ";
    
    foreach($subgroup as $value) {
        $sql.=" or userinfo.gbelong={$value}";
    }
    $sql.=") ";

?>
<div class='btn-group pull-left'>
<a href="grouplist.php" class='btn btn-success pull-left'><i class='icon-th-large icon-white'></i>用户分组列表</a>
<button class='btn btn-success dropdown-toggle' data-toggle='dropdown'><span class='caret'></span></button>
<ul id="group_now" class='dropdown-menu span4'>
<li>当前分组</li>
<li><a href=""><span class='label'><?=$d['gname'] ?></span><?=nl2br(sp2n(htmlspecialchars($d['memo']))) ?></a></li>
<?php if ($d['parent']) {
$sql2="select * from groups where gid={$d['parent']}";
$q->dosql($sql2);
$e=$q->rtnrlt(0);
?>
<li class='divider'></li>
<li>上级分组</li>
<li><a href="index.php?gid=<?=$e['gid'] ?>"><?=$e['gname'] ?></a></li>
<?php } ?>
<?php 
if ($subgroup!=array()) {
?>
<li class='divider'></li>
<li>下级分组</li>
<li><?php
foreach($subgroup as $value) {
$sql2="select * from groups where gid={$value}";
$q->dosql($sql2);
$e=$q->rtnrlt(0);
?>
<a href="index.php?gid=<?=$e['gid'] ?>"><?=$e['gname'] ?></a>
<?php 
}
?></li>
<?php } ?>
</ul>
</div>
<?php
    if ($_GET['key']!="")
        $sql.=" and (nickname like '%{$_GET[key]}%' or uid ='{$_GET[key]}' or usr like '%{$_GET[key]}%' or realname like '%{$_GET[key]}%')";
if($_GET['rank'])
$sql.=" order by {$_GET['rank']} {$_GET['order']}";
else
$sql.=" order by grade desc";

$cnt=$p->dosql($sql);
$st=检测页面($cnt, $_GET['page']);
?>
<form method="get" action="" class='form-search center'>
  <input name="gid" type="hidden" value="<?=$_GET['gid'] ?>" />
  <input name="order" type="hidden" value="<?=$_GET['order']=='asc'?'desc':'asc'?>" />
<div class='input-append pull-right'>
<input name="key" type="text" class='search-query input-medium' value='<?=$_GET['key']?>' placeholder='搜索用户'/>
<button type='submit' class='btn'><i class='icon icon-search'></i></button>
</div>
<div class='btn-group'>排序方法：
  <button name="rank" type="submit" value='uid' class='btn'>UID</button>
  <button name="rank" type="submit" value='nickname' class='btn'>昵称</button>
  <?php if(有此权限('查看用户')) { ?>
  <button name="rank" type="submit" value='realname' class='btn'>姓名</button>
  <? } ?>
  <button name="rank" type="submit" value='readforce' class='btn'>阅读</button>
  <button name="rank" type="submit" value='gbelong' class='btn'>分组</button>
  <button name="rank" type="submit" value='accepted' class='btn'>通过</button>
  <button name="rank" type="submit" value='accepted/submited' class='btn'>通过率</button>
  <button name="rank" type="submit" value='grade' class='btn'>等级</button>
</div>
</form>
<script language=javascript>
function okdel(name) {
    if(confirm("你确定要删除 "+name+" 的所有信息吗？\n删除之后将不可恢复！"))
        return true;
    return false;
}
</script>
<div class='row-fluid'>
<table id="userlist" class='table table-striped table-condensed table-bordered fiexd'>
<thead>
  <tr>
    <th width='30px'></th>
    <th width='35px'>UID</th>
    <th width='120px'>昵称</th>
    <? if(有此权限('查看用户')) { ?><th class='admin' width='50px'>姓名</th><? } ?>
    <th>权限</th>
    <th width='40px'>阅读</th>
    <th width='140px'>分组</th>
    <th width='40px'>通过</th>
    <th width='50px'>通过率</th>
    <th width='40px'>等级</th>
    <? if(有此权限('查看用户')) { ?><th class='admin' width='100px'>IP</th><? } ?>
    <? if(有此权限('修改用户')) { ?><th class='admin' width='100px'>操作</th><? } ?>
  </tr>
</thead>
<?php
    if (!$err) for ($i=$st;$i<$cnt && $i<$st+$SET['style_pagesize'] ;$i++) {
        $d=$p->rtnrlt($i);
?>
  <tr>
    <th class='center'><?=$i+1?></th>
    <td><?=$d['uid'] ?></td>
    <td><a href="detail.php?uid=<?=$d['uid'] ?>"><?=gravatar::showImage($d['email']);?><?=$d['nickname'] ?></a></td>
    <? if(有此权限('查看用户')) { ?><td ><?=$d['realname'] ?></td><? } ?>
    <td><?
    $sql="select privilege.* from privilege where uid={$d['uid']} order by pri asc";
	$cnt1=$r->dosql($sql);
	for($i1=0;$i1<$cnt1;$i1++) {
		$e=$r->rtnrlt($i1);
        echo array_search($e['pri'],$pri) . " ";
    } ?></td>
    <td ><?=$d['readforce'] ?></td>
    <td ><?="<a href='?gid={$d['gbelong']}'>{$d['gname']}</a>"; ?></td>
    <td ><?=$d['accepted'] ?></td>
    <td ><?=@round($d['accepted']/$d['submited']*100,2); ?>%</td>
    <td ><?=$d['grade'] ?></td>
    <? if(有此权限('查看用户')) { ?>
    <td>
    <a href="http://www.youdao.com/smartresult-xml/search.s?type=ip&q=<?=$d['lastip'] ?>"><?=$d['lastip'] ?></a>
    </td><? } ?>
    <? if(有此权限('修改用户')) { ?><td>
    <? if(有此权限('修改权限')) { ?>
    <a href='privilege.php?way=edit&uid=<?=$d['uid']?>'>权限</a>
    <? } ?>
    <a href="edituser.php?uid=<?=$d['uid'] ?>">修改</a>
    <a href="doedituser.php?uid=<?=$d['uid'] ?>&action=del" onclick="return okdel('<?=$d['nickname']?>')">删除</a>
    </td><? } ?>
  </tr>
<?php
    }
?>
</table>
<? 分页($cnt, $_GET['page'], '?key='.$_GET['key'].'&sc'.$_GET['sc'].'&rank='.$_GET['rank'].'&order='.$_GET['order'].'&caid='.$_GET['caid'].'&'); ?>
</div>
<?php
include_once("../include/footer.php");
?>

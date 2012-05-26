<?php
require_once("../include/stdhead.php");
gethead(1,"","用户列表");
?>

<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='?key=<?=$_GET['key'] ?>&rank=<?=$_GET['rank'] ?>&page="+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
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
<table id="group_now" class='table table-condensed fixed'>
  <tr>
    <th width="80px">当前分组</th>
    <td>[<?=$d['gname'] ?>] <?=nl2br(sp2n(htmlspecialchars($d['memo']))) ?></td>
  </tr>
<?php if ($d['parent']) {
    $sql2="select * from groups where gid={$d['parent']}";
    $q->dosql($sql2);
    $e=$q->rtnrlt(0);
?>
  <tr>
    <th>上级分组</th>
    <td>[<a href="index.php?gid=<?=$e['gid'] ?>"><?=$e['gname'] ?></a>]</td>
  </tr>
<?php } ?>
<?php 
if ($subgroup!=array()) {
?>
  <tr>
    <th>下级分组</th>
    <td><?php
    foreach($subgroup as $value) {
        $sql2="select * from groups where gid={$value}";
        $q->dosql($sql2);
        $e=$q->rtnrlt(0);
?>
        [<a href="index.php?gid=<?=$e['gid'] ?>"><?=$e['gname'] ?></a>]
<?php 
    }
?></td>
  </tr>
<?php } ?>
</table>
<?php
    if ($_GET['key']!="")
        $sql.=" and (nickname like '%{$_GET[key]}%' or uid ='{$_GET[key]}' or usr like '%{$_GET[key]}%' or realname like '%{$_GET[key]}%')";
if($_GET['rank'])
$sql.=" order by {$_GET['rank']} {$_GET['order']}";
else
$sql.=" order by grade desc";

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
  <input name="gid" type="hidden" value="<?=$_GET['gid'] ?>" />
  <input name="order" type="hidden" value="<?=$_GET['order']=='asc'?'desc':'asc'?>" />
  搜索用户
<input name="key" type="text" class='search-query input-medium' value='<?=$_GET['key']?>' />
<button type="submit" class='btn'>搜索</button>
<p>
  <button name="rank" type="submit" value='uid' class='btn'>按ID排序</button>
  <button name="rank" type="submit" value='nickname' class='btn'>按昵称排序</button>
  <?php if(有此权限('查看用户')) { ?>
  <button name="rank" type="submit" value='realname' class='btn'>按姓名排序</button>
  <? } ?>
  <button name="rank" type="submit" value='readforce' class='btn'>按阅读权限排序</button>
  <button name="rank" type="submit" value='gbelong' class='btn'>按分组排序</button>
  <button name="rank" type="submit" value='accepted' class='btn'>按通过数量排序</button>
  <button name="rank" type="submit" value='accepted/submited' class='btn'>按通过率排序</button>
  <button name="rank" type="submit" value='grade' class='btn'>按等级排序</button>
</form>
<? 分页($cnt, $_GET['page'], '?key='.$_GET['key'].'&sc'.$_GET['sc'].'&rank='.$_GET['rank'].'&caid='.$_GET['caid'].'&'); ?>
<script language=javascript>
function okdel(name) {
    if(confirm("你确定要删除 "+name+" 的所有信息吗？\n删除之后将不可恢复！"))
        return true;
    return false;
}
</script>
<table id="userlist" class='table table-condensed fixed'>
<thead>
  <tr>
    <th width='30px'></th>
    <th width='35px'>UID</th>
    <th width='120px'>昵称</th>
    <? if(有此权限('查看用户')) { ?><th class='admin' width='50px'>姓名</th><? } ?>
    <th>权限</th>
    <th width='40px'>阅读</th>
    <th width='120px'>分组</th>
    <th width='40px'>通过</th>
    <th width='40px'>通过率</th>
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
    <td><a href="../user/detail.php?uid=<?=$d['uid'] ?>" target="_blank"><?=gravatar::showImage($d['email']);?><?=$d['nickname'] ?></a></td>
    <? if(有此权限('查看用户')) { ?><td class=admin align=center><?=$d['realname'] ?></td><? } ?>
    <td><?
    $sql="select privilege.* from privilege where uid={$d['uid']} order by pri asc";
	$cnt1=$r->dosql($sql);
	for($i1=0;$i1<$cnt1;$i1++) {
		$e=$r->rtnrlt($i1);
        echo array_search($e['pri'],$pri) . " ";
    } ?></td>
    <td align=center><?=$d['readforce'] ?></td>
    <td align=center><?="<a href='?gid={$d['gbelong']}'>{$d['gname']}</a>"; ?></td>
    <td align=center><?=$d['accepted'] ?></td>
    <td align=center><?=@round($d['accepted']/$d['submited']*100,2); ?>%</td>
    <td align=center><?=$d['grade'] ?></td>
    <? if(有此权限('查看用户')) { ?>
    <td class=admin>
    <a href="../admin/user/loginlog.php?uid=<?=$d['uid'] ?>"><?=$d['lastip'] ?></a>
    </td><? } ?>
    <? if(有此权限('修改用户')) { ?><td class=admin align=center>
    <? if(有此权限('修改权限')) { ?>
    <a href='../admin/settings.php?settings=privilege&way=edit&uid=<?=$d['uid']?>'>权限</a>
    <? } ?>
    <a href="../admin/user/edituser.php?uid=<?=$d['uid'] ?>">修改</a>
    <a href="../admin/user/doedituser.php?uid=<?=$d['uid'] ?>&action=del" onclick="return okdel('<?=$d['nickname']?>')">删除</a>
    </td><? } ?>
  </tr>
<?php
    }
?>
</table>
<?php
    include_once("../include/stdtail.php");
?>

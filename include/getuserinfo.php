<?
$p=new DataAccess();
$sql="select * from userinfo where uid={$uid}";
$p->dosql($sql);
$d=$p->rtnrlt(0);
$_SESSION['ID']=$d['uid'];
$_SESSION['nickname']=$d['nickname'];
$_SESSION['readforce']=$d['readforce'];
$_SESSION['group']=$d['gbelong'];
$_SESSION['email']=$d['email'];
$_SESSION['grade']=$d['grade'];
$_SESSION['user_style']=$d['user_style']?$d['user_style']:$SET["user_style"];

$sql = "select * from privilege where uid=$uid";
$cnt=$p->dosql($sql);
for ($i=0;$i<$cnt;$i++) {
	$d=$p->rtnrlt($i);
    $_SESSION['pri'.$d['pri']]=$d['def'];
}

?>

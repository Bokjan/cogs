<?php
require_once("../include/stdhead.php");
gethead(8,"sess","");

if ($_POST[action]=="edit") {
    if($_FILES['file']['tmp_name']) {
        $portrait=$SET['base']."images/background";
        $path = pathconvert($SET['cur'],$portrait).'/';
        $backfile = $path . $_POST['uid'] . ".png";
        if(file_exists($backfile)) {
            $cmd = "rm $backfile";
            $hr = popen($cmd, 'r');
            pclose($hr);
        }
        $cmd = "convert {$_FILES['file']['tmp_name']} $backfile";
        $hr = popen($cmd, 'r');
        pclose($hr);
    }
	$p=new DataAccess();
	$sql="update userinfo set nickname='{$_POST['nick']}',realname='{$_POST['realname']}',email='{$_POST['email']}',memo='{$_POST['memo']}' where uid={$_POST['uid']}";
	$p->dosql($sql);
	$LIB->get_userinfo($_GET['uid']);
    提示("用户设置信息修改成功！", 取路径("user/panel.php"));
}
if ($_POST[action]=="editpwd") {
	if ($_POST[npwd1]==$_POST[npwd2]) {
		$p=new DataAccess();
		$sql="select pwdhash,nickname from userinfo where uid={$_GET[uid]}";
		$p->dosql($sql);
		$d=$p->rtnrlt(0);
		if ($d[pwdhash]==encode($_POST[opwd])) {
			$sql="update userinfo set pwdhash='". encode($_POST[npwd1]) ."' where uid={$_GET[uid]}";
			$p->dosql($sql);
            提示("用户 $nickname 的密码修改成功！", 取路径("user/panel.php"));
		} else
            异常("旧密码不正确！", 取路径("user/panel.php"));
	} else {
        异常("两次输入的密码不匹配！", 取路径("user/panel.php"));
	}
}
?>

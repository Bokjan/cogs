<?php
require_once("../../include/stdhead.php");
gethead(0,"admin","");

if ($_POST[submitable]==1) $sub=1; else $sub=0;
if ($_REQUEST[action]=='add')
{
	$p=new DataAccess();
	$sql="insert into problem(probname,filename,readforce,submitable,datacnt,timelimit,memorylimit,detail,addtime,addid,difficulty,plugin,`group`) values('{$_POST[probname]}','{$_POST[filename]}',{$_POST[readforce]},{$sub},{$_POST[datacnt]},{$_POST[timelimit]},{$_POST[memorylimit]},'".str_replace("'", "\'", $_POST[detail])."',".time().",{$_SESSION[ID]},{$_POST[difficulty]},'{$_POST['plugin']}','{$_POST['group']}')";
	$p->dosql($sql);
	
	$sql="select pid from problem where filename='{$_POST['filename']}'";
	$p->dosql($sql);
	$d=$p->rtnrlt(0);
	$pid=$d['pid'];
	foreach($_POST[cate] as $k=>$v)
	{
		if ($v)
		{
			$sql="insert into tag(pid,caid) values({$pid},{$k})";
			$p->dosql($sql);
		}
	}
}

if ($_REQUEST[action]=='edit')
{
	$p=new DataAccess();
	$sql="update problem set probname='{$_POST[probname]}',filename='{$_POST[filename]}',readforce={$_POST[readforce]},submitable={$sub},datacnt={$_POST[datacnt]},timelimit={$_POST[timelimit]},memorylimit={$_POST[memorylimit]},detail='".str_replace("'", "\'", $_POST[detail])."',difficulty={$_POST[difficulty]},plugin='{$_POST['plugin']}',`group`='{$_POST['group']}' where pid={$_REQUEST[pid]}";
	$p->dosql($sql);
	foreach($_POST[cate] as $k=>$v)
	{
		$sql="select tid from tag where caid={$k} and pid={$_REQUEST[pid]}";
		$cnt=$p->dosql($sql);
		if (!$cnt)
		{
			if ($v)
				$sql="insert into tag(pid,caid) values({$_REQUEST[pid]},{$k})";
		}
		else
		{
			if (!$v)
				$sql="delete from tag where pid={$_REQUEST[pid]} and caid={$k}";
		}
		$p->dosql($sql);
	}
	$pid=$_REQUEST[pid];
}

if ($_REQUEST[action]=='del') {
	$p=new DataAccess();
	$sql="delete from problem where pid={$_REQUEST[pid]}";
	$p->dosql($sql);
	$pid=0;
}

/*if($_FILES['file']) {
if($_FILES['file']['error'] > 0) {
    echo "<h3>文件上传失败！</h3>";
} else {
    echo "解压缩数据。";
    chdir("/home/ruvtex/grading_data/testdata");
    move_uploaded_file($_FILES['file']['tmp_name'],"tmp.zip");
    chmod("tmp.zip",0664);
    $handle = popen("unzip -cl -o tmp.zip", 'r');
    rfile($handle);
    pclose($handle);
}
} else*/
echo "<script>document.location=\"../../refresh.php?id=7&pid={$pid}\"</script>";
?>

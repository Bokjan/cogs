<table width="100%" border="1"  bordercolor=#000000  cellspacing=0 cellpadding=4>
  <tr>
    <th width="6%" scope="col">GRID</th>
    <th width="8%" scope="col">����</th>
    <th width="12%" scope="col">��ַ</th>
    <th width="6%" scope="col">״̬</th>
    <th width="6%" scope="col">�汾</th>
    <th width="8%" scope="col">�������</th>
    <th width="8%" scope="col">���ȼ�</th>
    <th width="24%" scope="col">��ע</th>
    <th width="16%" scope="col">����</th>
  </tr>
<?php
	$LIB->func_socket();

	$p=new DataAccess();
	$sql="select * from grader";
	$cnt=$p->dosql($sql);
	$totalpage=(int)(($cnt-1)/$SETTINGS['style_pagesize'])+1;
	if (!isset($_GET[page])) 
	{
		$_GET[page]=1;
		$st=0;
	}
	else 
	{
		if ($_GET[page]<1 || $_GET[page]>$totalpage)
		{
			echo "ҳ����";
			$err=1;
		}
		else
		$st=(($_GET[page]-1)*$SETTINGS['style_pagesize']);
	}
	if (!$err)
	for ($i=$st;$i<$cnt && $i<$st+$SETTINGS['style_pagesize'] ;$i++)
	{
		$d=$p->rtnrlt($i);
		$s['action']="state";
		$tmp=httpsocket($d['address'],$s);
		$tmp=array_decode($tmp);

		if ($tmp==array())
		{
			$tmp['name']="�޷�����";
			$tmp['state']="δ֪";
			$tmp['ver']="δ֪";
			$tmp['cnt']="δ֪";
		}
?>
  <tr>
    <td><?php echo $d['grid'] ?></td>
    <td><?php echo $tmp['name'] ?></td>
    <td><?php echo $d['address'] ?></td>
    <td><?php echo $tmp['state'] ?></td>
    <td><?php echo $tmp['ver'] ?></td>
    <td><?php echo $tmp['cnt'] ?></td>
    <td><?php echo $d['priority'] ?></td>
    <td><?php echo sp2n(htmlspecialchars($d['memo'])) ?></td>
    <td><a href="grader/editgrader.php?action=edit&grid=<?php echo $d['grid'] ?>">�޸�</a> <a href="grader/doeditgrader.php?action=start&grid=<?php echo $d['grid'] ?>">����</a> <a href="grader/doeditgrader.php?action=stop&grid=<?php echo $d['grid'] ?>">�ر�</a></td>
  </tr>
<?php
	}
?>
</table>
<p><a href="grader/editgrader.php?action=add">����������</a></p>
<p>��ǰ��<?php echo $_GET[page]?>ҳ ��<?php echo $cnt?>����¼ ��<?php echo $totalpage?>ҳ ÿҳ�����ʾ<?php echo $SETTINGS['style_pagesize'] ?>����¼</p>
<form id="form1" name="form1" method="get" action="">
  <p>

    <?php 
if (!$err)
{
	if ($_GET[page]>1)
	{
		$lp=$_GET[page]-1;
		
		$url="?";
		foreach($_GET as $k=>$v)
		{
			if ($k!='page')
				$url.="{$k}={$v}&";
		}
		$url.="page=$lp";
		
		echo "<a href='$url'>��һҳ</a>";
	}
	if ($_GET[page]!=$totalpage)
	{
		$lp=$_GET[page]+1;
		
		$url="?";
		foreach($_GET as $k=>$v)
		{
			if ($k!='page')
				$url.="{$k}={$v}&";
		}
		$url.="page=$lp";
		
		echo " <a href='$url'>��һҳ</a>";	
	}
}
?>
    ȥ��
    <input name="page" type="text" id="page" size="4"  class="InputBox" />
    ҳ 
  <input name="fastgo" type="submit" id="fastgo" value="go" class="Button" />
  <input name="settings" type="hidden" id="settings" value="grader" />
</form>
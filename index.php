<?php
require_once("./include/header.php");
gethead(1,"","首页");
$p=new DataAccess();
$q=new DataAccess();
$sizee=$SET['style_ranksize'] - 7;
?>
<div class='row-fluid'>
<div class='span9'>
<div class='row-fluid'>
<div class='span4'>
<?php 
$now = time();
$noww = time() + 60*60*2;
$cnt = $p->dosql("select comptime.*,compbase.*,userinfo.nickname,groups.* from comptime,compbase,userinfo,groups where comptime.cbid=compbase.cbid and userinfo.uid=compbase.ouid and comptime.group=groups.gid and endtime > $now and starttime < $noww order by starttime asc");
if($cnt) {
    for($i=0; $i<$cnt; $i++) {
        $d=$p->rtnrlt($i);
?>
<table class='table table-striped table-condensed table-bordered fiexd'>
<tr>
<th width="40px">比赛</th>
<th><?php echo $d[cname] ?></th>
</tr>
<tr>
<td>状态</td>
<td><?php
if (time()>$d[endtime]) echo "<span class='did'>已结束</span>"; else
if (time()<$d[endtime] && time()>$d[starttime]) echo "<a href='contest/problem.php?ctid={$d[ctid]}'><span class='doing'>正在进行...</span></a>"; else
echo "<span class='todo'>还未开始</span>"; 
?></td>
</tr>
<tr>
<td>开始</td>
<td><?php echo date('Y-m-d H:i:s', $d[starttime]) ?></td>
</tr>
<tr>
<td>结束</td>
<td><?php echo date('Y-m-d H:i:s', $d[endtime]) ?></td>
</tr>
<tr>
<td>分组</td>
<td><a href="../user/index.php?gid=<?php echo $d['gid'] ?>"><?php echo $d['gname'] ?></a></td>
</tr>
<tr>
<td>介绍</td>
<td><?php echo nl2br(sp2n(htmlspecialchars($d[intro]))) ?></td>
</tr>
</table>
<?php } ?>
<br />
<? } else { ?>
<table class='table table-striped table-condensed table-bordered fiexd'>
<?php 
$cnt=$p->dosql("select * from page order by etime desc limit 6");
for($i=0;$i<$cnt;$i++) {
$d=$p->rtnrlt($i);
?>
<tr><td><a href="page/page.php?aid=<?=$d['aid']?>"><?=$d['title']?></a></td></td>
<?php } ?>
</table>
<? } ?>
</div>
<div class='span8'>
<div class='alert alert-info'>
<?=输出文本($SET['global_bulletin']); ?>
</div>
<div id='index'>
<?php //echo 输出文本($SET['global_index']); ?>
<?php echo 输出文本($SET['global_head']); ?>
</div>
</div>
</div>
<div class='row-fluid'>
<div class='span4'>
<table class='table table-striped table-condensed table-bordered fiexd'>
<thead>
<tr>
<th width="40px">PID</th>
<th>最新题目
<a href="problem/random.php" title="随机选择一道你没有通过的题目" class='btn btn-danger btn-mini pull-right' >随机题目</a>
</th>
</thead>
</tr>
<?php 
$cnt=$p->dosql("select * from problem where submitable=1 order by addtime desc limit {$SET['index_problem_size']}");
for($i=0;$i<$cnt;$i++) {
$d=$p->rtnrlt($i);
?>
<tr>
<td><?php echo $d['pid']; ?></td>
<td>
<? 是否通过($d['pid'], $q); ?>
<a href="problem/problem.php?pid=<?php echo $d['pid']; ?>"><?php echo shortname($d['probname']); ?></a></td>
</tr>
<?php } ?>
</table>
</div>
<div class='span8'>
<table class='table table-striped table-condensed table-bordered fixed'>
<thead><tr>
<th>题目</th>
<th>用户</th>
<th width='95px'>评测结果</th>
<th width='36px'>得分</th>
<th width='66px'>提交时间</th>
</tr></thead>
<?php 
$cnt=$p->dosql("select submit.sid,submit.pid,submit.uid,submit.result,submit.score,submit.accepted,submit.subtime,problem.probname,userinfo.nickname,userinfo.realname,userinfo.email from submit,problem,userinfo where submit.score>={$SET['index_submit_score']} and submit.uid=userinfo.uid and submit.pid=problem.pid order by submit.sid desc limit {$SET['index_submit_size']}");
for($i=0;$i<$cnt;$i++) {
    $d=$p->rtnrlt($i);
?>
<tr>
<td><a href='problem/problem.php?pid=<?=$d['pid']?>'><?=shortname($d['probname'])?></a></td>
<td><a href='user/detail.php?uid=<?=$d['uid']?>'><?=gravatar::showImage($d['email']);?><?php if(有此权限("查看用户")) echo $d['realname']; else echo $d['nickname'];?></a></td>
<td><a href='submit/code.php?id=<?=$d['sid']?>'><?=评测结果($d['result'], 10, true)?></a></td>
<td><span class="<?=$d['accepted']?'ok':'no'?>"><?=$d['score'] ?></span></td>
<td><?php echo date('H:i:s',$d['subtime']); ?></td>
</tr>
<?php } ?>
</table>
</div>
</div>
</div>
<div class='span3'>
<table class='table table-striped table-condensed table-bordered fixed'>
<thead>
<tr>
<th width='12px'></th>
<th>用户排名</th>
<th width='34px'>积分</th>
<th width='34px'>题目</th>
</tr>
</thead>
<?php 
$cnt=$p->dosql("select * from userinfo order by grade desc limit 0, {$SET['style_ranksize']}");
for($i=0;$i<$cnt;$i++) {
$d=$p->rtnrlt($i);
?>
<tr>
<td><i><?=$i+1 ?></i></td>
<td><a href="user/detail.php?uid=<?php echo $d['uid']; ?>"><?=gravatar::showImage($d['email'], $SET['index_rank_icon']);?></a>
<a href="user/detail.php?uid=<?php echo $d['uid']; ?>"><?php if(有此权限("查看用户")) echo $d['realname']; else echo $d['nickname'];?></a></td>
<td><?=$d['grade']?></td>
<td><?=$d['accepted']?></td>
</tr>
<?php } ?>
</table>
</div>
</div>
<?php
require_once("./include/footer.php");
?>

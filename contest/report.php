<?php
require_once("../include/header.php");
gethead(1,"","比赛成绩");

$p=new DataAccess();
$r=new DataAccess();
$sql="select comptime.starttime,comptime.endtime,compbase.contains,comptime.showscore from compbase,comptime where comptime.cbid=compbase.cbid and comptime.ctid={$_GET[ctid]}";
$cnt=$p->dosql($sql);
if (!$cnt)
    异常("未查询到记录！");
$d=$p->rtnrlt(0);
if (!$d['showscore'] && !有此权限('查看比赛'))
    异常("成绩还未公布！");
if(time() < $d['starttime'] && !有此权限('查看比赛'))
    异常("比赛尚未开始，不能查看关于题目的任何信息！");
$end = time() > $d['endtime'];
$q=new DataAccess();
$pbs=explode(":",$d['contains']);
?>
<div class='row-fluid'>
<table id="contest_report" class='table table-striped table-condensed table-bordered fiexd'>
<thead>
  <tr>
    <th style="width: 5ex;">名次</th>
    <th>用户</th>
<?php
    $cnt_prob=0;
    foreach($pbs as $k=>$v) {
        $v=(int)$v;
        $mbarray[$v][score]=0;
        $mbarray[$v][result]="N";
        $sql="select probname from problem where pid={$v}";
        $p->dosql($sql);
        $d=$p->rtnrlt(0);
        $cnt_prob++;
?>
    <th><a href="problem.php?pid=<?=$v?>&ctid=<?=$_GET[ctid]?>" target="_blank"><?=shortname($d['probname'])?></a>
    <? if($end || 有此权限('查看比赛')) { ?><a href="../problem/problem.php?pid=<?=$v?>" target="_blank" title="跳转到题目 <?=$d['probname']?>"><i class='icon-share'></i></a><? } ?>
    </th>
    <th onclick="sortTable('contest_report', <?=$cnt_prob*2+1?>, 'int')" style="width: 5ex; cursor: pointer; color:navy;">得分</th>
<?php
    }
?>
    <th onclick="sortTable('contest_report', <?=$cnt_prob*2+2?>, 'int')" style="width: 6ex; cursor: pointer; color:navy;">总分</th>
  </tr>
</thead>
<?php 
    $sql="select userinfo.uid,userinfo.nickname,userinfo.realname,userinfo.email from userinfo,compscore where compscore.uid=userinfo.uid and compscore.ctid=$_GET[ctid] order by uid";
    $cnt=$p->dosql($sql);
    $luid=0;
    $rowcnt=0;
    for ($i=0;$i<$cnt;$i++) {
        $d=$p->rtnrlt($i);
        if ($d[uid]==$luid) continue;
        $rowcnt++;
        $luid=$d[uid];
?>
  <tr>
    <td id="rank<?=$rowcnt?>"></td>
    <td id="nickname<?=$rowcnt ?>"><a href="../user/detail.php?uid=<?=$d['uid'] ?>" target="_blank">
<?=gravatar::showImage($d['email'], 14);?>
<?=有此权限('查看用户') ? $d['realname'] : $d['nickname'] ?>
</a></td>
<?php
        $sql="select pid,result,score,csid,lang from compscore where uid='{$d['uid']}' and ctid={$_GET[ctid]} order by pid asc";
        $cnt_sub=$q->dosql($sql);
        $sum=0;
        $rank=$mbarray;
        for ($j=0;$j<$cnt_sub;$j++) {
            $e=$q->rtnrlt($j);
            $sum+=$e[score];
            $rank[ $e[pid] ][csid]=$e[csid];
            $rank[ $e[pid] ][score]=$e[score];
            $rank[ $e[pid] ][result]=$e[result];
        }
        foreach($pbs as $k=>$v) {
?>
    <td id="result<?=$v?>_<?=$rowcnt?>" class='wrap'>
    <?php
    if($rank[$v][result] =="N")
        评测信息($rank[$v][result]);
    else {
        if((有此权限('查看比赛') || $end))
            echo "<a href='code.php?csid={$rank[$v]['csid']}'>";
        if($rank[$v][result] == "") echo "未评测";
        else if((有此权限('查看比赛') || $end)) 评测结果($rank[$v][result], 30);
        else echo "不显示";
        if((有此权限('查看比赛') || $end))
            echo "</a>";
    } ?></td>
    <td id="score<?=$v ?>_<?=$rowcnt ?>" ><?if($end || (有此权限('查看比赛'))) echo $rank[$v][score]; ?></td>
<?php
        }
?>
    <td id="sum<?=$rowcnt ?>" ><?if($end || (有此权限('查看比赛'))) echo $sum; ?></td>
  </tr>
<?php 
    }
?>
</table>
</div>
<script language="javascript">
var sortsx=true;
var rowcnt=<?=$rowcnt ?>;

function qsort(key) {
    sortsx=!sortsx;
    vmin=10000;
    vmax=-1;
    if (sortsx) {
        for (i=1;i<=rowcnt-1;i++) {
            vi=new Number(document.getElementById(key+i).innerHTML);
            pmin=vmin;
            for (j=i;j<=rowcnt;j++) {
                vj=new Number(document.getElementById(key+j).innerHTML);
                if (vj<pmin) {
                    pmin=vj;
                    k=j;
                }
            }
            if (pmin<vi)
                swap(i,k);
        }
    } else {
        for (i=1;i<=rowcnt-1;i++) {
            vi=new Number(document.getElementById(key+i).innerHTML);
            pmax=vmax;
            for (j=i;j<=rowcnt;j++) {
                vj=new Number(document.getElementById(key+j).innerHTML);
                if (vj>pmax) {
                    pmax=vj;
                    k=j;
                }
            }
            if (pmax>vi)
                swap(i,k);
        }
    }
}

function swap(a,b) {
    t=document.getElementById("nickname"+a).innerHTML;
    document.getElementById("nickname"+a).innerHTML=document.getElementById("nickname"+b).innerHTML;
    document.getElementById("nickname"+b).innerHTML=t;
    t=document.getElementById("sum"+a).innerHTML;
    document.getElementById("sum"+a).innerHTML=document.getElementById("sum"+b).innerHTML;
    document.getElementById("sum"+b).innerHTML=t;

    t=document.getElementById("rank"+a).innerHTML;
    document.getElementById("rank"+a).innerHTML=document.getElementById("rank"+b).innerHTML;
    document.getElementById("rank"+b).innerHTML=t;
<?php
foreach($pbs as $k=>$v) {
?>
    t=document.getElementById("result<?=$v ?>_"+a).innerHTML;
    document.getElementById("result<?=$v ?>_"+a).innerHTML=document.getElementById("result<?=$v ?>_"+b).innerHTML;
    document.getElementById("result<?=$v ?>_"+b).innerHTML=t;
    
    t=document.getElementById("score<?=$v ?>_"+a).innerHTML;
    document.getElementById("score<?=$v ?>_"+a).innerHTML=document.getElementById("score<?=$v ?>_"+b).innerHTML;
    document.getElementById("score<?=$v ?>_"+b).innerHTML=t;
<?php
}
?>

}

qsort("sum");
var last="";

for (i=1;i<=rowcnt;i++) {
    if (last==document.getElementById("sum"+i).innerHTML) {
        document.getElementById("rank"+i).innerHTML=document.getElementById("rank"+(i-1)).innerHTML;
    } else {
        document.getElementById("rank"+i).innerHTML=i;
        last=document.getElementById("sum"+i).innerHTML;
    }
}
    
</script>

<?php
    include_once("../include/footer.php");
?>

<?php
require_once("../include/stdhead.php");
gethead(1,"","帮助");
?>
<table border=1>
<tr><td colspan=2>评测结果说明</td></tr>
<? $s="AWTMREDCNP";
for($i=0; $i<strlen($s); $i++) {?>
<tr><td><pre style='margin:0;'><?=judgeresult($s[$i])?></pre></td>
<td><?=judgetext($s[$i])?></td></tr>
<? } ?>
</table>
<?php echo output_text($SETTINGS['global_help']) ?>
<?php
	include_once("../include/stdtail.php");
?>

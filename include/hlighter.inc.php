<?php
$SHfull=$SET['base']."include/syntaxhighlighter/";
$SH=pathconvert($SET['cur'],$SHfull);
?>
<script type="text/javascript" src="<?=$SH?>scripts/shCore.js"></script>
<script type="text/javascript" src="<?=$SH?>scripts/shBrushDelphi.js"></script>
<script type="text/javascript" src="<?=$SH?>scripts/shBrushCpp.js"></script>
<script type="text/javascript" src="<?=$SH?>scripts/shBrushDiff.js"></script>
<script type="text/javascript" src="<?=$SH?>scripts/shBrushPlain.js"></script>
<script type="text/javascript" src="<?=$SH?>scripts/shBrushBash.js"></script>
<link type="text/css" rel="stylesheet" href="<?=$SH?>styles/shCoreDefault.css"/>

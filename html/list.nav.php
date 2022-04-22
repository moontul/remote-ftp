
<?php

$a_idx=array();
$a_list=array();
$a_listtitle=array();
$a_listorder=array();
$a_qcnt=array();

if(isset($code)){

$start=0;
$sqlh="

WITH RECURSIVE tmp1 AS
(
    SELECT list, idx, listtitle, pidx,
    listtitle AS path, 1 AS lvl
    FROM tb_list WHERE pidx=0 and code='$code'

    UNION ALL

    SELECT e.list, e.idx, e.listtitle, e.pidx,
    CONCAT(t.path,',',e.listtitle) AS path, t.lvl+1 AS lvl
    FROM tmp1 t JOIN (select * from tb_list where code='$code') e
    ON t.idx=e.pidx
)

SELECT list, idx, CONCAT(REPEAT(' ', lvl*4), listtitle) listtitle, pidx, path, lvl
,(select count(*) from tb_qlist where list=A.list) as qcnt
FROM tmp1 A
ORDER BY path;
 ";

// /echo($sqlh);

$resulth=sql_query($sqlh);
for($h=0;$rsh=sql_fetch_array($resulth);$h++){

  array_push($a_idx, $rsh["idx"]);
  array_push($a_list, $rsh["list"]);
  array_push($a_listtitle, $rsh["listtitle"]);
  array_push($a_listorder, $rsh["lvl"]);
  array_push($a_qcnt, $rsh["qcnt"]);
  //echo($rsh["listtitle"]."<br>");
}

}
?>

<nav id="pp-sidebar">
  <div class="pp-sidebardiv">

<?php if(isset($code)){ ?>
  <div class="sidebardiv">
    <a href="/view?code=<?=$code?>">
    [<?=$title?><?=(isset($is_subtitle))?' '.$subtitle:''?>]
    </a>

    <?php if($is_admin){?>
    <a href="/write?code=<?=$code?>" title="목록 추가"><i class="fas fa-plus-circle"></i></a>
    <?}?>
  </div>
<? } ?>

<?php
for($x=0;$x<count($a_idx);$x++){
?>
<div class="pp-sidebardiv">
  <?if ($a_qcnt[$x]>0){ ?>
  <div class="float-right"><?for($y=1;$y<$a_listorder[$x];$y++){echo("");}?>
    <a href="/qview?list=<?=$a_list[$x]?>" class="btn"><?=$a_qcnt[$x]?> 문제 </a>
  </div>
  <?}?>

   <?for($y=1;$y<$a_listorder[$x];$y++){echo(" &nbsp;&nbsp; ");}?>
   <a href="/view?list=<?=$a_list[$x]?>">
     <?=$a_listtitle[$x]?>
   </a>
</div>
<?
}
?>
</div>
</nav>

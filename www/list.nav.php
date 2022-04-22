
<?php if(isset($code)){

$start=0;
$sqlh="
SELECT  CONCAT(REPEAT('    ', level - 1), CAST(idx AS CHAR)),
        idx, pidx, listtitle, code, list,
        level
FROM    (
        SELECT  idx, pidx, listtitle, list, code, IF(ancestry, @cl := @cl + 1, level + @cl) AS level
        FROM    (
                SELECT  TRUE AS ancestry, _idx AS idx, pidx, listtitle, code, list,  level
                FROM    (
                        SELECT  @r AS _idx, listtitle, h.code as code,  list,
                                (
                                SELECT  @r := pidx
                                FROM    tb_list
                                WHERE   idx = _idx
                                ) AS pidx,
                                @l := @l + 1 AS level
                        FROM    (
                                SELECT  @r := $start,
                                        @l := 0,
                                        @cl := 0
                                ) vars,
                                tb_list h
                        WHERE   @r <> 0 and h.code='$code'
                        ORDER BY
                                level DESC, listtitle
                        ) qi
                UNION ALL
                SELECT  FALSE, hi.idx, pidx, listtitle, hi.code as code, list, level
                FROM    (
                        SELECT  hierarchy_list(idx) AS idx, @level AS level
                        FROM    (
                                SELECT  @start_with := $start,
                                        @idx := @start_with,
                                        @level := 0
                                ) vars, tb_list
                        WHERE   @idx IS NOT NULL
                        ) ho
                JOIN    tb_list hi
                ON      hi.idx = ho.idx and  hi.code='$code'
                -- order by listtitle
                ) q
        ) q2
 ";

 $a_idx=array();
 $a_list=array();
 $a_listtitle=array();
 $a_listorder=array();
 $a_qcnt=array();

//echo($sqlh);

$resulth=sql_query($sqlh);
for($h=0;$rsh=sql_fetch_array($resulth);$h++){

  array_push($a_idx, $rsh["idx"]);
  array_push($a_list, $rsh["list"]);
  array_push($a_listtitle, $rsh["listtitle"]);
  array_push($a_listorder, $rsh["level"]);
  array_push($a_qcnt, 0);
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
    <a href="/write?code=<?=$code?>" title="목록 추가" class="btn btn-xs"><i class="fas fa-list-ol"></i></a>
    <?}?>
  </div>
<? } ?>

<?php
for($x=0;$x<count($a_idx);$x++){
?>
<div class="sidebardiv">
   <?for($y=1;$y<$a_listorder[$x];$y++){echo(" &nbsp;&nbsp; ");}?>
   <a href="/view?list=<?=$a_list[$x]?>">
     <?=$a_listtitle[$x]?>
   </a>
</div>
    <?if ($a_qcnt[$x]>0){ ?>
      <div class="sidebardiv">
        <a href="/qview?list=<?=$a_list[$x]?>">{문제 <?=$a_qcnt[$x]?>}</a>
    </div>
<?}?>
<?
}
?>
</div>
</nav>

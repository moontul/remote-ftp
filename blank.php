<?php include_once('./_common.php'); ?>



<?php
$page_code="20220409013559F82C62";





$sql="GET_PAGE_CODEMENU($page_code)";
$




die();


    $sql2="select title, idx, pidx, fullidx, (select isdesc from tb_page where idx=A.pidx) as parent_isdesc
          from tb_page A where code='$page_code' and lvl=2
          order by (CASE WHEN parent_isdesc=1 THEN title END) DESC, (CASE WHEN parent_isdesc=0 THEN title END) ASC";
    $result2=sql_query($sql2);
    for($k=0;$rs2=sql_fetch_array($result2);$k++){
      echo($rs2["title"]."<br>");
      $sql3="select title, idx, pidx, fullidx, (select isdesc from tb_page where idx=A.pidx) as parent_isdesc
            from tb_page A where code='$page_code' and lvl=3 and pidx=";
            $sql3.= $rs2["idx"];
            $sql3.=" order by (CASE WHEN parent_isdesc=1 THEN title END) DESC, (CASE WHEN parent_isdesc=0 THEN title END) ASC";
      $result3=sql_query($sql3);
      for($k=0;$rs3=sql_fetch_array($result3);$k++){
        echo($rs3["title"]."<br>");
      }

    }











die();
$arr[0]["test1"]  = 1;
$arr[0]["test2"]  = 2;
$arr[0]["test3"]  = 3;
$arr[0]["test4"]  = '나';
$arr[0]["test5"]  = 5;

$arr[1]["test1"]  = 2;
$arr[1]["test2"]  = 3;
$arr[1]["test3"]  = 4;
$arr[1]["test4"]  = '가';
$arr[1]["test5"]  = 5;

$arr[2]["test1"]  = 3;
$arr[2]["test2"]  = 4;
$arr[2]["test3"]  = 5;
$arr[2]["test4"]  = '다';
$arr[2]["test5"]  = 8;

$sortArr = array();
foreach($arr as $res)
  $sortArr [] = $res['test4'];

array_multisort($sortArr , SORT_ASC, $arr);

foreach($arr as $k => $v){
  foreach($v as $k1 => $v1){
      echo($v1);
  }
  echo("<br>");
}
?>




<?
$sql="
select lvl, gs from(
  select lvl, listorder,  title
  , GET_PAGE_FULLTITLES( concat(fullidx,'[',idx,']'),'n') as gs
  from tb_page
  where code='2022040410544116517A'
) A
order by gs asc
";

$row=sql_query($sql);
$a=[];
for($i=0;$rs=sql_fetch_array($row);$i++){
  $b=explode(" > ", $rs["gs"]);
  $c=[];
  for($j=0;$j<count($b);$j++){
    $c["path".$j]=$b[$j];
  }
  array_push($a, $c);
?>
<!--
  <?php for($j=0;$j<count($b);$j++){?>
    [<?=$b[$j]?>]
  <?php } ?>
<br>
-->
<?}?>


<hr>
<?php
$sortArr = array();
foreach($a as $res)
  $sortArr [] = $res['path2'];

array_multisort($sortArr , SORT_DESC, $a);


foreach($a as $key => $value){
  foreach($value as $key => $val){
    echo("[".$val."]");
  }
  echo("<br>");
}


die();

$sql="
WITH RECURSIVE tmp1 AS (

    SELECT list, listorder, idx, fullidx, title, pidx, isopen, title AS path, 1 AS lvl
    FROM tb_page
    WHERE lvl=3 and code='2022040410544116517A'

    UNION ALL

    SELECT e.list, e.listorder, e.idx, e.fullidx, e.title, e.pidx, e.isopen ,CONCAT(t.path,' > ', e.title) AS path, t.lvl+1 AS lvl
    FROM tmp1 t
    JOIN ( select list, listorder, idx, fullidx, title, pidx, isopen from tb_page where code='2022040410544116517A' ) e
    ON t.idx=e.pidx
)

    SELECT list, listorder, idx, fullidx, title, pidx, isopen ,path, lvl, fullidx ,CONCAT(REPEAT(' ', (lvl-1)*4), title) tabtitle
    ,(select count(*) from tb_pageq where list=A.list) as qcnt
    FROM tmp1 A
    ORDER BY path asc;
";

    $row=sql_query($sql);

    for($i=0;$rs=sql_fetch_array($row);$i++){
    ?>
    <?=$rs["path"]?><br>
    <?}?>

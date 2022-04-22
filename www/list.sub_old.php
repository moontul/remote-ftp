
$sql0=" select *,(select count(*)  from tb_qlist where list=A.list) as qcnt  from tb_list A where A.code='$code' and pidx=0 order by listtitle";
//echo($sql0);
$result0=sql_query($sql0);
for($i0=0;$rs0=sql_fetch_array($result0);$i0++){
  array_push($a_idx, $rs0["idx"]);
  array_push($a_list, $rs0["list"]);
  array_push($a_listtitle, $rs0["listtitle"]);
  array_push($a_listorder, 0);
  array_push($a_qcnt, $rs0["qcnt"]);

  $sql1=" select *,(select count(*)  from tb_qlist where list=A.list) as qcnt   from tb_list A where A.code='$code' and pidx=".$rs0['idx']." order by listtitle";
  $result1=sql_query($sql1);
  for($i1=0;$rs1=sql_fetch_array($result1);$i1++){
    array_push($a_idx, $rs1["idx"]);
    array_push($a_list, $rs1["list"]);
    array_push($a_listtitle, $rs1["listtitle"]);
    array_push($a_listorder, 1);
    array_push($a_qcnt, $rs1["qcnt"]);
    $sql2=" select *  from tb_list A where A.code='$code' and pidx=".$rs1['idx']." order by listtitle";
    $result2=sql_query($sql2);
    for($i2=0;$rs2=sql_fetch_array($result2);$i2++){
      array_push($a_idx, $rs2["idx"]);
      array_push($a_list, $rs2["list"]);
      array_push($a_listtitle, $rs2["listtitle"]);
      array_push($a_listorder, 2);
      $sql3=" select *  from tb_list A where A.code='$code' and pidx=".$rs2['idx']." order by listtitle";
      $result3=sql_query($sql3);
      for($i3=0;$rs3=sql_fetch_array($result3);$i3++){
        array_push($a_idx, $rs3["idx"]);
        array_push($a_list, $rs3["list"]);
        array_push($a_listtitle, $rs3["listtitle"]);
        array_push($a_listorder, 3);
        $sql4=" select *  from tb_list A where A.code='$code' and pidx=".$rs3['idx']." order by listtitle";
        $result4=sql_query($sql4);
        for($i4=0;$rs4=sql_fetch_array($result4);$i4++){
          array_push($a_idx, $rs4["idx"]);
          array_push($a_list, $rs4["list"]);
          array_push($a_listtitle, $rs4["listtitle"]);
          array_push($a_listorder, 4);
        }
      }
    }
  }
}
?>
<div class="sidebardiv"><a href="/view?code=<?=$code?>">[<?=$title?>]</a></div>
<?php
//$sql="select * from tb_list where code='$code' order by listorder, listtitle";
$sql=" SELECT CASE WHEN LEVEL-1 > 0 then CONCAT(CONCAT(REPEAT(' &nbsp; ', level  - 1),'┗ '), A.listtitle)
                 ELSE A.listtitle
           END AS listtitle
     , A.idx
     , A.pidx
     , fnc.level
     , A.list
  FROM
     (SELECT fnc_tree('$code') AS idx, @level AS level
        FROM (SELECT @start_with:=0, @idx:=@start_with, @level:=0) vars
          JOIN tb_list
         WHERE @idx IS NOT NULL) fnc
  JOIN tb_list A ON fnc.idx = A.idx and A.code='$code'";
  //order by pidx, listtitle;

echo($sql);

$result=sql_query($sql);
for($i=0;$rs=sql_fetch_array($result);$i++){
?>
  <div class="sidebardiv">
    <a href="/view?list=<?=$rs["list"]?>"><?=$rs["listtitle"]?></a>
  </div>
<?
}
if($i==0){
?>
리스트가 없어요
<?
}
?>
===============================

<div class="sidebardiv"><a href="/view?code=<?=$code?>">[<?=$title?>]</a></div>
<?php
//$sql="select * from tb_list where code='$code' order by listorder, listtitle";
$a_idx=array();
$a_listtitle=array();

$sql=" select *
  from tb_list A
  where A.code='$code' and pidx=0 order by listtitle";
  //order by pidx, listtitle;
//echo($sql);
$result=sql_query($sql);
for($i=0;$rs=sql_fetch_array($result);$i++){
  $sql1="select  idx, list,
          listtitle,
          pidx , listorder
  from    (select * from tb_list
           order by pidx, idx) products_sorted,
          (select @pv := '".$rs["idx"]."') initialisation
  where   find_in_set(pidx, @pv) > 0
  and     @pv := concat(@pv, ',', idx);";
  //  echo($sql1);
  $result1=sql_query($sql1);
?>
  <div class="sidebardiv">
    <a href="/view?list=<?=$rs["list"]?>"><?=$rs["listtitle"]?></a>
  </div>
<?php
  array_push($a_idx, $rs["idx"]);
  array_push($a_listtitle, $rs["listtitle"]);

  for($j=0;$rs1=sql_fetch_array($result1);$j++){
?>
<div class="sidebardiv">
  &nbsp; &nbsp; <a href="/view?list=<?=$rs1["list"]?>"><?=$rs1["listtitle"]?> <?=$rs1["listorder"]?></a>
</div>
<?
    array_push($a_idx, $rs1["idx"]);
    array_push($a_listtitle, $rs1["listtitle"]);
  }

}
if($i==0){
?>
리스트가 없어요
<?
}
?>

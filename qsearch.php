<?php include_once('./_common.php');?>
<?php
$a_qx=array();
//현재 코드에 있는 문제 - 현재 목록문제 제외
$sql="select CT.type, CT.code, LT.list, title, subtitle, listtitle, qcnt, pidx
,(select listtitle from tb_list where idx=LT.pidx) as pname1
,(select listtitle from tb_list where idx=(select pidx from tb_list where idx=LT.pidx)) as pname2
,(select listtitle from tb_list where idx=(select pidx from tb_list where idx=(select pidx from tb_list where idx=LT.pidx))) as pname3

from tb_container CT, tb_list LT
, ( select count(*) as qcnt, list from tb_qlist group by list having qcnt>0 )
 A where CT.code=LT.code and LT.list=A.list
 order by CT.type, CT.code, pname3, pname2, pname1, listtitle
      ";
    //  echo($sql);
?>
<div style="max-height:300px;overflow:auto;">
  <div>
  필터 : <input type="text">
  </div>

  <?php
    $result=sql_query($sql);
    for($i=0;$rs=sql_fetch_array($result);$i++){
  ?>
  <div list="<?=$a_list[$x]?>" idx="<?=$a_idx[$x]?>">
     <input name="a_elist[]" type="checkbox" class="qlistview" list="<?=$a_list[$x]?>" value="">
     <?=$rs["type"]?>...<?=$rs["title"]?>...<?=$rs["subtitle"]?>...
     <?=$rs["pname3"]?>.<?=$rs["pname2"]?>.<?=$rs["pname1"]?>.<?=$rs["listtitle"]?>...<?=$rs["qcnt"]?>
  </div>
  <? } ?>
</div>
<div><input type=button value="문제 추가" class="btn btn-secondary btn-sm shadow-sm"></div>

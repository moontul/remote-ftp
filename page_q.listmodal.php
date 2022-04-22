<?php include_once('./_common.php');

@include_once(G5_THEME_PATH.'/head.sub.php');

$edit_list=$_REQUEST["edit_list"];
$page_lvl="";
$page_code="";

echo($edit_list);

$sql="
WITH RECURSIVE tmp1 AS
(
    SELECT list, listorder, idx, title, pidx,
    title AS path, 1 AS lvl
    ,content
    FROM tb_page
    WHERE
    lvl=1
";

if($page_code!=""){
$sql.="
      and code='$page_code'
";
}

$sql.="
    UNION ALL

    SELECT e.list, e.listorder, e.idx, e.title, e.pidx,
    CONCAT(t.path,' > ',e.title) AS path, t.lvl+1 AS lvl
    ,e.content
    FROM tmp1 t JOIN (
      select *
      from tb_page
      where 1=1
";

if($page_code!=""){
$sql.="
      and code='$page_code'
";
}

$sql.="

      ) e
    ON t.idx=e.pidx
)

SELECT list, listorder, idx, title, pidx, path, lvl
,content
,CONCAT(REPEAT('&nbsp;', (lvl-1)*4), title) tabtitle
,(select count(*) from tb_pageq where list=A.list) as qcnt
FROM tmp1 A
ORDER BY path; ";
//echo($sql);

$result=sql_query($sql);
for($i=0;$rs=sql_fetch_array($result);$i++){

  $a_list[$i]=$rs["list"];
  $a_idx[$i]=$rs["idx"];
  $a_listorder[$i]=$rs["listorder"];
  $a_title[$i]=$rs["title"];
  $a_pidx[$i]=$rs["pidx"];
  $a_path[$i]=$rs["path"];
  $a_lvl[$i]=$rs["lvl"];

  $a_tabtitle[$i]=$rs["tabtitle"];
  $a_qcnt[$i]=$rs["qcnt"];
  //array_push($a_ccnt, $rs["ccnt"]);

  //array_push($a_listcontent, $rs["listcontent"]);
  //array_push($a_youtube, $rs["youtube"]);
  //array_push($a_files, $rs["fcnt"]);

?>
<div  id="list_<?=$rs["list"]?>" style="height:30px;overflow:hidden;<?=($edit_list==$rs["list"])?'background:#eee':''; ?>">
  <input type="checkbox" class="chkl" value="<?=$rs["list"]?>"> <a href="page?<?=$rs["list"]?>"><?=$rs["tabtitle"]?><span class="badge text-dark"><?=$rs["qcnt"]?></span></a>
</div>
<?
}
?>

<script>
$(function(){

  $('html, body').animate({
  scrollTop: $('#list_<?=$edit_list?>').offset().top
  }, 'fast');

});

function addList(){

    var qlists="";

    for(var i=0;i<$(".chkl").length;i++){

      if( $(".chkl").eq(i).prop("checked") ){

        if(qlists!=""){qlists+=",";}
        qlists+=$(".chkl").eq(i).val();
      }
    }

    if(qlists==""){alert("선택된 목록이 없습니다.");return;}

    $.ajax({
           type : "POST",
           url : "/page_q.listmodal.ajaxsave.php",
           data : {"qlists":qlists,"list":"<?=$edit_list?>" },
           error : function(){
               //alert('error');
           },
           success : function(data){
             parent.location.reload();
           }
     });
}
</script>

</body>
</html>

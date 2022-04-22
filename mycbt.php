<?php
include_once('./_common.php');
$this_menu="오답노트";
include_once(G5_THEME_PATH.'/head.php');

function qnumReplaceDot($g,$a){
  $g1="";
  if($g==1){$g1=($a==1)?"●":"①";}
  elseif($g==1){$g1=($a==1)?"●":"①";}
  elseif($g==2){$g1=($a==2)?"●":"②";}
  elseif($g==3){$g1=($a==3)?"●":"③";}
  elseif($g==4){$g1=($a==4)?"●":"④";}
  elseif($g==5){$g1=($a==5)?"●":"⑤";}
  else{$g1=$g;}
  return $g1;
}
?>

<?php
  $list=$_GET['list'];
  $page_list=$list;
  $this_title="CBT결과";

  $sql="select title from tb_page where list='$list'";
  $rs=sql_fetch($sql);
  $page_list_title=$rs["title"];


  $sql="select count(*) as cnt, sum(counttrue) as ctrue, sum(countfalse) as cfalse, max(in_date) as in_date
    from tb_answerlog A
    where A.mb_id='".$member["mb_id"]."' and A.page_list='$page_list'
    and A.fromcbt=1
    ";
  $result=sql_fetch($sql);
  $my_total_count=$result["cnt"];
  $my_total_true=$result["ctrue"];
  $my_total_false=$result["cfalse"];
  $my_total_date=$result["in_date"];

//OMR형태로 모의고사 결과 보여줌
  $sqlt="select counttrue, countfalse, anum
    ,(select pqnum from tb_pageq where qcode=A.qcode and list=A.list) as qnum
    from tb_answerlog A
    where A.mb_id='".$member["mb_id"]."' and A.page_list='$page_list'
    and A.fromcbt=1
    order by qnum
    ";

  $resultt=sql_query($sqlt);
  //echo($sqlt);
?>


<?php include_once("page.wraptop.php");?>
<?php include_once("mynote.nav.php");?>
<div class="col-lg-9 col-md-9 col-sm-12 pp-mainpage shadow" style="background-image:url('<?=G5_THEME_URL?>/assets/img/notebg2.jpg');padding-right:15px;">


    <div class="ct-docs-page-title">
      <span class="ct-docs-page-h1-title"><?=$this_title?></span>
    </div>

<?php
  ////////////////////////////////////////////////////전체문제 쿼리 //해당문제의 정답
  $page_list=$list;
  include_once("page.qview.detail.query.php");
  $resultq=sql_query($sqlq);
  for($i=0;$rsq=sql_fetch_array($resultq);$i++){
    //$title=$rsq["title"];
  }

  //////////////////////////////////////////////////////////////////시험제약 정보
  if($list!=""){
  	$sqltmp="select * from tb_exam where list='$list'";
  	$rstmp=sql_fetch($sqltmp);
  	$examlimit=$rstmp["examlimit"];
  	$examopen=$rstmp["examopen"];
  	$examclose=$rstmp["examclose"];
    $examopentime=$rstmp["examopentime"];
  	$examclosetime=$rstmp["examclosetime"];
  	$code=$rstmp["code"];
  }else if($code!=""){
  	$sqltmp="select * from tb_exam where code='$code'";
  	$rstmp=sql_fetch($sqltmp);
  	$examlimit=$rstmp["examlimit"];
  	$examopen=$rstmp["examopen"];
  	$examclose=$rstmp["examclose"];
    $examopentime=$rstmp["examopentime"];
  	$examclosetime=$rstmp["examclosetime"];
  }
?>


    <div class="p-3" style="width:740px;height:513px;background-image:url('<?=G5_THEME_URL?>/assets/img/cbt_cetification.jpg')">

      <div class="mt-5 text-center h3 text-primary text-gradient" style="margin:0 auto; width:50%;border-bottom:1px solid #ccc; ;letter-spacing:-1px;padding-bottom:5px;">PangPang</div>

      <div style="margin:0 auto;width:50%;border-bottom:1px solid #ccc;padding-bottom:20px;">
        <div class="mt-3">시 험 명: <?=$page_list_title?> </div>
        <div>응시기간: <?=$examopen?>~<?=$examclose?>  [<?=$examopentime?>시 ~ <?=$examclosetime?>시]</div>
      </div>

      <div class="h2" style="margin:0 auto;width:50%;text-align:center;padding:20px;">
        <?=$my_total_true?>점 <sub> / 전체 <?=$my_total_count?>점</sub>
      </div>

      <div style="margin:0 auto;width:50%;text-align:center;border-bottom:1px solid #ccc;padding-top:30px;">
        <?=$my_total_date?>
      </div>

    </div>


    <br>
    <div class="h5">제출 결과 상세보기</div>
    <table border=1 style="border:1px solid hotpink">
    <tr align=center bgcolor=#efefef>
    <td>문제번호</td>
    <td>보기</td>
    <td>정답여부</td>
    </tr>
    <?php
    for($i=0;$rst=sql_fetch_array($resultt);$i++){
    ?>
    <tr>
    <td class="p-1 fs-5"><?=$rst["qnum"]?></td>
    <td class="p-1 fs-5">
      <?php for($j=1;$j<5;$j++){?>
      <span class="p-1 fs-5"><?=qnumReplaceDot($j, $rst["anum"])?></span>
      <?}?>
    </td>
    <td class="p-1 fs-6 text-bold">
      <?=($rst["counttrue"])==1?"정답":"오답"?>
      <?//=$rst["countfalse"]?>
    </td>
    </tr>
    <?
    }
    ?>
    </table>

    <br>
    <!--
    <div class="h5">전체 문제 확인</div>
    <?php //include_once("qview.detail.php")?>
  -->



</div>
<?php include_once("page.wrapbottom.php");?>

<?php include_once(G5_THEME_PATH.'/tail.php'); ?>

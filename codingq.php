<?php
include_once('./_common.php');
$this_menu="코딩 문제모음";
include_once("./container.page.php");
include_once(G5_THEME_PATH.'/head.php');
?>

<?php
  $qs=$_SERVER['QUERY_STRING'];

  if(strtoupper($qs)=="C"){
    $this_title="C 코드문제";
  }elseif(strtoupper($qs)=="CPP"){
    $this_title="CPP 코드문제";
  }elseif(strtoupper($qs)=="JAVA"){
    $this_title="Java 코드문제";
  }elseif(strtoupper($qs)=="PYTHON"){
      $this_title="Python 코드문제";
  }elseif(strtoupper($qs)=="SQL"){
      $this_title="SQL 쿼리문제";
  }else{
    $this_title="코딩 키다리아저씨";
  }
?>

<?php include_once("page.wraptop.php");?>
<?php include_once("codingq.nav.php");?>
<div class="col-lg-9 col-md-9 col-sm-12 pp-mainpage">


    <div class="ct-docs-page-title">
      <span class="ct-docs-page-h1-title"><?=$this_title?></span>
    </div>
    <hr class="pp-tr">
    <?php
  if($qs==""){
    ?>

    <div>
      <img src="<?=G5_THEME_URL?>/img/daddylogleg1.jpg" width=200 align=left>


      <div class="h6 p-3 mt-1">
        보이지 않는 곳에서도 <br>
        항상 따듯한 마음을 아끼지 않는<br>
        키다리 아저씨처럼<br>
        팡팡이 당신의 코딩을 응원합니다.
      </div>
      <div class="h2 p-2" style="width:600px;letter-spacing:-2px;border-bottom:1px solid #ccc">
        "당신의 코딩을 응원합니다"
      </div>
    </div>



    <?php
  }else{
//    $member_id=$member['mb_id'];
    $sqlq_prepare="select A.qnum as qnum, qtype, A.qcode, qtext, qtextsub, A.qimg, A.imgpath
      , is_compiler, is_compilertheme, is_compilerfirst, qcompilecode
      , qm1text, qm2text, qm3text, qm4text, qm5text
      , qm1img, qm2img, qm3img, qm4img, qm5img
      , qm1correct, qm2correct, qm3correct, qm4correct, qm5correct
      , qanswer, qessay, qexplain, qyoutube
      , C.title, B.list
        from tb_question A, tb_pageq B, tb_page C
      where A.qcode=B.qcode and B.list=C.list and A.is_compiler='".strtoupper($qs)."'  ";

//    if($qs=="today"){
//      $sqlq_prepare.=" and DATE_FORMAT(A.in_date, '%Y-%m-%d') = CURDATE() ";
//    }
//    echo($sqlq_prepare);
//    is_compiler='qs' 로 쿼리한다
    ?>
    <?php include_once("page.qview.detail.php"); ?>

<?php } ////qs 조건 종료?>


</div>
<?php include_once("page.wrapbottom.php");?>
<?php include_once(G5_THEME_PATH.'/tail.php'); ?>

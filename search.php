<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');

/**
 * Download text file from string.
 *
 * @param $filename
 * @param $string
 */
function download_txt($filename, $string){
    header('cache-control: no-cache');
    header('Content-Type: text/plain');
    header("Content-Disposition: attachment; filename={$filename}");
    header("Content-Length: " . strlen($string));
    echo $string;
}

?>

<?php
  $q=$_REQUEST["q"];

  $qlimits=$_REQUEST["qlimits"];
  if($qlimits==""){$qlimits=5;}

  $qorder=$_REQUEST["qorder"];

  $qviewtype=$_REQUEST["qviewtype"];

  $a_list=$_REQUEST["list"];
  if($a_list){
    for($i=0;$i<count($a_list);$i++){
      if($liststr!=""){$liststr.=",";}
      $liststr.="'".($a_list[$i])."'";
    }
    $listquery="select qcode from tb_pageq where list in ($liststr)";
  }
?>

<!-- wrapper -->
<div class="ct-docs-main-container">
  <?php include_once("./search.nav.php"); ?>

  <!-- Page Content -->
  <main class="ct-docs-content-col" role="main">
      <h4 class="mt-4 mb-4 pp-title1">문제검색</h4>

    <hr>
<?php
if($q==""&&$listquery==""){
?>

  검색어를 입력하세요

<?php
}else{
    $sqlq_prepare="select A.qnum as qnum, qtype, qcode, qtext, qtextsub, qimg, imgpath, is_compiler, qcompilecode
      , qm1text, qm2text, qm3text, qm4text, qm5text
      , qm1img, qm2img, qm3img, qm4img, qm5img
      , qm1correct, qm2correct, qm3correct, qm4correct, qm5correct
      , qanswer, qessay, qexplain, qyoutube
      from tb_question A
      where A.qtext like '%".$q."%' ";

    if($listquery!=""){
      $sqlq_prepare .= " and qcode in (".$listquery.")";
    }

    if($qorder=="rand"){
      $sqlq_prepare.=" order by rand() ";
    }

    $sqlq_prepare.=" limit ". $qlimits;

    //$is_myq="timeline";
    //echo($sqlq_prepare);
    ?>

    <?php include_once("qview.detail.php"); ?>



    <?php if($is_admin){?>
      <div class="container">
      <hr>

        <button class="btn">이 문제들 다운로드</button>

        <button class="btn">이 문제들 연결</button>

        <br><br><br>
      </div>
    <?php } ?>


<?php
}
?>

    </main><!--/ Page Content -->

</div><!--wrapper-->
<?php include_once(G5_THEME_PATH.'/tail.php'); ?>

<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');

include_once('./container.head.php');
?>

<!-- container -->
<div class="container">
  <!-- wrapper -->
  <div class="pp-wrapper">

    <?php include_once("./list.nav.php"); ?>

    <!-- Page Content -->
    <div id="content" style="width:100%;margin:10px;">
      <?=$listtitle?> 문제풀기

        <?php
        if(isset($list)){
        $sql="select A.qcode as qcode, qtext, qm1text, qm2text, qm1correct, qm2correct
         from tb_qlist A, tb_question B where A.qcode=B.qcode and A.list='$list'";
       }elseif(isset($code)){
         $sqlq="select C.qcode as qcode, qtext, qm1text, qm2text, qm1correct, qm2correct
          from tb_container A, tb_qlist B, tb_question C where A.code='$code' and A.code=B.code and B.qcode=C.qcode ";
       }
        $resultq=sql_query($sqlq);
        for($i=0;$rs=sql_fetch_array($resultq);$i++){
      ?>

      <div>
        <div><b><?=$rs["qtext"]?></b></div>
      </div>

      <div>
        <span style="cursor:pointer" class="qchk_answer" qcode="<?=$rs["qcode"]?>" correct="<?=$rs["qm1correct"]?>">
          1. <?=$rs["qm1text"]?>
        </span>
      </div>
      <div>
        <span style="cursor:pointer" class="qchk_answer" qcode="<?=$rs["qcode"]?>" correct="<?=$rs["qm2correct"]?>">
          2. <?=$rs["qm2text"]?>
        </span>
      </div>
        <?php if($is_admin){?>
          <a href="./qedit?list=<?=$list?>&qcode=<?=$rs["qcode"]?>">문제수정</a>
        <?php } ?>
      <br>
      <?php
      }
      ?>

      <br>

    </div><!--/ Page Content -->
  </div><!-- / wrapper -->
</div><!-- /container -->


<script>
$(".qchk_answer").click(function(){

	var qc=$(this).attr("qcode");
	var correct=$(this).attr("correct");
  var correctval="0";
  if( $(this).attr("correct")=="1"){
    alert("정답입니다!!");correctval="1";
  }else{
    alert("오답입니다ㅠㅠ");correctval="-1";
  };

	$.ajax({
         type : "GET",
         url : "/qchk.ajax.save.php",
         data : {"qcode":qc, "mb_id":"<?=$member["mb_id"]?>", "list":"<?=$list?>",  "correctval":correctval},
         error : function(){
             //alert('error');
         },
         success : function(data){
            // alert(data) ;
         }
   });



})
</script>








<?php include_once(G5_THEME_PATH.'/tail.php'); ?>

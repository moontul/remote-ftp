<?php
if(isset($list)){
$sqlq="select A.qnum as qnum, qtype, A.qcode as qcode, qtext, qtextsub
  , qm1text, qm2text, qm3text, qm4text, qm5text
  , qm1correct, qm2correct, qm3correct, qm4correct, qm5correct
  from tb_qlist A, tb_question B where A.qcode=B.qcode and A.list='$list'";
}elseif(isset($code)){
 $sqlq="select B.qnum as qnum, qtype, C.qcode as qcode, qtext, qtextsub
  , qm1text, qm2text, qm3text, qm4text, qm5text
  , qm1correct, qm2correct, qm3correct, qm4correct, qm5correct
  from tb_container A, tb_qlist B, tb_question C where A.code='$code' and A.code=B.code and B.qcode=C.qcode ";
}
$resultq=sql_query($sqlq);
for($i=0;$rs=sql_fetch_array($resultq);$i++){
?>

<div>
<div><b><?=$rs["qnum"]?></b>. <b><?=$rs["qtext"]?></b></div>
</div>

<?php if(!empty($rs["qtextsub"])){?>
<div style="border:1px solid #c0c0c0;padding:15px;text-align:justify;">
<span>
  <b><?=nl2br($rs["qtextsub"])?></b>
</span>
</div>
<?php } ?>

<?php if($rs["qtype"]=="주관식"){?>
<div>
  <input type=text><input type="button" value="정답확인">
</div>
<?php }else{?>
      <?for($j=1;$j<5;$j++){?>
        <div>
          <span style="cursor:pointer" class="qchk_answer" qcode="<?=$rs["qcode"]?>" correct="<?=$rs["qm".$j."correct"]?>">
            <?=$j?>. <?=$rs["qm".$j."text"]?>
          </span>
        </div>
      <?}?>
<?php } ?>

            <?php if($is_admin){?>
            <div class="">
              <a href="./qedit?list=<?=$list?>&qcode=<?=$rs["qcode"]?>"
                class="btn btn-secondary btn-sm">문제수정</a>
            </div>
            <?php } ?>
<br>

<?}?>


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

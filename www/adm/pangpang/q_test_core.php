
<?php

$tcode = $_GET['tcode'];

$code = $_GET['code'];
$ucode = $_GET['ucode'];

if(strtoupper(substr($code, 0, 2))=="SJ"){	if($sjcode==""){$sjcode=$code;};}
if(strtoupper(substr($code, 0, 2))=="BK"){	if($bkcode==""){$bkcode=$code;};}
if(strtoupper(substr($code, 0, 2))=="LC"){	if($lccode==""){$lccode=$code;};}
if(strtoupper(substr($ucode, 0, 3))=="SJU"){	if($sjucode==""){$sjucode=$ucode;};}
if(strtoupper(substr($ucode, 0, 3))=="BKU"){	if($bkucode==""){$bkucode=$ucode;};}
if(strtoupper(substr($ucode, 0, 3))=="LCU"){	if($lcucode==""){$lcucode=$ucode;};}

$sql_code = " select qcode ";
$sql_all = "	select qcode, qtype, qnum, qtext, qtextsub, qimg, qcoding, qmessay, qiscompile
					, qm1order, qm1text, qm1img, qm1correct
					, qm2order, qm2text, qm2img, qm2correct
					, qm3order, qm3text, qm3img, qm3correct
					, qm4order, qm4text, qm4img, qm4correct
					, qm5order, qm5text, qm5img, qm5correct
					, qrightratio, qexplain ";
$sql=		"	from
					tb_question A
					where 1=1 ";

$isq=0;
if($qcode!=""){ $sql .=  " and A.qcode='$qcode'";$isq=1;}
if($lcucode!=""){ $sql .= " and A.lcucode='$lcucode'";$isq=1;}
if($lccode!=""){ $sql .=  " and A.lccode='$lccode'";$isq=1;}
if($bkucode!=""){ $sql .= " and A.bkucode='$bkucode'";$isq=1;}
if($bkcode!=""){ $sql .= " and A.bkcode='$bkcode'";$isq=1;}
if($sjucode!=""){ $sql .=" and A.sjucode='$sjucode'";$isq=1;}
if($sjcode!=""){ $sql .= " and A.sjcode='$sjcode'";$isq=1;}
if($isq==0){$sql .= " and 1=2 ";}

$sql .= " order by convert(qnum, int)";
if($vtype=="1"){ $sql .= " limit 1"; }

//$sql="CALL sp_testpaper('$tcode')"
$sql_final=$sql_all.$sql;
$sql_onlycode=$sql_code.$sql;

$result = mysqli_query($conn, $sql_final);
$row=$result->num_rows;

?>
<?php
if($retest==""){
//멤버시험결과 로그
$sqltestlog = "	select *, (select qtype from tb_question where qcode=A.qcode) as qtype
	from	tb_qsheet_log A
	where 1=1 ";
if ($qcode!=""){$sqltestlog .= " and qcode='$qcode' "; }
$sqltestlog .= " and mb_id='$mb_id' ";
$sqltestlog .= " and qcode in (".$sql_onlycode.")";
$resulttestlog = mysqli_query($conn, $sqltestlog);
$rowtestlog=$resulttestlog->num_rows;

//echo($sqltestlog);

$user_qcode=array();
$user_anum=array();
$user_aessay=array();
$user_correctval=array();
	foreach($resulttestlog as $listlog) {
			array_push($user_qcode, $listlog["qcode"]);
			array_push($user_anum, $listlog["anum"]);
			array_push($user_aessay, $listlog["aessay"]);
			array_push($user_correctval, $listlog["correctval"]);
	}
}else{
	$rowtestlog=0;
}
//, 'anum' => $listlog["anum"]
//, 'aessay' => $listlog["aessay"]
//, 'correctval' => $listlog["correctval"]
?>



<form name=f method=post action="<?=$form_action_str?>">
<input type=hidden name="tcode" value="<?=$tcode?>">

<input type=hidden name="sjucode" value="<?=$sjucode?>">
<input type=hidden name="lcucode" value="<?=$lcucode?>">
<input type=hidden name="mb_id" value="<?=$mb_id?>">
<input type=hidden name="retest" value="<?=$retest?>">

<?php
$qcodestr="";
foreach($result as $list) {
	$a=array_search($list['qcode'], $user_qcode);
	$uv="";
	//echo($list['qcode'].":".$a);
	if(is_numeric($a)){
		$uv=$user_correctval[array_search($list['qcode'], $user_qcode)];
		$u_aessay=$user_aessay[array_search($list['qcode'], $user_qcode)];
		//echo(":".$uv."<br>");
	}
	$correctstr="";
?>

  <!--문제영역start-->
	<div style="position:absolute;display:<?if(($rowtestlog>0)&&($uv!='')&&($uv>0)){echo('show');}else{echo('none');}?>;margin-top:-10px;margin-left:-15px;" id="o_<?=$list['qcode']?>"><img src="/img/util/testresult_o1.png" width=40></div>
	<div style="position:absolute;display:<?if(($rowtestlog>0)&&($uv!='')&&($uv<0)){echo('show');}else{echo('none');}?>;margin-top:-15px;margin-left:-15px;" id="x_<?=$list['qcode']?>"><img src="/img/util/testresult_x1.png" width=30></div>
	<div style="position:absolute;display:<?if(($rowtestlog>0)&&($uv!='')&&($uv==0)){echo('show');}else{echo('none');}?>;color:#cc0000;margin-top:-18px;margin-left:-18px;" id="try_<?=$list['qcode']?>"><img src="/img/util/testresult_tri.png" width=40>채점대기</div>

  <?php
    if($qcodestr!=""){$qcodestr .=",";}
    $qcodestr .="'".$list["qcode"]."'";
  ?>


  <b><?=$list['qnum']?>.	<?=$list['qtext']?></b>

	<?if($list['qtextsub']!=""){?><div style="border:2px solid #cccccc;padding:10px;"><?=$list['qtextsub']?></div><?}?>

  <?if($list['qcoding']!=""){?><div><pre style="border:1px solid #cccccc"><code><?=$list['qcoding']?></code></pre></div><?}?>

  <?if($list['qimg']!=""){?>
    <div><img src="/files/testdata/<?=$list['qimg']?>" border=0></div>
  <?}?>
          <?if(isset($_SESSION["adminID"])){?>
        			<a title="문제 수정" target="_new" href="admin/q_edit.php?qcode=<?=$list['qcode']?>"><i class="fa fa-edit"></i></a>
          <?}?>
		<input type=hidden name="qcode[]" value="<?=$list['qcode']?>">
		<input type=hidden name="qtype[]" value="<?=$list['qtype']?>">
   <!--문제영역end-->
	 <br>

   <!--객관식영역start-->
   				<?if(($list['qtype']=="객관식")||($list['qtype']=="객관식다답일부")){?>
   				<input type=hidden size=1 value="<?=$list['qmorder']?>" name="qmorder_<?=$list['qcode']?>[]">

               <? for($x=1;$x<=5;$x++){
                   if($list['qm'.$x.'text']!=""){
               ?>
               <div>
                 <input type="radio" class="chk_radio" qcode="<?=$list['qcode']?>" anum="<?=$x?>" correct="<?=$list['qm'.$x.'correct']?>" name="chk_<?=$list['qcode']?>[]" value="<?=$list['qm'.$x.'order']?>" id="chk_<?=$list['qcode']?>_<?=$list['qm'.$x.'order']?>"
   								<? if($user_anum==$x){echo(" checked ");} ?>
   							>

                &nbsp; (<?=$list['qm'.$x.'order']?>) &nbsp; <?=$list['qm'.$x.'text']?>
                <?if($list['qm1img']!=""){?><div><img src="/files/testdata/<?=$list['qmimg']?>" border=0></div><?}?>

               </div>
                 <?}
               }?>

               <?if($list['qm1correct']!=""){ $correctstr .="정답 ".$list['qm1order'];} ?>
               <?if($list['qm2correct']!=""){ $correctstr .="정답 ".$list['qm2order'];} ?>
               <?if($list['qm3correct']!=""){ $correctstr .="정답 ".$list['qm3order'];} ?>
               <?if($list['qm4correct']!=""){ $correctstr .="정답 ".$list['qm4order'];} ?>
               <?if($list['qm5correct']!=""){ $correctstr .="정답 ".$list['qm5order'];} ?>


							 <div class="c_correct" style="display:none;">
								 <?=$correctstr?>
							 </div>


   				<?}?>
    <!--객관식영역end-->


		<!--주관식영역start-->
		<?if($list['qtype']=="주관식"){?>
		<input type=hidden size=1 value="<?=$list['qmorder']?>" name="qmorder_<?=$list['qcode']?>[]">
		<div style="color:gray;">▼내용을 입력하세요</div>
		<input type="text" style="width:100%" name="chk_<?=$list['qcode']?>[]" id="chk_<?=$list['qcode']?>" value="<?=$u_aessay?>">
		<input type=button class="chk_btn" qcode="<?=$list['qcode']?>" correct="<?=$list['qmessay']?>" value="정답 확인">

			<?if($list['qmimg']!=""){?>
				<div><img src="/files/testdata/<?=$list['qmimg']?>" border=0></div>
			<?}?>

			<div class="c_correct" style="display:none;">
			<?="정답 ".$list['qmessay']?>
		</div>

		<?}?>
		<!--주관식영역end-->



		<?if($list['qtype']=="서술식"){?>
			<input type=hidden size=1 value="<?=$list['qmorder']?>" name="qmorder_<?=$list['qcode']?>[]">
										<?php if($list["qiscompile"]!=""){ ?>
														<div>
															<b>연습코딩</b>

															<?if($list["qiscompile"]=="c"){?>
															<div id="pym" data-pym-src="https://www.jdoodle.com/iembed/v0/mjS?stdin=0&arg=0&rw=1"></div>
															<?}?>
															<?if($list["qiscompile"]=="cpp"){?>
															<div id="pym" data-pym-src="https://www.jdoodle.com/iembed/v0/mjQ?stdin=0&arg=0&rw=1"></div>
															<?}?>
															<?if($list["qiscompile"]=="java"){?>
															<div id="pym" data-pym-src="https://www.jdoodle.com/iembed/v0/mjR?stdin=0&arg=0&rw=1"></div>
															<?}?>
															<?if($list["qiscompile"]=="python"){?>
															<div id="pym" data-pym-src="https://www.jdoodle.com/iembed/v0/mjT?stdin=0&arg=0&rw=1"></div>
															<?}?>
															<?if($list["qiscompile"]=="sql"){?>
															<div id="pym" data-pym-src="https://www.jdoodle.com/iembed/v0/mjT?stdin=0&arg=0&rw=1"></div>
															<?}?>

															<script src="https://www.jdoodle.com/assets/jdoodle-pym.min.js" type="text/javascript"></script>
														</div>
														<hr>
														<div>
															<b>제출할 코드를 입력하세요</b><br>
																<input type=hidden name="userl" value="<?=strtolower($l)?>">
																<textarea name="chkessay_<?=$list['qcode']?>[]" id="chkessay_<?=$list['qcode']?>" rows="5" cols="80" class="usercode form-control"><?=$user_aessay?></textarea>
																<input type=button value="모범답 보기" onclick="$('#codeEssay_<?=$list['qcode']?>').toggle();">
																<div style="display:none" id="codeEssay_<?=$list['qcode']?>"><pre><code><?=$list['qmessay']?></code></pre></div>
																<!--center><input type="button" value="코드 제출하기" class="btn btn-primary" onclick="pref();"></center-->
														</div>

														<script>
														function pref(){
															if($(".usercode").val()==""){
																alert("코드를 입력하고 제출하세요.");
															}else{
																if(confirm("코드를 제출할까요?")){
																 // document.fcode.submit();
																}
															}
														}
														</script>
										<? }else{ ?>
												<textarea name="chk_<?=$list['qcode']?>[]" id="chkessay_<?=$list['qcode']?>" style="width:100%;"><?=$user_aessay?></textarea>

											<?if($rowtestlog>0){?>
												모범답 : <?=$list['qmessay']?>
											<?}?>

										<? } ?>
		<?}?>




    <!--메모start-->
    <div class="margin-top-10">
		<input type=checkbox>한번틀림 <input type=checkbox>여러번틀림
		<!--<input type=checkbox>확실히앎 <input type=checkbox>잘모름-->

    <textarea placeholder="나만의 학습메모" style="width:100%;" id="memo_<?=$list['qcode']?>"></textarea><input
		type=button value="메모 저장" onclick="memoSave('<?=$list['qcode']?>')">
    </div>

    <br>
    <!--메모end-->








<?}?>



				<?if($list['qtype']=="객관식다답전부"){?>
				<input type=hidden size=1 value="<?=$list['qmorder']?>" name="qmorder_<?=$list['qcode']?>[]"><input type="checkbox" name="chk_<?=$list['qcode']?>[]" value="<?=$list['qmorder']?>" id="chk_<?=$list['qcode']?>_<?=$list['qmorder']?>" >(<?=$list['qmorder']?>) <?=$list['qmtext']?>
					<?if($list['qmcorrect']=="1"){ $correctstr=$correctstr."정답 ".$list['qmorder'];} ?>
          <?if($list['qmimg']!=""){?>
            <div><img src="/files/testdata/<?=$list['qmimg']?>" border=0></div>
          <?}?>
				<?}?>


				<?if($list['qtype']=="주관식다답전부"){?>
				<input type=hidden size=1 value="<?=$list['qmorder']?>" name="qmorder_<?=$list['qcode']?>[]"><input type="text" name="chk_<?=$list['qcode']?>[]" id="chk_<?=$list['qcode']?>_<?=$list['qmorder']?>" value="">

					<? $correctstr=$correctstr."정답 ".$list['qmessay']; ?>
          <?if($list['qmimg']!=""){?>
            <div><img src="/files/testdata/<?=$list['qmimg']?>" border=0></div>
          <?}?>

				<?}?>


				<?if(($list['qtype']=="주관식다답일부")){
						if($old_qtype_qcode!=$list['qcode']){
				?>
				<input type=hidden size=1 value="<?=$list['qmorder']?>" name="qmorder_<?=$list['qcode']?>[]"><input type="text" name="chk_<?=$list['qcode']?>[]" id="chk_<?=$list['qcode']?>" value="">
				<?
						}
					$old_qtype_qcode=$list['qcode'];
					$correctstr=$correctstr."정답 ".$list['qmessay'];
				}
				?>



<?if(1==2){?>
				<hr>
				정답률 : <?=$list["qrightratio"]?>
				<hr>
				<?=$list["qexplain"]?>
				<hr>

<?}?>

				<br>




<script>
$(".chk_btn").click(function(){

	var qc=$(this).attr("qcode");
	var aessay=$("#chk_"+qc).val();
	var correct=$(this).attr("correct");
	var correctval=0;

	if(aessay==correct){
		alert("정답입니다!!");
		correctval=1;
	}else{
		alert("오답입니다ㅠㅠ");
		correctval=-1;
	};

	$.ajax({
         type : "GET",
         url : "/qchk_save.php",
         data : {"qcode":qc, "mb_id":"<?=$mb_id?>", "aessay":aessay, "correctval":correctval},
         error : function(){
             //alert('error');
         },
         success : function(data){
             //alert(data) ;
         }
   });

	return true;

})



$(".chk_radio").click(function(){

	var qc=$(this).attr("qcode");
	var anum=$(this).attr("anum");
	var correctval=$(this).attr("correct");
	if(correctval==""){correctval="-1";}

	$.ajax({
         type : "GET",
         url : "/qchk_save.php",
         data : {"qcode":qc, "mb_id":"<?=$mb_id?>", "anum":anum, "correctval":correctval},
         error : function(){
             //alert('error');
         },
         success : function(data){
             //alert(data) ;
         }
   });


    if( $(this).attr("correct")=="1"){
      alert("정답입니다!!");
    }else{
      alert("오답입니다ㅠㅠ");
    };

})

function memoSave(qc){
  var memo=$("#memo_"+qc).val();
  $.ajax({
         type : "GET",
         url : "/qmemo_save.php",
         data : {"qcode":qc, "mb_id":"<?=$mb_id?>", "memo":memo},
         error : function(){
             alert('error');
         },
         success : function(data){
             //alert(data) ;
         }
     });
}
</script>


<script>
$(function(){
<?php
////멤버메모
$sqlmemo="select qcode, memo from tb_qmemo where mb_id='$mb_id' and qcode in ($qcodestr)";
//echo("/////".$sqlmemo);
$resultmemo=mysqli_query($conn, $sqlmemo);
$rowmemo=$resultmemo->num_rows;
//echo($sqltestlog);
	foreach($resultmemo as $listmemo) {
			$user_qcode=$listmemo["qcode"];
      $user_memo=$listmemo["memo"];
?>
  $("#memo_<?=$user_qcode?>").val("<?=$user_memo?>");

<?php }?>
});
</script>

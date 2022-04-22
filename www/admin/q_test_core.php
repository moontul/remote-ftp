
<?php
$tcode = $_GET['tcode'];

$sql = <<<EOT
select qcode, qtype, qnum, qtext, qimg, qcoding, qmessay, qiscompile
, qm1order, qm1text, qm1img, qm1correct
, qm2order, qm2text, qm2img, qm2correct
, qm3order, qm3text, qm3img, qm3correct
, qm4order, qm4text, qm4img, qm4correct
, qm5order, qm5text, qm5img, qm5correct
, qrightratio, qexplain
from
tb_question A
where 1=1
EOT;
if($qcode!=""){ $sql = $sql . " and A.qcode='$qcode'";}
if($lcucode!=""){ $sql = $sql . " and A.lcucode='$lcucode'";}
if($lccode!=""){ $sql = $sql . " and A.lccode='$lccode'";}
if($sjucode!=""){ $sql = $sql . " and A.sjucode='$sjucode'";}
if($sjcode!=""){ $sql = $sql . " and A.sjcode='$sjcode'";}
$sql = $sql . " order by convert(qnum, int)";
if($vtype=="1"){ $sql = $sql . " limit 1"; }
echo($sql);
//$sql="CALL sp_testpaper('$tcode')"
$result = mysqli_query($conn, $sql);
$row=$result->num_rows;
//echo($sql);
?>
<?php
if($retest==""){
//멤버시험결과 로그
$sqltestlog = <<<EOT
	select *, (select qtype from tb_question where qcode=A.qcode) as qtype
	from	tb_qsheet_log A
	where 1=1
EOT;
if ($tcode!=""){$sqltestlog = $sqltestlog ." and tcode='$tcode' "; }
if ($qcode!=""){$sqltestlog = $sqltestlog ." and qcode='$qcode' "; }
if ($sjucode!=""){$sqltestlog = $sqltestlog ." and sjucode='$sjucode' "; }
$sqltestlog = $sqltestlog ." and mb_id='$mb_id' ";

$resulttestlog = mysqli_query($conn, $sqltestlog);
$rowtestlog=$resulttestlog->num_rows;
//echo($sqltestlog);
	foreach($resulttestlog as $listlog) {
			$user_anum=$listlog["anum"];
			$user_aessay=$listlog["aessay"];
			$user_correctval=$listlog["correctval"];
	}
}else{
	$rowtestlog=0;
}
?>



<form name=f method=post action="<?=$form_action_str?>">
<input type=hidden name="tcode" value="<?=$tcode?>">

<input type=hidden name="sjucode" value="<?=$sjucode?>">
<input type=hidden name="lcucode" value="<?=$lcucode?>">
<input type=hidden name="mb_id" value="<?=$mb_id?>">
<input type=hidden name="retest" value="<?=$retest?>">

<?php foreach($result as $list) {?>

				<?if ($old_qtext!==$list['qtext']){?>

							<?if(($correctstr!="")&&($rowtestlog>0)){?>
								<hr>
								[ <?=$correctstr;?> ]
								<hr>
							<?
								$correctstr="";
							}?>
									<br>
									<div style="position:absolute;display:<?if(($rowtestlog>0)&&($user_correctval>0)){echo('show');}else{echo('none');}?>;margin-top:-10px;margin-left:-15px;" id="o_<?=$list['qcode']?>"><img src="/img/util/testresult_o1.png" width=40></div>
									<div style="position:absolute;display:<?if(($rowtestlog>0)&&($user_correctval<0)){echo('show');}else{echo('none');}?>;margin-top:-15px;margin-left:-15px;" id="x_<?=$list['qcode']?>"><img src="/img/util/testresult_x1.png" width=30></div>
									<div style="position:absolute;display:<?if(($rowtestlog>0)&&($user_correctval==0)){echo('show');}else{echo('none');}?>;color:#cc0000;margin-top:-18px;margin-left:-18px;" id="try_<?=$list['qcode']?>"><img
										src="/img/util/testresult_tri.png" width=40>채점대기</div>

										<b><?=$list['qnum']?>.	<?=$list['qtext']?></b>
										<?if($list['qcoding']!=""){?><div><pre style="border:1px solid #cccccc"><code><?=$list['qcoding']?></code></pre></div><?}?>

                    <?if($list['qimg']!=""){?>
                      <div><img src="/files/testdata/<?=$list['qimg']?>" border=0></div>
                    <?}?>
                        <?if(isset($_SESSION["adminID"])){?>
														<a title="문제 수정" target="_new" href="admin/q_edit.php?qcode=<?=$list['qcode']?>"><i class="fa fa-edit"></i></a>
                        <?}?>
									<br><br>
									<input type=hidden name="qcode[]" value="<?=$list['qcode']?>">
									<input type=hidden name="qtype[]" value="<?=$list['qtype']?>">
				<?}?>

				<?if(($list['qtype']=="객관식")||($list['qtype']=="객관식다답일부")){?>
				<input type=hidden size=1 value="<?=$list['qmorder']?>" name="qmorder_<?=$list['qcode']?>[]">


            <? for($x=1;$x<=5;$x++){
                if($list['qm'.$x.'text']!=""){
            ?>
            <div>
              <input type="radio" name="chk_<?=$list['qcode']?>[]" value="<?=$list['qm'.$x.'order']?>" id="chk_<?=$list['qcode']?>_<?=$list['qm'.$x.'order']?>"
								<? if($user_anum==$x){echo(" checked ");} ?>
							>
             &nbsp; (<?=$list['qm'.$x.'order']?>) &nbsp; <?=$list['qm'.$x.'text']?>
             <?if($list['qm1img']!=""){?><div><img src="/files/testdata/<?=$list['qmimg']?>" border=0></div><?}?>

            </div>
              <?}
            }?>

            <?if($list['qm1correct']!=""){ $correctstr=$correctstr."정답 ".$list['qm1order'];} ?>
            <?if($list['qm2correct']!=""){ $correctstr=$correctstr."정답 ".$list['qm2order'];} ?>
            <?if($list['qm3correct']!=""){ $correctstr=$correctstr."정답 ".$list['qm3order'];} ?>
            <?if($list['qm4correct']!=""){ $correctstr=$correctstr."정답 ".$list['qm4order'];} ?>
            <?if($list['qm5correct']!=""){ $correctstr=$correctstr."정답 ".$list['qm5order'];} ?>

				<?}?>


				<?if($list['qtype']=="객관식다답전부"){?>
				<input type=hidden size=1 value="<?=$list['qmorder']?>" name="qmorder_<?=$list['qcode']?>[]"><input type="checkbox" name="chk_<?=$list['qcode']?>[]" value="<?=$list['qmorder']?>" id="chk_<?=$list['qcode']?>_<?=$list['qmorder']?>" >(<?=$list['qmorder']?>) <?=$list['qmtext']?>

					<?if($list['qmcorrect']=="1"){ $correctstr=$correctstr."정답 ".$list['qmorder'];} ?>
          <?if($list['qmimg']!=""){?>
            <div><img src="/files/testdata/<?=$list['qmimg']?>" border=0></div>
          <?}?>

				<?}?>

				<?if($list['qtype']=="주관식"){?>
				<input type=hidden size=1 value="<?=$list['qmorder']?>" name="qmorder_<?=$list['qcode']?>[]">
				<input type="text" style="width:100%" name="chk_<?=$list['qcode']?>[]" id="chk_<?=$list['qcode']?>" value="<?=$user_aessay?>">

					<? $correctstr=$correctstr."정답 ".$list['qmessay']; ?>
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
				    <textarea name="chkessay_<?=$list['qcode']?>[]" id="chkessay_<?=$list['qcode']?>" rows="8" cols="80" class="usercode form-control"><?=$user_aessay?></textarea>
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
<?if($rowtestlog>0){?>
				<hr>
				정답률 : <?=$list["qrightratio"]?>
				<hr>
				<?=$list["qexplain"]?>
				<hr>
<?}?>

				<br>
<?php
	$old_qtext=$list['qtext'];
} ?>


<?if(($correctstr!="")&&($rowtestlog>0)){?>
	<hr>
	[ <?=$correctstr;?> ]
	<hr>
<?}?>

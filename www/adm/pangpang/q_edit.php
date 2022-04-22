<?php
$sub_menu = "600200";
include_once("./_common.php");

 if($qcode!=""){
   $g5['title'] = "문제 수정";
 }else{
   $g5['title'] = "문제 만들기";
 }
include_once(G5_ADMIN_PATH.'/admin.head.php');
//--------------------------------------------------------------------
?>
<?php

$qcode = $_GET["qcode"];
if($qcode!=""){

    $sql="select * from tb_question where qcode='$qcode'";
    $result = mysqli_query($conn, $sql);
    $row=$result->num_rows;
    foreach($result as $list)
    {
      $qtext=$list["qtext"];
      $qtextsub=$list["qtextsub"];
      $qimg=$list["qimg"];
      $qcoding=$list["qcoding"];

      $qnum=$list["qnum"];
      $qtype=$list["qtype"];

      $sjcode=$list["sjcode"];
      $sjucode=$list["sjucode"];
      $lccode=$list["lccode"];
      $lcucode=$list["lcucode"];
      $bkcode=$list["bkcode"];
      $bkucode=$list["bkucode"];

      $qm1text=$list["qm1text"];
      $qm2text=$list["qm2text"];
      $qm3text=$list["qm3text"];
      $qm4text=$list["qm4text"];
      $qm5text=$list["qm5text"];
      $qm1correct=$list["qm1correct"];
      $qm2correct=$list["qm2correct"];
      $qm3correct=$list["qm3correct"];
      $qm4correct=$list["qm4correct"];
      $qm5correct=$list["qm5correct"];

      $qmessay=$list["qmessay"];
      $qiscompile=$list["qiscompile"];
      $merrill_x=$list["merrill_x"];
      $merrill_y=$list["merrill_y"];
      $merrill=$merrill_x."X".$merrill_y;

      $qlevel=$list["qlevel"];
      $qimportance=$list["qimportance"];

      $qrightratio=$list["qrightratio"];

      $qexplain=$list["qexplain"]; //기본해설

    }
}else{
  $sjcode=$_GET["sjcode"];
  $sjucode=$_GET["sjucode"];

  $lccode=$_GET["lccode"];
  $lcucode=$_GET["lcucode"];

  $bkcode=$_GET["bkcode"];
  $bkucode=$_GET["bkucode"];

//  if($sjcode==""){$sjcode=$_COOKIE["sjcode"];}
//  if($sjucode==""){$sjucode=$_COOKIE["sjucode"];}
//  $qnum_new=$_COOKIE["qnum_new"];
}
?>

<form name=f method=post action="q_save.php" enctype="multipart/form-data">
<input type=hidden name="qcode" value="<?=$qcode?>">

<table>
<tr>
<td><label for="qnum" class="col-form-label"><h6>*유형</h6></label></td>
<td class="col-sm-5">
      <input type=radio name="qtype" id="qtyperadio1" value="객관식" <?if($qtype=='객관식'){echo('checked');}?> onclick="changeQtype(this.value)"> 객관식
      &nbsp; &nbsp;
      <input type=radio name="qtype" id="qtyperadio2" value="주관식" <?if($qtype=='주관식'){echo('checked');}?> onclick="changeQtype(this.value)"> 주관식
      &nbsp; &nbsp;
      <input type=radio name="qtype" id="qtyperadio3" value="서술식" <?if($qtype=='서술식'){echo('checked');}?> onclick="changeQtype(this.value)"> 서술식
</td>
<td><label for="qnum" class="col-form-label"><h6>*문제번호</h6></label></td>
<td class="col-sm-1">
      <input type="text" class="form-control form-control-sm" name="qnum" value="<?=$qnum?><?=$qnum_new?>"  id="qnum">
</td>
<!--<input type=radio name="qtype" value="OX식" onclick="changeQtype(this.value)"> OX식(다중선택)-->
</tr>
</table>
<hr>
<script>
function chkMerrill(){
  $.ajax({
      url:'q_edit_chkmerrill.php',
      data : {"str": "str"},
      success:function(data){
        data=(data.replace(/\"/gi ,""));
        $("#mr_"+data).attr("checked", "checked");
        //$('#time').append(data);
      }
  })
}
</script>
<table>
<tr>
<td valign=top width=8%>
        <label for="qnum" class="col-form-label"><h6>*질문</h6></label>

        <input type=button value="▼상세" onclick="$('#q_detail').toggle()">

        <!--input type=button value="merrill" onclick="chkMerrill()" class="btn btn-sm" style="padding:0"-->
</td>
<td>
        <textarea name="qtext" id="qtext" class="form-control form-control-sm"><?=$qtext?></textarea>
</td>
</tr>
</table>

<div id="q_detail" style="display:<?=($qtextsub!=''||$qimg!=''||$qcoding!='')?'':'none'?>;">
<table>
<tr><td>
        <table><tr><td width=8%>지문</td><td><textarea name="qtextsub"><?=$qtextsub?></textarea></td></tr></table>

        <table><tr><td width=8%>파일</td><td>
                  <? if($qimg!=""){?>
                  <img src="/files/testdata/<?=$qimg?>">
                      <input type=text name=qimg value="<?=$qimg?>" class="form-control from-control-sm">
                  <?}?>
                  <input type=file name="qimgup" id="qimgup" class="form-control form-control-sm">
          </td></tr></table>

          <table><tr><td width=8%>코드</td>
          <td><textarea  name="qcoding" class="form-control form-control-sm"><?=$qcoding?></textarea>
          </td></tr></table>
</td>
</tr>
</table>
</div>

<hr>
<!--객관식-->
<div class="qtype" id="qtype1" style="display:none;">

  <table class="form-group row">
  <tr>
  <td width=8% valign=top><label for="" class="col-sm-1 col-form-label"><h6>문항</h6></label></td>
  <td>
    <div class="col-sm-11">
      <?for($ix=1;$ix<=5;$ix++){?>
      <div style="clear:both;">
          <div style="float:left;width:5%;"><input type=text name="qm<?=$ix?>order" size=2 class="form-control form-control-sm" value="<?=$ix?>"></div>
          <div style="float:left;width:85%;"><input type=text name="qm<?=$ix?>text" size=90 class="form-control form-control-sm" value="<?=${"qm".$ix."text"}?>" autocomplete="off"></div>
          <div style="float:left;width:5%;text-align:right;font-weight:bold;">정답&nbsp;</div>
          <div style="float:left;width:5%;"><input type=checkbox name="qm<?=$ix?>correct" size=2 class="chkcorrect" value="1" <?if(${"qm".$ix."correct"}=="1"){echo(" checked ");}?>></div>
      </div>
      <?}?>
    </div>
  </td>
  </tr>
  </table>

</div>

<!--주관식-->
<div class="qtype" id="qtype2" style="display:none;">
  <table><tr><td width=8%>
    <label for="" class="col-sm-1 col-form-label" style="letter-spacing:-3px"><h6>주관식<br>정답</h6></label>
  </td>
  <td><textarea name="qmessay" class="form-control"><?=$qmessay?></textarea></td>
  </tr></table>
</div>

<!--서술식-->
<div class="qtype" id="qtype3" style="display:none;">
  <table><tr><td width=8% valign=top><label for="" class="col-sm-1 col-form-label" style="letter-spacing:-2px"><h6>서술식<br>모범답</h6></label></td>
  <td>
        <textarea name="qmessaylong" class="form-control form-control-sm"><?=$qmessay?></textarea>
        <select name="qiscompile" class="form-control form-control-sm">
        <option value="">컴파일러사용여부
        <option value="c" <?if($qiscompile=="c"){echo(" selected ");}?>>C
        <option value="cpp" <?if($qiscompile=="cpp"){echo(" selected ");}?>>C++
        <option value="java" <?if($qiscompile=="java"){echo(" selected ");}?>>Java
        <option value="python" <?if($qiscompile=="python"){echo(" selected ");}?>>python
        <option value="sql" <?if($qiscompile=="sql"){echo(" selected ");}?>>sql
        </select>
        <span style="font-size:11px">(서술식은 수동 채점 됩니다)</span>
    </td>
  </tr></table>
</div>

<hr>
<table>
<tr>
<td rowspan=3 width=8% valign=top><label for="" class="col-sm-1 col-form-label"><h6>제공<br>방식</h6></label></td>
<td>
      <!--과목-->
      <table>
      <tr>
      <td width=10%><label for="" class="col-sm-1 col-form-label f11" style="font-size:12px">과목</label></td>
      <td width=40%>
            <?php  $sqlsj="select * from tb_subject A";
                $resultsj = mysqli_query($conn, $sqlsj);
                $rowsj=$resultsj->num_rows;
            ?>
            <select name="sjcode" class="form-control form-control-sm">
              <?php
              echo("<option value=''>과목 선택하세요</option>");
              foreach($resultsj as $list)
              {
                echo("<option value='".$list["sjcode"]."' ");
                if($sjcode==$list["sjcode"]){echo(" selected ");}
                echo(">".$list["subjectname"]."</option>");
              }
              ?>
            </select>
      </td>
      <td width=10%><label for="" class="col-sm-1 col-form-label" style="font-size:12px">단원</label></td>
      <td width=40%>

            <? if ($sjcode!=""){
                $sqlsj="select * from tb_subjectunit A where sjcode='$sjcode' order by unitorder";
                $resultsj = mysqli_query($conn, $sqlsj);
                $rowsj=$resultsj->num_rows;
                if ($rowsj>0){
            ?>
            <select name="sjucode" class="form-control  form-control-sm">
              <?php
              echo("<option value=''>단원 선택 안함</option>");
              foreach($resultsj as $list)
              {
                echo("<option value='".$list["sjucode"]."' ");
                if($sjucode==$list["sjucode"]){echo(" selected ");}
                echo(">".$list["unitname"]."</option>");
              }
              ?>
            </select>
            <? }
            } ?>
        </td>
        </tr>
      </table>
      <!--/과목-->
</td>
</tr>
<tr>
<td>
      <!--자격-->
      <table>
      <tr>
      <td width=10%><label for="" class="col-sm-1 col-form-label" style="font-size:12px">자격증</label></td>
      <td width=40%>
            <?php  $sqllc="select * from tb_license A";
                $resultlc = mysqli_query($conn, $sqllc);
                $rowlc=$resultlc->num_rows;
            ?>
            <select name="lccode" class="form-control form-control-sm">
              <?php
              echo("<option value=''>자격시험 선택하세요</option>");
              foreach($resultlc as $list)
              {
                echo("<option value='".$list["lccode"]."' ");
                if($lccode==$list["lccode"]){echo(" selected ");}
                echo(">".$list["licensename"]." ".$list["licensedate"]."</option>");
              }
              ?>
            </select>
        </td>
        <td width=10%><label for="" class="col-sm-1 col-form-label" style="letter-spacing:-2px;font-size:12px;">응시과목</label></td>
        <td width=40%>
            <? if ($lccode!=""){
                $sqllcu="select * from tb_licenseunit A where lccode='$lccode' order by unitorder";
                $resultlcu = mysqli_query($conn, $sqllcu);
                $rowlcu=$resultlcu->num_rows;
                if ($rowlcu>0){
            ?>
            <select name="lcucode" class="form-control  form-control-sm">
              <?php
              echo("<option value=''>응시과목 선택 안함</option>");
              foreach($resultlcu as $list)
              {
                echo("<option value='".$list["lcucode"]."' ");
                if($lcucode==$list["lcucode"]){echo(" selected ");}
                echo(">".$list["unitname"]."</option>");
              }
              ?>
            </select>
            <? }
            } ?>
        </td>
      </tr>
    </table>
      <!--/자격-->
</td>
</tr>
<tr>
<td>
      <!--도서-->
      <table>
      <tr>
      <td width=10%><label for="" class="col-sm-1 col-form-label" style="font-size:12px">도서</label></td>
      <td width=40%>
            <?php  $sqllc="select * from tb_book A";
                $resultlc = mysqli_query($conn, $sqllc);
                $rowlc=$resultlc->num_rows;
            ?>
            <select name="bkcode" class="form-control form-control-sm">
              <?php
              echo("<option value=''>도서를 선택하세요</option>");
              foreach($resultlc as $list)
              {
                echo("<option value='".$list["bkcode"]."' ");
                if($bkcode==$list["bkcode"]){echo(" selected ");}
                echo(">".$list["bookname"]."</option>");
              }
              ?>
            </select>
        </td>
        <td width=10%><label for="" class="col-sm-1 col-form-label" style="letter-spacing:-2px;font-size:12px;">단원</label></td>
        <td width=40%>
            <? if ($bkcode!=""){
                $sqllcu="select * from tb_bookunit A where bkcode='$bkcode' order by unitorder";
                $resultlcu = mysqli_query($conn, $sqllcu);
                $rowlcu=$resultlcu->num_rows;
                if ($rowlcu>0){
            ?>
            <select name="bkucode" class="form-control  form-control-sm">
              <?php
              echo("<option value=''>단원 선택안함</option>");
              foreach($resultlcu as $list)
              {
                echo("<option value='".$list["bkucode"]."' ");
                if($bkucode==$list["bkucode"]){echo(" selected ");}
                echo(">".$list["unitname"]."</option>");
              }
              ?>
            </select>
            <? }
            } ?>
        </td>
      </tr>
    </table>
      <!--도서-->

</td>
</tr>
</table>


<hr>

<table>
<tr>
<td valign=top width=8%><label for="" class="col-form-label" ><h6>내용<br>요소</h6></label></td>
<td width=32%>

                    <table>
                    <tr><td></td><td>사실</td><td>개념</td><td>절차</td><td>원리</td></tr>
                    <tr><td>기억</td>
                      <td><input type=radio class="form-control" name="merrill" id="mr_x1_y1" value="사실X기억" <?if ($merrill=="사실X기억"){echo(" checked");}?> ></td>
                      <td><input type=radio class="form-control" name="merrill" id="mr_x2_y1" value="개념X기억" <?if ($merrill=="개념X기억"){echo(" checked");}?> ></td>
                      <td><input type=radio class="form-control" name="merrill" id="mr_x3_y1" value="절차X기억" <?if ($merrill=="절차X기억"){echo(" checked");}?> ></td>
                      <td><input type=radio class="form-control" name="merrill" id="mr_x4_y1" value="원리X기억" <?if ($merrill=="원리X기억"){echo(" checked");}?> ></td>
                    </tr>
                    <tr><td>활용</td>
                      <td><input type=radio class="form-control" name="merrill" id="mr_x1_y2" value="사실X활용" <?if ($merrill=="사실X활용"){echo(" checked");}?> ></td>
                      <td><input type=radio class="form-control" name="merrill" id="mr_x2_y2" value="개념X활용" <?if ($merrill=="개념X활용"){echo(" checked");}?> ></td>
                      <td><input type=radio class="form-control" name="merrill" id="mr_x3_y2" value="절차X활용" <?if ($merrill=="절차X활용"){echo(" checked");}?> ></td>
                      <td><input type=radio class="form-control" name="merrill" id="mr_x4_y2" value="원리X활용" <?if ($merrill=="원리X활용"){echo(" checked");}?> ></td>
                    </tr>
                    <tr><td>발견</td>
                      <td><input type=radio class="form-control" name="merrill" id="mr_x1_y3" value="사실X발견" <?if ($merrill=="사실X발견"){echo(" checked");}?> ></td>
                      <td><input type=radio class="form-control" name="merrill" id="mr_x2_y3" value="개념X발견" <?if ($merrill=="개념X발견"){echo(" checked");}?> ></td>
                      <td><input type=radio class="form-control" name="merrill" id="mr_x3_y3" value="절차X발견" <?if ($merrill=="절차X발견"){echo(" checked");}?> ></td>
                      <td><input type=radio class="form-control" name="merrill" id="mr_x4_y3" value="원리X발견" <?if ($merrill=="원리X발견"){echo(" checked");}?> ></td>
                    </tr>
                    <tr><td>창조</td>
                      <td><input type=radio class="form-control" name="merrill" id="mr_x1_y4" value="개념X창조" <?if ($merrill=="개념X창조"){echo(" checked");}?> ></td>
                      <td><input type=radio class="form-control" name="merrill" id="mr_x2_y4" value="사실X창조" <?if ($merrill=="사실X창조"){echo(" checked");}?> ></td>
                      <td><input type=radio class="form-control" name="merrill" id="mr_x3_y4" value="절차X창조" <?if ($merrill=="절차X창조"){echo(" checked");}?> ></td>
                      <td><input type=radio class="form-control" name="merrill" id="mr_x4_y4" value="원리X창조" <?if ($merrill=="원리X창조"){echo(" checked");}?> ></td>
                    </tr>
                    </table>

</td>
<td width=60%>
    <div class="row">
                <label for="" class="col-sm-2 col-form-label"><h6>난이도</h6></label>
                <div class="col-sm-10">
                  <input type=radio name="qlevel" value="하" <?if($qlevel=="하"){echo(" checked ");}?>>하 &nbsp;
                  <input type=radio name="qlevel" value="중" <?if($qlevel=="중"){echo(" checked ");}?>>중 &nbsp;
                  <input type=radio name="qlevel" value="상" <?if($qlevel=="상"){echo(" checked ");}?>>상
                </div>
      </div>
      <div class="row">
                <label for="" class="col-sm-2 col-form-label" style="letter-spacing:-2px;"><h6>중요도</h6></label>
                <div class="col-sm-10">
                  <input type=radio name="qimportance" value="기초" <?if($qimportance=="기초"){echo(" checked ");}?>>기초 &nbsp;
                  <input type=radio name="qimportance" value="핵심" <?if($qimportance=="핵심"){echo(" checked ");}?>>핵심 &nbsp;
                  <input type=radio name="qimportance" value="심화" <?if($qimportance=="심화"){echo(" checked ");}?>>심화
                </div>
      </div>
      <div class="row">
                <label for="" class="col-sm-2 col-form-label" style="letter-spacing:-2px;"><h6>정답률</h6></label>
                <div class="col-sm-4">
                  <input type=text name="qrightratio" class="form-control" value="<?=$qrightratio?>">
                </div>
      </div>
</td>
</tr>
</table>

<hr>
<table>
<tr>
<td width=8% valign=top><label for="" class="col-sm-1 col-form-label" style="letter-spacing:-1px"><h6>해설</h6></label></td>
<td>
    <div class="col-sm-11"><textarea type=text name="qexplain" class="form-control form-control-sm"><?=$qexplain?></textarea></div>
</td>
</tr>
</table>
<hr>
<table>
<tr>
<td width=8%><label for="" class="col-sm-1 col-form-label" style="letter-spacing:-1px"><h6>키워드</h6></label></td>
<td><div class="col-sm-11"><input type=text name="qgroup" class="form-control form-control-sm" value="<?=$qgroup?>"></div></td>
</tr>
</table>

<br>
<br>
<br>


<div class="btn_fixed_top">
    <a href="./q_list.php?code=<?=$code?>" class="btn btn_02">목록</a>
    <input type="submit" value="저장" class="btn btn_submit" accesskey="s">
</div>

<!--
<input type=submit value="저장" class=" btn btn-primary">
<a href="q_list.php" class="btn btn-secondary">목록</a>
<a href="q_edit.php" class="btn btn-secondary">새 문제</a>
-->
</form>



<script>
//도서선택
function changeProvision(v,b)
{

	if(v=="도서형")
	{
		$.ajax({
				url:'testqedit_getbook.php',
        data : {"b_idx": b},
				success:function(data){

					$("#provisionbook").html(data);
					//$('#time').append(data);
				}
		})
	}
	else
	{
		$("#provisionbook").html("");
    $("#bookunit").html("");
	}
}

//단원선택
function changeBook(v1, v2)
{
//	alert(obj.value);
  $.ajax({
      url:'testqedit_getbookunit.php',
      data: {'b_idx':v1, 'bu_idx':v2},
      success:function(data){

        $("#bookunit").html(data);
      }
  })

}

function changeQtype(v)
{
	$(".qtype").hide();
	if(v=="객관식"){$("#qtype1").show();}
  if(v=="주관식"){$("#qtype2").show();}
  if(v=="서술식"){$("#qtype3").show();}
  //if(v=="OX식"){$("#qtype1").show();}
	//if(v=="단답식"){$("#qtype2").show();}
}

$(function(){

<?php if($qcode!=""){ ?>
  changeProvision("<?=$provision?>","<?=$b_idx?>");
  <? if("<?=$provision?>"=="도서형"){?>
  changeBook("<?=$b_idx?>", "<?=$bu_idx?>");
  <?}?>
  changeQtype("<?=$qtype?>");
<?}else{?>
  $("#qtyperadio1").attr("checked","checked");
  changeQtype("객관식");
<?}?>


  $('.chkcorrect').click(function(){
    var index = $(".chkcorrect").index(this);
    var tf=$(".chkcorrect:eq("+index+")").prop("checked");
    if(tf){
      $(".hiddencorrect:eq("+index+")").val("1");
    }else{
      $(".hiddencorrect:eq("+index+")").val("");
    }

  });

});
</script>

</div>
<!-- /.container-fluid -->













<?php
//--------------------------------------------------------------------
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>

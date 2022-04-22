<?php include_once(G5_EDITOR_LIB); ?>
<?php include_once("page.wraptop.php");?>
<?php include_once("page.nav.php");?>
<div class="col-lg-9 col-md-9 col-sm-12 pp-mainpage">
<?php include_once("page.adm.btns.php");?>

<?php
$qcode=$_GET["qcode"];
$copyq=$_GET["copyq"]; //문제 복사 : 처음 복사할 때 copyq로 기존문제 번호 호출

if(isset($copyq)){$qcode=$copyq;}

if($qcode!=""){
  $sqlq="select * from tb_question where qcode='$qcode'";
  $resultq=sql_fetch($sqlq);

  $isopen=$resultq["isopen"];

  $qnum=$resultq["qnum"];
  $qtype=$resultq["qtype"];

  $qtext=$resultq["qtext"];
  $qtextsub=$resultq["qtextsub"];
  $qimg=$resultq["qimg"];
  $imgpath=$resultq["imgpath"];

  $is_compiler=$resultq["is_compiler"];
  $is_compilerfirst=$resultq["is_compilerfirst"];
  $is_compilertheme=$resultq["is_compilertheme"];
    if($is_compilertheme==""){$is_compilertheme="vs-dark";}

  $qcompilecode=$resultq["qcompilecode"];
  $qtextsubcoding=$resultq["qtextsubcoding"];
  $qm1text=$resultq["qm1text"];
  $qm2text=$resultq["qm2text"];
  $qm3text=$resultq["qm3text"];
  $qm4text=$resultq["qm4text"];
  $qm5text=$resultq["qm5text"];

  $qm1img=$resultq["qm1img"];
  $qm2img=$resultq["qm2img"];
  $qm3img=$resultq["qm3img"];
  $qm4img=$resultq["qm4img"];

  $qm1correct=$resultq["qm1correct"];
  $qm2correct=$resultq["qm2correct"];
  $qm3correct=$resultq["qm3correct"];
  $qm4correct=$resultq["qm4correct"];
  $qanswer=$resultq["qanswer"];
  $qessay=$resultq["qessay"];

  $qexplain=$resultq["qexplain"];
  $qyoutube=$resultq["qyoutube"];

  $merrillx=$resultq["merrillx"]; //메릴x
  $merrilly=$resultq["merrilly"]; //메릴y
  $merrilljson=$resultq["merrilljson"]; //메릴y

  $merrill=$merrillx."X".$merrilly;

  $qlevel=$resultq["qlevel"];
  $qimportance=$resultq["qimportance"];
}

if($list!=""&&($qcode==""||$copyq!="")){
  //새로운 문제 만들때 최대문제번호를 호출
  $sql="select max(pqnum) as max_qnum from tb_pageq where list='$list'";
  //echo($sql);
  $result=sql_fetch($sql);
  $max_qnum=$result["max_qnum"];
  $qnum=$max_qnum+1;
}

//초기설정값
if($qtype==""){$qtype="객관식";}
if($isopen==""){$isopen="1";}
?>


<script>
function adjustHeight(obj) {
  var textEle = $(obj); //$('textarea');
  textEle[0].style.height = 'auto';
  var textEleHeight = textEle.prop('scrollHeight');
  textEle.css('height', textEleHeight);
};

$(function(){

    $(".qtype").click(function(){

        var t=$(this).attr("target");
        $(".qtype_dest").hide();$("#"+t).show();

    })
})
</script>

      <div class="ct-docs-page-title">



        <?$page_full_title=$a_path[array_search($list, $a_list)];?>
        <sub class="ms-3 text-muted"><?=$page_full_title?></sub>
      </div>

      <div class="ct-docs-page-title">
        <span class="ct-docs-page-h1-title">
                <?php if(isset($copyq)){?> <span class="badge rounded-pill bg-light text-dark shadow-sm">기존문제로 새문제를 만듭니다</span><? }else{?>
                    <?if(isset($qcode)){echo("문제 수정");}else{echo("문제 등록");}?>
                <?php } ?></span>
      </div>
      <hr class="ct-docs-hr">



      <form name=f method="post" action="./page_qsave.php" enctype="MULTIPART/FORM-DATA">
      <input type=hidden name=code value="<?=$code?>" size=5>
      <input type=hidden name=list value="<?=$list?>" size=5>
      <input type=hidden name=page_full_title value="<?=$page_full_title?>" size=5>

      <input type=hidden name=mode value="">
      <?php if(isset($copyq)){ ?>
      <input type=hidden name=qcode value="">
      <input type=hidden name=copyqcode value="<?=$copyq?>">
      <?php }else { ?>
      <input type=hidden name=qcode value="<?=$qcode?>">

    <?php } ?>

      <table class="table table-sm pptable">
      <tr>
      <td style="width:7%" nowrap>번호</td>
      <td style="width:7%" nowrap><input type="text" name="qnum" value="<?=$qnum?>" class="form-control form-control-sm" autocomplete="off"></td>
      <td style="width:7%" nowrap>유형</td>
      <td>
        <input type="radio" name="qtype" value="객관식" <?=($qtype=="객관식")?"checked":""?> class="qtype" target="qtype1">객관식
        <input type="radio" name="qtype" value="주관식" <?=($qtype=="주관식")?"checked":""?> class="qtype" target="qtype2">주관식
        <input type="radio" name="qtype" value="서술식" <?=($qtype=="서술식")?"checked":""?> class="qtype" target="qtype3">서술식
        <input type="radio" name="qtype" value="코딩" <?=($qtype=="코딩")?"checked":""?> class="qtype" target="qtype3">코딩

        &nbsp; &nbsp;  &nbsp;   &nbsp;   &nbsp;

        <input type="radio" name="isopen" value="1" <?=($isopen=="1")?"checked":""?>> 공개
        <input type="radio" name="isopen" value="0" <?=($isopen=="0")?"checked":""?>> 비공개


      </td>
      </tr>

      <tr>
      <td style="width:7%" nowrap>문제
        <a class="q_detail" onclick="$('.q_detail').toggle();"><i class="fas fa-caret-down"></i></a>
        <a class="q_detail" onclick="$('.q_detail').toggle();" style="display:none;"><i class="fas fa-caret-up"></i></a>
      </td>
      <td colspan=3>
          <input type="text" name="qtext" id="qtext" value="<?=$qtext?>" class="form-control form-control-sm" autocomplete="off">
      </td>
      </tr>
      </table>
<?php /////////////////////// qdetail?>

          <table width="100%" class="table table-sm q_detail pp-table" style="display:<?=($qtextsub!=''||$qimg!=''||$qcompilecode!='')?'':'none'?>;">
          <tr>
          <td width="7%" align=right>지문</td>
          <td colspan=3>
            <?php if(trim(strip_tags($qtextsub))==""){$qtextsub="";}?>
            <?php echo editor_html('qtextsub', get_text(html_purifier($qtextsub), 0)); ?>
            <!--
            <textarea name="qtextsub" rows=3 class="form-control form-control-sm" autocomplete="off"
            onkeyup="adjustHeight(this);" onkeydown="if(event.keyCode===9){var v=this.value,s=this.selectionStart,e=this.selectionEnd;this.value=v.substring(0, s)+'\t'+v.substring(e);this.selectionStart=this.selectionEnd=s+1;return false;}"
            ><?=$qtextsub?></textarea>
            -->
          </td>
          </tr>
          <tr>
          <td style="width:7%"  align=right>파일</td>
          <td colspan=3>
              <div class="d-flex">
            <? if($qimg!=""){?>
                <div>
                <a href="<?=G5_DATA_URL?><?=$imgpath?><?=$qimg?>" target="_blank"><img src="<?=G5_DATA_URL?><?=$imgpath?><?=$qimg?>" height=30></a>
                <input type=checkbox name=qimgdel value="<?=$imgpath?><?=$qimg?>">파일삭제
                <input type=hidden name=qimg value="<?=$qimg?>" class="form-control from-control-sm">
                <input type=hidden name=imgpath value="<?=$imgpath?>">
                </div>
            <?}?>
                <div class="s-50">
                <input type=file name="qimgup" id="qimgup" class="form-control form-control-sm">
                </div>
              </div>
          </td>
          </tr>
          <tr>
          <td style="width:7%"  align=right>코드</td>
          <td colspan=3>

              <input type=checkbox name=is_compilerfirst value="1" <?=($is_compilerfirst=="1")?"checked":"" ?>> 이미지보다 우선
              &nbsp; &nbsp;

              <input type=checkbox value="1" name="qtextsubcoding" <?=($qtextsubcoding=="1")?"checked":"" ?>> 설명코딩스타일

              <?php //// 모나코 start ?>

                              <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.20.0/min/vs/editor/editor.main.min.css">
                              <style>
                                    .code_container {
                                      width: 100%;
                                      height: 300px;
                                      border: 0;
                                    }
                              </style>
                              <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.26.1/min/vs/loader.min.js"></script>
                              <script>
                              function createMonaco(qc, v, l){
                                require.config({
                                  paths: {'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.26.1/min/vs'}
                                });
                                if(v==""){v="";}
                                if(l==""){l="c";}
                                require(["vs/editor/editor.main"], () => {
                                    window.monaco["qc_"+qc]=monaco.editor.create(document.getElementById('code_container_'+qc), {
                                    value:v,
                                    language: l,
                                    theme: 'vs-dark',
                                    automaticLayout: true
                                  });
                                });
                              }
                              function changelanguageMonaco(qc, obj){

                                //alert(obj.value);
                                //window.monaco["qc_"+qc]=monaco.editor.setLanguage(obj.value);
                              }
                              function changethemeMonaco(qc, obj){
                                window.monaco["qc_"+qc]=monaco.editor.setTheme(obj.value);
                              }
                              </script>
            <?php //// 모나코 end ?>


              <div>
                          <div>
                              <div class="p-1" style="background:black;text-align:left;">

                                <select name=is_compiler id="is_compiler_0" onchange="changelanguageMonaco('0',this)">
                                  <option value="">::프로그래밍 언어선택::</option>
                                  <option value="c" <?=(strtolower($is_compiler)=="c")?"selected":""; ?>>C</option>
                                  <option value="cpp" <?=(strtolower($is_compiler)=="cpp")?"selected":""; ?>>CPP</option>
                                  <option value="java" <?=(strtolower($is_compiler)=="java")?"selected":""; ?>>JAVA</option>
                                  <option value="python" <?=(strtolower($is_compiler)=="python")?"selected":""; ?>>PYTHON</option>
                                </select><select name=is_compilertheme onchange="changethemeMonaco('0',this)">
                                  <option value="">::테마::</option>
                                  <option value="vs-dark" <?=(($is_compilertheme)=="vs-dark")?"selected":""; ?>>DarkGray</option>
                                  <option value="vscode" <?=(($is_compilertheme)=="vscode")?"selected":""; ?>>White</option>
                                  <option value="hc-black" <?=(($is_compilertheme)=="hc-black")?"selected":""; ?>>Black</option>
                                </select>
                              </div>

                                <div id="code_container_0" class="code_container"></div>
                                <script>
                                  createMonaco("0",`<?=$qcompilecode?>`,"<?=strtolower($is_compiler)?>");
                                </script>
                                <!--
                                  <div class="text-center p-1">
                                    <input type=button value="  결과 값 제출  " class="btn btn-sm btn-light shadow-sm" qc="" list=""
                                     onclick="saveDoodle()">

                                    <input type=button value="  결과 값 제출  " class="btn btn-sm btn-light shadow-sm" qc="" list=""
                                    onclick="saveCodex('','','')">
                                  </div>

                                  <div class="p-1">
                                    <span class="text-secondary">컴파일 결과값 : </span>
                                    <span id="code_container_result"></span>
                                  </div>
                                -->
                            </div>
              </div>



              <textarea name="qcompilecode" id="qcompilecode" rows=3 class="d-none form-control form-control-sm" autocomplete="off"
              onkeyup="adjustHeight(this);" onkeydown="if(event.keyCode===9){var v=this.value,s=this.selectionStart,e=this.selectionEnd;this.value=v.substring(0, s)+'\t'+v.substring(e);this.selectionStart=this.selectionEnd=s+1;return false;}"
              ><?=$qcompilecode?></textarea>

          </td>
          </tr>
          </table>
<?php ///////////////////////////// qdetail ?>







      <table class="table table-sm qtype_dest" id="qtype1" <?=($qtype=="객관식")?"style='display:'":"style='display:none;'"?>>
      <?for($q=1;$q<=5;$q++){?>
      <tr class="qmtr<?=$q?>" <?php if(($q==5)&&(${"qm".$q."text"}=="")){echo("style='display:none'");} ?>>
      <td style="width:7%" nowrap>
        보기<?=$q?>

        <?php if($q==4){?>
          <br><input type=button value='▽' class='btn btn-sm p-1' onclick="$('.qmtr5').toggle()">
          <?}?>
      </td>
      <td style="width:7%" nowrap>정답<input type="checkbox" name="qm<?=$q?>correct" value="1" <?=(${"qm".$q."correct"}=="1")?"checked":""?>></td>
      <td style="width:70%">
        <textarea name="qm<?=$q?>text" class="form-control form-control-sm"  autocomplete="off"><?=${"qm".$q."text"}?></textarea>
      </td>
      <td style="width:16%" nowrap><input type="file" name="qm<?=$q?>imgup" class="form-control form-control-sm">
        <?php if(${"qm".$q."img"}!=""){?>
          <a href="<?=G5_DATA_URL?><?=$imgpath?><?=${"qm".$q."img"}?>" target="_blank"><?=${"qm".$q."img"}?></a>
          <input type=checkbox name="qm<?=$q?>imgdel" value="<?=$imgpath?><?=${"qm".$q."img"}?>">파일삭제
          <input type="text" name="qm<?=$q?>img" value="<?=${"qm".$q."img"}?>">
        <?php } ?>
      </td>
      </tr>
      <?}?>
      </table>

      <table class="table table-sm qtype_dest" id="qtype2" <?=($qtype=="주관식")?"style='display:;'":"style='display:none;'"?>>
      <tr>
      <td style="width:7%" nowrap>정답</td><td colspan=3><textarea name="qanswer" rows=3 class="form-control form-control-sm" autocomplete="off"><?=$qanswer?></textarea></td>
      </tr>
      </table>

      <table class="table table-sm qtype_dest" id="qtype3" <?=($qtype=="서술식")?"style='display:;'":"style='display:none;'"?>>
      <tr>
      <td style="width:7%" nowrap>모범답</td>
      <td colspan=3><textarea name="qessay" rows=6 class="form-control form-control-sm" autocomplete="off"><?=$qessay?></textarea></td>
      </tr>
      </table>

      <table class="table table-sm">
      <tr>
      <td style="width:7%" nowrap>기본해설</td><td colspan=3><textarea name="qexplain" rows=3 class="form-control form-control-sm" autocomplete="off"><?=$qexplain?></textarea></td>
      </tr>
      <tr>
      <td style="width:7%" nowrap>YOUTUBE</td><td colspan=3><input type=text name="qyoutube" rows=3 class="form-control form-control-sm" autocomplete="off" value="<?=$qyoutube?>"></td>
      </tr>
      </table>

      <table class="table table-sm">
      <tr>
      <td valign=top width=7% nowrap>
        내용요소
        <br>
        <input type=button value="Check" class="btn btn-sm w-auto p-2" onclick="chkMerrill()">
        <br>
        <input type=button value="초기화" class="btn btn-sm p-2" onclick="$('.cmerrill').prop('checked',false);$('.merrilljson').val('');">
        <!--
        <input type=button value="ETRI" class="btn btn-sm w-auto" onclick="chkETRI()">
      -->

      </td>
      <td width=32%>

          <table style="width:100%">
          <tr><td style="width:17%" nowrap></td><td>사실</td><td>개념</td><td>절차</td><td>원리</td></tr>
          <tr><td>기억</td>
            <td><div class="form-check"><input type="radio" class="form-check-input cmerrill" name="merrill" id="mr_x1_y1" value="사실X기억" <?if ($merrill=="사실X기억"){echo(" checked");}?>></div></td>
            <td><div class="form-check"><input type="radio" class="form-check-input cmerrill" name="merrill" id="mr_x2_y1" value="개념X기억" <?if ($merrill=="개념X기억"){echo(" checked");}?>></div></td>
            <td><div class="form-check"><input type="radio" class="form-check-input cmerrill" name="merrill" id="mr_x3_y1" value="절차X기억" <?if ($merrill=="절차X기억"){echo(" checked");}?>></div></td>
            <td><div class="form-check"><input type="radio" class="form-check-input cmerrill" name="merrill" id="mr_x4_y1" value="원리X기억" <?if ($merrill=="원리X기억"){echo(" checked");}?>></div></td>
          </tr>
          <tr><td>활용</td>
            <td><div class="form-check"><input type="radio" class="form-check-input cmerrill" name="merrill" id="mr_x1_y2" value="사실X활용" <?if ($merrill=="사실X활용"){echo(" checked");}?>></div></td>
            <td><div class="form-check"><input type="radio" class="form-check-input cmerrill" name="merrill" id="mr_x2_y2" value="개념X활용" <?if ($merrill=="개념X활용"){echo(" checked");}?>></div></td>
            <td><div class="form-check"><input type="radio" class="form-check-input cmerrill" name="merrill" id="mr_x3_y2" value="절차X활용" <?if ($merrill=="절차X활용"){echo(" checked");}?>></div></td>
            <td><div class="form-check"><input type="radio" class="form-check-input cmerrill" name="merrill" id="mr_x4_y2" value="원리X활용" <?if ($merrill=="원리X활용"){echo(" checked");}?>></div></td>
          </tr>
          <tr><td>발견</td>
            <td><div class="form-check"><input type="radio" class="form-check-input cmerrill" name="merrill" id="mr_x1_y3" value="사실X발견" <?if ($merrill=="사실X발견"){echo(" checked");}?>></div></td>
            <td><div class="form-check"><input type="radio" class="form-check-input cmerrill" name="merrill" id="mr_x2_y3" value="개념X발견" <?if ($merrill=="개념X발견"){echo(" checked");}?>></div></td>
            <td><div class="form-check"><input type="radio" class="form-check-input cmerrill" name="merrill" id="mr_x3_y3" value="절차X발견" <?if ($merrill=="절차X발견"){echo(" checked");}?>></div></td>
            <td><div class="form-check"><input type="radio" class="form-check-input cmerrill" name="merrill" id="mr_x4_y3" value="원리X발견" <?if ($merrill=="원리X발견"){echo(" checked");}?>></div></td>
          </tr>
          <tr><td>창조</td>
            <td><div class="form-check"><input type="radio" class="form-check-input cmerrill" name="merrill" id="mr_x1_y4" value="개념X창조" <?if ($merrill=="개념X창조"){echo(" checked");}?>></div></td>
            <td><div class="form-check"><input type="radio" class="form-check-input cmerrill" name="merrill" id="mr_x2_y4" value="사실X창조" <?if ($merrill=="사실X창조"){echo(" checked");}?>></div></td>
            <td><div class="form-check"><input type="radio" class="form-check-input cmerrill" name="merrill" id="mr_x3_y4" value="절차X창조" <?if ($merrill=="절차X창조"){echo(" checked");}?>></div></td>
            <td><div class="form-check"><input type="radio" class="form-check-input cmerrill" name="merrill" id="mr_x4_y4" value="원리X창조" <?if ($merrill=="원리X창조"){echo(" checked");}?>></div></td>
          </tr>
          </table>

          <textarea name="merrilljson" class="merrilljson"><?=$merrilljson?></textarea>

      </td>
      <td width=60%>
          <div class="row">
                <label for="">난이도</label>
                <div class="col-sm-10">
                  <table><tr><td>
                    <span class="form-check"><input type="radio" class="form-check-input" name="qlevel" value="하" <?if($qlevel=="하"){echo(" checked ");}?>>하 &nbsp;</span>
                  </td>
                  <td>
                    <span class="form-check"><input type="radio" class="form-check-input" name="qlevel" value="중" <?if($qlevel=="중"){echo(" checked ");}?>>중 &nbsp;</span>
                  </td>
                  <td>
                    <span class="form-check"><input type="radio" class="form-check-input" name="qlevel" value="상" <?if($qlevel=="상"){echo(" checked ");}?>>상 &nbsp;</span>
                  </td></tr></table>
                </div>
            </div>
            <br>
            <div class="row">
                <label for="">중요도</label>
                <div class="col-sm-10">
                  <table><tr><td>
                    <span class="form-check"><input type="radio" class="form-check-input" name="qimportance" value="기초" <?if($qimportance=="기초"){echo(" checked ");}?>>기초 &nbsp;</span>
                  </td>
                  <td>
                    <span class="form-check"><input type="radio" class="form-check-input" name="qimportance" value="핵심" <?if($qimportance=="핵심"){echo(" checked ");}?>>핵심 &nbsp;</span>
                  </td>
                  <td>
                    <span class="form-check"><input type="radio" class="form-check-input" name="qimportance" value="심화" <?if($qimportance=="심화"){echo(" checked ");}?>>심화</span>
                  </td></tr></table>
                </div>
            </div>
            <!--
            <div class="row">
                      <label>정답률</label>
                      <div class="col-sm-4">
                        <input type=text name="qrightratio" class="form-control" value="<?=$qrightratio?>">
                      </div>
            </div>-->
      </td>
      </tr>
      </table>

      <!-- Scrollable modal -->


<?if($is_admin){?>
      <div class="text-center mt-4 mb-4">

        <input type="button" onclick="fchk()" value="  저장  " class="btn btn-sm bg-gradient-primary shadow-sm">

        <input type="button" onclick="showModal()" id="qpreview" class="btn btn-sm btn-light shadow-sm" value="결과창">

        <a href="page?<?=$list?>" class="btn btn-sm btn-light shadow-sm">돌아가기</a>

        <a href="?list=<?=$list?>" class="btn btn-sm btn-light shadow-sm ">새문제</a>

        <?php if($qcode!=""){?>
          <a href="qedit?list=<?=$list?>&copyq=<?=$qcode?>" class="btn btn-sm btn-light shadow-sm ">복사</a>
        <?php } ?>

        <?php if(($qcode!="")&&($copyq=="")){?>
          <input type="button" value="삭제" class="btn btn-sm btn-secondary shadow-sm" onclick="if(confirm('문제를 정말 삭제할까요?')){document.f.mode.value='d';document.f.submit();}">
        <?}?>
      </div>
<?}?>

      </form>


      <div id="qviewModal" class="modal fade" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title">결과창</h6>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <iframe style="width:100%;height:400px;" name="iframeQresultview" id="iframeQresultview" src="qviewone.php?list=<?=$list?>&qcode=<?=$qcode?>"></iframe>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm shadow-sm" data-bs-dismiss="modal">창 닫기</button>
              <!--button type="button" class="btn btn-primary">Save changes</button-->
            </div>
          </div>
        </div>
      </div>



      <script>
      function chkMerrill(){

        var qtext=$("#qtext").val();
        var qtextsub=$("#qtextsub").val();

        $.ajax({
            type : "POST",
            async: false,
            url:'qedit.chkmerrill.php',
            data : {"sentence": qtext},
            success:function(data){

              if(data.indexOf("merrill")==-1){
                alert("Merrill 분류 서버 오류입니다.");
                return;
              }
              var jdata=JSON.parse(data);
              var m=jdata["merrill"];
              if(m=="none"){
                var mx="none";
                var my="none";
                alert("계산값없음\n"+qtext);
              }else{
                var a=m.split("X");
                var mx=a[0];
                var my=a[1];
                //alert(mx + "X"+my);
              }
              $(".cmerrill[value='"+mx+"X"+my+"']").prop("checked",true);
              $(".merrilljson").val(data);
            }
        })
      }

      function chkETRI(){
        $.ajax({
            url:'qedit.chkETRI.php',
            data : {"str": "str"},
            success:function(data){
              data=(data.replace(/\"/gi ,""));
              //alert(data);
              //$("#mr_"+data).attr("checked", "checked");
              //$('#time').append(data);
            }
        })
      }
      </script>




      <script>
      function fchk(){

        if(document.f.qtext.value==""){
          alert("문제를 입력하세요.");return;
        }
          var val = window.monaco["qc_0"].getValue();
          $("#qcompilecode").val(val);

          document.f.submit();
      }
      function showModal(){

        <?php if($qcode==""){ ?>
          document.f.mode.value="resultviewfirst";
          document.f.submit();
        <?}else{?>
          document.f.target="iframeQresultview";
          document.f.mode.value="resultview";
          document.f.submit();

          var myModal = new bootstrap.Modal(document.getElementById("qviewModal"), {});
          myModal.show();
        <? } ?>
      }

          <?php if($mode=="resultviewfirst"){ ?>
            var myModal = new bootstrap.Modal(document.getElementById("qviewModal"), {});
            myModal.show();
          <?php } ?>

            var myModalEl = document.getElementById('qviewModal')
            myModalEl.addEventListener('hidden.bs.modal', function (event) {
              $("#qpreview").focus();
            })

      </script>



</div>
<?php include_once("page.wrapbottom.php");?>

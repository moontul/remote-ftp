<?php
function ppdate($g){

  $now_year=date("Y");
  $now_month=date("m");
  $now_day=date("d");
  $now_Ymd=date("Ymd");

  //////echo "현재 일시 : ". date("Y-m-d H:i:s")."<br/>";
  $get_Ymd=date("Ymd", strtotime($g));

  $get_year=date("Y", strtotime($g));
  $get_month=date("m", strtotime($g));
  $get_day=date("d", strtotime($g));

  if($now_Ymd==$get_Ymd){ ///오늘이면 시간:분
    return date('H:i',strtotime($g));
  }else{
    if($now_Y==$get_Y){ //올해면 월/일
      return date('m.d',strtotime($g));
    }else{ // 그전이면 년/월
      return date('Y.m',strtotime($g));
    }
  }
}
?>
                        <?php //// 모나코 start ?>
                                        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.20.0/min/vs/editor/editor.main.min.css">
                                        <style>
                                              .code_container {
                                                width: 100%;
                                                height: 350px;
                                                border: 1px solid black;
                                              }
                                        </style>
                                        <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.26.1/min/vs/loader.min.js"></script>
                                        <script>
                                        function createMonaco(qc, v, l){
                                          require.config({
                                            paths: {'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.26.1/min/vs'}
                                          });
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

                      <?php //// 모나코 end ?>
                                        function saveDoodle(qc) {
                                         // get the value of the data
                                         var val = window.monaco["qc_"+qc].getValue();
                                               $.ajax({
                                                      type : "POST",
                                                      url : "/qchk.ajax.doodle.php",
                                                      data : {"usercode":val, "userl":"<?=strtolower($rs['is_compiler'])=='python'?'python3':strtolower($rs['is_compiler'])?>"},
                                                      error : function(){
                                                          alert('error');
                                                      },
                                                      success : function(data){
                                                        $("#code_container_result_"+qc).html(data);
                                                        ajaxsave("<?=$rs["qcode"]?>", "<?=$code?>", "<?=$rs["list"]?>", "", "", val, "0", data);
                                                      }
                                                });
                                        }
                                        function saveCodex(qc, code, list) {
                                        // get the value of the data
                                        var val = window.monaco["qc_"+qc].getValue();
                                        var l = $("#is_compiler_"+qc).val();
                                        if(l=="python"){l="py";}

                                             $.ajax({
                                                    type : "POST",
                                                    url : "/qchk.ajax.codex.php",
                                                    data : {"usercode":val, "userl":l},
                                                    error : function(){
                                                        alert('error');
                                                    },
                                                    success : function(data){
                                                      $("#code_container_result_"+qc).html(data);
                                                      ajaxsave(qc, code, list, "", "", val, "0", data);
                                                    }
                                              });
                                        }
                                        </script>

                                      <?php
                                      //문제번호를 원문자로 변경
                                      function qnumReplace($g){
                                        $g1="";
                                        if($g==1){$g1="①";}
                                        elseif($g==2){$g1="②";}
                                        elseif($g==3){$g1="③";}
                                        elseif($g==4){$g1="④";}
                                        elseif($g==5){$g1="⑤";}
                                        else{$g1=$g;}
                                        return $g1;
                                      }

//문제를 추출하는 메인쿼리, cbt에서도 사용
include_once("page.qview.detail.query.php");

//이미 쿼리가 있으면 이미 있는 쿼리 실행
if(isset($sqlq_prepare)){
  $sqlq=$sqlq_prepare;
}
$resultq=sql_query($sqlq);

//echo($sqlq);

//문제루프시작
$qcodestr=""; //전체 문제코드 (아래쪽에서 해설쿼리위함)
for($i=0;$rs=sql_fetch_array($resultq);$i++){
  if($qcodestr!=""){$qcodestr.=",";}
  $qcodestr.="'".$rs["qcode"]."'";

  $qtextsubcoding=$rs["qtextsubcoding"];

  //문제번호 : 랜덤일 경우와 아닐 경우
  if($is_random==1){
    $this_qnum=$i+1;
  }else{
    $this_qnum=$rs["qnum"];
  }
?>

<a name="<?=$rs["qcode"]?>" qnum="<?=$this_qnum?>" class="questioncode"></a>
<div <?php if(isset($is_myq)){ ?> class="qcodecard"
<?php }else{ ?> class="qcodecard card mt-3 mb-3 shadow-sm <?php if((int)$qtextsubcoding==1){echo('bg-dark');}?>"
     <?php }?>
  id="<?=$rs["qcode"]?>">

              <?php if(isset($is_myq)){ ////////////////////////////////////////////////////////////  오답노트?>
              <div  class="text-primary">

                <?=date("Y-m-d",strtotime($rs["my_in_date"]))?>
                <span title="오답노트에서 제거" class="text-primary start-100 cursor-pointer"
                  onclick="$('#<?=$rs["qcode"]?>').remove();mychkRemove('<?=$rs["qcode"]?>','<?=$rs["list"]?>');">
                  <i class="fas fa-times-circle"></i>
                </span>

                  <?php if($rs["countfalse"]==0){?>
                      <!--<span style="color:skyblue"><i class="fas fa-bullseye"></i></span>-->
                  <?php }else{?>
                      <span><i class="fas fa-tired"></i><sup><?=$rs["countfalse"]?></sup></span>
                  <?php } ?>

                  <span title="중요표시" class="cursor-pointer mychkStar starNo text-secondary" starval=1 style="display:<?=($rs['star']==0)?'':'none' ?>"
                    qcode="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>" isstar="star"><i class="fas fa-exclamation-circle"></i></span>
                  <span  title="중요제거" class="cursor-pointer mychkStar starYes" starval=0  style="display:<?=($rs['star']==0)?'none':''?>"
                    qcode="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>" isstar="star"><i class="fas fa-exclamation-circle"></i></span>



                  <?php if($is_admin){?>
                    <a href="qrecommend?qcode=<?=$rs["qcode"]?>" class="btn btn-sm w-auto pt-2 pb-0 ps-2 pe-2" target="_blank">추천문제</a>
                  <?}?>
              </div>
              <?php } ////////////////////////////////////////////////////////////  오답노트  ?>

<?php if((int)$qtextsubcoding==1&&$qtextsubcoding_col==""){$qtextsubcoding_col="true"; ?>
<script>
$(".pp-sidebar").removeClass("col-lg-3 col-md-3");
$(".pp-mainpage").removeClass("col-lg-9 col-md-9");
$(".pp-sidebar").addClass("col-lg-1 col-md-1");
$(".pp-mainpage").addClass("col-lg-11 col-md-11");

</script>
<?php } ?>

  <div class="card-body " style="padding-top:1px;">

    <div class="cardheader py-1 mt-3 w-100">
                                            <div>
                                              <b><?=$this_qnum?></b>.

                                              <b><?=$rs["qtext"]?></b>
                                            </div>

                                            <?php if(($code=="")&&($list=="")){?>
                                              <div style="font-size:12px; margin-top: -5px;text-align:right;">
                                                <?=$rs["fullidx"]?>
                                               </div>
                                            <?php }?>
    </div>

    <div class="cardflex <?=((int)$qtextsubcoding==1)?'d-flex':''?>">
      <div class="cardleft <?=((int)$qtextsubcoding==1)?'w-40':'w-100'?>"
        <?if((int)$qtextsubcoding==1){?>
          style="border:1px solid #666;padding:20px;"
        <?}?>
      >

                  <?php if(!empty($rs["qtextsub"])){?>
                  <div
                    <?if((int)$qtextsubcoding!=1){?>
                      style="border:1px solid #c0c0c0;padding:15px;text-align:justify;"
                      <?}?>
                    >
                    <span>
                      <b><?=nl2br($rs["qtextsub"])?></b>
                    </span>
                  </div>
                  <?php } ?>

      <?php if($rs["is_compilerfirst"]=="1"){

      }else{?>
                    <?php if($rs["qimg"]!=""){?>
                    <div style="border:0;padding:5px;text-align:justify;">
                      <div>
                        <img src="<?=G5_DATA_URL?><?=$rs["imgpath"]?><?=$rs["qimg"]?>" class="col-md-7 col-sm-12 col-12">
                      </div>
                    </div>
                    <?php } ?>
        <?php } ?>

                    <?php $src_code=""; ?>
                      <?php if($rs["is_compiler"]!=""){ //////////랭귀지
                        $src_code=trim($rs['qcompilecode']);
                        if($src_code!=""){
                        ?>
                        <div style="background:ivory;">
                          <pre <?php if(!empty($rs["qimg"])){?> style="overflow:auto;"<?}?>><code
                            class="<?=strtolower($rs["is_compiler"])?>"><?=str_replace("<", "&lt;", $src_code)?></code></pre>
                        <!--
                          <div class="text-end" style="margin-top:-10px;">
                          <input type=button value="/*온라인 컴파일러 연습*/"  class="shadow-sm btn btn-sm btn_is_comiler btn-pp-sx" l="<?=$rs["is_compiler"]?>" qcode="<?=$rs['qcode']?>">
                          <textarea id="coding_<?=$rs['qcode']?>" style="display:none;"><?=$src_code?></textarea>
                          </div>
                        -->
                        </div>
                        <?php } ?>

                      <?php } ?>


      </div>
      <div class="cardright <?=((int)$qtextsubcoding==1)?'w-60':'w-100'?>">


        <?php if($rs["is_compiler"]!=""){?>
          <div>
                      <div>
                          <div class="p-1" style="background:black;text-align:right;">
                            <select id="is_compiler_<?=$rs["qcode"]?>" onchange="changelanguageMonaco('<?=$rs["qcode"]?>',this)">
                              <option value="">::Language::</option>
                              <option value="c" <?=(strtolower($rs["is_compiler"])=="c")?"selected":""; ?>>c</option>
                              <option value="cpp" <?=(strtolower($rs["is_compiler"])=="cpp")?"selected":""; ?>>cpp</option>
                              <option value="java" <?=(strtolower($rs["is_compiler"])=="java")?"selected":""; ?>>java</option>
                              <option value="python" <?=(strtolower($rs["is_compiler"])=="python")?"selected":""; ?>>python</option>
                            </select><select onchange="changethemeMonaco('<?=$rs["qcode"]?>',this)">
                              <option value="">::Theme::</option>
                              <option value="vs-dark" selected>DarkGray</option>
                              <option value="vscode">White</option>
                              <option value="hc-black">Black</option>
                            </select>
                          </div>

                            <div id="code_container_<?=$rs['qcode']?>" class="code_container"></div>
                            <script>
                              createMonaco("<?=$rs['qcode']?>",`<?=$src_code?><?=$rs['u_essay']?>`,"<?=strtolower($rs["is_compiler"])?>");
                            </script>

                              <div class="text-center p-1">
                                <!--<input type=button value="  결과 값 제출  " class="btn btn-sm btn-light shadow-sm" qc="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>" onclick="saveDoodle()">
                                -->
                                <input type=button value="컴파일 결과 값 제출" class="btn btn-sm btn-light shadow-sm" qc="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>"
                                onclick="saveCodex('<?=$rs["qcode"]?>','<?=$rs["code"]?>','<?=$rs["list"]?>')">
                              </div>
                              <div class="p-1">
                                <span class="text-secondary">컴파일 결과값 : </span>
                                <span id="code_container_result_<?=$rs["qcode"]?>"><?=$rs["u_opt1"]?></span>
                              </div>
                        </div>
          </div>
        <?php } ?>


    <?php if($rs["qtype"]=="코딩"){?>


                  <div style="display:none;color:#ff00ff;" class="qmcorrect_<?=$rs["qcode"]?>">
                    <b>[모범답 : <?=$rs["qessay"]?>]</b>

                    <div><?=nl2br($rs["qexplain"])?></div>

                  </div>


  <?php }else if($rs["qtype"]=="서술식"){?>

                  <div>
                    <div class="input-group mb-3">
                      <textarea id="essay_<?=$rs["qcode"]?>" class="form-control" placeholder="답을 입력하세요"
                        aria-label="답을 입력하세요" aria-describedby="button-addon2"><?=$rs["u_essay"]?></textarea>
                        <button class="btn btn-outline-secondary qchk_essay" type="button" id="button-addon2" qcode="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>">
                        정답확인
                      </button>
                    </div>
                  </div>

                  <div style="display:none;color:#ff00ff;" class="qmcorrect_<?=$rs["qcode"]?>">
                    <b>[모범답 : <?=$rs["qessay"]?>]</b>

                    <div><?=nl2br($rs["qexplain"])?></div>

                  </div>

  <?php }else if($rs["qtype"]=="주관식"){?>

                    <div>
                      <div class="input-group mb-3">
                        <input type="text" qanswer="<?=$rs["qanswer"]?>" id="answer_<?=$rs["qcode"]?>" class="form-control" placeholder="답을 입력하세요"
                          aria-label="답을 입력하세요" aria-describedby="button-addon2" value="<?=$rs["u_answer"]?>">
                        <button class="btn btn-outline-secondary qchk_answer" type="button" id="button-addon2" qcode="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>">정답확인</button>
                      </div>
                    </div>

                    <div style="display:none;color:#ff00ff;" class="qmcorrect_<?=$rs["qcode"]?>">
                      <b>[정답 : <?=$rs["qanswer"]?>]</b>
                      <div><?=nl2br($rs["qexplain"])?></div>
                    </div>

<?php }else{ //객관식 *********************************************************** ?>
                      <div class="p-1">
                      <?for($j=1;$j<=5;$j++){?>
                        <?php if(    (($rs["qm".$j."text"])!="")  ||  (!empty($rs["qm".$j."img"]))    ){?>
                          <ul class="list-inline">
                              <list class="list-inline-item align-top">

                                <?php if($rs["qm".$j."correct"]==1){?>
                                  <span class="position-absolute rounded-pill p-1 qmbadge_<?=$rs["qcode"]?>" style="display:none;font-size:10px;color:#fff;background:#ff00ff;margin-left:-28px;margin-top:-1px;">정답</span>
                                <?}?>
                                <div style="position:inline-block;cursor:pointer"
                                     class="qchk_num" qcode="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>" anum="<?=$j?>" correct="<?=$rs["qm".$j."correct"]?>">
                                  <?=qnumReplace($j)?>

                                </div>
                              </list>
                              <list class="list-inline-item">
                                <div class="qchk_num_toggle"  qcode="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>" anum="<?=$j?>" correct="<?=$rs["qm".$j."correct"]?>">
                                      <?php if(!empty($rs["qm".$j."img"])){?>
                                      <div style="border:0;padding:5px;text-align:justify;">
                                      <span>
                                        <img src="<?=G5_DATA_URL?><?=$rs["imgpath"]?><?=$rs["qm".$j."img"]?>" width=50%>
                                      </span>
                                      </div>
                                      <?php } ?>

                                      <?=nl2br($rs["qm".$j."text"])?>
                                </div>
                              </list>
                            </ul>
                          <?}?>
                      <?}?>
                    </div>
                      <?for($j=1;$j<=5;$j++){////////정답 보여줌, n개 정답 있을 수 있음?>
                          <?if($rs["qm".$j."correct"]==1){?>
                            <div style="display:none;color:#ff00ff;" class="qmcorrect_<?=$rs["qcode"]?>">
                              <b>[정답 : <?=$j?>]</b>

                                              <?php if(!isset($is_myq)){ ////////// 내문제가 아닐때 중요표시 ----- 이미 중요표시한 것은 어케??>

                                                <span><!--중요 표시-->
                                                  <span title="중요표시" class="mychkStar starNo text-secondary cursor-pointer" starval=1 style="display:"
                                                    qcode="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>" isstar="star"><i class="fas fa-exclamation-circle"></i></span>
                                                  <span  title="중요제거" class="mychkStar starYes text-primary cursor-pointer" starval=0  style="display:none"
                                                    qcode="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>" isstar="star"><i class="fas fa-exclamation-circle"></i></span>
                                                </span>
                                              <?php } ?>


                                              <div><?=nl2br($rs["qexplain"])?></div>

                            </div>
                          <?}?>
                      <?} ///정답보여줌?>

  <?php } //문제유형 조건 종료?>



    </div><!--cardright-->
  </div><!--cardflex-->




  <?php //해설, 관리자?>
  <div class="cardfooter mt-1">
        <?php if($is_admin){?>
        <div class="mt-2">
          <a href="./page_qedit?list=<?=$rs["list"]?>&qcode=<?=$rs["qcode"]?>"
            class="badge btn btn-outline-primary shadow-sm bg-light text-dark">문제수정</a>

          <a href="./page_qedit?list=<?=$rs["list"]?>&copyq=<?=$rs["qcode"]?>"
            class="badge btn btn-outline-light shadow-sm bg-light text-dark">문제복사</a>
          <span class="text-sm text-secondary"><?=$rs["merrillx"]?><?=$rs["merrilly"]?></span>
        </div>
        <?php } ?>

        <div>
                  <?php //해설영역 : 문제가 모두 보여진 후 맨 아래에서 불러와서 각 문제별로 뿌려줌 ?>
                  <div class="qexp-area-<?=$rs["qcode"]?>"></div>

                  <div>
                      <div style="width:95%;padding-left:8%;margin-top:6px;">
                        <textarea class="form-control txtqexp-<?=$rs["qcode"]?>" placeholder="해설을 달아주세요"></textarea>
                      </div>
                      <div style="width:95%;background:;">
                          <div class="qexp-in-<?=$rs["qcode"]?> text-end">
                              <span style="font-size:13px;"><?=$member["mb_id"]?></span> &nbsp;
                              <button type="button" class="btn btn-sm badge w-auto bg-light text-dark  btn-qexplain" qcode="<?=$rs["qcode"]?>">해설저장</button>
                          </div>
                      </div>


                    <div class="qexp-up-<?=$rs["qcode"]?> text-end" style="width:95%;display:none">
                      <a type="button" class="badge btn btn-sm bg-primary text-light text-bold btn-qexplainup" qcode="<?=$rs["qcode"]?>">수정완료</a>
                      <button type="button" class="badge btn btn-sm bg-secondary text-white btn-qexplaincancel" qcode="<?=$rs["qcode"]?>">수정취소</button>
                    </div>
                    <input type=hidden size=1 name="mode" class="modeqexp-<?=$rs["qcode"]?>">
                    <input type=hidden size=1 name="idx" class="idxqexp-<?=$rs["qcode"]?>">
                  </div>
        </div>


    </div>
    <?php //해설, 관리자 종료?>




</div><!--cardbody-->
</div><!--card-->
<?} //문제 루프 종료?>


    <?php ////////////////////////////////////////////////////////// 각 문제에 대한 해설 쿼리는 모든 문제 보여주고 시작함  ?>
    <?php if($qcodestr!=""){ //문제코드 있을 경우?>
          <div class="qexp-sandbox d-none">
          <?php
            $sqltmp="select * from tb_qexplain where qcode in ($qcodestr) order by qcode, point desc, idx";
            $rstmp=sql_query($sqltmp);
            $old_qcode="";
            $qcode_star_index=0;
            for($i=0;$rs=sql_fetch_array($rstmp);$i++){
              if($old_qcode!=$rs["qcode"]){
                $qcode_star_index=1;
                $old_qcode=$rs["qcode"];
              }else{
                $qcode_star_index+=1;
              }
          ?>
            <div class="qexpbox" qcode="<?=$rs['qcode']?>">
                                <?php
                                  $point=$rs["point"];
                                  $pointalpha=$rs["point"];
                                  if($pointalpha>5){$pointalpha=5;}
                                ?>
                              <div>
                                <table style="width:95%;border-bottom:1px solid #ddd" cellpadding=0 cellspacing=0>
                                <tr>
                                <td width=10% rowspan=2 valign=top align=center style="padding-top:5px;">
                                      <span class="pointExp camellia<?=$pointalpha?> cursor-pointer" idx="<?=$rs['idx']?>"
                                      title="별을 달아주세요" data-bs-toggle="tooltip" data-bs-html="true"
                                      data-bs-placement="top">
                                            <?php if($qcode_star_index==1&&$point>0){ ?>
                                              <span style="color:gold"><i class="far fa-star fa-2x"></i></span>
                                            <?php }elseif($qcode_star_index==2&&$point>0){ ?>
                                              <span style="color:silver"><i class="far fa-star fa-2x"></i></span>
                                            <?php }else{?>
                                              <span style="color:#ddd;"><i class="fas fa-magic fa-2x"></i></span>
                                            <?php }?>
                                        </span>
                                        <div class="text-center" style="color:#aaa;font-size:20px;font-weight:bold;">
                                            <?php if($point>0){?><?=$point?><?php } ?>
                                        </div>
                                  </td>
                                  <td style="padding-left:5px">
                                    <div class="qexpcon-<?=$rs["idx"]?>"><?=$rs["qexplain"]?></div>
                                  </td>
                                </tr>
                                <tr>
                                <td align=right>
                                        <span class="fs-7 fw-lighter" style="font-size:13px;"><?=ppdate($rs['in_date'])?> <?=$rs['mb_id']?></span>
                                        <?php if($rs["mb_id"]==$member["mb_id"]){ ?>
                                          <span class="badge s-100">
                                              <a type="button" class="edtExp btn badge w-auto btn-sm btn-light"
                                                qcode="<?=$rs['qcode']?>" idx="<?=$rs['idx']?>">
                                                <i class="fas fa-pen"></i>
                                              </a>
                                              <a type="button" class="delExp btn badge w-auto btn-sm btn-light" idx="<?=$rs['idx']?>">
                                                <i class="fas fa-times"></i>
                                              </a>
                                          </span>
                                        <?php } ?>
                                  </td>
                                  </tr>
                                  </table>
                                </div>
            </div>
          <?php  } //해설이 있는 루프 종료?>
        </div> <!--sandbox -->
      <?php } /// 문제 보여주고 해설쿼리 료?>




<?php if($qcodestr!=""){ /////////////////// 문제코드가 하나라도 있어야 실행 ?>
<script>
for(var i=0;i<$(".qexpbox").length;i++){
  var qc=$(".qexpbox").eq(i).attr("qcode");
  var str=$(".qexpbox").eq(i).html();
  if((str!="")&&($(".qexp-area-"+qc).text()=="")){
    $(".qexp-area-"+qc).append("<div class='border-bottom mb-2 fw-bold'>해설</div>");
  }
  $(".qexp-area-"+qc).append(str);
}
$(".qexp-sandbox").remove();

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>




<div style="display:none">
<!--Jdoodle 코드 전송을 위한 폼-->
<form name="f_to_jdoodle" action="https://www.jdoodle.com/api/redirect-to-post/java-online-compiler" method="post" target="_blank">
<textarea name="initScript" id="initScript"></textarea>
</form>
</div>

<div id=sandbox></div>
<script>
$(".btn_is_comiler").click(function(){

  var l=$(this).attr("l");
  var src=$("#coding_"+$(this).attr("qcode")).val();
  var t="";
  if(l=="JAVA"){t="https://www.jdoodle.com/api/redirect-to-post/online-java-compiler";}
  else if(l=="PYTHON"){t="https://www.jdoodle.com/api/redirect-to-post/python3-programming-online";}
  else if(l=="CPP"){t="https://www.jdoodle.com/api/redirect-to-post/online-compiler-c++";}
  else if(l=="SQL"){t="https://www.jdoodle.com/api/redirect-to-post/execute-sql-online";}
  else{t="https://www.jdoodle.com/api/redirect-to-post/c-online-compiler";}

  $("#initScript").val(src);
  document.f_to_jdoodle.action=t;
  document.f_to_jdoodle.submit();
});

<?php /////////////////해설저장 ?>
$(".btn-qexplain").click(function(){
<?php if($is_member){?>
    var qc=$(this).attr("qcode");
    var qexp=$(".txtqexp-"+qc).val();
    if(qexp!=""){
      $.ajax({
             type : "POST",
             url : "/qchk.ajax.exp.php",
             data : {"qcode":qc, "mb_id":"<?=$member["mb_id"]?>", "qexp":qexp },
             error : function(){
                 //alert('error');
             },
             success : function(data){
               location.reload();
             }
       });
    }
<?php }else{ ?>
  alert("로그인하세요.")
<?php }?>

})
//해설수정저장
$(".btn-qexplainup").click(function(){
<?php if($is_member){?>
  var qc=$(this).attr("qcode");
  var qexp=$(".txtqexp-"+qc).val();
  var idx=$(".idxqexp-"+qc).val();
  if(qexp!=""){
    $.ajax({
           type : "POST",
           url : "/qchk.ajax.exp.php",
           data : {"mode":"u", "idx":idx, "qcode":qc, "mb_id":"<?=$member["mb_id"]?>", "qexp":qexp },
           error : function(){
               //alert('error');
           },
           success : function(data){
             //alert(data);
             location.reload();
           }
     });
  }
<?php }?>
})
//해설취소
$(".btn-qexplaincancel").click(function(){
<?php if($is_member){?>
  var qc=$(this).attr("qcode");
  var idx=$(this).attr("idx");
  $(".txtqexp-"+qc).val("");
  $(".modeqexp-"+qc).val("");
  $(".idxqexp-"+qc).val("");
  $(".qexp-in-"+qc).show();
  $(".qexp-up-"+qc).hide();
<? }?>
})

//포인트
$(document).on("click",".pointExp", function(e){
<?php if($is_member){?>
  var idx=$(this).attr("idx");
  if(confirm("별 달까요?")){
      $.ajax({
             type : "POST",
             url : "/qchk.ajax.exp.php",
             data : {"mode":"p", "idx": idx, "mb_id":"<?=$member["mb_id"]?>" },
             error : function(){
                 //alert('error');
             },
             success : function(data){
               //alert(data);
               location.reload();
             }
       });
  }
<?php }?>
});

//해설삭제
$(document).on("click",".delExp", function(e){
<?php if($is_member){?>
  var idx=$(this).attr("idx");
  if(confirm("해설을 삭제할까요?")){
      $.ajax({
             type : "POST",
             url : "/qchk.ajax.exp.php",
             data : {"mode":"d", "idx": idx, "mb_id":"<?=$member["mb_id"]?>" },
             error : function(){
                 //alert('error');
             },
             success : function(data){
               //alert(data);
               location.reload();
             }
       });
  }
<?php } ?>
});
//해설수정
$(document).on("click",".edtExp", function(e){
<?php if($is_member){?>
        var idx=$(this).attr("idx");
        var qc=$(this).attr("qcode");
        var str=$(".qexpcon-"+idx).text();
        $(".txtqexp-"+qc).val(str);
        $(".modeqexp-"+qc).val("u");
        $(".idxqexp-"+qc).val(idx);
        $(".qexp-in-"+qc).hide();
        $(".qexp-up-"+qc).show();
        return;
<?php } ?>
});

//중요별
$(".mychkStar").click(function(){
  var qc=$(this).attr("qcode");
  var list=$(this).attr("list");
  var starval=$(this).attr("starval");

  //중요별 토글
  $("span[qcode="+qc+"][list="+list+"][isstar='star']").toggle();

  $.ajax({
         type : "GET",
         url : "/mychk.ajax.action.php",
         data : {"mode":"star", "qcode":qc, "mb_id":"<?=$member["mb_id"]?>", "list":list , "starval":starval },
         error : function(){
             //alert('error');
         },
         success : function(data){
             //alert(data) ;
         }
   });
})

function mychkRemove(qc, list){
  $.ajax({
         type : "GET",
         url : "/mychk.ajax.action.php",
         data : {"mode":"remove", "qcode":qc, "mb_id":"<?=$member["mb_id"]?>", "list":list },
         error : function(){
             //alert('error');
         },
         success : function(data){
             //alert(data);
             if($(".qcodecard").length==0){location.reload();}
         }
   });
}
</script>

<script>
function showToast(tf,qc,mode){

  $("#qani").animate({  left: "1000px", top:"100px"  },1000);

  if(tf=="O"){
    Swal.fire({
    icon: 'success',
    title: '정답입니다!',
    confirmButtonText: '닫기',
    timer: 1000,
    timerProgressBar: true,
    confirmButtonColor: 'pink',
    didClose: (toast) => {
          //  toast.addEventListener('mouseenter', Swal.stopTimer)
          //  toast.addEventListener('mouseleave', Swal.resumeTimer)
          //console.log("정답창 닫힘........")
          if(mode=="showanswer"){
            $(".qmcorrect_"+qc).show()
            $(".qmbadge_"+qc).show()
          }
        }
    })
  }

  if(tf=="X"){
    var textstr="";
    if(mode=="showanswer"){
      textstr='정답을 확인해보세요';
    }else{
      textstr='다시 생각해 보세요';
    }

    Swal.fire({
      icon: 'error',
      title: '오답입니다ㅜㅜ',
      text : textstr,
      confirmButtonText: '닫기',
      timer: 1000,
      timerProgressBar: true,
      didClose: (toast) => {
            //  toast.addEventListener('mouseenter', Swal.stopTimer)
            //  toast.addEventListener('mouseleave', Swal.resumeTimer)
            //console.log("오답 닫힘........")
            if(mode=="showanswer"){
              $(".qmcorrect_"+qc).show()
              $(".qmbadge_"+qc).show()
            }
          }
      //footer: '<a href="">Why do I have this issue?</a>'
    })


  }

//  var toastLive = document.getElementById('Toast'+tf)
//  var toast = new bootstrap.Toast(toastLive)
//  toast.show()
}
//오답2번이면 정답해설 보이고
//그전에 정답이면 정답해설
var qcfalse1="";
var qcfalse2="";

//서술식 정답확인
$(".qchk_essay").click(function(){

	var qc=$(this).attr("qcode");
  var list=$(this).attr("list");
  var a=$("#essay_"+qc).val();

  var correctval="0";
//  if(a==q){
//    $('#btn_tmodal').trigger("click");
//    correctval="1";
//    $(".qmcorrect_"+qc).show();
//  }else{
//    $('#btn_fmodal').trigger("click");
//    if(qcfalse1!=qc){
//      qcfalse1=qc;
//    }else if(qcfalse2!=qc){
      //alert("아이쿠")
//      qcfalse1=qcfalse2="";
      $(".qmcorrect_"+qc).show();
//    }
//    correctval="-1";
//  };
//  setTimeout(close_modal,700);
    ajaxsave(qc, "<?=$code?>", list, "", "", a,  correctval,"");//ajaxsave(qc, list, anum, anser, essay, correctval)

});


$(".qchk_answer").click(function(e){
	var qc=$(this).attr("qcode");
  var list=$(this).attr("list");
  var a=$("#answer_"+qc).val();
  var q=$("#answer_"+qc).attr("qanswer");
  var correctval="0";

  if(a==q){
    //lert("정답입니다!!");
    showToast('O',qc);
    correctval="1";
    $(".qmcorrect_"+qc).show();
    $(".qmbadge_"+qc).show();
  }else{
    //alert("오답입니다ㅠㅠ");
    showToast('X',qc);
    if(qcfalse1!=qc){
      qcfalse1=qc;
    }else if(qcfalse2!=qc){
      //alert("아이쿠")
      qcfalse1=qcfalse2="";
      $(".qmcorrect_"+qc).show();
      $(".qmbadge_"+qc).show();
    }

    correctval="-1";
  };

  ajaxsave(qc, "<?=$code?>", list, "", a, "", correctval,""); //ajaxsave(qc, list, anum, anser, essay, correctval)

});

//$(".qchk_num").on("click", function(e){
$(document).on("click",".qchk_num", function(e){

  //console.log("몇번틀림:" + qcfalse1 + ":" + qcfalse2)
	var qc=$(this).attr("qcode");
  var list=$(this).attr("list");
  var anum=$(this).attr("anum");
	var correct=$(this).attr("correct");
  var correctval="0";
  if( $(this).attr("correct")=="1"){
      //alert("정답입니다!!");
      showToast('O',qc,'showanswer');
      correctval="1";
      qcfalse1="";
      qcfalse2="";
  }else{
      //alert("오답입니다ㅠㅠ");
      correctval="-1";
      if(qcfalse1!=qc){
        showToast('X',qc,'');
        qcfalse1=qc;
      }else if(qcfalse2!=qc){
        //alert("아이쿠")
        qcfalse1=qcfalse2="";
        showToast('X',qc,'showanswer');
        //$(".qmcorrect_"+qc).show();
        //$(".qmbadge_"+qc).show();
      }
  };
  ajaxsave(qc, "<?=$code?>", list, anum, "", "", correctval,""); //ajaxsave(qc, list, anum, anser, essay, correctval)

});

function ajaxsave(qc, code, list, anum, answer, essay, correctval, opt1){

  	$.ajax({
           type : "GET",
           url : "/qchk.ajax.save.php",
           data : {"qcode":qc, "mb_id":"<?=$member["mb_id"]?>", "code":code, "list":list, "anum":anum, "answer":answer, "essay":essay
           , "correctval":correctval, "opt1":opt1},
           error : function(){
               alert('error');
           },
           success : function(data){
              // console.log(data) ;
           }
     });

}

$(document).ready(function () {

  var h=location.hash;
  if(h!=""){
    $('html, body').animate({
        scrollTop: $(h).offset().top-150
        }, 'slow');
  }
});

</script>

<?php } ///////////////////////////////////////// 문제코드들 qcodestr가 하나라도 있어야 실행종료 ?>

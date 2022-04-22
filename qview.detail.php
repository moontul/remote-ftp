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
    });
  });
}
function changethemeMonaco(qc, obj){
  window.monaco["qc_"+qc]=monaco.editor.setTheme(obj.value);
}
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
                $("#code_container_result").html(data);
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
              $("#code_container_result").html(data);
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
include_once("qview.detail.query.php");

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
?>
<div
<?php if(isset($is_myq)){ ?>
class="qcodecard"
<?php }else{ ?>
class="qcodecard card mb-3 shadow-sm"
<?php }?>
id="<?=$rs["qcode"]?>">

  <?php if(isset($is_myq)){ ////////////////////////////////////////////////////////////  오답노트?>
  <div style="color:#ff00ff;">

    <?=date("Y-m-d",strtotime($rs["my_in_date"]))?>

    <!--
    <a href="view?code=<?=$rs["code"]?>">
      <?=$rs["title"]?>
    </a> >
    <a href="view?list=<?=$rs["list"]?>#<?=$rs["qcode"]?>">
      <?=$rs["listtitle"]?>
    </a>
    -->


      <?php if($rs["countfalse"]==0){?>
          <!--<span style="color:skyblue"><i class="fas fa-bullseye"></i></span>-->
      <?php }else{?>
          <i class="fas fa-times-circle"></i><sup><?=$rs["countfalse"]?></sup>
      <?php } ?>

      <span title="중요표시" class="cursor-pointer mychkStar starNo" starval=1 style="display:<?=($rs['star']==0)?'':'none' ?>"
        qcode="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>" isstar="star"><i class="far fa-star"></i></span>
      <span  title="중요제거" class="cursor-pointer mychkStar starYes" starval=0  style="display:<?=($rs['star']==0)?'none':''?>"
        qcode="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>" isstar="star"><i class="fas fa-star"></i></span>

      <span title="오답노트에서 제거" class="start-100 cursor-pointer" onclick="$('#<?=$rs["qcode"]?>').remove();mychkRemove('<?=$rs["qcode"]?>','<?=$rs["list"]?>');">
        <i class="fas fa-minus"></i>
      </span>
  </div>
  <?php } ////////////////////////////////////////////////////////////  오답노트  ?>

  <div
<?php if(isset($is_myq)){ ?>
<?php }else{?>
  class="card-header"
<?php }?>
  style="padding-bottom:10px;">

    <div>
      <?php if($is_admin){?>
        <input type=checkbox name="chk_qcode_search" value="<?=$rs['qcode']?>" checked>  
      <?}?>

      <?php if($is_random==1){ ?>
        <b><?=$i+1?></b>.
      <?php }else{ ?>
        <b><?=$rs["qnum"]?></b>.
      <?php } ?>

      <b><?=$rs["qtext"]?></b>
    </div>

    <?php if(($code=="")&&($list=="")){?>
      <div style="font-size:12px; margin-top: -5px;text-align:right;"><?=$rs["title"]?> <?=$rs["subtitle"]?> > <?=$rs["listtitle"]?></div>
    <?php }?>

  </div>

  <div class="card-body" style="padding-top:1px;">


          <?php if(!empty($rs["qtextsub"])){?>
          <div style="border:1px solid #c0c0c0;padding:15px;text-align:justify;">
            <span>
              <b><?=nl2br($rs["qtextsub"])?></b>
            </span>
          </div>
          <?php } ?>

          <?php if(!empty($rs["qimg"])){?>
          <div style="border:0;padding:5px;text-align:justify;">
            <div>
              <img src="<?=G5_DATA_URL?><?=$rs["imgpath"]?><?=$rs["qimg"]?>" class="col-md-7 col-sm-12 col-12">
            </div>
          </div>
          <?php } ?>

          <?php $src_code=""; ?>
            <?php if(!empty($rs["is_compiler"])){ //////////프로그램 코드 ?>
              <?php
              $src_code=trim($rs['qcompilecode']);
              if($src_code==""){$src_code=trim($rs['qtextsub']);}
                if($src_code!=""){
              ?>

                <pre <?php if(!empty($rs["qimg"])){?> style="height:100px;overflow:auto;"<?}?>><code
                  class="<?=strtolower($rs["is_compiler"])?>"><?=str_replace("<", "&lt;", $src_code)?></code></pre>
              <!--
                <div class="text-end" style="margin-top:-10px;">
                <input type=button value="/*온라인 컴파일러 연습*/"  class="shadow-sm btn btn-sm btn_is_comiler btn-pp-sx" l="<?=$rs["is_compiler"]?>" qcode="<?=$rs['qcode']?>">
                <textarea id="coding_<?=$rs['qcode']?>" style="display:none;"><?=$src_code?></textarea>
                </div>
              -->
              <?php } ?>

            <?php } ?>

    <?php if($rs["qtype"]=="코딩"){?>
    <div>
        <div>
                <div class="p-1 bg-dark">
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
                  createMonaco("<?=$rs['qcode']?>",`<?=$rs['u_essay']?>`,"<?=strtolower($rs["is_compiler"])?>");
                </script>

                    <div class="text-center p-1">
                      <!--<input type=button value="  결과 값 제출  " class="btn btn-sm btn-light shadow-sm" qc="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>" onclick="saveDoodle()">
                      -->
                      <input type=button value="  결과 값 제출  " class="btn btn-sm btn-light shadow-sm" qc="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>"
                      onclick="saveCodex('<?=$rs["qcode"]?>','<?=$rs["code"]?>','<?=$rs["list"]?>')">
                    </div>
                    <div class="p-1">
                      <span class="text-secondary">컴파일 결과값 : </span>
                      <span id="code_container_result"><?=$rs["u_opt1"]?></span>
                    </div>
              </div>
      <!--
      <div class="input-group mb-3">
        <textarea id="essay_<?=$rs["qcode"]?>" class="form-control" placeholder="답을 입력하세요"
          aria-label="답을 입력하세요" aria-describedby="button-addon2"><?=$rs["u_essay"]?></textarea>
        <button class="btn btn-outline-secondary qchk_essay" type="button" id="button-addon2" qcode="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>">정답확인</button>
      </div>
      -->
    </div>

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
        <?for($j=1;$j<=5;$j++){?>
            <?if($rs["qm".$j."correct"]==1){?>
              <div style="display:none;color:#ff00ff;" class="qmcorrect_<?=$rs["qcode"]?>">
                <b>[정답 : <?=$j?>]</b>

                                <?php if(!isset($is_myq)){ ////////// 내문제가 아닐때 중요표시 ----- 이미 중요표시한 것은 어케??>

                                  <span style="color:#ff00ff;"><!--중요 표시-->
                                    <span title="중요표시" class="mychkStar starNo" starval=1 style="display:"
                                      qcode="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>" isstar="star"><i class="far fa-star"></i></span>
                                    <span  title="중요제거" class="mychkStar starYes" starval=0  style="display:none"
                                      qcode="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>" isstar="star"><i class="fas fa-star"></i></span>
                                  </span>
                                <?php } ?>


                                <div><?=nl2br($rs["qexplain"])?></div>

              </div>
            <?}?>
        <?}?>

  <?php } ?>

            <div>

              <div class="qexp-area-<?=$rs["qcode"]?>"></div>

              <div>


                  <div class="input-group mb-3">
                      <textarea class="form-control txtqexp-<?=$rs["qcode"]?>" placeholder="해설을 달아주세요"></textarea>

                      <div class="qexp-in-<?=$rs["qcode"]?> text-end">
                      <button class="btn btn-sm shadow-sm btn-qexplain" qcode="<?=$rs["qcode"]?>">해설저장</button>
                      </div>

                  </div>






                <div class="qexp-up-<?=$rs["qcode"]?> text-end" style="display:none">
                  <input type="button" value="수정" class="btn btn-sm shadow-sm btn-qexplainup" qcode="<?=$rs["qcode"]?>">
                  <input type="button" value="취소" class="btn btn-sm shadow-sm btn-qexplaincancel" qcode="<?=$rs["qcode"]?>">
                </div>
                <input type=hidden size=1 name="mode" class="modeqexp-<?=$rs["qcode"]?>">
                <input type=hidden size=1 name="idx" class="idxqexp-<?=$rs["qcode"]?>">
              </div>
            </div>

              <?php if($is_admin){?>
              <div class="">
                <a href="./qedit?list=<?=$rs["list"]?>&qcode=<?=$rs["qcode"]?>"
                  class="badge btn btn-outline-dark shadow-sm text-dark">문제수정</a>

                <a href="./qedit?list=<?=$rs["list"]?>&copyq=<?=$rs["qcode"]?>"
                  class="badge btn btn-outline-light shadow-sm text-dark">문제복사</a>

              </div>
              <?php } ?>
  <br>
</div><!--cardbody-->
</div><!--card-->
<?} //문제 루프 종료?>


<?php ////////////////////////////////////////////////////////// 해설 쿼리 부분 ?>
<?php if($qcodestr!=""){ //문제코드 있을 경우?>
<div class="qexp-sandbox">
<?php
  $sqltmp="select * from tb_qexplain where qcode in ($qcodestr) order by qcode, idx";
  $rstmp=sql_query($sqltmp);
  $old_qcode="";
  for($i=0;$rs=sql_fetch_array($rstmp);$i++){
?>
<?php if($old_qcode!=$rs["qcode"]){?>
  <?php if($old_qcode!=""){?></div><?php } ?>

  <div class="qexpbox" qcode="<?=$rs["qcode"]?>">
    <div class="border-bottom mb-2 fw-bold">해설</div>


<?php $old_qcode=$rs["qcode"]; } ?>

  <?php
    $point=$rs["point"];
    $pointalpha=$rs["point"];
    if($pointalpha>5){$pointalpha=5;}
  ?>
  <div class="d-flex" style="border-bottom:1px solid #ccc">
    <div class="col-1 text-center cursor-pointer" >
      <span class="position-absolute translate-middle badge rounded-pill bg-danger">
          <?=$point?>
      </span>

      <img src="<?=G5_THEME_URL?>/img/camellia64.png" width=40 class="pointExp camellia<?=$pointalpha?>" idx="<?=$rs["idx"]?>"
      title="꽃을 달아주세요" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top">

    </div>
    <div class="qexpcon-<?=$rs["idx"]?> col-8 p-1"><?=$rs["qexplain"]?></div>
    <div class="col-1 fs-7 fw-lighter"><?=$rs["mb_id"]?></div>
    <?php if($rs["mb_id"]==$member["mb_id"]){ ?>
      <div class="s-100 col-1">
          <input type="button" value="e" class="edtExp btn btn-sm btn-light shadow-sm" qcode="<?=$rs["qcode"]?>" idx="<?=$rs["idx"]?>">
          <input type="button" value="x" class="delExp btn btn-sm btn-light shadow-sm" idx="<?=$rs["idx"]?>">
      </div>
    <?php } ?>
  </div>
<?php
  }

  if($old_qcode!=""){
?></div>
  <?php } ?>
</div>
<?php } /// 문제코드 있음?>
<?php ////////////////////////////////////////////////////////// 해설 쿼리 부분 끝 ?>

<script>
for(var i=0;i<$(".qexpbox").length;i++){
  var qc=$(".qexpbox").eq(i).attr("qcode");
  var str=$(".qexpbox").eq(i).html();
  $(".qexp-area-"+qc).html(str);
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

//해설저장
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
  if(confirm("꽃 달까요?")){
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
             //alert($(".qcodecard").length) ;
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
            console.log("오답 닫힘........")
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
               console.log(data) ;
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

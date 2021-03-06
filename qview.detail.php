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
//??????????????? ???????????? ??????
function qnumReplace($g){
  $g1="";
  if($g==1){$g1="???";}
  elseif($g==2){$g1="???";}
  elseif($g==3){$g1="???";}
  elseif($g==4){$g1="???";}
  elseif($g==5){$g1="???";}
  else{$g1=$g;}
  return $g1;
}

//????????? ???????????? ????????????, cbt????????? ??????
include_once("qview.detail.query.php");

//?????? ????????? ????????? ?????? ?????? ?????? ??????
if(isset($sqlq_prepare)){
  $sqlq=$sqlq_prepare;
}
$resultq=sql_query($sqlq);

//echo($sqlq);

//??????????????????
$qcodestr=""; //?????? ???????????? (??????????????? ??????????????????)
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

  <?php if(isset($is_myq)){ ////////////////////////////////////////////////////////////  ?????????????>
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

      <span title="????????????" class="cursor-pointer mychkStar starNo" starval=1 style="display:<?=($rs['star']==0)?'':'none' ?>"
        qcode="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>" isstar="star"><i class="far fa-star"></i></span>
      <span  title="????????????" class="cursor-pointer mychkStar starYes" starval=0  style="display:<?=($rs['star']==0)?'none':''?>"
        qcode="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>" isstar="star"><i class="fas fa-star"></i></span>

      <span title="?????????????????? ??????" class="start-100 cursor-pointer" onclick="$('#<?=$rs["qcode"]?>').remove();mychkRemove('<?=$rs["qcode"]?>','<?=$rs["list"]?>');">
        <i class="fas fa-minus"></i>
      </span>
  </div>
  <?php } ////////////////////////////////////////////////////////////  ????????????  ?>

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
            <?php if(!empty($rs["is_compiler"])){ //////////???????????? ?????? ?>
              <?php
              $src_code=trim($rs['qcompilecode']);
              if($src_code==""){$src_code=trim($rs['qtextsub']);}
                if($src_code!=""){
              ?>

                <pre <?php if(!empty($rs["qimg"])){?> style="height:100px;overflow:auto;"<?}?>><code
                  class="<?=strtolower($rs["is_compiler"])?>"><?=str_replace("<", "&lt;", $src_code)?></code></pre>
              <!--
                <div class="text-end" style="margin-top:-10px;">
                <input type=button value="/*????????? ???????????? ??????*/"  class="shadow-sm btn btn-sm btn_is_comiler btn-pp-sx" l="<?=$rs["is_compiler"]?>" qcode="<?=$rs['qcode']?>">
                <textarea id="coding_<?=$rs['qcode']?>" style="display:none;"><?=$src_code?></textarea>
                </div>
              -->
              <?php } ?>

            <?php } ?>

    <?php if($rs["qtype"]=="??????"){?>
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
                      <!--<input type=button value="  ?????? ??? ??????  " class="btn btn-sm btn-light shadow-sm" qc="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>" onclick="saveDoodle()">
                      -->
                      <input type=button value="  ?????? ??? ??????  " class="btn btn-sm btn-light shadow-sm" qc="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>"
                      onclick="saveCodex('<?=$rs["qcode"]?>','<?=$rs["code"]?>','<?=$rs["list"]?>')">
                    </div>
                    <div class="p-1">
                      <span class="text-secondary">????????? ????????? : </span>
                      <span id="code_container_result"><?=$rs["u_opt1"]?></span>
                    </div>
              </div>
      <!--
      <div class="input-group mb-3">
        <textarea id="essay_<?=$rs["qcode"]?>" class="form-control" placeholder="?????? ???????????????"
          aria-label="?????? ???????????????" aria-describedby="button-addon2"><?=$rs["u_essay"]?></textarea>
        <button class="btn btn-outline-secondary qchk_essay" type="button" id="button-addon2" qcode="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>">????????????</button>
      </div>
      -->
    </div>

    <div style="display:none;color:#ff00ff;" class="qmcorrect_<?=$rs["qcode"]?>">
      <b>[????????? : <?=$rs["qessay"]?>]</b>

      <div><?=nl2br($rs["qexplain"])?></div>

    </div>


  <?php }else if($rs["qtype"]=="?????????"){?>
  <div>
    <div class="input-group mb-3">
      <textarea id="essay_<?=$rs["qcode"]?>" class="form-control" placeholder="?????? ???????????????"
        aria-label="?????? ???????????????" aria-describedby="button-addon2"><?=$rs["u_essay"]?></textarea>
        <button class="btn btn-outline-secondary qchk_essay" type="button" id="button-addon2" qcode="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>">
        ????????????
      </button>
    </div>
  </div>

  <div style="display:none;color:#ff00ff;" class="qmcorrect_<?=$rs["qcode"]?>">
    <b>[????????? : <?=$rs["qessay"]?>]</b>

    <div><?=nl2br($rs["qexplain"])?></div>

  </div>

  <?php }else if($rs["qtype"]=="?????????"){?>
  <div>
    <div class="input-group mb-3">
      <input type="text" qanswer="<?=$rs["qanswer"]?>" id="answer_<?=$rs["qcode"]?>" class="form-control" placeholder="?????? ???????????????"
        aria-label="?????? ???????????????" aria-describedby="button-addon2" value="<?=$rs["u_answer"]?>">
      <button class="btn btn-outline-secondary qchk_answer" type="button" id="button-addon2" qcode="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>">????????????</button>
    </div>
  </div>

  <div style="display:none;color:#ff00ff;" class="qmcorrect_<?=$rs["qcode"]?>">
    <b>[?????? : <?=$rs["qanswer"]?>]</b>
    <div><?=nl2br($rs["qexplain"])?></div>
  </div>

<?php }else{ //????????? *********************************************************** ?>
        <div class="p-1">
        <?for($j=1;$j<=5;$j++){?>
          <?php if(    (($rs["qm".$j."text"])!="")  ||  (!empty($rs["qm".$j."img"]))    ){?>
            <ul class="list-inline">
                <list class="list-inline-item align-top">

                  <?php if($rs["qm".$j."correct"]==1){?>
                    <span class="position-absolute rounded-pill p-1 qmbadge_<?=$rs["qcode"]?>" style="display:none;font-size:10px;color:#fff;background:#ff00ff;margin-left:-28px;margin-top:-1px;">??????</span>
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
                <b>[?????? : <?=$j?>]</b>

                                <?php if(!isset($is_myq)){ ////////// ???????????? ????????? ???????????? ----- ?????? ??????????????? ?????? ????????>

                                  <span style="color:#ff00ff;"><!--?????? ??????-->
                                    <span title="????????????" class="mychkStar starNo" starval=1 style="display:"
                                      qcode="<?=$rs["qcode"]?>" list="<?=$rs["list"]?>" isstar="star"><i class="far fa-star"></i></span>
                                    <span  title="????????????" class="mychkStar starYes" starval=0  style="display:none"
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
                      <textarea class="form-control txtqexp-<?=$rs["qcode"]?>" placeholder="????????? ???????????????"></textarea>

                      <div class="qexp-in-<?=$rs["qcode"]?> text-end">
                      <button class="btn btn-sm shadow-sm btn-qexplain" qcode="<?=$rs["qcode"]?>">????????????</button>
                      </div>

                  </div>






                <div class="qexp-up-<?=$rs["qcode"]?> text-end" style="display:none">
                  <input type="button" value="??????" class="btn btn-sm shadow-sm btn-qexplainup" qcode="<?=$rs["qcode"]?>">
                  <input type="button" value="??????" class="btn btn-sm shadow-sm btn-qexplaincancel" qcode="<?=$rs["qcode"]?>">
                </div>
                <input type=hidden size=1 name="mode" class="modeqexp-<?=$rs["qcode"]?>">
                <input type=hidden size=1 name="idx" class="idxqexp-<?=$rs["qcode"]?>">
              </div>
            </div>

              <?php if($is_admin){?>
              <div class="">
                <a href="./qedit?list=<?=$rs["list"]?>&qcode=<?=$rs["qcode"]?>"
                  class="badge btn btn-outline-dark shadow-sm text-dark">????????????</a>

                <a href="./qedit?list=<?=$rs["list"]?>&copyq=<?=$rs["qcode"]?>"
                  class="badge btn btn-outline-light shadow-sm text-dark">????????????</a>

              </div>
              <?php } ?>
  <br>
</div><!--cardbody-->
</div><!--card-->
<?} //?????? ?????? ???????>


<?php ////////////////////////////////////////////////////////// ?????? ?????? ?????? ?>
<?php if($qcodestr!=""){ //???????????? ?????? ???????>
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
    <div class="border-bottom mb-2 fw-bold">??????</div>


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
      title="?????? ???????????????" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top">

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
<?php } /// ???????????? ???????>
<?php ////////////////////////////////////////////////////////// ?????? ?????? ?????? ??? ?>

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
<!--Jdoodle ?????? ????????? ?????? ???-->
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

//????????????
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
  alert("??????????????????.")
<?php }?>

})
//??????????????????
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
//????????????
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

//?????????
$(document).on("click",".pointExp", function(e){
<?php if($is_member){?>
  var idx=$(this).attr("idx");
  if(confirm("??? ??????????")){
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

//????????????
$(document).on("click",".delExp", function(e){
<?php if($is_member){?>
  var idx=$(this).attr("idx");
  if(confirm("????????? ????????????????")){
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
//????????????
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

//?????????
$(".mychkStar").click(function(){
  var qc=$(this).attr("qcode");
  var list=$(this).attr("list");
  var starval=$(this).attr("starval");

  //????????? ??????
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
    title: '???????????????!',
    confirmButtonText: '??????',
    timer: 1000,
    timerProgressBar: true,
    confirmButtonColor: 'pink',
    didClose: (toast) => {
          //  toast.addEventListener('mouseenter', Swal.stopTimer)
          //  toast.addEventListener('mouseleave', Swal.resumeTimer)
          //console.log("????????? ??????........")
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
      textstr='????????? ??????????????????';
    }else{
      textstr='?????? ????????? ?????????';
    }

    Swal.fire({
      icon: 'error',
      title: '?????????????????????',
      text : textstr,
      confirmButtonText: '??????',
      timer: 1000,
      timerProgressBar: true,
      didClose: (toast) => {
            //  toast.addEventListener('mouseenter', Swal.stopTimer)
            //  toast.addEventListener('mouseleave', Swal.resumeTimer)
            console.log("?????? ??????........")
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
//??????2????????? ???????????? ?????????
//????????? ???????????? ????????????
var qcfalse1="";
var qcfalse2="";

//????????? ????????????
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
      //alert("?????????")
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
    //lert("???????????????!!");
    showToast('O',qc);
    correctval="1";
    $(".qmcorrect_"+qc).show();
    $(".qmbadge_"+qc).show();
  }else{
    //alert("?????????????????????");
    showToast('X',qc);
    if(qcfalse1!=qc){
      qcfalse1=qc;
    }else if(qcfalse2!=qc){
      //alert("?????????")
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

  //console.log("????????????:" + qcfalse1 + ":" + qcfalse2)
	var qc=$(this).attr("qcode");
  var list=$(this).attr("list");
  var anum=$(this).attr("anum");
	var correct=$(this).attr("correct");
  var correctval="0";
  if( $(this).attr("correct")=="1"){
      //alert("???????????????!!");
      showToast('O',qc,'showanswer');
      correctval="1";
      qcfalse1="";
      qcfalse2="";
  }else{
      //alert("?????????????????????");
      correctval="-1";
      if(qcfalse1!=qc){
        showToast('X',qc,'');
        qcfalse1=qc;
      }else if(qcfalse2!=qc){
        //alert("?????????")
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

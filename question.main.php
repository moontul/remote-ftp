<?php include_once("page.wraptop.php");?>

<?php
  $question_search_page="true"; //모든 페이지
  $page_code="0";
  $page_lvl="1";
  $question_filedown="true";
?>
<?php @include_once("page.nav.php");?>
<div class="col-lg-9 col-md-9 col-sm-12 pp-mainpage">


    <?php include_once("page.qsearch.php");?>

<?php if($is_admin){ /////////////////////////////////////////////////////////////////////////////?>
<!--
<hr>
체크한 문제를 <input type="button" value="xml 다운로드" onclick="qcode2file('xml')">
<input type="button" value="hwp 다운로드" onclick="qcode2file('hwp')">
<input type="button" value="excel 다운로드" onclick="qcode2file('xls')">
 txtdown()
-->
<br>



<?php include_once("page.listall.query.php");
//echo($sql);
$result=sql_query($sql_listall);
?>

<div class="d-flex">
  <div>
    <select name="pagelist" id="pagelist" class="form-control form-control-sm w-auto">
    <option value="">:::연결할 목록을 선택하세요:::</option>
<?php
for($i=0;$rs=sql_fetch_array($result);$i++){
?>
  <option value="<?=$rs["list"]?>">
    <?=$rs["tabtitle"]?></a>
  </option>
<?}?>
  </select>
  </div>
  <div>
    <input type=button value="연결하기" class="btn btn-sm bg-gradient-primary  w-auto d-inline" onclick="qcode2page()"></div>
  </div>


  <?php if($is_admin){?>
  <div>
    <input type=button value="메릴 자동분류 받아오기" class="btn btn-sm bg-gradient-primary  w-auto d-inline" onclick="pre_qcode2merrill()"></div>
  </div>
  <?php } ?>

</div>
<br><br>



<script>
function pre_qcode2merrill(){
    Swal.showLoading();
    setTimeout(qcode2merrill,1000);
}
function qcode2merrill(){
  var qcodes="";



/*
  Swal.fire({
  icon: 'success',
  title: '메릴 자동 분류 작업중입니다........',
  confirmButtonText: '닫기',
  didClose: (toast) => {
        //confirmButtonColor: 'pink',
        //  toast.addEventListener('mouseenter', Swal.stopTimer)
        //  toast.addEventListener('mouseleave', Swal.resumeTimer)
        //console.log("정답창 닫힘........")
      }
  })
*/

  for(var i=0;i<$(".chkq").length;i++){
    if($(".chkq").eq(i).prop("checked")){
        var qcode=$(".chkq").eq(i).val();
        var qtext=$(".qtext_"+qcode).val();
        if(qtext!=""){


          //if(confirm( (i+1)+") 메릴 분류값을 받아옵니다?\n"+qtext)){

                              $.ajax({
                                     type : "POST",
                                     async: false,
                                     url : "/qedit.chkmerrill.php",
                                     data : {"sentence":qtext },
                                     error : function(){
                                         //alert('메릴 분류 서버가 오류입니다.');
                                     },
                                     success : function(data){
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
                                         $.ajax({
                                                type : "POST",
                                                async:false,
                                                url : "/qedit.chkmerrill.save.php",
                                                data : {qcode:qcode, merrillx:mx, merrilly:my, merrilljson:data },
                                                error : function(){
                                                    //alert('error');
                                                },
                                                success : function(data){
                                                    //alert("업데이트완료!!");
                                                    $(".merrill_"+qcode).text(mx+"X"+my);
                                                    $(".chkq").eq(i).prop("checked",false);
                                                }
                                          });

                                     }
                               });
          //}

        }
        //if(qcodes!=""){qcodes+=",";}
        //qcodes+=$(".chkq").eq(i).val();
    }



  }

    alert("작업을 완료했습니다.");
    Swal.hideLoading();
  return;

}

function chk_qcode2file(f){
  var qcodes="";
  var qnums="";
  for(var i=0;i<$(".chkq").length;i++){
    if($(".chkq").eq(i).prop("checked")){
        if(qnums!=""){qnums+=",";}
        qnums+=$(".chkq").eq(i).attr("qnum");

        if(qcodes!=""){qcodes+=",";}
        qcodes+=$(".chkq").eq(i).val();
    }
  }
  if(qcodes==""){alert("문제를 선택하세요");$(".chkq").focus();return;}
  document.f.fileformat.value=f;
  document.f.action="question.code2file.php";
  document.f.target="_blank";
  document.f.submit();

}

function qcode2page(){
    var pagelist="";
    pagelist=$("#pagelist").val();

    var qcodes="";
    var qnums="";
    for(var i=0;i<$(".chkq").length;i++){
      if($(".chkq").eq(i).prop("checked")){
          if(qnums!=""){qnums+=",";}
          qnums+=$(".chkq").eq(i).attr("qnum");

          if(qcodes!=""){qcodes+=",";}
          qcodes+=$(".chkq").eq(i).val();
      }
    }

    if(pagelist==""){alert("목록을 선택하세요");$("#pagelist").focus();return;}
    if(qcodes==""){alert("문제를 선택하세요");$(".chkq").focus();return;}


    if(qcodes!=""){

          $.ajax({
                 type : "POST",
                 url : "/question.ajax.qcode2pagelist.php",
                 data : {"qcodes":qcodes, "qnums":qnums, "pagelist":pagelist },
                 error : function(){
                     //alert('error');
                 },
                 success : function(data){
                   alert("연결 결과 : " + data);
                   if(confirm("연결된 목록으로 이동할까요?")){
                     window.open("page?"+pagelist);
                   }else{
                     location.reload();
                   }

                 }
           });
  }

}



  $(".chkqall").click(function(){
    $(".chkq").prop("checked", $(this).prop("checked"));
  });

  /*

  function download(filename, textInput) {

        var element = document.createElement('a');
        element.setAttribute('href','data:text/plain;charset=utf-8, ' + encodeURIComponent(textInput));
        element.setAttribute('download', filename);
        document.body.appendChild(element);
        element.click();
        //document.body.removeChild(element);
  }
  document.getElementById("btn")
        .addEventListener("click", function () {
              var text = document.getElementById("text").value;
              var filename = "output.txt";
              download(filename, text);
        }, false);
        */
</script>
<?php } ////////////////////////////////////////////////////////////////////////////?>



</div>
<?php include_once("page.wrapbottom.php");?>

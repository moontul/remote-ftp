<?php include_once('./_common.php');
@include_once(G5_THEME_PATH.'/head.sub.php');

$list=$_GET["list"];
?>

<?php include_once('page.qsearch.php');?>


<script>
function addq(){

  var qorder=$("input[name='qorder']:checked").val();

  var qnums="";
  var qcodes="";
  var chkcount=0;
  for(var i=0;i<$(".chkq").length;i++){

    if( $(".chkq").eq(i).prop("checked") ){

        if(qorder=="rand"){
            if(qnums!=""){qnums+=",";}
            chkcount+=1;
            qnums+=chkcount;
        }else{
            if(qnums!=""){qnums+=",";}
            qnums+=$(".chkq").eq(i).attr("qnum");
        }

            if(qcodes!=""){qcodes+=",";}
            qcodes+=$(".chkq").eq(i).val();
    }
  }

  if(qcodes==""){alert("선택된 문제가 없습니다.");return;}

  $.ajax({
         type : "POST",
         url : "/page_q.modal.ajaxsave.php",
         data : {"qcodes":qcodes, "qnums":qnums, "list":"<?=$list?>" },
         error : function(){
             //alert('error');
         },
         success : function(data){
           parent.location.reload();
         }
   });

}
</script>

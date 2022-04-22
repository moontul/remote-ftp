<?php include_once('./_common.php');

//사용자가 어떤 문제를 풀었을때 로그를 저장함
//cbt 문제 풀이와 분리하기 위해 fromcbt를 0인 값으로 처리

$qcodes=$_POST["qcodes"];
$pagelist=$_POST["pagelist"];

$msg="";
$okcount=0;
$nocount=0;
if($is_admin){ ///관리자

  $a_qnum=explode(",", $qnums);
  $a_qcode=explode(",", $qcodes);
  for($i=0;$i<count($a_qcode);$i++){

      //이미 있는지 검사해서 있으면 입력안하고, 없으면 입력함
      $qcode=$a_qcode[$i];
      $qnum=$a_qnum[$i];
      if($qcode!=""){
              $sql="select count(*) as cnt from tb_pageq where list='$pagelist' and qcode='$qcode'";
              $result=sql_fetch($sql);

              if($result["cnt"]==0){
                $sql="insert into tb_pageq(pqnum, qcode, list) values('$qnum','$qcode', '$pagelist')";
                sql_query($sql);
                $okcount+=1;
              }else{
                  //중복오류
                  $nocount+=1;
              }
      }
  }

  $msg.= "연결수:".$okcount;
  $msg.= "(중복오류:".$nocount.")";

}else{
  $msg .= "관리자만 연결작업할 수 있어요";
}

echo($msg);
?>

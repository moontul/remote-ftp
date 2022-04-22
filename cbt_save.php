<?php include_once('./_common.php');

$list=$_POST["list"];
$page_list=$_POST["page_list"];

$mb_id=$_POST["mb_id"];

$is_test=$_POST["is_test"];
$is_cbt=$_POST["is_cbt"];

if($is_cbt==""){$is_cbt=0;}
//echo($code.":".$list.":".$mb_id."<br>");

//전체문제 쿼리 //해당문제의 정답
include_once("page.qview.detail.query.php");

echo($sqlq."<br>");
$result=sql_query($sqlq);

$org_qnum=array(); //문제번호
$org_qmcorrect=array(); //정답
$org_qcode=array(); //문제고유

for($i=0;$rs=sql_fetch_array($result);$i++){

  //객관식 정답
  if($rs["qm1correct"]==1){$qmcorrect=1;}
  if($rs["qm2correct"]==1){$qmcorrect=2;}
  if($rs["qm3correct"]==1){$qmcorrect=3;}
  if($rs["qm4correct"]==1){$qmcorrect=4;}
  if($rs["qm5correct"]==1){$qmcorrect=5;}

  echo("불러온 번호:".$rs["rownum"]." 정답:". $qmcorrect. "<br>");
  $org_qnum[$i]=$rs["rownum"];
  $org_qmcorrect[$i]=$qmcorrect;
  $org_qcode[$i]=$rs["qcode"];
}



//사용자 선택값
$a_qnum=$_POST["qnum_a"];
$a_sel=$_POST["sel_a"];
$a_answer=$_POST["answer_a"];
$a_qcode=$_POST["qcode_a"];
$a_qlist=$_POST["qlist_a"];
$countsum=0;
for($i=0;$i<count($a_qnum);$i++){

  echo("<br>문제".$a_qnum[$i] . "--->선택" . $a_sel[$i] .":". $a_answer[$i] . " <--- 정답". $org_qmcorrect[$i].":::".$org_qcode[$i]." vs ".$a_qcode[$i]. "<br>");

  $counttrue=0;
  $countfalse=0;
  $countall=0;
  if($a_sel[$i]==$org_qmcorrect[$i]){ //맞췄음
    $counttrue=1;
    $countsum++;
  }else{
    $countfalse=1;
  }

  $sql="insert into tb_answerlog(mb_id, page_list, list, qcode, anum, answer, counttrue, countfalse, countall, fromcbt, is_cbt) values(
        '$mb_id', '$page_list', '$a_qlist[$i]', '$a_qcode[$i]', '$a_sel[$i]', '$a_answer[$i]', '$counttrue','$countfalse','$countall',1, $is_cbt
      ); ";

  echo($sql."<br>");
  sql_query($sql);
}

echo("총점:".$countsum);

goto_url("cbt_result.php?list=$page_list&mb_id=$mb_id");

?>

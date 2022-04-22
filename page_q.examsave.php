<?php include_once('./_common.php');

$edit_list=$_POST["edit_list"];

$is_test=$_POST["is_test"];
$is_random=$_POST["is_random"];

$is_cbt=$_POST["is_cbt"];

$examcodes=$_POST["examcodes"]; //대상아이디 tb_exam_codes에 저장
$examids=$_POST["examids"]; //대상아이디
$examgroups=$_POST["examgroups"]; //대상그룹
$examcondition=$_POST["examcondition"]; //대상조건

$examopen=$_POST["examopen"];
$examclose=$_POST["examclose"];
$examopentime=$_POST["examopentime"];
$examclosetime=$_POST["examclosetime"];

$examlimit=$_POST["examlimit"];


//시험 제약 정보
$sql="delete from tb_exam where list='$edit_list'";  ////code='$code' and
sql_query($sql);

$sql="insert into tb_exam(list, examcondition, examopen, examclose, examopentime, examclosetime, examlimit, is_random
      , is_test, is_cbt
      ) values(
      '$edit_list',
      '$examcondition', '$examopen', '$examclose','$examopentime', '$examclosetime','$examlimit','$is_random'
      ,'$is_test','$is_cbt'
      )";
echo($sql."<br>");
sql_query($sql);

//유저 코드
$sql="delete from tb_exam_codes where list='$edit_list'";  /////code='$code' and
sql_query($sql);
$a=explode("\n",$examcodes);
for($i=0;$i<count($a);$i++){
  $mb_code=trim($a[$i]);
  if($mb_code!=""){
      $sql="insert into tb_exam_codes(list, mb_code) values('$edit_list', '$mb_code')";
      sql_query($sql);
  }
}

//유저 아이디
$sql="delete from tb_exam_ids where and list='$edit_list'";
sql_query($sql);
$a=explode("\n",$examids);
for($i=0;$i<count($a);$i++){
  $mb_id=trim($a[$i]);
  if($mb_id!=""){
      $sql="insert into tb_exam_ids(list, mb_id) values('$edit_list', '$mb_id')";
      sql_query($sql);
  }
}

//유저 그룹
$sql="delete from tb_exam_groups where list='$edit_list'";
sql_query($sql);
$a=explode("\n",$examgroups);
for($i=0;$i<count($a);$i++){
  $mb_group=trim($a[$i]);
  if($mb_group!=""){
      $sql="insert into tb_exam_groups(list, mb_group) values('$edit_list', '$mb_group')";
      sql_query($sql);
  }
}

goto_url("page?$edit_list");
?>

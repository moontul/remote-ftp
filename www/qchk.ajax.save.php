<?php include_once('./_common.php');

$qcode=$_GET["qcode"];
$mb_id=$_GET["mb_id"];
$list=$_GET["list"];

$anum=$_GET["anum"];
$aessay=$_GET["aessay"];
$correctval=$_GET["correctval"];

$sql="select qcode from tb_answerlog where mb_id='$mb_id' and qcode='$qcode'";
$result=sql_fetch($sql);
if(count($result)>0){
    if((int)$correctval==1){
      $sql = "update tb_answerlog set counttrue=counttrue+1, countall=countall+1, in_date=now() where mb_id='$mb_id' and qcode='$qcode'";
    }elseif((int)$correctval==-1){
      $sql = "update tb_answerlog set countfalse=countfalse+1, countall=countall+1, in_date=now() where mb_id='$mb_id' and qcode='$qcode'";
    }else{
      $sql = "update tb_answerlog set countall=countall+1, in_date=now() where mb_id='$mb_id' and qcode='$qcode'";
    }
    sql_query($sql);

}else{

  if((int)$correctval==1){
    $sql = " insert into tb_answerlog (mb_id, qcode, list, counttrue, countall) values('$mb_id', '$qcode', '$list', 1, 1)";
  }elseif((int)$correctval==-1){
    $sql = " insert into tb_answerlog (mb_id, qcode, list, countfalse, countall) values('$mb_id', '$qcode','$list', 1, 1)";
  }else{
    $sql = " insert into tb_answerlog (mb_id, qcode, list, countall) values('$mb_id', '$qcode','$list', 1)";
  }
  sql_query($sql);
}

//echo($sql);
?>

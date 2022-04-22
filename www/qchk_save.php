<?php
include_once("adm/pangpang/_conn.php");

$qcode=$_GET["qcode"];
$mb_id=$_GET["mb_id"];

$anum=$_GET["anum"];
$aessay=$_GET["aessay"];
$correctval=$_GET["correctval"];

//해당 qcode에 없으면 insert 이미 있으면 update
$sql="select qcode from tb_qsheet_log where mb_id='$mb_id' and qcode='$qcode'";
$result=mysqli_query($conn, $sql);
$row=$result->num_rows;
if($row>=1){
  if($correctval==1){
    $sql = "update tb_qsheet_log set anum='$anum', aessay='$aessay', correctval=correctval+1, counttrue=counttrue+1, countcount=countcount+1, in_date=now() where mb_id='$mb_id' and qcode='$qcode'";
  }elseif($correctval==-1){
    $sql = "update tb_qsheet_log set anum='$anum', aessay='$aessay', correctval=correctval-1, countfalse=countfalse+1, countcount=countcount+1, in_date=now() where mb_id='$mb_id' and qcode='$qcode'";
  }else{
    $sql = "update tb_qsheet_log set anum='$anum', aessay='$aessay', countcount=countcount+1, in_date=now() where mb_id='$mb_id' and qcode='$qcode'";
  }
  $result=mysqli_query($conn, $sql);


}else{
  if($correctval==1){
    $sql = " insert into tb_qsheet_log (mb_id, qcode, anum, aessay, correctval, counttrue, countcount) values('$mb_id', '$qcode', '$anum', '$aessay', '$correctval',1,1)";
  }elseif($correctval==-1){
    $sql = " insert into tb_qsheet_log (mb_id, qcode, anum, aessay, correctval, countfalse, countcount) values('$mb_id', '$qcode', '$anum', '$aessay', '$correctval',1,1)";
  }else{
    $sql = " insert into tb_qsheet_log (mb_id, qcode, anum, aessay, correctval, countcount) values('$mb_id', '$qcode', '$anum', '$aessay', '$correctval',1)";
  }
  $result=mysqli_query($conn, $sql);
}
//echo($row);
?>

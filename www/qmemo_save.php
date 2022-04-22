<?php
include_once("adm/pangpang/_conn.php");

$mb_id=$_GET["mb_id"];
$memo=$_GET["memo"];
$qcode=$_GET["qcode"];

//해당 qcode에 없으면 insert 이미 있으면 update
$sql="select qmidx from tb_qmemo where mb_id='$mb_id' and qcode='$qcode'";
$result=mysqli_query($conn, $sql);
$row=$result->num_rows;
if($row>=1){
  $sql = "update tb_qmemo set memo='$memo' where mb_id='$mb_id' and qcode='$qcode'";
  $result=mysqli_query($conn, $sql);

}else{
  $sql = " insert into tb_qmemo (memo, mb_id, qcode) values('$memo', '$mb_id', '$qcode')";
  $result=mysqli_query($conn, $sql);
}
//echo($row);
?>

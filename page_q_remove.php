<?php include_once('./_common.php');

$list=$_POST["list"];
$a_chkq=$_POST["chkq"];

if($is_admin){
  for($i=0;$i<count($a_chkq);$i++){
    $sql="delete from tb_pageq where list='$list' and qcode='$a_chkq[$i]'";
    sql_query($sql);
  }
}
goto_url("page_q?list=$list");
?>

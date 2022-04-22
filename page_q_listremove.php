<?php include_once('./_common.php');

$list=$_POST["list"];
$a_chke=$_POST["chke"];

if($is_admin){

  for($i=0;$i<count($a_chke);$i++){
    $sql="delete from tb_elist where list='$list' and exam_list='$a_chke[$i]'";
    echo($sql);
    sql_query($sql);
  }

}
goto_url("page_q?list=$list");
?>

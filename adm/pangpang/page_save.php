<?php include_once("./_common.php");

$s_title=$_POST["s_title"];
$s_type=$_POST["s_type"];
$s_code=$_POST["s_code"];
$s_pidx=$_POST["s_pidx"];

$a_idx=$_POST["idx_a"];
$a_fullidx=$_POST["fullidx_a"];
$a_code=$_POST["code_a"];

echo($a_idx);
foreach($a_idx as $key => $value){

  $fullidx=$a_fullidx[$key];
  $code=$a_code[$key];

  $sql="update tb_page set fullidx='".$fullidx."', code='".$code."' where idx=".$value;

  echo($sql."<br><br>");
  sql_query($sql);
}

goto_url("page_list.php?s_title=$s_title&s_type=$s_type&s_code=$s_code&s_pidx=$s_pidx");

?>

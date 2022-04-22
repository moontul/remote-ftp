<?php include_once('./_common.php');

$q=$_POST["query"];

$q=str_replace("\'","'",$q);

$a_q=explode(";;;;;", $q);

foreach($a_q as $key => $val){

//  echo($val."<br>");
  sql_query($val);

}

echo(($key+1)."쿼리 실행완료");
?>

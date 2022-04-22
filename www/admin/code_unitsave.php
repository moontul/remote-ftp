<?php include_once('_conn.php'); ?>
<?php include_once("code_sub.php");?>
<?php

$new_unitorder_a = $_POST['new_unitorder_a'];
$new_unitname_a = $_POST['new_unitname_a'];
$new_p_u_idx_a = $_POST['new_p_u_idx_a'];
$new_u_tab_a = $_POST['new_u_tab_a'];

foreach($new_unitorder_a as  $key => $val)
{
  $new_unitorder=addslashes(trim($new_unitorder_a[$key]));
  $new_unitname=addslashes(trim($new_unitname_a[$key]));
  $new_p_u_idx=addslashes(trim($new_p_u_idx_a[$key]));
  $new_u_tab=addslashes(trim($new_u_tab_a[$key]));

// echo($new_unitname."<br>");

  if($code!="" && $new_unitorder !="" && $new_unitname !="")
  {
      //echo(uniqid(sha1())."<br>");
      $rand= strtoupper(substr(uniqid(sha1()),7));
      $ucode=strtoupper(substr($code, 0, 2))."U".date("YmdHis").$rand;
      $sql = <<<EOT
      insert into $code_unittable($code_code, $code_unitcode, unitorder, unitname, p_u_idx, u_tab)
      values('$code', '$ucode', '$new_unitorder', '$new_unitname', '$new_p_u_idx', '$new_u_tab');
EOT;
      $result=mysqli_query($conn, $sql);
      echo($sql."<br>");
  }

}

$ucode_a=$_POST['ucode_a'];

$unitorder_a=$_POST['unitorder_a'];
$unitname_a=$_POST['unitname_a'];

$p_u_idx_a=$_POST['p_u_idx_a'];
$u_tab_a=$_POST['u_tab_a'];

foreach($ucode_a as  $key => $val){
//echo("$val ----- $unitorder_a[$key]<br><br>");
    $unitorder_v=addslashes(trim($unitorder_a[$key]));
    $unitname_v=addslashes(trim($unitname_a[$key]));
    $p_u_idx_v=addslashes(trim($p_u_idx_a[$key]));
    $u_tab_v=addslashes(trim($u_tab_a[$key]));

    if($val==""&&$unitname_v!=""){ //코드가 비어있으면 신규 인서트
      $rand= strtoupper(substr(uniqid(sha1()),7));
      $ucode=strtoupper(substr($code, 0, 2))."U".date("YmdHis").$rand;
      $sql = <<<EOT
      insert into $code_unittable($code_code, $code_unitcode, unitorder, unitname, p_u_idx, u_tab)
      values('$code', '$ucode', '$unitorder_v', '$unitname_v', '$p_idx_v', '$u_tab_v');
EOT;

    }else{

      $sql = <<<EOT
      update $code_unittable set unitorder='$unitorder_v'
      , unitname='$unitname_v'
      , p_u_idx='$p_u_idx_v'
      , u_tab='$u_tab_v' where $code_unitcode='$val';
EOT;
  }
  $result=mysqli_query($conn, $sql);
  echo($sql."<br>");
}


echo("<script>location.href='codeunit_list.php?code=$code'</script>");
?>

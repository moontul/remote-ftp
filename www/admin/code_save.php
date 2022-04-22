<?php include_once('_conn.php');?>

<?php include_once("code_sub.php");?>

<?php
//  echo($code);

  for($i=0;$i<count($code_col);$i++){
    ${$code_col[$i]} = addslashes(trim($_POST[$code_col[$i]]));
    //echo($code_col[$i] . ":".   ${$code_col[$i]} ."<br>" );
  }

  if(strlen($code)==2){
      //고유코드 13중 뒤 6자리
      $rand = strtoupper(substr(uniqid(sha1()),7));
      $code= strtoupper($code).date("YmdHis").$rand;

      $sql = "insert into ".$code_table."( $code_code ";
      for($i=0;$i<count($code_col);$i++){
        $sql = $sql. ", ";
        $sql = $sql. " $code_col[$i]";
      }

      $sql = $sql . ") values(";
      $sql = $sql . "'". $code . "'";
      for($i=0;$i<count($code_col);$i++){
        $sql = $sql. ", ";
        $sql = $sql. "'${$code_col[$i]}'";
      }
      $sql = $sql . ");";

      //echo($sql);
      $result=mysqli_query($conn, $sql);
  }
  else
  {
      $sql = " update ".$code_table." set ";

      for($i=0;$i<count($code_col);$i++){
        if($i>0){$sql = $sql. ", ";}
        $sql = $sql. " $code_col[$i]='${$code_col[$i]}'";
      }

      $sql = $sql . " where $code_code='$code'";
EOT;
      $result=mysqli_query($conn, $sql);
      //echo($sql);
  }

    echo("<script>location.href='code_list.php?code=$code'</script>");
?>

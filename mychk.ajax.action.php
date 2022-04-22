<?php include_once('./_common.php');

$mode=$_GET["mode"];
$qcode=$_GET["qcode"];
$mb_id=$_GET["mb_id"];
$list=$_GET["list"];
$starval=$_GET["starval"];


if($is_member){ ////////////////////////// 로그인되어 있음
  if(($member["mb_id"]==$mb_id)||$is_admin){

    if($mode=="remove"){
      $sql="delete from tb_answerlog where mb_id='$mb_id' and qcode='$qcode'"; //////리스트 상관없이 코드값으로만 삭제 and list='$list'";
      sql_query($sql);
      //echo($sql);
    }

    if($mode=="star"){
      $sql="update tb_answerlog set star=$starval where mb_id='$mb_id' and qcode='$qcode' "; //////리스트 상관없이 코드값만으로 별and list='$list'";
      sql_query($sql);
    }
    //echo($sql);
  }

}else{ ////////////////// 로그인되어 있지 않을 경우 쿠키제거

      if($mode=="remove"){
        //unset($_COOKIE["pangd[$qcode]"]);
        setcookie("pangd[$qcode]", '', time() - 3600, '/');
        //unset($_COOKIE["panga[$qcode]"]);
        setcookie("panga[$qcode]", '', time() - 3600, '/');
      //  unset($_COOKIE["pangs[$qcode]"]);
        setcookie("pangn[$qcode]", '', time() - 3600, '/');
      //  unset($_COOKIE["pange[$qcode]"]);
        setcookie("pange[$qcode]", '', time() - 3600, '/');
      //  unset($_COOKIE["pangv[$qcode]"]);
        setcookie("pangv[$qcode]", '', time() - 3600, '/');
        setcookie("pangs[$qcode]", '', time() - 3600, '/'); //star

        setcookie("pango[$qcode]", '', time() - 3600, '/');
        setcookie("pangx[$qcode]", '', time() - 3600, '/');

        echo("remove".$qcode);
      }
      if($mode=="star"){
          setcookie("pangs[$qcode]", $starval,  0, '/');
      }
}
?>

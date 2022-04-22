<?php include_once('./_common.php');

  $mode=$_POST["mode"];
  $code=$_POST["code"];
  $list=$_POST["list"];

  $qcode_a=$_POST["a_qcode"];

if($mode=="d"){
  /* 문제삭제 */

//    $sql="delete from tb_qlist where qcode='$qcode'";
//    sql_query($sql);
//    $sql="delete from tb_question where qcode='$qcode'";
//    sql_query($sql);
//    goto_url("/qview?code=$code");
}elseif($mode=="d"){
  /* 시험해제 */

    $sql="update tb_list set is_exam=0 where list='$list'";
    sql_query($sql);
     goto_url("qlist?list=$list");

}else{


  foreach($qcode_a as  $key => $val){

    $sql="insert into tb_qlist (code, list, qcode) values('$code','$list','$val')";
    //echo($sql."<br>");
    sql_query($sql);

  }

  $sql="update tb_list set is_exam=1 where list='$list'";
  sql_query($sql);

//  goto_url("qlist?list=$list");

}

?>

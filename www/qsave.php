<?php include_once('./_common.php');

  $mode=$_POST["mode"];
  $code=$_POST["code"];
  $list=$_POST["list"];

  $qcode=$_POST["qcode"];
  $qtext=$_POST["qtext"];
  $qm1text=$_POST["qm1text"];
  $qm2text=$_POST["qm2text"];
  $qm1correct=$_POST["qm1correct"];
  $qm2correct=$_POST["qm2correct"];

if($mode=="d"){
  /*
    $sql="select idx, pidx from tb_list where list='$list'";
    $result=sql_fetch($sql);
      $d_pidx=$result["pidx"];
      $d_idx=$result["idx"];
    $sql="update tb_list set pidx=$d_pidx where pidx=$d_idx";
    sql_query($sql);
        $sql="delete from tb_list where list='$list'";
    sql_query($sql);
    goto_url("/view?code=$code");
    */
}else{


  if($qcode==""){
    //고유코드 연월일시분초 13중 뒤 6자리
     $rand = strtoupper(substr(uniqid(sha1()),7));

     $qcode= "Q".date("YmdHis").$rand;

     $sql="insert into tb_question(qcode, qtext, qm1text, qm2text, qm1correct, qm2correct)
          values('$qcode','$qtext','$qm1text','$qm2text','$qm1correct','$qm2correct')";
     sql_query($sql);

     echo($sql."<br>");

     $sql="insert into tb_qlist(code, list, qcode) values('$code','$list','$qcode')";
     sql_query($sql);
     echo($sql."<br>");

  }else{

    $sql="update tb_question set
      qtext='$qtext'
      ,qm1text='$qm1text',qm1correct='$qm1correct'
      ,qm2text='$qm2text',qm2correct='$qm2correct'
    where qcode='$qcode'";
    sql_query($sql);
    echo($sql);
  }
  goto_url("/qlist?list=$list");
}

?>

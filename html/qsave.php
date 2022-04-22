<?php include_once('./_common.php');

  $mode=$_POST["mode"];
  $code=$_POST["code"];
  $list=$_POST["list"];

  $qcode=$_POST["qcode"];

  $qnum=$_POST["qnum"];  //문제번호
  $qtype=$_POST["qtype"];  //문제유형
  $qtext=$_POST["qtext"];
  $qtextsub=$_POST["qtextsub"];
  $qm1text=$_POST["qm1text"];
  $qm2text=$_POST["qm2text"];
  $qm3text=$_POST["qm3text"];
  $qm4text=$_POST["qm4text"];
  $qm5text=$_POST["qm5text"];

  $qm1correct=$_POST["qm1correct"];
  $qm2correct=$_POST["qm2correct"];
  $qm3correct=$_POST["qm3correct"];
  $qm4correct=$_POST["qm4correct"];
  $qm5correct=$_POST["qm5correct"];
  $qanswer=$_POST["qanswer"];

  $qexplain=$_POST["qexplain"];

if($mode=="d"){
  /* 문제삭제 */

    $sql="delete from tb_qlist where qcode='$qcode'";
    sql_query($sql);
    $sql="delete from tb_question where qcode='$qcode'";
    sql_query($sql);

    goto_url("/qview?code=$code&list=$list");

}else{


  if($qcode==""){
    //고유코드 연월일시분초 13중 뒤 6자리
     $rand = strtoupper(substr(uniqid(sha1()),7));

     $qcode= "Q".date("YmdHis").$rand;

     $sql="insert into tb_question(qcode
          , qnum, qtype
          , qtext, qtextsub
          , qm1text, qm2text, qm3text, qm4text, qm5text
          , qm1correct, qm2correct, qm3correct, qm4correct, qm5correct
          , qanswer
          , qexplain
          )
          values('$qcode'
          ,'$qnum','$qtype'
          ,'$qtext','$qtextsub'
          ,'$qm1text','$qm2text','$qm3text','$qm4text','$qm5text'
          ,'$qm1correct','$qm2correct','$qm3correct','$qm4correct','$qm5correct'
          ,'$qanswer'
          ,'$qexplain'
          )";

     sql_query($sql);
     echo($sql."<br>");
     //문제와 목록 매칭 테이블에도 insert
     $sql="insert into tb_qlist(code, qnum, list, qcode) values('$code','$qnum','$list','$qcode')";
     sql_query($sql);
     echo($sql."<br>");

  }else{

    $sql="update tb_question set
      qnum='$qnum', qtype='$qtype'
      ,qtext='$qtext',qtextsub='$qtextsub'
      ,qm1text='$qm1text',qm1correct='$qm1correct'
      ,qm2text='$qm2text',qm2correct='$qm2correct'
      ,qm3text='$qm3text',qm3correct='$qm3correct'
      ,qm4text='$qm4text',qm4correct='$qm4correct'
      ,qm5text='$qm5text',qm5correct='$qm5correct'
      ,qanswer='$qanswer'
      ,qexplain='$qexplain'
    where qcode='$qcode'";
    sql_query($sql);
    //echo($sql);
    //문제와 목록 매칭 테이블에도 insert
    $sql="update tb_qlist set qnum='$qnum'
          where code='$code' and list='$list' and qcode='$qcode'";
    sql_query($sql);

  }
  goto_url("/qedit?list=$list&qcode=$qcode");
}

?>

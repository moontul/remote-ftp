<?php include_once('./_common.php');

  $mode=$_POST["mode"];
  $code=$_POST["code"];
  $list=$_POST["list"];

  $examcodes=$_POST["examcodes"]; //대상아이디 tb_exam_codes에 저장
  $examids=$_POST["examids"]; //대상아이디
  $examgroups=$_POST["examgroups"]; //대상그룹
  $examcondition=$_POST["examcondition"]; //대상조건

  $examopen=$_POST["examopen"];
  $examclose=$_POST["examclose"];
  $examopentime=$_POST["examopentime"];
  $examclosetime=$_POST["examclosetime"];

  $examlimit=$_POST["examlimit"];

  $is_test=$_POST["is_test"];
  $is_cbt=$_POST["is_cbt"];
  $is_random=$_POST["is_random"];

  $qnum_a=$_POST["a_qnum"]; //list의 시험문제 번호

  $max_qnum=$_POST["max_qnum"];

  $qcode_a=$_POST["a_qcode"]; //list의 문제코드

  $elist_a=$_POST["a_elist"];

if($mode=="d"){
  /* 문제삭제 */

    $sql="delete from tb_qlist where qcode='$qcode' and list='$list' and code='$code'";
    sql_query($sql);

    //$sql="delete from tb_question where qcode='$qcode'";
    //sql_query($sql);

    //goto_url("/qview?code=$code");
}elseif($mode=="dis"){
    /* 시험해제 ??????????*/
    $sql="update tb_list set is_exam=0 where list='$list'";
    sql_query($sql);

    //tb_exam을 삭제할 것인가....
    goto_url("qlist?list=$list");

}else{


  //시험 제약 정보
  $sql="delete from tb_exam where code='$code' and list='$list'";
  sql_query($sql);

  $sql="insert into tb_exam(code, list, examcondition, examopen, examclose, examopentime, examclosetime, examlimit, is_random
        , is_test, is_cbt
        ) values(
        '$code', '$list',
        '$examcondition', '$examopen', '$examclose','$examopentime', '$examclosetime','$examlimit','$is_random'
        ,'$is_test','$is_cbt'
        )";
  echo($sql."<br>");
  sql_query($sql);

  //유저 코드
  $sql="delete from tb_exam_codes where code='$code' and list='$list'";
  sql_query($sql);
  $a=explode("\n",$examcodes);
  for($i=0;$i<count($a);$i++){
    $mb_code=trim($a[$i]);
    if($mb_code!=""){
        $sql="insert into tb_exam_codes(code, list, mb_code) values('$code','$list', '$mb_code')";
        sql_query($sql);
    }
  }

  //유저 아이디
  $sql="delete from tb_exam_ids where code='$code' and list='$list'";
  sql_query($sql);
  $a=explode("\n",$examids);
  for($i=0;$i<count($a);$i++){
    $mb_id=trim($a[$i]);
    if($mb_id!=""){
        $sql="insert into tb_exam_ids(code, list, mb_id) values('$code','$list', '$mb_id')";
        sql_query($sql);
    }
  }

  //유저 그룹
  $sql="delete from tb_exam_groups where code='$code' and list='$list'";
  sql_query($sql);
  $a=explode("\n",$examgroups);
  for($i=0;$i<count($a);$i++){
    $mb_group=trim($a[$i]);
    if($mb_group!=""){
        $sql="insert into tb_exam_groups(code, list, mb_group) values('$code','$list', '$mb_group')";
        sql_query($sql);
    }
  }




  //전체시험 설정 code에 해당하는
  if($list==""){
      $sql="delete from tb_elist where code='$code'";
      sql_query($sql);
      foreach($elist_a as  $key => $val){

        $sql="insert into tb_elist (code, list) values(
          '$code','$val'
          )";
        echo($sql."<br>");
        sql_query($sql);
      }

  }else{

          //시험 문제 목록
          $sql="delete from tb_qlist where code='$code' and list='$list'";
          sql_query($sql);

            foreach($qcode_a as  $key => $val){
                //보기 섞기
                $a_qm = array(1, 2, 3, 4);
                shuffle($a_qm);
                $myqnum=$qnum_a[$key];
                if($myqnum==""){
                  $myqnum=$max_qnum;
                  $max_qnum++;
                }

              $sql="insert into tb_qlist (is_exam, code, list, qnum, qcode, qm1, qm2, qm3, qm4) values(
                1, '$code','$list','$myqnum','$val'
                ,'$a_qm[0]','$a_qm[1]','$a_qm[2]','$a_qm[3]'
                )";
              echo($sql."<br>");
              sql_query($sql);
            }

            //$sql="update tb_list set is_exam=1 where list='$list'";
            //echo($sql."<br>");
            //sql_query($sql);
  }

  goto_url("eedit?list=$list&code=$code");

}

?>

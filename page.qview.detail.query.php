<?php
if(isset($page_list)||$qcode!=""||$qcodes!=""){  //목록이 있거나 문제코드가 있을때 쿼리 실행

  if(isset($page_list)){
    //이 list에 시험목록이 있다면
    $sql="select * from tb_elist where list='$page_list'";
    $result=sql_query($sql);
    $exam_lists="";
    for($i=0;$rs=sql_fetch_array($result);$i++){
      if($exam_lists!=""){$exam_lists.=",";}
      $exam_lists.="'".$rs["exam_list"]."'";
    }
  }

$sqlq="select (@rownum:=@rownum+1) as rownum
  , qtype, qtext, qtextsub, QS.qimg, QS.imgpath
  , is_compiler, is_compilerfirst, is_compilertheme, qcompilecode, qtextsubcoding
  , qm1text, qm2text, qm3text, qm4text, qm5text
  , qm1img, qm2img, qm3img, qm4img, qm5img
  , qm1correct, qm2correct, qm3correct, qm4correct, qm5correct
  , qanswer, qessay, qexplain, qyoutube, merrillx, merrilly ";
  if(isset($page_list)){
  $sqlq.="
    , PQ.qcode as qcode
    , PQ.pqnum as qnum
    , PQ.list as list
    , PG.title as title ";
  }elseif($qcode!=""){ //목록없고 문제코드만 있음
    $sqlq.="
    , QS.qcode as qcode
    , QS.qnum as qnum
    , '' as list
    , '' as title ";
  }elseif($qcodes!=""){ //목록없고 문제코드 여러개 있음(추천문제 등)
    $sqlq.="
    , QS.qcode as qcode
    , QS.qnum as qnum
    , '' as list
    , '' as title ";
  }

if($exam_lists!=""){
  $sqlq.="
    from tb_elist EL, tb_pageq PQ, tb_question QS, tb_page PG,  (SELECT @rownum:=0) TMP
    where EL.list='$page_list' and EL.exam_list=PQ.list and PQ.qcode=QS.qcode and PQ.list=PG.list
    ";
}else{

  if(isset($page_list)){
    $sqlq.="
      from tb_pageq PQ, tb_question QS, tb_page PG, (SELECT @rownum:=0) TMP
      where PQ.qcode=QS.qcode ";
  }elseif($qcode!=""){  //목록은 없고 문제코드만 있음
    $sqlq.="
        from tb_question QS, (SELECT @rownum:=0) TMP
        where QS.qcode='$qcode' ";
  }elseif($qcodes!=""){  //목록은 없고 문제코드만 있음
  $sqlq.="
      from tb_question QS, (SELECT @rownum:=0) TMP
      where QS.qcode in ($qcodes) ";
}

  if(isset($page_list)){
    $sqlq.="
      and PQ.list='$page_list'
      and PQ.list=PG.list
      ";
  }
}

  if($qcode!=""){
    if(isset($page_list)){
      $sqlq .= " and PQ.qcode='$qcode' ";
    }else{
      $sqlq .= " and QS.qcode='$qcode' ";
    }
  }
  if($qcodes!=""){
    if(isset($page_list)){
      $sqlq .= " and PQ.qcode in ($qcodes) ";
    }else{
      $sqlq .= " and QS.qcode in ($qcodes) ";
    }
  }

  if($qs!=""){ $sqlq .= " and QS.is_compiler='$qs' "; }

    if($is_random==1){
        $sqlq .= "  order by rand() ";
    }else{
      if(isset($page_list)){
        $sqlq .= "  order by PQ.pqnum ";
      }elseif($qcode!=""){
        $sqlq .= "  order by QS.qnum ";
      }
    }

}
?>

<?php
if(isset($list)){

$sqlq="select (@rownum:=@rownum+1) as rownum, A.qnum as qnum, qtype, A.qcode as qcode, qtext, qtextsub, qimg, B.imgpath, is_compiler, qcompilecode
  , qm1text, qm2text, qm3text, qm4text, qm5text
  , qm1img, qm2img, qm3img, qm4img, qm5img
  , qm1correct, qm2correct, qm3correct, qm4correct, qm5correct
  , qanswer, qessay, qexplain, qyoutube
  , A.list as list
  , C.listtitle as listtitle
  , D.title as title
  from tb_qlist A, tb_question B, tb_list C, tb_container D, (SELECT @rownum:=0) TMP
  where A.qcode=B.qcode and A.list='$list' and A.list=C.list and A.code=D.code
  ";
  if($qcode!=""){ $sqlq .= " and A.qcode='$qcode' "; }

  if($qs!=""){ $sqlq .= " and B.is_compiler='$qs' "; }

    if($is_random==1){
        $sqlq .= "  order by rand() ";
    }else{
        $sqlq .= "  order by A.qnum ";
    }

}elseif(isset($code)){

  //리스트 없이 코드만 있음

$sqlq="select (@rownum:=@rownum+1) as rownum, QL.qnum as qnum, qtype, QL.qcode as qcode, qtext, qtextsub, qimg, QT.imgpath, is_compiler, qcompilecode
 , qm1text, qm2text, qm3text, qm4text, qm5text
 , qm1img, qm2img, qm3img, qm4img, qm5img
 , qm1correct, qm2correct, qm3correct, qm4correct, qm5correct
 , qanswer, qessay, qexplain, qyoutube
 , CT.title as title, CT.subtitle as sutitle
 , QL.list as list, LT.listtitle as listtitle
 from tb_elist EL, tb_container CT, tb_list LT,  tb_qlist QL, tb_question QT, (SELECT @rownum:=0) TMP
 where EL.code='$code' and EL.code=CT.code and EL.list=LT.list and QL.code=EL.code and QL.list=LT.list and QL.qcode=QT.qcode ";
 if($qcode!=""){ $sqlq .= " and QL.qcode='$qcode' "; }

   if($qs!=""){ $sqlq .= " and QT.is_compiler='$qs' "; }

   if($is_random==1){
       $sqlq .= "  order by rand() ";
   }else{
       $sqlq .= "  order by LT.listtitle, QL.qnum asc ";
   }

}

?>

<?php
$code=$_GET["code"]; //tb_container의 코드입니다
$list=$_GET["list"]; //tb_list의 코드입니다
$type=$_GET["type"];

if(isset($list)&&!isset($code)){
  $sql="select * from tb_list where list='$list'";
  $result=sql_fetch($sql);
  $code=$result["code"];
  $listtitle=$result["listtitle"];
  $listcontent=$result["listcontent"];
  $youtube=$result["youtube"];

  $is_exam=$result["is_exam"];

  $pidx=$result["pidx"];


  $showmode="list";
}
if(isset($code)){
  $sql="select * from tb_container where code='$code'";
  $result=sql_fetch($sql);
  $type=$result["type"];
  $title=$result["title"];
  $subtitle=$result["subtitle"];
  $content=$result["content"];
}

if($type=="과목"){
  $is_title="과목명";
  //$is_subtitle="";
  $is_content="과목 설명";
}

if($type=="자격시험"){
  $is_title="시험명";
  $is_subtitle="응시일자";
  $is_content="자격시험 설명";

  //자격시험에 문제가 있으면 문제풀이 링크 제공
  $sqlcnt="select count(*) as cnt from tb_qlist where code='$code'";
  $rscnt=sql_fetch($sqlcnt);
  $qcnt=$rscnt["cnt"];
  if($qcnt>0){
    $is_link_buttons="
      <a href='/qview?v=all&code=$code' class='btn btn-secondary'>전체 문제풀기</a>
      <a href='/cbt?code=$code' class='btn btn-white' target='_blank'>CBT 문제풀기</a>
    ";
  }
}

if($type=="도서"){
  $is_title="도서명";
  //$is_subtitle="";
  $is_content="도서 요약";
}

?>

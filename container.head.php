<?php
$code=$_GET["code"]; //tb_container의 코드입니다
$list=$_GET["list"]; //tb_list의 코드입니다
$type=$_GET["type"]; //타입값이 넘어오면 처음 만들때 임

$cpage=substr(basename($_SERVER["PHP_SELF"]), 0, strrpos(basename($_SERVER["PHP_SELF"]), "."));
if($cpage!=""){

  if($_GET["type"]!=""){
    $sql="select * from tb_container_page where ctype='$type'";
  }else{
    $sql="select * from tb_container_page where cpage='$cpage'";
  }
  $result=sql_fetch($sql);
  if($result!=""){
    $this_menu=$result["cmenu"]; //어떤메뉴에 속해 있는지
    $this_type=$result["ctype"];
    $this_menufull=$result["cmenufull"]; //
    $this_menudetail=$result["cmenudetail"];
  }
}



if(isset($list)){
  $sql="select * from tb_list where list='$list'";
  $result=sql_fetch($sql);

  $code=$result["code"];
  $listtitle=$result["listtitle"];
  $listcontent=$result["listcontent"];


  $youtube=$result["youtube"];
  $pidx=$result["pidx"];
      $sql1="select *,(select cmenu from tb_container_page where ctype=A.type) as cmenu  from tb_container A where code='$code'";
      $result1=sql_fetch($sql1);
      $this_menu=$result1["cmenu"];
      $this_type=$result1["type"];
      $title=$result1["title"];
      $subtitle=$result1["subtitle"];




  //이 목록에 대한 시험설정이 있는지 검사
  //설정대로 이 목록에 해당하는 문제를 보여주는 처리를 함
  $sqlexam="select * from tb_exam where code='$code' and list='$list'";
  $rsexam=sql_fetch($sqlexam);
  $examcodes=trim($rsexam["examcodes"]);
  $examids=trim($rsexam["examids"]);
  $examgroups=trim($rsexam["examgroups"]);
  $examcondition=$rsexam["examcondition"];

  $examopen=$rsexam["examopen"];
  $examclose=$rsexam["examclose"];
  $examopentime=$rsexam["examopentime"];
  $examclosetime=$rsexam["examclosetime"];
  $examlimit=$rsexam["examlimit"];

  $is_test=$rsexam["is_test"];
  $is_cbt=$rsexam["is_cbt"];
  $is_random=$rsexam["is_random"];


  $showmode="list";

}else if(isset($code)){

  $sql="select *,(select cmenu from tb_container_page where ctype=A.type) as cmenu from tb_container A where code='$code'";

  $result=sql_fetch($sql);
  $this_menu=$result["cmenu"];
  $this_type=$result["type"];

  $title=$result["title"];
  $subtitle=$result["subtitle"];
  $titleimg=$result["titleimg"];
  $imgpath=$result["imgpath"];
  $is_open=$result["is_open"];
  $content=$result["content"];

  //이 코드에 대한 시험설정이 있는지 검사
  //설정대로 이 목록에 해당하는 문제를 보여주는 처리를 함
  $sqlexam="select * from tb_exam where code='$code' and list=''";
  $rsexam=sql_fetch($sqlexam);
  $examcodes=$rsexam["examcodes"];
  $examids=$rsexam["examids"];
  $examgroups=$rsexam["examgroups"];
  $examcondition=$rsexam["examcondition"];

  $examopen=$rsexam["examopen"];
  $examclose=$rsexam["examclose"];
  $examopentime=$rsexam["examopentime"];
  $examclosetime=$rsexam["examclosetime"];
  $examlimit=$rsexam["examlimit"];

  $is_test=$rsexam["is_test"];
  $is_cbt=$rsexam["is_cbt"];
  $is_random=$rsexam["is_random"];


}

if($type=="강좌"){
  $is_title="강좌명";
  //$is_subtitle="";
  $is_content="강좌 설명";
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
      <hr>
      <div class='text-center'>
      <a href='/qview?v=all&code=$code' class='btn btn-secondary btn-sm shadow-sm'>전체 문제풀기</a>
      <a href='/cbt?code=$code' class='btn btn-light btn-sm shadow-sm' target='_blank'>CBT 문제풀기</a>
      </div>
    ";
  }
}

if($type=="도서"){
  $is_title="도서명";
  //$is_subtitle="";
  $is_content="도서 요약";
}

if($is_open==""){$is_open=1;}
?>

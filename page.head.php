<?php
//쿼리스트링은 페이지의 고유번호
//tb_page의 page값을 호출하여 설정값을 불러움
$QS=$_SERVER['QUERY_STRING'];

  $plist=$_GET["plist"]; ////부모리스트
  if($plist!=""){ //부모목록이름
    $sql1="select * from tb_page where list='$plist'";
    $rs1=sql_fetch($sql1);
    $plist_title=$rs1["title"];
  }
  $list=$_GET["list"];

  if( ($list=="") &&( strpos($QS,"=")==false) ){
    $list=$QS;
  }

  if($list!=""){
      $sql="select * from tb_page A where list='$list'";
  }else{
    $sql="select * from tb_page A where pidx=0";  ///최상위 목록
  }
  $rs=sql_fetch($sql);
        if($rs){
            $page_idx=$rs["idx"];
            $page_lvl=$rs["lvl"];

            $page_list=$rs["list"]; //자신고유번호
            $page_type=$rs["type"]; //lvl 1 : 강좌, 자격시험, 코딩 등
              $sql1="select * from tb_page where type='$page_type' and lvl=1";
              $rs1=sql_fetch($sql1);
              $total_type_title=$rs1["title"];
              $total_type=$rs1["list"];

            $page_code=$rs["code"]; //lvl 2 : 파이썬, c, 정보처리기사 등
              $sql2="select * from tb_page where code='$page_code' and lvl=2";
              $rs2=sql_fetch($sql2);
              $total_code_title=$rs2["title"];
              $total_code=$rs2["list"];

            $page_title=trim($rs["title"]);
            $page_titleimg=$rs["titleimg"];
            $page_titleimgpath=$rs["titleimgpath"];
            $page_youtube=$rs["youtube"];
            $page_fullidx=$rs["fullidx"];
            $page_issublist=$rs["issublist"];
            //echo($page_fullidx);
            $tmp0=str_replace("[1]","",$page_fullidx); ///최상위 전체메뉴 제거
            $tmp1=str_replace("][",",",$tmp0);
            $tmp2=str_replace("[","",$tmp1);
            $tmp3=str_replace("]","",$tmp2);

              $sql3="
              select group_concat( concat('<a href=''page?',list,'''>',title,'</a>') ) as fulltitles
              from(
              	select 'g' as g, title, list from tb_page where idx in(".$tmp3.")
              ) A group by g";
              $rs3=sql_fetch($sql3);
              //echo($sql3);
              $page_fulltitles=str_replace(","," > ", $rs3["fulltitles"]);








            $page_content=$rs["content"];
        }

        $this_menu=$total_type_title; //어떤 메뉴를 active 시킬지 설정
?>

<?php include_once('./_common.php');

$edit_list = $_POST["edit_list"];
$mode = $_POST["mode"];

/////// 이 리스트의 type과 code를 불러옴
$sql="select * from tb_page where list='$edit_list'";
$result=sql_fetch($sql);
$edit_type=$result["type"];
$edit_code=$result["code"];
$edit_idx=$result["idx"];

echo($edit_list);

if($mode=="d"){ //삭제

            $chk_idx_a=$_POST['chk_idx'];
            foreach($chk_idx_a as $key => $val){

              //삭제전 idx와 p_idx
              $sql="select idx, pidx, lvl from tb_page where idx=$val and code='$edit_code'";
              echo($sql."<br>");
              $rs=sql_fetch($sql);
              $my_idx=$rs["idx"];
              $my_lvl=$rs["lvl"];
              $my_pidx=$rs["pidx"];

              //나를 pidx로 삼고 있는 자식을 my_pidx로 변경 , lvl을 -1, fullpath에서 [idx]를 제거
              $sql="update tb_page set pidx=$my_pidx where pidx=$my_idx and code='$edit_code'";
              sql_query($sql);
              echo($sql."<br>");

              //나보다 높은 레벨값을 1감소, fullidx 제거
              $sql="update tb_page set lvl=lvl-1, fullidx=replace(fullidx, '[$my_idx]','')  where lvl>$my_lvl and fullidx like '%[$my_idx]%' and code='$edit_code'";
              sql_query($sql);
              echo($sql."<br>");

              //내목록 삭제
              $sql="delete from tb_page where idx=$val and code='$edit_code'";
              sql_query($sql);
              echo($sql."<br>");
            //  sql_query($sql);
            }

            //내 리스트를 삭제하면 tb_qlist목록도 삭제해야함
            //tb_qlist 삭제하면 tb_answerlog도 처리해야함
            //연결되어 있는 문제는 연결링크가 하나도 없으면 question에서 처리

}else{


    //신규 목록 여러줄 입력 부분
    $chk_idx_a=$_POST['chk_idx'];
    if(count($chk_idx_a)==0){$chk_idx_a[0]=$edit_idx;}  //체크된 값이 없으면 현재 idx가 됨

    foreach($chk_idx_a as $key => $val){

                  //체크되어 있거나 기본idx의 정보
                  $sql="select * from tb_page where idx=$val";
                  $result=sql_fetch($sql);
                  $default_pidx=$result["pidx"];
                  $default_lvl=$result["lvl"];
                  $default_fullidx=$result["fullidx"];
                  $default_code=$result["code"];
                  $default_type=$result["type"];


                  $new_title = $_POST['new_title'];
                  if($default_code!="" && $new_title !=""){

                                $a_title = explode("\n", $new_title);

                                for($i=0;$i<count($a_title);$i++){

                                            if($a_title[$i]!=""){

                                              $tmptitle=$a_title[$i];
                                              $rand= strtoupper(substr(uniqid(sha1()),7));
                                              $new_list=strtoupper(date("YmdHis").$rand);

                                                      if(substr($tmptitle, 0, 2) == "\t\t"){ //2단계 들여쓰기 last1_idx가 있다면 그 값을 pidx로 사용
                                                              if($last_idx1!=""){$pidx=$last_idx1;}else{$pidx=$default_pidx;}
                                                              $tmptitle=trim($tmptitle);

                                                              if($default_lvl_2!=""){ $default_lvl_3=$default_lvl_2+1; }
                                                              else{$default_lvl_3=$default_lvl+1; }

                                                              if($default_fullidx_2!=""){ $default_fullidx_3=$default_fullidx_2."[".$pidx."]"; }
                                                              else{$default_fullidx_3=$default_fullidx."[".$pidx."]";}

                                                              $sql = " insert into tb_page(type, code, list, title, pidx, lvl, fullidx)
                                                                      values('$default_type', '$default_code', '$new_list', '$tmptitle', $pidx, $default_lvl_3, '$default_fullidx_3')";
                                                              echo($sql."----3단계<br>");
                                                              $result = sql_query($sql);
                                                              if ($result){$last_idx2 = sql_insert_id();}
                                                      }else if(substr($tmptitle, 0, 1) == "\t"){ //1단계 들여쓰기 last_idx가 있다면 그 값을 pidx로 사용, 없으면 상위 idx 그냥 사용
                                                                if($last_idx!=""){$pidx=$last_idx;}else{$pidx=$default_pidx;}
                                                                $tmptitle=trim($tmptitle);

                                                                if($default_lvl_1!=""){ $default_lvl_2=$default_lvl_1+1; }
                                                                else{$default_lvl_2=$default_lvl+1; }

                                                                if($default_fullidx_1!=""){ $default_fullidx_2=$default_fullidx_1."[".$pidx."]"; }
                                                                else{$default_fullidx_2=$default_fullidx."[".$pidx."]";}

                                                                $sql = " insert into tb_page(type, code, list, title, pidx, lvl, fullidx)
                                                                        values('$default_type', '$default_code', '$new_list', '$tmptitle', $pidx, $default_lvl_2, '$default_fullidx_2')";
                                                                echo($sql."<br>");
                                                                $result = sql_query($sql);
                                                                if ($result){$last_idx1 = sql_insert_id();}
                                                      }else{
                                                                  $pidx=$val; //들여쓰기가 없으면 default_idx 가 pidx가 됨
                                                                  $tmptitle=trim($tmptitle);
                                                                  $default_lvl_1=$default_lvl+1;
                                                                  $default_fullidx_1=$default_fullidx."[".$pidx."]";
                                                                  $sql = " insert into tb_page(type, code, list, title, pidx, lvl, fullidx)
                                                                          values('$default_type', '$default_code', '$new_list', '$tmptitle', $pidx, $default_lvl_1, '$default_fullidx_1')";
                                                                  echo($sql."<br>");
                                                                  $result = sql_query($sql);
                                                                  if ($result){$last_idx = sql_insert_id();$last_idx1="";}
                                                      }
                                          }
                              }
                  }
    }
    //신규 여러줄 입력 부분 종료


    //기존 내용 수정 또는 insert
      $list_a=$_POST['list'];
      $title_a=$_POST['title'];
      $titleorder_a=$_POST['titleorder'];

      $pidx_a=$_POST['pidx'];
      $listorder_a=$_POST['listorder'];

      foreach($list_a as  $key => $val){
            $title=(trim($title_a[$key]));
            $titleorder=(trim($titleorder_a[$key]));

            $listorder=$listorder_a[$key];

            $pidx=$pidx_a[$key];

            if($val==""){
                  if($title!=""){  //제목이 있어야 신규로 insert

                    //부모의 type, code, lvl, edit_fullidx
                    $sql="select * from tb_page where idx=$pidx";
                    echo($sql);
                    $result=sql_fetch($sql);
                    $edit_type=$result["type"];
                    $edit_code=$result["code"];
                    $edit_fullidx=$result["fullidx"];
                    $edit_fullidx .= "[$pidx]";

                    $edit_lvl=$result["lvl"];
                    $edit_lvl=$edit_lvl+1;

                    $rand= strtoupper(substr(uniqid(sha1()),7));
                    $new_list=strtoupper(date("YmdHis").$rand);

                    $sql="insert into tb_page(type, code, list, title, titleorder, pidx, fullidx, lvl) values(
                          '$edit_type', '$edit_code', '$new_list', '$title', '$titleorder', $pidx, '$edit_fullidx', '$edit_lvl')";
                    echo($sql."<br>insert");
                    sql_query($sql);
                  }
            }else{

                  //내원래 lvl, fullidx

                  $sql="select * from tb_page where list='$val'";
                  $result=sql_fetch($sql);
                  $my_idx=$result["idx"];
                  $my_lvl=$result["lvl"];
                  $my_fullidx=$result["fullidx"];

                  echo("<br>원래 : ". $my_lvl . "...." . $my_fullidx);

                  //pidx의 lvl과 fullidx
                  $sql="select * from tb_page where idx='$pidx'";
                  $result=sql_fetch($sql);
                  $p_idx=$result["idx"];
                  $p_lvl=$result["lvl"];
                  $p_fullidx=$result["fullidx"];
                  $re_lvl=$p_lvl+1;
                  $re_fullidx=$p_fullidx."[$pidx]";

                  $sql="update tb_page set title='$title', titleorder='$titleorder', pidx=$pidx, lvl=$re_lvl, fullidx='$re_fullidx' , listorder='$listorder' where list='$val'";
                  echo("<br>update:".$sql);
                  sql_query($sql);
            }
      }



} //삭제가 아닌 조건 종료

goto_url("page_ledit?$edit_list");
?>

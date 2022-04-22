<?php include_once('./_common.php');

$code = $_POST["code"];
$mode = $_POST["mode"];



if($mode=="d"){ //삭제

            $chk_idx_a=$_POST['chk_idx'];
            foreach($chk_idx_a as $key => $val){

              //삭제전 idx와 p_idx
              $sql="select idx, pidx from tb_list where idx=$val and code='$code'";
              echo($sql."<br>");
              $rs=sql_fetch($sql);
              $my_idx=$rs["idx"];
              $my_pidx=$rs["pidx"];

              //나를 pidx로 삼고 있는 자식을 my_pidx로 변경함
              $sql="update tb_list set pidx=$my_pidx where pidx=$my_idx and code='$code'";
              sql_query($sql);
              echo($sql."<br>");

              $sql="delete from tb_list where idx=$val and code='$code'";
              echo($sql."<br>");
              sql_query($sql);
            }

            //내 리스트를 삭제하면 tb_qlist목록도 삭제해야함
            //연결되어 있는 문제는 연결링크가 하나도 없으면 임시폴더에 넣어 둬야함               


}else{

  //신규 목록 입력
  $chk_idx_a=$_POST['chk_idx'];
  if(count($chk_idx_a)==0){$chk_idx_a[0]=0;}

  foreach($chk_idx_a as $key => $val){ //체크된 값이 있으면 이 값 아래에 넣음

                $new_listtitle = $_POST['new_listtitle'];
                if($code!="" && $new_listtitle !=""){
                    $a_listtitle = explode("\n", $new_listtitle);
                    for($i=0;$i<count($a_listtitle);$i++){
                      if($a_listtitle[$i]!=""){
                        $tmplisttitle=$a_listtitle[$i];
                        $rand= strtoupper(substr(uniqid(sha1()),7));
                        $new_list=strtoupper("L".date("YmdHis").$rand);

                        if(substr($tmplisttitle, 0, 2) == "\t\t"){ //2단계 들여쓰기 last1_idx가 있다면 그 값을 pidx로 사용
                              if($last_idx1!=""){$pidx=$last_idx1;}else{$pidx=0;}
                              $tmplisttitle=trim($tmplisttitle);
                              $sql = " insert into tb_list(code, list, listtitle, pidx) values('$code', '$new_list', '$tmplisttitle', $pidx)";
                              echo($sql."<br>");
                              $result = sql_query($sql);
                              if ($result){$last_idx2 = sql_insert_id();}
                      }else if(substr($tmplisttitle, 0, 1) == "\t"){ //1단계 들여쓰기 last_idx가 있다면 그 값을 pidx로 사용
                                if($last_idx!=""){$pidx=$last_idx;}else{$pidx=0;}
                                $tmplisttitle=trim($tmplisttitle);
                                $sql = " insert into tb_list(code, list, listtitle, pidx) values('$code', '$new_list', '$tmplisttitle', $pidx)";
                                echo($sql."<br>");
                                $result = sql_query($sql);
                                if ($result){$last_idx1 = sql_insert_id();}
                      }else{
                                  $pidx=$val; //없으면 0이 됨
                                  $tmplisttitle=trim($tmplisttitle);
                                  $sql = " insert into tb_list(code, list, listtitle, pidx) values('$code', '$new_list', '$tmplisttitle', $pidx)";
                                  echo($sql."<br>");
                                  $result = sql_query($sql);
                                  if ($result){$last_idx = sql_insert_id();$last_idx1="";}
                      }
                    }
                  }
                }
  }


            //기존 내용 수정 또는 insert
            $list_a=$_POST['list'];
            $listtitle_a=$_POST['listtitle'];
            $pidx_a=$_POST['pidx'];

            foreach($list_a as  $key => $val){
              $listtitle=(trim($listtitle_a[$key]));
              $pidx=$pidx_a[$key];

              if($val==""){
                if($listtitle!=""){
                  $rand= strtoupper(substr(uniqid(sha1()),7));
                  $new_list=strtoupper("L".date("YmdHis").$rand);

                  $sql="insert into tb_list(code, list, listtitle, pidx) values(
                        '$code', '$new_list', '$listtitle', $pidx)";
                  echo($sql."<br>신규!!!!!!!");
                  sql_query($sql);
                }
              }else{
                $sql="update tb_list set listtitle='$listtitle', pidx=$pidx where list='$val'";
                echo($sql."<br>업뎃체크");
                sql_query($sql);
              }
            }
            //goto_url("ledit.php?code=$code");

            ///////
}

goto_url("ledit.php?code=$code");
?>

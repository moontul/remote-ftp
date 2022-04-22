<?php include_once('./_common.php');

  $mode=$_POST["mode"]; //삭제시 d, 드래그앤드롭 dragdrop


  $list=$_POST["list"];
  $type=$_POST["type"];
  $code=$_POST["code"];

  $title=$_POST["title"];
  $titleorder=$_POST["titleorder"];

  $titleicon=addslashes(trim($_POST["titleicon"]));
  $titleimg=$_POST["titleimg"];
  $titleimgpath=$_POST["titleimgpath"];

  $content=(trim($_POST["content"]));
  $isopen=$_POST["isopen"];

  $fullidx=$_POST["fullidx"];

  $youtube=$_POST["youtube"];
  $issublist=$_POST["issublist"];
  $pageid=$_POST["pageid"];

  $pidx=$_POST["pidx"];
  if($pidx==""){$pidx=0;}



  //편집모드
  //$pangpang_write=$_POST["pangpang_write"];

  //기존파일 삭제부분
  $filedel_a=$_POST["filedel"];
  foreach($filedel_a as $key => $val){
    //파일
    if ($val!=""){
      $sql="select * from tb_page_files where idx=$val";
      $rs=sql_fetch($sql);
      $filepath=$rs["filepath"];
      $filename=$rs["filename"];

      @unlink(G5_DATA_PATH.$filepath.$filename);
      $sql="delete from tb_page_files where idx=$val and list='$list'";
      sql_query($sql);
    }
  }


if($mode=="d"){

    //목록삭제 작업1 : 하부리스트의 pidx를 나의 pidx로 연결해줌
    $sql="select idx, pidx, type, code from tb_page where list='$list'";
    echo("<br>삭제작업을 위한 내 쿼리---->".$sql."<br>");
    $result=sql_fetch($sql);
      $d_pidx=$result["pidx"];
      $d_idx=$result["idx"];
      $d_type=$result["type"];
      $d_code=$result["code"];

    $sql="update tb_page set pidx=$d_pidx where pidx=$d_idx";
    echo("<br>내 바로 아래 자식의 pidx을 나의 pidx로 변경해줌---->".$sql."<br>");
    sql_query($sql);
    //echo($sql);
    $sql="update tb_page set lvl=lvl-1, fullidx=replace(fullidx, '[$d_idx]','') where fullidx like '%[$d_idx]%'";
    echo("하위목록에서 내 존재를 지우고 lvl-1해줌<br>".$sql."<br>");
    sql_query($sql);

    //목록삭제 작업2 :내용에 있는 이미지를 삭제

    //목록삭제 작업3 :첨부파일 삭제 tb_page_files

    //목록삭제 작업4 :연결되어 있는 문제 tb_question 처리

    $sql="delete from tb_page where list='$list'";
    sql_query($sql);
    echo("최종삭제:".$sql);

    $sql="select list from tb_page where idx=$d_pidx";
    $result=sql_fetch($sql);
    $p_list=$result["list"];

    goto_url("page?$p_list"); //내가 삭제되었으므로 내 부모목록으로 이동

}else{



          if($mode=="dragdrop"){ //드래그드롭일경 child_list가 현재 list가 됨

            $child_list=$_POST["child_list"];
            $list=$child_list;
            $sql="select * from tb_page where list='$child_list'";
            $result=sql_fetch($sql);
            $code=$result["code"];
            $type=$result["type"];
            $lvl=$result["lvl"];
            $fullidx=$result["fullidx"];

            $parent_list=$_POST["parent_list"];
            $sql="select * from tb_page where list='$parent_list'";
            $result=sql_fetch($sql);
            $pidx=$result["idx"];

            echo("<br>자기:".$list."부모:".$parent_list."<br>");

            echo("<br>dragdrop부모키:".$pidx."<br>");

          }

          //부모값을 쿠키에 저장해둠 - 최상위는 저장하지 않음
          if($pidx!="1"){
            setcookie("PANGPANG_PIDX", $pidx, 0, '/');
          }


          if($list==""){

                            //다른곳에서 pageid를 사용하는지 검사
                            if($pageid!=""){
                              $psql="select count(*) as cnt from tb_page where pageid='$pageid'";
                              $prs=sql_fetch($psql);
                              if($prs){
                                if($prs["cnt"]>0){
                                  echo("<script>alert('다른곳에서 페이지ID를 사용하고 있어요');history.back()</script>");
                                  exit();
                                }
                              }
                            }


                            if($type==0){ ////////////최상위 구분값
                              $rand = strtoupper(substr(uniqid(sha1()),7));
                              $type= date("YmdHis").$rand;
                            }
                            if($lvl==1){  /////////lvl1값일 경우 code=0
                              $code= "0";
                            }elseif($lvl==2){  /////////lvl2값일 경우 code 고유값으로
                              $rand = strtoupper(substr(uniqid(sha1()),7));
                              $code= date("YmdHis").$rand;
                            }

                            //신규로 페이지 만듦
                            //고유코드 연월일시분초 13중 뒤 6자리
                             $rand = strtoupper(substr(uniqid(sha1()),7));
                             $list= date("YmdHis").$rand;

                             $sql="insert into tb_page(list, type, code, pidx, lvl, title, titleorder, titleicon
                             , content, youtube, isopen, fullidx, issublist, pageid)
                             values('$list','$type','$code', '$pidx', '$lvl', '$title', '$titleorder', '$titleicon'
                             ,'$content', '$youtube', '$isopen', '$fullidx', '$issublist', '$pageid')";
                             sql_query($sql);
                             echo($sql);


          }else{ ///////////////////////// 업데이트

                                  //다른곳에서 pageid를 사용하는지 검사
                                  if($pageid!=""&&$mode!="dragdrop"){
                                    $psql="select count(*) as cnt from tb_page where pageid='$pageid' and list!='$list'";
                                    $prs=sql_fetch($psql);
                                    if($prs){
                                      if($prs["cnt"]>0){
                                        echo("<script>alert('다른곳에서 페이지ID를 사용하고 있어요');history.back()</script>");
                                        exit();
                                      }
                                    }
                                  }




                  if($pidx>0){

                    //pidx의 값을 가져와서 내 값과 하위 값을 수정함
                    $sql="select title, idx from tb_page where list='$list'";
                    $result=sql_fetch($sql);
                    $my_idx=$result["idx"];
                    $my_title=$result["title"];
                    echo($my_title.$my_idx."=내 idx--------<br>");
                    echo("<br>-----pidx 분석 시작 --------<br>");
                      $sql="select idx, type, code, pidx, lvl, fullidx from tb_page where idx=$pidx";
                      echo("부모정보쿼리 : ".$sql."<br>");
                      $result=sql_fetch($sql);
                      $parent_idx=$result["idx"];
                      $parent_type=$result["type"];
                      $parent_code=$result["code"];
                      $parent_lvl=$result["lvl"];
                      $parent_fullidx=$result["fullidx"];

                      echo("부모정보 : parent_type->".$parent_type."<br>");
                      echo("부모정보 : parent_code->".$parent_code."<br>");
                      echo("부모정보 : parent_lvl->".$parent_lvl."<br>");
                      echo("부모정보 : parent_fullidx->".$parent_fullidx."<br>");
                      //type 일치
                      $calc_type=$parent_type;
                      //code가 0이면 신규 code생성
                      if($parent_code==0){
                        echo("<br>------새로운 코드를 만들어야함-----<br>");
                        $rand = strtoupper(substr(uniqid(sha1()),7));
                        $new_code= date("YmdHis").$rand;
                        $calc_code=$new_code;
                        echo($calc_code."<---새로운 코드<br>");
                      }else{
                        $calc_code=$parent_code;
                      }
                      //lvl +1
                      echo("내 레벨>".$lvl."<br>");
                      $calc_lvl=((int)$parent_lvl)+1;
                      $gap_lvl=((int)$calc_lvl)-((int)$lvl); ///내 레벨과의 갭

                      echo("변경되는 내 레벨 : calc_lvl->".$calc_lvl."<br>");
                      echo("변경되면 생기는 레벨과 갭(하위목록에 추가) : gap_lvl->".$gap_lvl."<br>");

                      //fullidx = parent의 fullidx + parent의 idx
                      $calc_fullidx=$parent_fullidx."[".$parent_idx."]";
                      echo("원래 fullidx : fullidx->".$fullidx."<br>");
                      echo("변경되는 fullidx : calc_lvl->".$calc_fullidx."<br>");

                      //나의 fullidx를 갖고 있던 모든 하위 list
                      $sql="select title, idx, type, code, pidx, lvl, fullidx from tb_page where fullidx like '%[$my_idx]%' and fullidx like '$fullidx%' and fullidx != '$fullidx'";
                      echo("<br>나의 fullidx 갖고있던 하위List : ".$sql."<br>");
                      $result=sql_query($sql);
                      for($xx=0;$rs=sql_fetch_array($result);$xx++){
                        $child_lvl=((int)$rs["lvl"])+((int)$gap_lvl);
                        $child_type=$calc_type;
                        $child_code=$calc_code;
                        echo($rs["title"]."<---자식원래 레벨 --> ".$rs["lvl"]."<br>");
                        echo($rs["title"]."<---자식레벨 child_lvl --> ".$child_lvl."<br>");
                                                //////////$child_fullidx=$calc_fullidx."[".$rs["pidx"]."]"; fullidx는 모두 재정렬 필요하겠네....
                        $sqlu="update tb_page set lvl='$child_lvl', type='$child_type', code='$child_code' where idx=".$rs['idx'];
                        echo("내 자식목록의 type, code, lvl 수정-->".$sqlu."<br>");
                        sql_query($sqlu);
                      }

                      $type=$calc_type;
                      $code=$calc_code;
                      $lvl=$calc_lvl;
                      $fullidx=$calc_fullidx;
                  }



            if($mode=="dragdrop"){
              $sql="update tb_page set
               code='$code'
              , type='$type'
              , pidx='$pidx'
              , lvl='$lvl'
              , fullidx='$fullidx'
              where list='$list'";
            }else{

                $sql="update tb_page set
                title='$title'
                , titleorder='$titleorder'
                , titleicon='$titleicon'
                , titleimg='$titleimg'
                , titleimgpath='$titleimgpath'
                , content='$content'
                , code='$code'
                , type='$type'
                , youtube='$youtube'
                , isopen='$isopen'
                , issublist='$issublist'
                , pidx='$pidx'
                , lvl='$lvl'
                , fullidx='$fullidx'
                , pageid='$pageid'
                where list='$list'";
            }
            sql_query($sql);
            echo("<br>내 업데이트 : ".$sql."<br><br>");

          }


          //fullidx 재정렬
          echo("<br><br>------------ fullidx 재정렬 --------------<br>");
          $sql="select * from tb_page where type='$type' and code='$code' and lvl>=2 order by lvl";
          echo($sql."<br><br>");
          $result=sql_query($sql);
          for($zz=0;$rs=sql_fetch_array($result);$zz++){

              if($rs["lvl"]==2){
                  echo("레벨2단계 부모정보------<br>");
                  $sql1="select idx, pidx from tb_page where idx=".$rs['pidx'];
                  echo($sql1."<-----레벨2단계 부모쿼리<br>");
                  $result1=sql_fetch($sql1);
                  $this_fullidx="[".$result1["pidx"]."]"."[".$rs["pidx"]."]";
                  echo($this_fullidx."<-----레벨2단계 fullidx<br>");
                $sql2="update tb_page set fullidx='$this_fullidx' where idx=".$rs['idx'];
                sql_query($sql2);
                echo($sql2."<-----레벨2단계 업데이트완료<br>");
              }else{
                  echo($rs["lvl"]."<--레벨3단계 이상 부모정보------<br>");
                  $sql1="select idx, pidx,fullidx from tb_page where idx=".$rs['pidx'];
                  echo($sql1."<-----레벨3단계이상 부모쿼리<br>");
                  $result1=sql_fetch($sql1);
                  $this_fullidx=$result1["fullidx"]."[".$rs["pidx"]."]";
                  echo($this_fullidx."<-----레벨3단계 이상 fullidx<br>");
                $sql2="update tb_page set fullidx='$this_fullidx' where idx=".$rs['idx'];
                echo($sql2."<-----레벨3단계 이상 업데이트완료<br>");
                sql_query($sql2);
                echo($sql2."<br>");
              }
          }




          if($mode!="dragdrop"){
                    //대표이미지 시작
                    $titleimg_del=$_POST["titleimg_del"];  //기존 타이틀이미지 경로가 들어있음
                    if ($titleimg_del){
                      @unlink(G5_DATA_PATH.$titleimg_del);
                      $titleimg="";
                      $titleimgpath="";
                    }

                    if ($_FILES['titleimg_up']['name'])
                    {
                      //기존파일 없고 새파일 업로드경우
                      //기존파일 있고 새파일 업로드경우 = 기존파일 삭제하고 새로운 파일로 교체
                      //  @unlink(G5_DATA_PATH.$imgpath.$titleimg);
                      //기존파일 삭제경우

                        //data 폴더아래cdata폴더 생성
                        @mkdir(G5_DATA_PATH."/cdata", G5_DIR_PERMISSION);
                        @chmod(G5_DATA_PATH."/cdata", G5_DIR_PERMISSION);
                        //data 폴더아래qdata폴더 연월폴더 생성
                        @mkdir(G5_DATA_PATH."/cdata/".date("Ym"), G5_DIR_PERMISSION);
                        @chmod(G5_DATA_PATH."/cdata/".date("Ym"), G5_DIR_PERMISSION);

                        $file_ext = pathinfo($_FILES['titleimg_up']['name'], PATHINFO_EXTENSION);
                        $titleimg=$list.".".$file_ext;
                        $titleimgpath="/cdata/".date("Ym")."/";
                        $dest_path = G5_DATA_PATH.$titleimgpath.$titleimg;

                        move_uploaded_file($_FILES['titleimg_up']['tmp_name'], $dest_path);
                        chmod($dest_path, G5_FILE_PERMISSION);
                    }
                    //대표이미지 정보 업데이트
                    $sql="update tb_page set titleimg='$titleimg', titleimgpath='$titleimgpath' where list='$list'";
                    //sql_query($sql);
                    //대표이미지 종료


                    //첨부파일 신규 업로드 부분 = 파일이름은 고유번호로 처리하고, 원래이름을 디비에 저장함
                    if ($_FILES['fileup']['name'])
                    {
                        //data 폴더아래cdata폴더 생성 : cdata = contentdata
                        @mkdir(G5_DATA_PATH."/cdata", G5_DIR_PERMISSION);
                        @chmod(G5_DATA_PATH."/cdata", G5_DIR_PERMISSION);
                        //data 폴더아래cdata폴더 연월폴더 생성
                        @mkdir(G5_DATA_PATH."/cdata/".date("Ym"), G5_DIR_PERMISSION);
                        @chmod(G5_DATA_PATH."/cdata/".date("Ym"), G5_DIR_PERMISSION);

                        //고유코드 연월일시분초 13중 뒤 6자리
                        $rand = strtoupper(substr(uniqid(sha1()),7));
                        $fcode= "F".date("YmdHis").$rand;
                        $file_ext = pathinfo($_FILES['fileup']['name'], PATHINFO_EXTENSION);
                        $filename=$fcode.".".$file_ext;
                        $fileorgname=$_FILES['fileup']['name'];
                        $filepath="/cdata/".date("Ym")."/";
                        $dest_path = G5_DATA_PATH.$filepath.$filename;

                        @move_uploaded_file($_FILES['fileup']['tmp_name'], $dest_path);
                        @chmod($dest_path, G5_FILE_PERMISSION);

                        //
                        $sql="insert into tb_page_files(list, filename, fileorgname, filepath)
                        values('$list','$filename', '$fileorgname','$filepath')";
                        //sql_query($sql);
                    }
          } //dragdrop이 아닐경우
                                                //goto_url("page_write?list=$list&edit_list=$list");

        if($mode!="dragdrop"){
          goto_url("page?$list");
        }


                                                        /*
                                                                  if($pangpang_write=="checked"){
                                                                    setcookie("PANGPANG_WRITE", $pangpang_write, 0, '/');


                                                                  }else{
                                                                    unset($_COOKIE["PANGPANG_WRITE"]);setcookie('PANGPANG_WRITE', '', time() - 3600, '/');
                                                                    goto_url("/view?list=$list");

                                                                  }
                                                        */




} ///삭제 또는 입력수정 조건 종료

?>

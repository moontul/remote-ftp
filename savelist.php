<?php include_once('./_common.php');

  $mode=$_POST["mode"];

  $code=$_POST["code"];
  $list=$_POST["list"];
  $listtitle=$_POST["listtitle"];
  $listcontent=(trim($_POST["listcontent"]));
  $youtube=$_POST["youtube"];

  $pidx=$_POST["pidx"];
  if($pidx==""){$pidx=0;}

  $pangpang_write=$_POST["pangpang_write"];

  //기존파일 삭제부분
  $filedel_a=$_POST["filedel"];
  foreach($filedel_a as $key => $val){
    //파일
    if ($val!=""){
      $sql="select * from tb_list_files where idx=$val";
      $rs=sql_fetch($sql);
      $filepath=$rs["filepath"];
      $filename=$rs["filename"];

      @unlink(G5_DATA_PATH.$filepath.$filename);
      $sql="delete from tb_list_files where idx=$val and list='$list'";
      sql_query($sql);
    }
  }



if($mode=="d"){

    //목록삭제 작업1 : 하부리스트의 pidx를 나의 pidx로 연결해줌
    $sql="select idx, pidx from tb_list where list='$list'";
    $result=sql_fetch($sql);
      $d_pidx=$result["pidx"];
      $d_idx=$result["idx"];
    $sql="update tb_list set pidx=$d_pidx where pidx=$d_idx";
    sql_query($sql);
    //echo($sql);

    //목록삭제 작업2 :내용에 있는 이미지를 삭제

    //목록삭제 작업3 :첨부파일 삭제 tb_list_files

    //목록삭제 작업4 :연결되어 있는 문제 tb_question 처리

    $sql="delete from tb_list where list='$list'";
    sql_query($sql);
    goto_url("/view?code=$code");

}else{

  if($pidx>0){
    $sql="select listorder+1 as listorder from tb_list where idx=$pidx";
    $result=sql_fetch($sql);
    $listorder=$result["listorder"];
  }else{$listorder=0;}

  if($list==""){
    //고유코드 연월일시분초 13중 뒤 6자리
     $rand = strtoupper(substr(uniqid(sha1()),7));
     $list= "L".date("YmdHis").$rand;

     $sql="insert into tb_list(code, list, listtitle, listcontent, youtube, pidx, listorder)
     values('$code','$list','$listtitle','$listcontent', '$youtube', $pidx, $listorder)";
     sql_query($sql);
    echo($sql);

  }else{

    $sql="update tb_list set
    listtitle='$listtitle'
    , listcontent='$listcontent'
    , youtube='$youtube'
    , pidx=$pidx
    , listorder=$listorder
    where list='$list'";
    sql_query($sql);
    echo($sql);
  }



          //파일 신규 업로드 부분
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
              $sql="insert into tb_list_files(list, filename, fileorgname, filepath)
              values('$list','$filename', '$fileorgname','$filepath')";
              sql_query($sql);
          }




          if($pangpang_write=="checked"){
            setcookie("PANGPANG_WRITE", $pangpang_write, 0, '/');
            goto_url("/write?list=$list");

          }else{
            unset($_COOKIE["PANGPANG_WRITE"]);setcookie('PANGPANG_WRITE', '', time() - 3600, '/');
            goto_url("/view?list=$list");

          }





}

?>

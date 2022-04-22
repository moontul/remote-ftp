<?php include_once('./_common.php');

  $code=$_POST["code"];
  $type=$_POST["type"];
  $title=$_POST["title"];
  $subtitle=$_POST["subtitle"];

  $titleimg=$_POST["titleimg"];
  $titleimg_del=$_POST["titleimg_del"];
  $imgpath=$_POST["imgpath"];

  $content=$_POST["content"];
  $is_open=$_POST["is_open"];

  $mode=$_POST["mode"];

if($mode=="d"){

  //대표이미지 삭제
  $sql="select * from tb_container where code='$code'";
  $rs=sql_fetch($sql);
  @unlink(G5_DATA_PATH.$rs["imgpath"].$rs["titleimg"]);

  //목록문제 삭제
  $sql="delete from tb_qlist where code='$code'";
  sql_query($sql);

  //목록 삭제
  $sql="delete from tb_list where code='$code'";
  sql_query($sql);
  //목록에 연결되어 있는 파일 삭제해야함

  //목록내부에 삽입된 이미지등 파일 삭제해야함

  //목록에 연결되어 있는 문제는 어떻게 할 것인가 = 관리자페이지 등에서 작업 필요

  //컨테이너 삭제
  $sql="delete from tb_container where code='$code'";
  sql_query($sql);

  if($type=="강좌"){
    goto_url("/subject");
  }
  if($type=="자격시험"){
    goto_url("/license");
  }
  if($type=="도서"){
    goto_url("/book");
  }

}else{


  if($code==""){
    //고유코드 연월일시분초 13중 뒤 6자리
     $rand = strtoupper(substr(uniqid(sha1()),7));
     $code= "C".date("YmdHis").$rand;


     //파일 업로드 부분
     $titleimg="";
     if ($_FILES['titleimg']['name'])
     {
         //data 폴더아래qdata폴더 생성
         @mkdir(G5_DATA_PATH."/cdata", G5_DIR_PERMISSION);
         @chmod(G5_DATA_PATH."/cdata", G5_DIR_PERMISSION);
         //data 폴더아래qdata폴더 연월폴더 생성
         @mkdir(G5_DATA_PATH."/cdata/".date("Ym"), G5_DIR_PERMISSION);
         @chmod(G5_DATA_PATH."/cdata/".date("Ym"), G5_DIR_PERMISSION);

         $file_ext = pathinfo($_FILES['titleimg']['name'], PATHINFO_EXTENSION);
         $titleimg=$qcode.".".$file_ext;
         $imgpath="/cdata/".date("Ym")."/";
         $dest_path = G5_DATA_PATH.$imgpath.$titleimg;

         @move_uploaded_file($_FILES['titleimg']['tmp_name'], $dest_path);
         @chmod($dest_path, G5_FILE_PERMISSION);
     }


     $sql="insert into tb_container(code, type, title, subtitle, titleimg, imgpath, content, is_open) values(
       '$code','$type','$title','$subtitle','$titleimg','$imgpath','$content', $is_open)";
     sql_query($sql);



  }else{


      //파일
      $titleimg_del=$_POST["titleimg_del"];  //기존 문제이미지삭제
      if ($titleimg_del){
        @unlink(G5_DATA_PATH.$titleimg_del);
        $titleimg="";
        $imgpath="";
      }

      if ($_FILES['titleimg_up']['name'])
      {
        //기존파일 없고 새파일 업로드경우
        //기존파일 있고 새파일 업로드경우 = 기존파일 삭제하고 새로운 파일로 교체
          @unlink(G5_DATA_PATH.$imgpath.$titleimg);
        //기존파일 삭제경우

          //data 폴더아래cdata폴더 생성
          @mkdir(G5_DATA_PATH."/cdata", G5_DIR_PERMISSION);
          @chmod(G5_DATA_PATH."/cdata", G5_DIR_PERMISSION);
          //data 폴더아래qdata폴더 연월폴더 생성
          @mkdir(G5_DATA_PATH."/cdata/".date("Ym"), G5_DIR_PERMISSION);
          @chmod(G5_DATA_PATH."/cdata/".date("Ym"), G5_DIR_PERMISSION);

          $file_ext = pathinfo($_FILES['titleimg_up']['name'], PATHINFO_EXTENSION);
          $titleimg=$code.".".$file_ext;
          $imgpath="/cdata/".date("Ym")."/";
          $dest_path = G5_DATA_PATH.$imgpath.$titleimg;

          move_uploaded_file($_FILES['titleimg_up']['tmp_name'], $dest_path);
          chmod($dest_path, G5_FILE_PERMISSION);
      }

    $sql="update tb_container set
    type='$type'
    ,title='$title'
    ,subtitle='$subtitle'
    ,titleimg='$titleimg'
    ,imgpath='$imgpath'
    ,content='$content'
    ,is_open='$is_open'
    where code='$code'";
    sql_query($sql);
  }
  goto_url("/view?code=$code");
}
?>

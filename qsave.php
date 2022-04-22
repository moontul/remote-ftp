<?php include_once('./_common.php');

  $mode=$_POST["mode"];
  $code=$_POST["code"];
  $list=$_POST["list"];

  $isopen=$_POST["isopen"];
  $qcode=$_POST["qcode"];
  $copyqcode=$_POST["copyqcode"];

  $qnum=$_POST["qnum"];  //문제번호
  $qtype=$_POST["qtype"];  //문제유형
  $qtext=trim($_POST["qtext"]);
  $qtextsub=trim($_POST["qtextsub"]);

  $qimg=$_POST["qimg"];  //기존 문제 이미지
  $imgpath=$_POST["imgpath"];  //기존 문제 이미지 경로

  $is_compiler=$_POST["is_compiler"];
  $qcompilecode=trim($_POST["qcompilecode"]);

  $qm1text=trim($_POST["qm1text"]);
  $qm2text=trim($_POST["qm2text"]);
  $qm3text=trim($_POST["qm3text"]);
  $qm4text=trim($_POST["qm4text"]);
  $qm5text=trim($_POST["qm5text"]);

  $qm1correct=$_POST["qm1correct"];
  $qm2correct=$_POST["qm2correct"];
  $qm3correct=$_POST["qm3correct"];
  $qm4correct=$_POST["qm4correct"];
  $qm5correct=$_POST["qm5correct"];

  $qm1img=$_POST["qm1img"];  //기존 보기1 이미지
  $qm2img=$_POST["qm2img"];  //기존 보기2 이미지
  $qm3img=$_POST["qm3img"];  //기존 보기3 이미지
  $qm4img=$_POST["qm4img"];  //기존 보기4 이미지
  $qm5img=$_POST["qm5img"];  //기존 보기5 이미지

  $qanswer=trim($_POST["qanswer"]); //주관식
  $qessay=trim($_POST["qessay"]); //서술식

  $qexplain=trim($_POST["qexplain"]);
  $qyoutube=trim($_POST["qyoutube"]);

  $merrill=$_POST["merrill"];
  if($merrill!=""){
		$a_merrill=explode("X", $merrill);
		$merrillx=$a_merrill[0];
		$merrilly=$a_merrill[1];
	}

  $qlevel=$_POST["qlevel"];
  $qimportance=$_POST["qimportance"];

if($mode=="d"){
  /* 문제삭제 */

    $sql="delete from tb_qlist where qcode='$qcode'";
    sql_query($sql);
    $sql="delete from tb_question where qcode='$qcode'";
    sql_query($sql);

    goto_url("/qview?code=$code&list=$list");

}else{


  if($qcode==""){
    //고유코드 연월일시분초 13중 뒤 6자리
     $rand = strtoupper(substr(uniqid(sha1()),7));

     $qcode= "Q".date("YmdHis").$rand;

          //파일 업로드 부분
          $qimg="";
          $imgpath="";
          if ($_FILES['qimgup']['name'])
          {
              //data 폴더아래qdata폴더 생성
              @mkdir(G5_DATA_PATH."/qdata", G5_DIR_PERMISSION);
              @chmod(G5_DATA_PATH."/qdata", G5_DIR_PERMISSION);
              //data 폴더아래qdata폴더 연월폴더 생성
              @mkdir(G5_DATA_PATH."/qdata/".date("Ym"), G5_DIR_PERMISSION);
              @chmod(G5_DATA_PATH."/qdata/".date("Ym"), G5_DIR_PERMISSION);

              $file_ext = pathinfo($_FILES['qimgup']['name'], PATHINFO_EXTENSION);
              $qimg=$qcode.".".$file_ext;
              $imgpath="/qdata/".date("Ym")."/";
              $dest_path = G5_DATA_PATH.$imgpath.$qimg;

              @move_uploaded_file($_FILES['qimgup']['tmp_name'], $dest_path);
              @chmod($dest_path, G5_FILE_PERMISSION);
          }

          //보기파일 업로드 부분
          $qm1img=$qm2img=$qm3img=$qm4img=$qm5img="";
          for($x=1;$x<=5;$x++){
              $qmimg="";
              //$imgpath="";
              if ($_FILES['qm'.$x.'imgup']['name'])
              {
                  //data 폴더아래qdata폴더 생성
                  @mkdir(G5_DATA_PATH."/qdata", G5_DIR_PERMISSION);
                  @chmod(G5_DATA_PATH."/qdata", G5_DIR_PERMISSION);
                  //data 폴더아래qdata폴더 연월폴더 생성
                  @mkdir(G5_DATA_PATH."/qdata/".date("Ym"), G5_DIR_PERMISSION);
                  @chmod(G5_DATA_PATH."/qdata/".date("Ym"), G5_DIR_PERMISSION);

                  $file_ext = pathinfo($_FILES['qm'.$x.'imgup']['name'], PATHINFO_EXTENSION);
                  $qmimg=$qcode."_".$x.".".$file_ext;
                  $imgpath="/qdata/".date("Ym")."/";
                  $dest_path = G5_DATA_PATH.$imgpath.$qmimg;

                  @move_uploaded_file($_FILES['qm'.$x.'imgup']['tmp_name'], $dest_path);
                  @chmod($dest_path, G5_FILE_PERMISSION);

                  ${"qm".$x."img"}=$qmimg;
              }
          }

          $sql="insert into tb_question(qcode
               , isopen , qnum, qtype
               , qtext, qtextsub, qimg, imgpath
               , is_compiler, qcompilecode
               , qm1text, qm2text, qm3text, qm4text, qm5text
               , qm1img, qm2img, qm3img, qm4img, qm5img
               , qm1correct, qm2correct, qm3correct, qm4correct, qm5correct
               , qanswer, qessay
               , qexplain, qyoutube
               , merrillx, merrilly
               , qlevel, qimportance
               , copyqcode
               )
               values('$qcode'
               ,'$isopen','$qnum','$qtype'
               ,'$qtext','$qtextsub', '$qimg', '$imgpath'
               ,'$is_compiler','$qcompilecode'
               ,'$qm1text','$qm2text','$qm3text','$qm4text','$qm5text'
               ,'$qm1img','$qm2img','$qm3img','$qm4img','$qm5img'
               ,'$qm1correct','$qm2correct','$qm3correct','$qm4correct','$qm5correct'
               ,'$qanswer','$qessay'
               ,'$qexplain','$qyoutube'
               ,'$merrillx','$merrilly'
               ,'$qlevel','$qimportance'
               ,'$copyqcode'
               )";



     sql_query($sql);
     echo($sql."<br>");




     //문제와 목록 매칭 테이블에도 insert???????
     $sql="insert into tb_qlist(code, qnum, list, qcode) values('$code','$qnum','$list','$qcode')";
     sql_query($sql);
     echo($sql."<br>");

     //문제와 목록 매칭 테이블에도 insert???????
     $sql="insert into tb_pageq(list, qcode) values('$list','$qcode')";
     sql_query($sql);
     echo($sql."<br>");


  }else{


    //파일
    $qimgdel=$_POST["qimgdel"];  //기존 문제이미지삭제
    if ($qimgdel){
      @unlink(G5_DATA_PATH.$qimgdel);
      $qimg="";
      $imgpath="";
    }

    for($x=1;$x<=5;$x++){
      $qimgdel=$_POST["qm".$x."imgdel"];  //기존 문제이미지삭제
      if ($qimgdel){
        @unlink(G5_DATA_PATH.$qimgdel);
        ${"qm".$x."img"}="";
      }
    }

    if ($_FILES['qimgup']['name'])
    {
      //기존파일 없고 새파일 업로드경우
      //기존파일 있고 새파일 업로드경우 = 기존파일 삭제하고 새로운 파일로 교체
        @unlink(G5_DATA_PATH.$imgpath.$qimg);
      //기존파일 삭제경우

        //data 폴더아래qdata폴더 생성
        @mkdir(G5_DATA_PATH."/qdata", G5_DIR_PERMISSION);
        @chmod(G5_DATA_PATH."/qdata", G5_DIR_PERMISSION);
        //data 폴더아래qdata폴더 연월폴더 생성
        @mkdir(G5_DATA_PATH."/qdata/".date("Ym"), G5_DIR_PERMISSION);
        @chmod(G5_DATA_PATH."/qdata/".date("Ym"), G5_DIR_PERMISSION);

        $file_ext = pathinfo($_FILES['qimgup']['name'], PATHINFO_EXTENSION);
        $qimg=$qcode.".".$file_ext;
        $imgpath="/qdata/".date("Ym")."/";
        $dest_path = G5_DATA_PATH.$imgpath.$qimg;

        move_uploaded_file($_FILES['qimgup']['tmp_name'], $dest_path);
        chmod($dest_path, G5_FILE_PERMISSION);

    }
    //보기파일 업로드 부분
    //$qm1img=$qm2img=$qm3img=$qm4img=$qm5img="";
    for($x=1;$x<=5;$x++){
        $qmimg="";
        //$imgpath="";
        if ($_FILES['qm'.$x.'imgup']['name'])
        {
            //data 폴더아래qdata폴더 생성
            @mkdir(G5_DATA_PATH."/qdata", G5_DIR_PERMISSION);
            @chmod(G5_DATA_PATH."/qdata", G5_DIR_PERMISSION);
            //data 폴더아래qdata폴더 연월폴더 생성
            @mkdir(G5_DATA_PATH."/qdata/".date("Ym"), G5_DIR_PERMISSION);
            @chmod(G5_DATA_PATH."/qdata/".date("Ym"), G5_DIR_PERMISSION);

            $file_ext = pathinfo($_FILES['qm'.$x.'imgup']['name'], PATHINFO_EXTENSION);
            $qmimg=$qcode."_".$x.".".$file_ext;
            $imgpath="/qdata/".date("Ym")."/";
            $dest_path = G5_DATA_PATH.$imgpath.$qmimg;

            @move_uploaded_file($_FILES['qm'.$x.'imgup']['tmp_name'], $dest_path);
            @chmod($dest_path, G5_FILE_PERMISSION);

            ${"qm".$x."img"}=$qmimg;
        }
    }

    $sql="update tb_question set
      isopen='$isopen', qnum='$qnum', qtype='$qtype'
      ,qtext='$qtext',qtextsub='$qtextsub'
      ,qimg='$qimg', imgpath='$imgpath'
      ,is_compiler='$is_compiler', qcompilecode='$qcompilecode'
      ,qm1text='$qm1text',qm1img='$qm1img',qm1correct='$qm1correct'
      ,qm2text='$qm2text',qm2img='$qm2img',qm2correct='$qm2correct'
      ,qm3text='$qm3text',qm3img='$qm3img',qm3correct='$qm3correct'
      ,qm4text='$qm4text',qm4img='$qm4img',qm4correct='$qm4correct'
      ,qm5text='$qm5text',qm5img='$qm5img',qm5correct='$qm5correct'
      ,qanswer='$qanswer',qessay='$qessay'
      ,qexplain='$qexplain',qyoutube='$qyoutube'
      ,merrillx='$merrillx'
      ,merrilly='$merrilly'
      ,qlevel='$qlevel',qimportance='$qimportance'
    where qcode='$qcode'";
    sql_query($sql);
    echo($sql);
    //문제와 목록 매칭 테이블에도 문제번호update
    $sql="update tb_qlist set qnum='$qnum'
          where code='$code' and list='$list' and qcode='$qcode'";
    sql_query($sql);

  }

  if($mode=="resultview"){
    goto_url("/qviewone.php?list=$list&qcode=$qcode");
  }elseif($mode=="resultviewfirst"){
    goto_url("/qedit?list=$list&qcode=$qcode&mode=$mode");
  }else{
    goto_url("/qedit?list=$list&qcode=$qcode");
  }
}

?>

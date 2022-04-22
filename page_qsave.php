<?php include_once('./_common.php');

  $mode=$_POST["mode"];
  $code=$_POST["code"];
  $list=$_POST["list"];
  $page_full_title=$_POST["page_full_title"]; //처음 저장될 때 qlog에 저장

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
  $is_compilerfirst=$_POST["is_compilerfirst"];
  $is_compilertheme=$_POST["is_compilertheme"];

  $qcompilecode=trim($_POST["qcompilecode"]);
  $qtextsubcoding=$_POST["qtextsubcoding"];

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
  $merrilljson=$_POST["merrilljson"];

  $qlevel=$_POST["qlevel"];
  $qimportance=$_POST["qimportance"];

if($mode=="d"){
  /* 문제삭제 */
  /*관련파일도 삭제*/
    $sql="delete from tb_pageq where qcode='$qcode'";
    sql_query($sql);
    $sql="delete from tb_question where qcode='$qcode'";
    sql_query($sql);

    //단어추출 삭제
    $sql="delete from tb_qwords where qcode='$qcode'";
    sql_query($sql);

    goto_url("/page?$list");

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
               , is_compiler, is_compilerfirst, is_comilertheme, qcompilecode, qtextsubcoding
               , qm1text, qm2text, qm3text, qm4text, qm5text
               , qm1img, qm2img, qm3img, qm4img, qm5img
               , qm1correct, qm2correct, qm3correct, qm4correct, qm5correct
               , qanswer, qessay
               , qexplain, qyoutube
               , merrillx, merrilly, merrilljson
               , qlevel, qimportance
               , copyqcode, qlog
               )
               values('$qcode'
               ,'$isopen','$qnum','$qtype'
               ,'$qtext','$qtextsub', '$qimg', '$imgpath'
               ,'$is_compiler', '$is_compilerfirst', '$is_compilertheme', '$qcompilecode', '$qtextsubcoding'
               ,'$qm1text','$qm2text','$qm3text','$qm4text','$qm5text'
               ,'$qm1img','$qm2img','$qm3img','$qm4img','$qm5img'
               ,'$qm1correct','$qm2correct','$qm3correct','$qm4correct','$qm5correct'
               ,'$qanswer','$qessay'
               ,'$qexplain','$qyoutube'
               ,'$merrillx','$merrilly','$merrilljson'
               ,'$qlevel','$qimportance'
               ,'$copyqcode', '$page_full_title'
               )";



     sql_query($sql);
     echo($sql."<br>");




     //문제와 목록 매칭 테이블에도 insert???????
     //$sql="insert into tb_qlist(code, qnum, list, qcode) values('$code','$qnum','$list','$qcode')";
     //sql_query($sql);
     //echo($sql."<br>");

     //문제와 목록 매칭 테이블에도 insert???????
     $sql="insert into tb_pageq(list, qcode, pqnum) values('$list','$qcode','$qnum')";
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
      ,is_compiler='$is_compiler', is_compilerfirst='$is_compilerfirst', is_compilertheme='$is_compilertheme'
      ,qcompilecode='$qcompilecode', qtextsubcoding='$qtextsubcoding'
      ,qm1text='$qm1text',qm1img='$qm1img',qm1correct='$qm1correct'
      ,qm2text='$qm2text',qm2img='$qm2img',qm2correct='$qm2correct'
      ,qm3text='$qm3text',qm3img='$qm3img',qm3correct='$qm3correct'
      ,qm4text='$qm4text',qm4img='$qm4img',qm4correct='$qm4correct'
      ,qm5text='$qm5text',qm5img='$qm5img',qm5correct='$qm5correct'
      ,qanswer='$qanswer',qessay='$qessay'
      ,qexplain='$qexplain',qyoutube='$qyoutube'
      ,merrillx='$merrillx' ,merrilly='$merrilly', merrilljson='$merrilljson'
      ,qlevel='$qlevel',qimportance='$qimportance'
    where qcode='$qcode'";
    sql_query($sql);
    echo($sql);
    //문제와 목록 매칭 테이블에도 문제번호update
    $sql="update tb_pageq set pqnum='$qnum'
          where list='$list' and qcode='$qcode'";
    sql_query($sql);

  }











  /////////////////////////////////////////////////////////////////////////////////////////////ETRI 문제와 지문을 키워드 분류
  if(1==2){

  if($qcode!=""){
    if($qtextsub!=""){
      $splitstr=$qtext." ".$qtextsub;
    }else {
      $splitstr=$qtext;
    }

    if($splitstr!=""){
      //////////////////////////////////////////////////////////////////////// ETRI 키워드 추출

       $openApiURL = "http://aiopen.etri.re.kr:8000/WiseQAnal";
       $accessKey = "3ab4aae1-a2da-40e4-a2bf-ef675abbcc3e";
       $text = $splitstr;

       $request = array(
               "access_key" => $accessKey,
               "argument" => array (
                   "text" => $text
               )
       );

       try {
               $server_output = "";
               $ch = curl_init();
               $header = array(
                   "Content-Type:application/json; charset=UTF-8",
               );
               curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
               curl_setopt($ch, CURLOPT_URL, $openApiURL);
               curl_setopt($ch, CURLOPT_VERBOSE, true);
               curl_setopt($ch, CURLOPT_POST, 1);
               curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode ( $request) );
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환

               $server_output = curl_exec ($ch);
               //echo($server_output);
               if($server_output == false) {
                   echo "Error Number:".curl_errno($ch)."\n";
                   echo "Error String:".curl_error($ch)."\n";
               }

               curl_close ($ch);
       } catch ( Exception $e ) {
           echo $e->getMessage ();
       }

        $data=json_decode($server_output, true);
        echo("<br>-----키워드 분석시작------<br>");
        //echo($data["return_object"]["orgQInfo"]["orgQUnit"]["ndoc"]["sentence"][0]["WSD"]);
        sql_query("delete from tb_qwords where qcode='$qcode'");

        $cnt=count($data["return_object"]["orgQInfo"]["orgQUnit"]["ndoc"]["sentence"]);
        if($cnt==""){$cnt=1;}
        for($i=0;$i<$cnt;$i++){

                 foreach ($data["return_object"]["orgQInfo"]["orgQUnit"]["ndoc"]["sentence"][$i]["WSD"] as $key=> $val) {
                     $wordid = $val["id"];
                     $wordposition = $val["position"];
                     $word = $val["text"];
                     $wordscode = $val["scode"];
                     $wordtype = $val["type"];
                     if($wordtype=="VV"||$wordtype=="VA"){$word.="다";}

              if(strpos(",SN,SF,SP,SS,SO,EP, EC,ETN,ETM,EF,JX,JKB,JKG,JKS,JKO,VX,VCP",$wordtype)){
                      //echo($wordtype.":" . $word. "저장안함");
              }else{

                     $sql="insert into tb_qwords(qcode, word, wordscode, wordtype, wordid, wordposition) values(
                       '$qcode', '$word', '$wordscode', '$wordtype','$wordid','$wordposition')";

                       echo($sql."<br><br>");
                       sql_query($sql);


                        //////////////////////////////////////////////////////////////////////// ETRI 유사도
                        if(1==2){
                                                      //if($word!=""&&($wordtype=="NNP"||$wordtype=="NNG"||$wordtype=="VV"||$wordtype=="VA")){

                            $sqlcompare="select * from tb_qcompare_cate where cate='merrill' ";
                            $resultcompare=sql_query($sqlcompare);
                            for($xx;$rscompare=sql_fetch_array($resultcompare);$xx++){
                                    $compareword=$rscompare["word"];
                                    $comparewordscode=$rscompare["wordscode"];
                                    $sqlcompare_pre="select count(*) from tb_wordcompare_similar where word='$word' and wordscode='$wordscode'
                                                        and compareword='$compareword' and comparewordscode='$comparewordscode' and similar_scource='ETRI'";
                                    $resultcompare_pre=sql_fetch($sqlcompare_pre);
                                    if($resultcompare_pre){

                                    }else{

                                                                      $openApiURL = "http://aiopen.etri.re.kr:8000/WiseWWN/WordRel";
                                                                      $accessKey = "3ab4aae1-a2da-40e4-a2bf-ef675abbcc3e";
                                                                      $firstWord = $word;
                                                                      $firstSenseId = $wordscode; //"FIRST_SENSE_ID";
                                                                      $secondWord = $compareword;//"사실";
                                                                      $secondSenseId = $comparewordscode;//"04"; //"SECOND_SECSE_ID ";

                                                                      $request = array(
                                                                          "access_key" => $accessKey,
                                                                          "argument" => array (
                                                                              "first_word" => $firstWord,
                                                                              "first_sense_id" => $firstSenseId,
                                                                              "second_word" => $secondWord,
                                                                              "second_sense_id" => $secondSenseId
                                                                          )
                                                                      );

                                                                      try {
                                                                          $server_output = "";
                                                                          $ch = curl_init();
                                                                          $header = array(
                                                                              "Content-Type:application/json; charset=UTF-8",
                                                                          );
                                                                          curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                                                                          curl_setopt($ch, CURLOPT_URL, $openApiURL);
                                                                          curl_setopt($ch, CURLOPT_VERBOSE, true);
                                                                          curl_setopt($ch, CURLOPT_POST, 1);
                                                                          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode ( $request) );
                                                                          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환

                                                                          $server_output = curl_exec ($ch);

                                                                          #echo("<br>".$server_output."<br>");

                                                                          $data=json_decode($server_output, true);

                                                                          $spath=$data["return_object"]["WWN WordRelInfo"]["WordRelInfo"]["ShortedPath"][0];
                                                                          $dist=$data["return_object"]["WWN WordRelInfo"]["WordRelInfo"]["Distance"];
                                                                          $sim=$data["return_object"]["WWN WordRelInfo"]["WordRelInfo"]["Similarity"][0]["SimScore"];

                                                                          echo("<br>ETRI SIM: ".$sim."<br>");

                                                                          $sql="insert into tb_wordcompare_similar(word, wordscode, compareword, comparewordscode, similar_source, similar_val)
                                                                           values('$word', '$wordscode', '$secondWord','$secondSenseId','ETRI','$sim')";

                                                                            echo($sql."<br><br>");
                                                                            sql_query($sql);





                                                                          if($server_output == false) {
                                                                          //    echo "Error Number:".curl_errno($ch)."\n";
                                                                          //    echo "Error String:".curl_error($ch)."\n";
                                                                          }

                                                                          curl_close ($ch);
                                                                      } catch ( Exception $e ) {
                                                                          //echo $e->getMessage ();
                                                                      }
                                  }
                                                                      //echo "result = " . var_dump($server_output);
                              //  flush();
                              //  sleep(1);

                              }
                        } //사용막음
                        //////////////////////////////////////////////////////////////////////// ETRI 유사도 end




                  }
              }
      }

       ///////////////////////////////////////////////////////////////////////////////////////////
      }
    }
    /////////////////////////////////////////////////////////////////////////////////////////////

    /*
        대분류	소분류	세분류	세종태그
        (1) 체언	명사
        일반명사	NNG  --------------------------------------
        고유명사	NNP  --------------------------------------
        의존명사	NNB
        대명사	 	NP
        수사	 	NR
        (2) 용언
        동사	 	VV   -----------------------------------------------
        형용사	 	VA  -----------------------------------------------
        보조용언	 	VX
        지정사	긍정지정사	VCP
        부정지정사	VCN
        (3) 수식언	관형사	 	MM
        부사	일반부사	MAG
        접속부사	MAJ
        (4) 독립언	감탄사	 	IC
        (5) 관계언	격조사	주격조사	JKS
        보격조사	JKC
        관형격조사	JKG
        목적격조사	JKO
        부사격조사	JKB
        호격조사	JKV
        인용격조사	JKQ
        보격조사	 	JX
        접속조사	 	JC
        (6) 의존형태	어미	선어말어미	EP
        종결어미	EF
        연결어미	EC
        명사형전성어미	ETN
        관형형전성어미	ETM
        접두사	체언접두사	XPN
        접미사	명사파생접미사	XSN
        동사파생접미사	XSV
        형용사파생접미사	XSA
        어근	 	XR
        (7) 기호
        마침표, 물음표, 느낌표	 	SF
        쉼표, 가운뎃점, 콜론, 빗금	 	SP
        따옴표, 괄호표, 줄표	 	SS
        줄임표	 	SE
        붙임표 (물결, 숨김, 빠짐)	 	SO
        외국어	 	SL
        한자	 	SH
        기타 기호 (논리 수학기호, 기호 등)	 	SW
        명사추정범주	 	NF
        용언추정범주	 	NV
        숫자	 	SN
        분석불능범주	 	NA
        */
} ////////////////////////////////////////////////// ETRI 문제분석 하지 않음














  if($mode=="resultview"){
    goto_url("/qviewone.php?list=$list&qcode=$qcode");
  }elseif($mode=="resultviewfirst"){
    goto_url("/page_qedit?list=$list&qcode=$qcode&mode=$mode");
  }else{
    goto_url("/page_qedit?list=$list&qcode=$qcode");
  }
}

?>

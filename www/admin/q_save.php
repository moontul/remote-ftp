<?php
  error_reporting( E_ALL );
  ini_set( "display_errors", 1 );
?>
<?php include_once('_conn.php');

$qcode = $_POST['qcode'];
$qtype = $_POST['qtype'];  //객관식, 주관식, 서술식
$qnum = $_POST['qnum'];
$qtext = addslashes(trim($_POST['qtext']));
$qcoding = addslashes(trim($_POST['qcoding']));
$merrill = $_POST['merrill']; //메릴
	if($merrill!=""){
		$a_merrill=explode("X", $merrill);
		$merrill_x=$a_merrill[0];
		$merrill_y=$a_merrill[1];
	}

$qgroup = $_POST['qgroup'];

$qm1order = $_POST['qm1order'];
$qm1text = addslashes(trim($_POST['qm1text']));
$qm1correct = $_POST['qm1correct'];

$qm2order = $_POST['qm2order'];
$qm2text = addslashes(trim($_POST['qm2text']));
$qm2correct = $_POST['qm2correct'];

$qm3order = $_POST['qm3order'];
$qm3text = addslashes(trim($_POST['qm3text']));
$qm3correct = $_POST['qm3correct'];

$qm4order = $_POST['qm4order'];
$qm4text = addslashes(trim($_POST['qm4text']));
$qm4correct = $_POST['qm4correct'];

$qm5order = $_POST['qm5order'];
$qm5text = addslashes(trim($_POST['qm5text']));
$qm5correct = $_POST['qm5correct'];

$qmessay = addslashes(trim($_POST['qmessay'])); //주관식 답
if($qtype=="서술식"){
  $qmessay = addslashes(trim($_POST['qmessaylong'])); //서술식 모범답
}

$qiscompile = addslashes(trim($_POST['qiscompile']));

$sjcode = $_POST['sjcode'];
$sjucode = $_POST['sjucode'];
$lccode = $_POST['lccode'];
$lcucode = $_POST['lcucode'];
$bkcode = $_POST['bkcode'];
$bkucode = $_POST['bkucode'];


$qlevel=$_POST['qlevel'];
$qimportance=$_POST['qimportance'];

$qrightratio=$_POST['qrightratio'];

$qexplain=addslashes(trim($_POST['qexplain']));

if($qcode=="")
{
  //  $result = mysqli_query($conn, $sql);
  //  $row=$result->num_rows;
		//문제 고유코드
		$rand = strtoupper(substr(uniqid(),7));
		$qcode="QC".date("YmdHis").$rand;

                  //문제파일업로드
                  //echo($_FILES['qimg']);
                  //업로드한 파일을 저장할 디렉토리
                  $save_dir = "qfiles/";
                  //파일이 HTTP POST 방식을 통해 정상적으로 업로드되었는지 확인한다.
                  if(is_uploaded_file($_FILES["qimg"]["tmp_name"]))
                  {
                  echo "<br>업로드한 파일명 : ".$_FILES["qimg"]["name"];
                  echo "<br>업로드한 파일의 크기 : ".$_FILES["qimg"]["size"];
                  echo "<br>업로드한 파일의 MIME Type : ".$_FILES["qimg"]["type"];
                  echo "<br>임시 디렉토리에 저장된 파일명 : ".$_FILES["qimg"]["tmp_name"];

                  //파일을 저장할 디렉토리 및 파일명
                  //$dest = $save_dir . $_FILES["qimg"]["name"];
                  $ext = substr($_FILES["qimg"]["name"], strrpos($_FILES["qimg"]["name"], '.') + 1);
                  $dest = $save_dir .'.'. $qcode.$ext;

                  //echo($dest);
                  //파일을 지정한 디렉토리에 저장
                  if(!move_uploaded_file($_FILES["qimg"]["tmp_name"], $dest))
                  {
                    die("파일을 지정한 디렉토리에 저장하는데 실패했습니다.");
                  }
                  }

                /*
                if(isset($_FILES['qimg']) && $_FILES['qimg']['name'] != "") {
                		$file = $_FILES['qimg'];
                		$upload_directory = 'qfiles/';
                		$ext = substr($file['name'], strrpos($file['name'], '.') + 1);

                		$max_file_size = 5242880;
                		// 파일 크기 체크
                		if($file['size'] >= $max_file_size) {
                		  echo "5MB 까지만 업로드 가능합니다.";
                		}
                		if(move_uploaded_file($file['tmp_name'], $upload_directory.$path)) {
                				$file_id = md5(uniqid(rand(), true));
                        $name_orig = $file['name'];
                        $name_save = $path;
                		}
                }
                */

  $sql = <<<EOT
			insert into tb_question(qcode, qtype, qnum, qtext, qcoding
      , qm1order, qm1text, qm1correct
      , qm2order, qm2text, qm2correct
      , qm3order, qm3text, qm3correct
      , qm4order, qm4text, qm4correct
      , qm5order, qm5text, qm5correct
      , qmessay, qiscompile
      , merrill_x, merrill_y
      , qlevel, qimportance
      , sjcode, sjucode
      , lccode, lcucode
      , bkcode, bkucode
      , qrightratio, qexplain
			)
			values(
			'$qcode', '$qtype', '$qnum', '$qtext', '$qcoding'
      ,'$qm1order','$qm1text','$qm1correct'
      ,'$qm2order','$qm2text','$qm2correct'
      ,'$qm3order','$qm3text','$qm3correct'
      ,'$qm4order','$qm4text','$qm4correct'
      ,'$qm5order','$qm5text','$qm5correct'
      ,'$qmessay','$qiscompile'
      ,'$merrill_x','$merrill_y'
      ,'$qlevel','$qimportance'
      ,'$sjcode','$sjucode'
      ,'$lccode','$lcucode'
      ,'$bkcode','$bkucode'
      ,'$qrightratio', '$qexplain'
			)
EOT;

	$result=mysqli_query($conn, $sql);
	echo($sql);

}
else
{

    $sql =<<<EOT
    update tb_question set
    qnum='$qnum'
    , qtype='$qtype'
    , qtext='$qtext'
    , qcoding='$qcoding'

    , qm1order='$qm1order'
    , qm1text='$qm1text'
    , qm1correct='$qm1correct'

    , qm2order='$qm2order'
    , qm2text='$qm2text'
    , qm2correct='$qm2correct'

    , qm3order='$qm3order'
    , qm3text='$qm3text'
    , qm3correct='$qm3correct'

    , qm4order='$qm4order'
    , qm4text='$qm4text'
    , qm4correct='$qm4correct'

    , qm5order='$qm5order'
    , qm5text='$qm5text'
    , qm5correct='$qm5correct'

    , qmessay='$qmessay'
    , qiscompile='$qiscompile'

    , merrill_x='$merrill_x'
    , merrill_y='$merrill_y'
    , qlevel='$qlevel'
    , qimportance='$qimportance'

    , sjcode='$sjcode', sjucode='$sjucode'
    , lccode='$lccode', lcucode='$lcucode'
    , bkcode='$bkcode', bkucode='$bkucode'

    , qrightratio='$qrightratio', qexplain='$qexplain'

    where qcode='$qcode'
EOT;
     $result=mysqli_query($conn, $sql);
		 echo($sql);

}


//보기배열
/*
if(($qtype=="객관식"))
{
  $qmorder=$_POST['qmorder'];
  $qmtext=$_POST['qmtext'];
  $qmcorrect=$_POST['qmcorrect'];

  foreach($qmorder as  $key => $val)
  {
    if($qmtext[$key]!="")
    {
      $sql = "insert into tb_testqmulti(qcode, qmorder, qmtext, qmcorrect) values('$qcode', '$val', '$qmtext[$key]', '$qmcorrect[$key]')";
      $result=mysqli_query($conn, $sql);
    }
  }
}

if(($qtype=="주관식단답")||($qtype=="주관식다답전부")||($qtype=="주관식다답일부"))
{
  $qmorder2=$_POST['qmorder2'];
  $qmessay=$_POST['qmessay'];

  foreach($qmorder2 as  $key => $val)
  {
    if($qmessay[$key]!="")
    {
      $sql = "insert into tb_testqmulti(qcode, qmorder, qmessay) values('$qcode', '$val', '$qmessay[$key]')";
      //echo $sql."<br>";
      $result=mysqli_query($conn, $sql);
    }
  }
}

if($qtype=="서술식")
{
  $qmorder3=$_POST['qmorder3'];
  $qmessay3=$_POST['qmessay3'];

  foreach($qmorder3 as  $key => $val)
  {

    if($val!="")
    {
			$essay_=$qmessay3[$key];
			if($essay_==""){ $essay_ = "(서술식)"; }

	    $sql = "insert into tb_testqmulti(qcode, qmorder, qmessay) values('$qcode', '$val', '$essay_')";

      $result=mysqli_query($conn, $sql);

    }

  }

}
*/
if($sjcode!=""){setcookie("sjcode",$sjcode);}
if($sjucode!=""){setcookie("sjucode",$sjucode);}

if($qnum!=""){setcookie("qnum_new",(int)$qnum + 1);}


echo("<script>location.href='q_edit.php?qcode=$qcode&lccode=$lccode&lcucode=$lcucode&bkcode=$bkcode&bkucode=$bkucode'</script>");

?>

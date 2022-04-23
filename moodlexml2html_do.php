<?php include_once('./_common.php');
/*
function base64ToImage($base64_string, $output_file) {
    $file = fopen($output_file, "wb");
    $data = explode(',', $base64_string);
    fwrite($file, base64_decode($data[1]));
    fclose($file);
    return $output_file;
}*/

$xml = simplexml_load_file($_FILES['xmlfile']['tmp_name']);


if ($xml === false) {
     echo "XML 로딩에 실패했어요 : ";
     foreach(libxml_get_errors() as $error) {
         echo "<br>", $error->message;
     }
     die();
}


// echo $xml->getName() . "<br>"; quiz 시작


  $qnum=0;

 foreach($xml->children() as $tag => $child){

   $my_type=strtolower($child["type"]);

   if($my_type=="category"){
     foreach($child -> children() as $tag1 => $child1){
       //echo $child1->getName() . " ---- " . $child1 . "<br>"; category영역
       //echo($tag1);
       foreach($child1 -> children() as $tag2 => $child2){
         //echo $child2->getName() . " ---- " . $child2 . "<br>";
         echo "<h2>" . $child2 . "</h2>";
       }
     }
   }else{

     if($my_type=="shortanswer"||$my_type=="multichoice"||$my_type=="essay"){

       $qnum++;
       $qmnum=0;
       //echo("---".$child -> name."---");
       foreach($child -> children() as $tag1 => $child1){

         $my_tag=strtolower($tag1);
         if($my_tag=="name"){ //문제고유번호
          echo( "<p><sub>".$child1->text."</sub></p>");

        }elseif($my_tag=="questiontext"){

                $a_file=array();
                $filecount=0;
                foreach($child1 -> children() as $tag2 => $child2){
                  //echo $child2->getName() . " ---- " . $child2 . "<br>";
                  if(strtolower($tag2)=="text"){
                    $qtext=$child2; ////문제를 저장해둠
                  }elseif(strtolower($tag2)=="file"){
                    $a_file[$filecount]=array($child2["name"], $child2);
                    $filecount++;
                  }else{
                    //echo "<p>" .$tag2.":::". $child2 . "</p>";
                  }
                }


                for($i=0;$i<count($a_file);$i++){
                  $filedata=$a_file[$i][1];
                  if($filedata!=""){
                          //echo "<img src='data:image/png;base64," . $filedata . "'>";
                          $qtext=str_replace("@@PLUGINFILE@@/".$a_file[$i][0],"data:image/png;base64,".$filedata,$qtext);
                  }
                }

                //echo( "<p><span><b>문제 ".$qnum."번</b></span>".$child1->text."</p>");
                echo( "<p><span><b>문제 ".$qnum."번</b></span>".$qtext."</p>");




        }elseif($my_tag=="answer"){
          $qmnum++;
          echo( "<p>보기".$qmnum.$child1->text."</p>");
          echo("[정답:".$child1["fraction"]."]");




        }elseif($my_tag=="generalfeedback"){
          if($child1->text!=""){
            echo("<p>피드백:".$child1->text."</p>");
          }

        }elseif($my_tag=="defaultgrade"){
          if($child1!=""){
            echo("<p>점수:".$child1."</p>");
          }
        }elseif($my_tag=="penalty"){
          if($child1!=""){
            echo("<p>패널티:".$child1."</p>");
          }
        }elseif($my_tag=="hidden"){
          if($child1!=""){
            echo("<p>숨김:".$child1."</p>");
          }
        }elseif($my_tag=="single"){
          if($child1!=""){
            echo("<p>싱글:".$child1."</p>");
          }
        }elseif($my_tag=="shuffleanswers"){
          if($child1!=""){
            echo("<p>보기섞음:".$child1."</p>");
          }
        }elseif($my_tag=="answernumbering"){
          if($child1!=""){
            echo("<p>보기문자:".$child1."</p>");
          }
        }elseif($my_tag=="correctfeedback"){
          if($child1->text!=""){
            echo("<p>맞으면:".$child1->text);
          }

        }elseif($my_tag=="partiallycorrectfeedback"){
          if($child1->text!=""){
            echo("<p>일부:".$child1->text);
          }

        }elseif($my_tag=="incorrectfeedback"){
          if($child1->text!=""){
            echo("<p>틀리면:".$child1->text);
          }

        }else{
          echo( "<p>".$my_tag.":".$child1->text."</p>");
        }



       }

     }else{
       echo $child->getName() . "===>" . $tag . "--->". $child . "<br>";

     }

   }
 }




/*
$q_arr = $xml->question;
foreach ($q_arr as $row) {

    printf($row);

}

//print_r($xml);

$fp = fopen($_FILES['xmlfile']['tmp_name'], 'rb');
while ( ($line = fgets($fp)) !== false) {
  echo "$line";
}

*/

?>

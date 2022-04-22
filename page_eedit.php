<?php include_once('./_common.php');

@include_once("./page.head.php");

include_once(G5_THEME_PATH.'/head.php');
?>



<div class="container pp-main">

                                <?php if($is_admin) { ?>

                                <?php } ?>
  <div class="row">
    <?php include_once("page.nav.php");?>

    <div class="col-lg-9">
      <div class="row">










        <?php
          $sql="select * from tb_exam where list='$list'"; ////code='$code' and
          $result=sql_fetch($sql);

          ////////////////////////////////// $examcondition=$result["examcondition"];  ///AND OR 사용하지 않음

          $examopen=$result["examopen"];
          $examclose=$result["examclose"];
          $examopentime=$result["examopentime"];
          $examclosetime=$result["examclosetime"];

          $examlimit=$result["examlimit"];

          $is_test=$result["is_test"];
          $is_random=$result["is_random"]; //볼때마다 순서 랜덤

          $is_cbt=$result["is_cbt"];

          $examcodes="";
          $sql="select * from tb_exam_codes where code='$code' and list='$list'";
          $result=sql_query($sql);
          for($i=0;$rs=sql_fetch_array($result);$i++){
            $examcodes.=$rs["mb_code"]."\n";
          }

          $examids="";
          $sql="select * from tb_exam_ids where code='$code' and list='$list'";
          $result=sql_query($sql);
          for($i=0;$rs=sql_fetch_array($result);$i++){
            $examids.=$rs["mb_id"]."\n";
          }

          $examgroups="";
          $sql="select * from tb_exam_groups where code='$code' and list='$list'";
          $result=sql_query($sql);
          for($i=0;$rs=sql_fetch_array($result);$i++){
            $examgroups.=$rs["mb_group"]."\n";
          }
        ?>

            <main class="ct-docs-content-col" role="main">

              <div class="cd-dotc-page-title">
                <span class="ct-docs-page-h1-title">
                  <?=$page_title?>
                <?php if($list==""){?>
                  <span> 전체 시험 설정</span>
                  <sub class="ms-3">문제 목록을 한 번에 풀 수 있도록 설정합니다</sub>
                <?php }else{ ?>
                  <?=$listtitle?> <span>시험 설정</span>
                    <?php if($a_listorder[array_search($list, $a_list)]>1){?>
                    <sub class="ms-3 text-muted"><?=$a_path[array_search($list, $a_list)];?></sub>
                    <?php } ?>
                <?php } ?>
                </span>
              </div>

              <hr>


              <form name=f method="post" action="./page_esave.php">
              <input type=hidden name=edit_list value="<?=$list?>">
              <input type=hidden name=mode value="">
              <input type=hidden name=qcode value="<?=$qcode?>">



                      <section>
                            <div class="h5">시험 방식 선택 </div>
                            <div class="h6">
                              <input type="checkbox" name="is_test" value="1" <?=(($is_test==1)||($is_test==""&&$is_cbt==""))?'checked':''?>>
                              문제를 바로 풀  수 있도록 제공합니다

                              <span>(<input type=checkbox name="is_random" value=1 <?=($is_random==1)?'checked':''?>> 볼 때 마다 문제 순서를 랜덤하게)</span>
                            </div>

                            <div class="h6"><input type="checkbox" name="is_cbt" value="1" <?=($is_cbt==1)?'checked':''?> onclick="$('#examset').toggle()"> CBT 시험보기로 제공합니다</div>

                            <div class="ms-5" id="examset" style="display:<?=($is_cbt==1)?'block':'none'?>">
                                  <table class="table table-sm">
                                  <tr>
                                  <td rowspan=2>시험 대상</td><td>그룹코드</td><td>아이디</td><td>소속</td>
                                  </tr>
                                  <tr>
                                    <td><textarea name=examcodes rows=5><?=$examcodes?></textarea></td>
                                    <td><textarea name=examids rows=5><?=$examids?></textarea></td>
                                    <td><textarea name=examgroups rows=5><?=$examgroups?></textarea></td>
                                  </tr>
                                <!--
                                  <tr>
                                    <td colspan=4>
                                    대상조건  &nbsp; <select name="examcondition">
                                      <option value="AND" <?if($examcondition=="AND"){echo("selected");}?>>AND 조건에 모두 만족하는 경우</option>
                                      <option value="OR" <?if($examcondition=="OR"){echo("selected");}?>>OR 조건에 하나만이라도 만족하는 경우</option>
                                      </select>
                                      <br>
                                      * 시험대상이 모두 빈값이면 제약없이 모두 cbt 볼 수 있습니다.</td>
                                  </tr>
                                -->
                                  </table>
                                  <table class="table table-sm">
                                  <tr>
                                  <td width="10%" rowspan=2>응시기간</td>
                                  <td width=80>시작일</td><td width=120><input type=text name=examopen id="examopen" class="form-control datepicker" value="<?=$examopen?>" autocomplete="off" size=10></td>
                                  <td width=80>시작시간</td><td>
                                    <select name=examopentime class="form-control form-control-sm">
                                      <option value=""></option>
                                      <?php for($x=0;$x<=24;$x++){ ?>
                                        <option value="<?=$x?>" <?if((int)$examopentime==$x){echo("selected");}?>><?=$x?>시</option>
                                  <?php } ?>
                                    </select></td>
                                  </tr>
                                  <tr>
                                  <td>종료일</td><td><input type=text name=examclose id="examclose" class="form-control datepicker"  value="<?=$examclose?>" autocomplete="off" size=10></td>
                                  <td>종료시간</td><td><select name=examclosetime class="form-control form-control-sm"><option value=""></option>
                                    <?php for($x=0;$x<=24;$x++){ ?>
                                    <option value="<?=$x?>" <?if($examclosetime==$x){echo("selected");}?>><?=$x?>시</option>
                                  <?php } ?>
                                    </select></td>
                                  </tr>
                                  </table>


                                  <table class="table table-sm">
                                  <tr>
                                  <td width="15%">시험 소요시간</td>
                                  <td><input type=text name=examlimit size=3 value="<?=$examlimit?>">분</td>
                                  <td>* 시간이 지나면 자동으로 제출합니다.</td>
                                  </tr>
                                  <!--
                                  <tr>
                                  <td>재응시 가능</td>
                                  <td>시험 제출 후 <input type=text name=examretest>번 재응시 가능</td>
                                  </tr>
                                  -->
                                  </table>
                              </div>
                          </section>




                          

                <div class="h5">목록 선택</div>
                <table class="table">
                  <thead>
                  <tr>
                  <th><input type="checkbox" class="chkall"></th>
                  <th>목록</th>
                  <th>경로</th>
                  <th>문제수</th>
                  </tr>
                  </thead>
                  <tbody>
                <?php
                  //전체시험 목록 체크확인
                    $elist_a=array();
                    $sql="select * from tb_elist where list='$list'";
                    $result=sql_query($sql);
                    for($i=0;$rs=sql_fetch_array($result);$i++){
                        $elist_a[$i]=$rs["exam_list"];
                    }
                  ?>

                    <?php
                    $lvl_top=0;
                    $lvl_sub="";
                    for($x=0;$x<count($a_idx);$x++){
                      if($a_qcnt[$x]>0){  ////왼쪽 보이는 전체목록중 문제가 있는 목록
                    ?>
                    <tr class="" list="<?=$a_list[$x]?>" idx="<?=$a_idx[$x]?>">
                      <td>
                       <input name="a_elist[]" type="checkbox" class="chkelist" value="<?=$a_list[$x]?>"  <?=in_array($a_list[$x],$elist_a)==false?"":"checked" ?> >
                     </td>
                     <td>
                            <?=$a_title[$x]?>
                      </td>
                      <td class="text-sm">
                            <?=$a_path[$x]?>
                      </td>
                      <td>
                               <?if ($a_qcnt[$x]>0){ ?>
                               <span class=" end-0 badge rounded-pill bg-secondary text-opacity-50">
                                 <?=$a_qcnt[$x]?>문제
                               </span>
                               <?}?>
                      </td>
                    </tr>
                    <?}
                    }?>
                    </tbody>
                  </table>
                    <hr>





        <?php if($list!=""){ ?>
            <br>
                <div class="h5">선택된 시험 문제</div>
                <div class="d-flex bg-light p-1">
                  <div class="col-1">해제</div>
                  <div class="col-1">순서</div>
                  <div class="col-10">문제</div>
                </div>
                <div id="target" class="p-1" style="border:1px solid #ddd">

                  <?php
                    $sql="select B.pqnum as pqnum, B.qcode as qcode, C.title as title, left(A.qtext,30) as qtext
                        from tb_question A , tb_pageq B, tb_page C
                        where A.qcode=B.qcode and B.list=C.list";
                    $sql.=" and B.list='$list' order by B.pqnum asc";

                    $result=sql_query($sql);

                    for($i=0;$rs=sql_fetch_array($result);$i++){
                      $plusqcode_str.=$rs["qcode"].";"
                    ?>
                    <div class="d-flex">
                      <div class="col-1"><input type="checkbox" name="a_qcode[]" class="plusqcode" value="<?=$rs["qcode"]?>" checked></div>
                      <div class="col-1"><input type=text size=2 name="a_qnum[]" value="<?=$rs["pqnum"]?>"></div>
                      <div class="col-10"> [<?=$rs["title"]?>] <?=$rs["qtext"]?></div>
                    </div>
                  <?php
                    $max_qqnum=$rs["qqnum"];
                  }
                  ?>
                </div>
                <span>* 선택해제 하려면 체크박스를 해제하고 저장버튼을 누르세요.<br>* 문제번호를 바꾸고 순서 변경 버튼을 누르세요</span>
                <div class="text-start">
                  <input type=submit value="순서 변경" class="btn btn-secondary btn-sm shadow-sm btn-pp-sx">
                </div>
                <input type="hidden" name=max_qnum value="<?=$max_qqnum+1?>">

                <br>
              <?php
                //현재 컨테이너에 있는 첫번째 목록 - 현재 목록문제 제외
                $sql="
                    select PG.title, PG.list, count(*) as qcnt
                    from tb_page PG, tb_pageq PQ, tb_question QS
                    where PG.list=PQ.list and PQ.qcode=QS.qcode and PG.list<>'$list'
                    group by B.list order by B.title
                    ";
                $result=sql_query($sql);
                //echo $sql;
              ?>
              <br>
              <div class="h5">문제선택
                <input type=text size=2 id=randomQnum>
                <input type=button class="btn btn-light btn-sm shadow-sm" value="문제 랜덤 추출" onclick="selQrandom()">
              </div>

                  <?php
                  $a_qx=array();
                  //현재 코드에 있는 문제 - 현재 목록문제 제외 ---------------- 어떤 문제 호출 할지 범위 설정필요
                  $sql="select left(QS.qtext,40) as qtext, PQ.qcode as qcode
                        ,(select title from tb_page where list=PQ.list) as title, list
                        from tb_pageq PQ, tb_question QS
                        where PQ.qcode=QS.qcode
                        order by PQ.list, PQ.pqnum
                        ";
                    $result=sql_query($sql);
                        for($i=0;$rs=sql_fetch_array($result);$i++){
                          $a_qx[$i]=array(
                            "list" => $rs["list"],
                            "qcode" => $rs["qcode"],
                            "listtitle" => $rs["listtitle"],
                            "qtext" => $rs["qtext"]
                          );
                    } ?>
                  <div style="max-height:300px;overflow:auto;">
                    <div>
                      범위선택 : 문제 추가
                    </div>

                    <?php
                    $lvl_top=0;
                    $lvl_sub="";
                    for($x=0;$x<count($a_idx);$x++){
                      if($a_qcnt[$x]>0){
                    ?>
                    <div list="<?=$a_list[$x]?>" idx="<?=$a_idx[$x]?>">
                      <span>
                       <input name="" type="checkbox" class="qlistview" list="<?=$a_list[$x]?>" value="<?=$a_list[$x]?>">
                     </span>
                      <span>
                            <?=$a_path[$x]?>
                      </span>
                      <span>
                               <?if ($a_qcnt[$x]>0){ ?>
                               <span>
                                 (<?=$a_qcnt[$x]?>문제)
                               </span>
                               <?}?>
                      </span>
                    </div>
                            <div class="qcodediv" style="display:none" list="<?=$a_list[$x]?>">
                              <?php
                              for ($r = 0; $r < count($a_qx); $r++)
                              {
                                if($a_qx[$r]["list"]==$a_list[$x]){ ?>
                                  <div class='ms-3  d-flex'>
                                    <div class="col-1"><input type="checkbox" class="qcodeview" list="<?=$a_list[$x]?>" value="<?=$a_qx[$r]["qcode"]?>"></div>
                                    <div class="col-9"><?=$a_qx[$r]["qtext"]?></div>
                                    <div class="col-2 me-0"> &nbsp; <input type="checkbox" name="a_qcode[]" class="qcodechk" value="<?=$a_qx[$r]["qcode"]?>" onclick="addQcode">추가</div>
                                  </div>
                                  <?}
                              }
                              ?>
                            </div>
                    <?}
                    }?>
                  </div>
                  *문제 추가하려면 추가체크하고 문제 추가 버튼을 누르세요.
                  <div class="text-center"><input type=submit value="문제 추가" class="btn btn-secondary btn-sm shadow-sm"></div>

                  <script>
                  $(".qlistview").click(function(){
                    var c=$(this).prop("checked");

                    $(".qcodeview[list='"+$(this).attr("list")+"']").prop("checked", c);
                    if(c==true){
                      $(".qcodediv[list='"+$(this).attr("list")+"']").css("display", "block");
                    }else{
                      $(".qcodediv[list='"+$(this).attr("list")+"']").css("display", "none");
                    }
                  })

                  function addQcode(){
                    //qcodechk 체크되어 있는 문제를 추가함
                    var l=$('.qcodechk').length;
                    for(var i=0;i<l;i++){
                      if($(".qcodechk").eq(i).prop("checked")==true){
                        var qc=$(".qcodechk").eq(i).val();
                        if($(".plusqcode[value='"+qc+"']").val()){
                          alert("이미 추가된 문제입니다.");
                          $(".qcodechk").eq(i).prop("checked",false)
                        }
                      }
                    }
                  }

                  $(".qcodechk").click(function(){
                    addQcode();
                  })
                  </script>

                  <br>
                  <div class="h5">문제검색</div>

                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
                    문제검색
                  </button>

                  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">문제검색</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                              <iframe style="width:100%;height:500px" src="qsearch.php">
                              </iframe>
                            </div>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary btn-sm">Send message</button>
                        </div>
                      </div>
                    </div>
                  </div>









                  <div style="max-height:200px;overflow:auto;">
                  <iframe>



                  </iframe>
                  </div>

        <?php } ?>

                <div class="mt-2 text-center">
                    <input type="submit" value="  저장  " class="btn btn-dark btn-sm shadow-sm">
                    <input type="button" value="돌아가기" class="btn btn-light btn-sm shadow-sm" onclick="location.href='view?code=<?=$code?>';">
                    <input type="button" value="시험해제" class="btn btn-secondary btn-sm shadow-sm <?=($is_exam==0)?'disabled':''?>"
                        <?php if($is_exam==1){?>
                            onclick="if(confirm('시험해제할까요?')){document.f.mode.value='dis';document.f.submit();}"
                        <?}?>>
                </div>

              </form>

              <script>
                  function qnumchk(){
                    var c_qnum=$('.c_qnum').length;
                    for(var i=0;i<c_qnum;i++){
                      $(".c_qnum").eq(i).val(i+1);
                    }
                  }
                  function addindexQ(g){

                          var obj=$(".chk").eq(g)
                          var c= $(obj).val();

                          if($(obj).attr("checked")=="checked"){

                              var str="<div id='addq_"+c+"' class='addq'><input type='checkbox' name='a_qcode[]' class='chkre' checked value='"+c+"'>";
                                  str += " 문제번호:<input type=text size=3 class='c_qnum' name='a_qnum[]' value=''>";
                                  str += $("#listtitle_"+c).text();
                                  str += $("#qtext_"+c).text();
                                  str += "</div>";
                              $("#target").append(str);

                          }else{
                              $("#addq_"+c).remove();
                          }
                          qnumchk();
                  }

                  $(".chk").click(function(){
                        var index = $(".chk").index(this);
                        addindexQ(index);
                  });

                  $(document).on("click", ".chkre", function(){
                      var c= $(this).val();
                      var chk=$('.chk').length;
                      for(var i=0;i<chk;i++){
                        if($(".chk").eq(i).val()==c){
                          $(".chk").eq(i).removeAttr("checked");
                          addindexQ(i);
                          return;
                        }
                      }

                      alert(c);
                      //var index = $(".chk").index(this);
                      //addindexQ(index);
                  });


                  //selecting random index without same element
                  const selectIndex = (totalIndex, selectingNumber) => {
                    let randomIndexArray = []
                    for (i=0; i<selectingNumber; i++) {   //check if there is any duplicate index
                      randomNum = Math.floor(Math.random() * totalIndex)
                      if (randomIndexArray.indexOf(randomNum) === -1) {
                        randomIndexArray.push(randomNum)
                      } else { //if the randomNum is already in the array retry
                        i--
                      }
                    }
                    return randomIndexArray
                  }

                  //랜덤추출
                  function selQrandom(){

                    //기존 문제 모두 초기화
                    $(".chk").removeAttr("checked");
                    $(".addq").remove();

                    //현재상태에서 뽑을 수 있는 모든 문제(hide된거 제외)
                    var a=[]
                    var q=[]
                    var c=0;
                    var m=0;
                    for(var i=0;i< $(".chk").length;i++){
                      if($(".chk").eq(i).parents("div.qtr").css("display")=="block"){

                        var myq=$(".chk").eq(i).val();
                        if(q.includes(myq)){
                            console.log(myq + ":" + i);
                            m++;
                        }else{
                            a[c]=i;
                            q[c]=myq;
                            c++;
                        }

                      }
                    }
                    console.log(c + " vs "+ m);

                    if(c < $("#randomQnum").val()){alert('뽑을 문제수가 너무 많아요. 최대 ' + c +'문제 추출 가능해요');return;}

                    var a1=selectIndex(c, $("#randomQnum").val());

                    for(var i=0;i<a1.length;i++){
                      $(".chk").eq(a[a1[i]]).attr("checked", "checked");
                      addindexQ(a[a1[i]]);
                    }

                  }


                  $(".chkbox_list").click(function(){
                        var list = $(this).attr("list");
                        if( $(this).attr("checked")=="checked" ){
                          $(".qtr[list='"+list+"']").show();
                        }else{
                          $(".qtr[list='"+list+"']").hide();
                        }
                  });

                  $(".chkall").click(function(){
                    $(".chk").prop("checked",$(this).prop("checked"));
                  });
                  </script>



















      </div>
    </div>
  </div>

</div><!--pp main -->



























<?php include_once(G5_THEME_PATH.'/tail.php'); ?>

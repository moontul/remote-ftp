<?php include_once("page.wraptop.php");?>
      <?php include_once("page.nav.php");?>
      <div class="col-lg-9 pp-mainpage">
          <?php include_once("page.adm.btns.php");?>



          <section>

            <div class="ct-docs-page-title">
              <span class="ct-docs-page-h1-title"><?=$page_title?></span>
              <?php
                if($a_lvl[array_search($list, $a_list)]>1){
                  $page_full_title=$a_path[array_search($list, $a_list)];
              ?>
              <sub class="ms-3 text-muted"><?=$page_full_title?></sub>
              <?php } ?>
            </div>

            <?php if($this_title!=""||$page_title!=""){?>
            <hr class="ct-docs-hr">
            <?php } ?>
        </section>


<form name=f method=post>
  <input type=hidden name=list value="<?=$list?>">



<div class="h5">연결된 문제</div>
<table class="table pptable">
<tr>
<td>
  <div class="form-check"><input type=checkbox name="chkqall" value="" class="chkqall form-check-input" onclick="$('.chkq').prop('checked',$(this).prop('checked'))"></div>
</td>
<td>번호</td><td>문제</td><td>유형</td><td></td>
</tr>
<?php
  $sql="select pqnum, left(qtext, 40) as qtext, qtype, A.qcode as qcode
    from tb_pageq A, tb_question B where A.list='$list' and A.qcode=B.qcode
    order by pqnum";
  $result=sql_query($sql);
  for($i=0;$rs=sql_fetch_array($result);$i++){
?>
<tr>
<td>
    <div class="form-check"><input type=checkbox name="chkq[]" value="<?=$rs['qcode']?>" class="chkq form-check-input"></div></td>
<td><?=$rs["pqnum"]?></td>
<td><?=$rs["qtext"]?></td>
<td><?=$rs["qtype"]?></td>
<td><a href="page_qedit?list=<?=$list?>&qcode=<?=$rs['qcode']?>" class="btn btn-sm btn-light">문제수정</></td>
</tr>
<?php
  }
?>
</table>


<!-- Question Search Modal -->
<div class="modal fade" id="qsearchModal" tabindex="-1" aria-labelledby="qsearchModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header" style="cursor:move">
        <h5 class="modal-title" id="qsearchModalLabel">기존 문제 연결 <sub><?=$page_full_title?></sub></h5>
        <button type="button" class="btn bg-gradient-dark text-light btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
      </div>
      <div class="modal-body">
        <iframe id="iframe_qsearch" style="border:1px solid #efefef; width:100%;height:400px;"></iframe>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn bg-gradient-dark" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn bg-gradient-primary" onclick="$('#iframe_qsearch')[0].contentWindow.addq();" >문제 추가</button>
      </div>
    </div>
  </div>
</div>


  <a href="page_qedit.php?list=<?=$list?>" class="btn btn-sm w-auto bg-gradient-primary">새문제 등록</a>
  <button type="button" class="btn btn-sm w-auto bg-gradient-secondary" data-bs-toggle="modal"
  data-bs-target="#qsearchModal"
  onclick="$('#iframe_qsearch').attr('src','page_q.modal.php?list=<?=$list?>');">
    기존 문제 연결
  </button>
  <button type="button" class="btn btn-sm w-auto bg-gradient-secondary" onclick="removeQcode()">
    선택 문제 제외
  </button>

<script>
function removeQcode(){

  if( $(".chkq:checked").length==0){alert("제외할 문제를 체크하세요");$(".chkq").focus();return;}

  if(confirm("선택된 문제를 제외할까요?")){
      document.f.action="page_q_remove.php";
      document.f.submit();
  }
}
</script>
</form>


<form name=fe method=post>
  <input type=hidden name=list value="<?=$list?>">
<div class="h5"> 연결된 목차 </div>
<table class="table pptable">
<tr>
<td>
  <div class="form-check"><input type=checkbox name="chkqall" value="" class="chkqall form-check-input" onclick="$('.chkq').prop('checked',$(this).prop('checked'))"></div>
</td>
<td>목차</td>
</tr>
<tbody>
<?php
  $sql="select *
        , (select title from tb_page where list=A.exam_list) as exam_title
        , (select title from tb_page where idx=((select pidx from tb_page where list=A.exam_list))) as exam_ptitle
        from
        tb_elist A
        where list='$list'";
  $result=sql_query($sql);

  for($i=0;$rs=sql_fetch_array($result);$i++){
?>
<tr>
<td class="col-1">
  <div class="form-check">
    <input type=checkbox name="chke[]" value="<?=$rs['exam_list']?>" class="chke form-check-input">
  </div>
</td>
<td><?=$rs["title"]?> <?=$rs['exam_title']?> <sub><?=$rs['exam_ptitle']?></sub></td>
</tr>
<?php
  }
?>
</tbody>
</table>



<!-- Question list Modal -->
<div class="modal fade" id="qlistModal" tabindex="-1" aria-labelledby="qlistModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="qlistModalLabel">목차 연결 <sub><?=$page_full_title?></sub></h5>
        <button type="button" class="btn bg-gradient-dark text-light text-bold btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
      </div>
      <div class="modal-body">
        <iframe id="iframe_qlist" style="border:1px solid #efefef; width:100%;height:400px;"
        ></iframe>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn bg-gradient-dark" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn bg-gradient-primary" onclick="$('#iframe_qlist')[0].contentWindow.addList();" >목차 추가</button>
      </div>
    </div>
  </div>
</div>

<button type="button" class="btn btn-sm w-auto bg-gradient-secondary" data-bs-toggle="modal" data-bs-target="#qlistModal"
  onclick="$('#iframe_qlist').attr('src','page_q.listmodal.php?edit_list=<?=$list?>');">
  목차 연결
</button>
<button type="button" class="btn btn-sm w-auto bg-gradient-secondary" onclick="removeQlist()">
  선택 목차 제외
</button>

<script>
function removeQlist(){

  if( $(".chke:checked").length==0){alert("제외할 목록을 체크하세요");$(".chke").focus();return;}

  if(confirm("선택된 목록을 제외할까요?")){
      document.fe.action="page_q_listremove.php";
      document.fe.submit();
  }
}
</script>
</form>




<hr>
<?php
  $sql="select * from tb_exam where list='$list'";
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
  $sql="select * from tb_exam_codes where list='$list'";
  $result=sql_query($sql);
  for($i=0;$rs=sql_fetch_array($result);$i++){
    $examcodes.=$rs["mb_code"]."\n";
  }

  $examids="";
  $sql="select * from tb_exam_ids where list='$list'";
  $result=sql_query($sql);
  for($i=0;$rs=sql_fetch_array($result);$i++){
    $examids.=$rs["mb_id"]."\n";
  }

  $examgroups="";
  $sql="select * from tb_exam_groups where list='$list'";
  $result=sql_query($sql);
  for($i=0;$rs=sql_fetch_array($result);$i++){
    $examgroups.=$rs["mb_group"]."\n";
  }
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(function(){
  $.fn.datepicker.dates['kr'] = {
    days: ["일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일", "일요일"],
    daysShort: ["일", "월", "화", "수", "목", "금", "토", "일"],
    daysMin: ["일", "월", "화", "수", "목", "금", "토", "일"],
    months: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
    monthsShort: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"]
  };

  $(".datepicker").datepicker({
    format:"yyyy-mm-dd",
    autoclose: true,
    todayHighlight: true,
    language: "kr"
  });
})
</script>

                  <form name="fexam" method="post" action="page_q.examsave.php">
                    <input type=hidden name=edit_list value="<?=$list?>">
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


                              <button type="button" class="btn btn-sm w-auto bg-gradient-second" onclick="document.fexam.submit()">
                                시험방식 저장
                              </button>

                          </section>
                        </form>
                        <!-- initialization script -->










<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" />
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>

          </div>

<script>
  $('.modal-dialog').draggable({
    "handle":".modal-header"
    });
</script>
<?php include_once("page.wrapbottom.php");?>

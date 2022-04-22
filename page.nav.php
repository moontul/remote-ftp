<div class="collapse pp-sidebar show col-lg-3 col-md-3 col-0" id="pp-sidebar">


                                        <?php if($question_filedown=="true"&&$is_admin){ //////////////// question.php 에서 파일 다운로드지원?>
                                        <div class="d-flex filedownloadbtns d-none">
                                          <span id="now_qcode_label" class="d-none">지금 보이는 문제를</span>
                                          <span id="now_qchk_label" class="d-none">체크한 문제를</span>

                                          <div>
                                            <input type="button" class="btn btn-sm bg-gradient-primary text-center w-auto pt-1 pb-1 ps-2 pe-2" value="xml" onclick="qcode2file('xml')">
                                          </div>
                                          <div>
                                            <input type="button" class="btn btn-sm bg-gradient-secondary text-center w-auto pt-1 pb-1 ps-2 pe-2" value="hwp" onclick="qcode2file('hwp')">
                                          </div>
                                          <div>
                                            <input type="button" class="btn btn-sm bg-gradient-secondary text-center w-auto pt-1 pb-1 ps-1 pe-1" value="excel" onclick="qcode2file('xls')">
                                          </div>
                                          <form name=f_code2file method=post>
                                          <input type=hidden name=fileformat>
                                          <input type=hidden name=qnums>
                                          <input type=hidden name=qcodes>
                                          </form>
                                        </div>
                                        <script>
                                        function qcode2file(f){
                                          var qcodes="";
                                          var qnums="";


                                          if($(".questioncode").length>0){

                                            //$("#now_qcode_label").removeClass("d-none");
                                            for(var i=0;i<$(".questioncode").length;i++){
                                                  if(qnums!=""){qnums+=",";}
                                                  qnums+=$(".questioncode").eq(i).attr("qnum");

                                                  if(qcodes!=""){qcodes+=",";}
                                                  qcodes+="'"+$(".questioncode").eq(i).attr("name")+"'";
                                            }

                                          }else if($(".chkq").length>0){

                                            //$("#now_qchk_label").removeClass("d-none");
                                            for(var i=0;i<$(".chkq").length;i++){
                                              if($(".chkq").eq(i).prop("checked")){
                                                  if(qnums!=""){qnums+=",";}
                                                  qnums+=$(".chkq").eq(i).attr("qnum");

                                                  if(qcodes!=""){qcodes+=",";}
                                                  qcodes+="'"+$(".chkq").eq(i).val()+"'";
                                              }
                                            }

                                          }

                                          if(qcodes==""){alert("저장할 문제가 없어요.");return;}
                                          document.f_code2file.fileformat.value=f;
                                          document.f_code2file.qnums.value=qnums;
                                          document.f_code2file.qcodes.value=qcodes;
                                          document.f_code2file.action="question.code2file.php";
                                          document.f_code2file.target="_blank";
                                          document.f_code2file.submit();
                                        }

                                        $(function(){
                                          if( ($(".questioncode").length>0)||($(".chkq").length>0) ){
                                              $(".filedownloadbtns").removeClass("d-none");
                                          }else{
                                            //console.log("문제가 없음")
                                          }
                                        });

                                        </script>
                                        <?php } //////////////////////////////?>


                            <div> <!-- class="position-sticky pb-1 mt-lg-0 mt-2 ps-2" -->

                                      <?php if($list==""){ /////////모든 처음?>
                                        <h3>
                                          <a href="page?list=<?=$list?>"><?=$page_title?></a>
                                        </h3>
                                      <?}?>

                                      <?php if($list==$total_type){ ///////// 최상위 강좌, 자격시험, 코딩..?>
                                        <h3>
                                          <a href="page?list=<?=$list?>"><?=$total_type_title?></a>
                                        </h3>
                                      <?php }elseif($list==$total_code){ ?>
                                        <h5>
                                          <a href="page?<?=$total_code?>"><?=$total_code_title?></a>
                                        </h5>
                                      <?php }else{ ?>

                                        <!--<a href="page?<?=$total_type?>"><?=$total_type_title?></a>-->
                                        <h5><a href="page?<?=$total_code?>"><?=$total_code_title?></a></h5>
                                        <!--
                                        <h3>
                                          <a href="page?list=<?=$list?>"><?=$page_title?></a>
                                        </h3>-->
                                      <?php } ?>
                                                        <!--
                                                                  <h6 class="text-secondary font-weight-normal pe-3">
                                                                    <?=$this_menudetail?>
                                                                  </h6>
                                                        -->
                            </div>

          <?php if($page_lvl>=1){ //메뉴는 1단계 이상부터 보임?>


<?php
  //목록용 배열
            $a_idx=array();
            $a_pidx=array();
            $a_path=array();
            $a_list=array();
            $a_listorder=array();
            $a_tabtitle=array();
            $a_titleorder=array();
            $a_ccnt=array();
            $a_qcnt=array();
            $a_listcontent=array();
            $a_youtube=array();
            $a_files=array();

            $sql="
            WITH RECURSIVE tmp1 AS
            (
                SELECT list, listorder, idx, fullidx, title, titleorder, pidx, isopen
                ,title AS path
                ,CONCAT(ifnull(titleorder,''),title) AS pathorder
                , 1 AS lvl
                ,content
                FROM tb_page
            ";
    if($question_search_page=="true"){
          $sql.="
              WHERE lvl=1
          ";
    }else{
            $sql.="
                WHERE lvl=3 and code='$page_code'
            ";
    }
            $sql.="
                UNION ALL

                SELECT e.list, e.listorder, e.idx, e.fullidx, e.title, e.titleorder, e.pidx, e.isopen
                ,CONCAT(t.path,' > ',e.title) AS path
                ,CONCAT(t.pathorder,' > ',ifnull(e.titleorder,''),e.title) AS pathorder
                , t.lvl+1 AS lvl
                ,e.content
                FROM tmp1 t JOIN (
                    select * from tb_page
            ";
    if($question_search_page=="true"){
    }else{
             $sql.="
                    where code='$page_code'
              ";
    }
             $sql.="
                    ) e
                ON t.idx=e.pidx
            )

            SELECT list, listorder, idx, fullidx, title, titleorder, pidx, isopen
            ,path, pathorder, lvl, fullidx
            ,content
            ,CONCAT(REPEAT('&nbsp;', (lvl-1)*4), title) tabtitle
            ,(select count(*) from tb_pageq where list=A.list) as qcnt

            FROM tmp1 A
            ";

            $sql.="
            ORDER BY pathorder;
            ";


  if($is_admin){ //관리자

      if($page_code!=0){
          $sql="
          SELECT list, listorder, idx, pidx, fullidx, title, titleorder, isopen
          ,'' as path, lvl
          ,CONCAT(REPEAT('&nbsp;', (lvl-3)*2), title) tabtitle

          FROM tb_page A  WHERE code='$page_code' ";

          $sql.="
          ORDER BY lvl, fullidx, title
          ";
          //,(select count(*) from tb_pageq where list=A.list) as qcnt
          echo($sql);
          $result=sql_query($sql);

                    //$a_tree=[];

                    $t_idx=[];
                    $t_pidx=[];
                    $t_name=[];


                    for($i=0;$rs=sql_fetch_array($result);$i++){
                              if($i==0){$start_tree=$rs["idx"];}
                              if($list==$rs["list"]){$open_tree=$rs["idx"];}

                      $t_idx[$i]=$rs["idx"];
                      $t_pidx[$i]=$rs["pidx"];
                      $t_title[$i]=$rs["title"];

                      //$a_str=$rs["idx"]."|".$rs["pidx"]."|".$rs["title"]."|"."/page?".$rs["list"];
                      //array_push($a_tree, $a_str);
                    }

        } //page_code가 있음

    ?>

    <script type="text/javascript" src="<?=G5_THEME_URL?>/assets/tree/jquery.ztree.all.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=G5_THEME_URL?>/assets/tree/awesome.css"/>

    <ul id="treeDemo" class="ztree"></ul>

    <?php if($t_idx){ //메뉴배열?>
    <script>
    const zNodes =[
        <?php foreach($t_idx as $key => $val){
            $a_idx[$key]=$val;
        ?>
        { id : "<?=$t_idx[$key]?>", pId : "<?=$t_pidx[$key]?>", name:"<?=$t_title[$key]?>" },
        <?php } ?>
    ];
    const setting = {
        data: {
            simpleData: {
                enable: true,
            }
        }
    }

    $(document).ready(function(){
        $.fn.zTree.init($("#treeDemo"), setting, zNodes);
    });
    </script>
  <?php } //메뉴배열이 있음






  }else{
            $result=sql_query($sql);

            $menu_a=[];

            for($i=0;$rs=sql_fetch_array($result);$i++){

              $a_list[$i]=$rs["list"];
              $a_idx[$i]=$rs["idx"];
              $a_listorder[$i]=$rs["listorder"];
              $a_title[$i]=$rs["title"];
              $a_titleorder[$i]=$rs["titleorder"];
              $a_pidx[$i]=$rs["pidx"];
              $a_path[$i]=$total_code_title." > ".$rs["path"];
              $a_lvl[$i]=$rs["lvl"];

              $a_tabtitle[$i]=$rs["tabtitle"];
              $a_qcnt[$i]=$rs["qcnt"];


              $menu_b=explode(" > ", $rs["path"]);
              $menu_c=[];
              for($jj=0;$jj<count($menu_b);$jj++){
                $menu_c["path".$jj]=$menu_b[$jj];
              }
                array_push($menu_a, $menu_c);



      if(  ($rs["isopen"]==1||$rs["isopen"]=="")  ||  ($rs["isopen"]==0&&$is_admin)   ){
            ?>
            <div class="pp-sidebardiv togglediv d-flex" ctoggle="<?=$rs["fullidx"]?>"
                cchild="<?=($rs["lvl"]>1)?'true':''?>"
                style="<?=($list==$rs["list"])?'background:#eee':''; ?>">

              <?php if($question_search_page=="true"){
                if($rs["qcnt"]>0){?>
                    <input type="checkbox">
              <?php } }?>


                      <?if($rs["isopen"]==0){?><span class="position-absolute ms-n3 opacity-4"><i class="fas fa-lock fa-xs position-relative"></i></span><?}?>
                      <?php if($rs["lvl"]==1){?>
                      <div class="ps-1 pe-1">
                      <a class="togglediv cursor-pointer toggleright" ctoggle="<?=$rs["fullidx"]?>[<?=$rs["idx"]?>]" onclick="ftoggle('<?=$rs["fullidx"]?>[<?=$rs["idx"]?>]')"><i class="fas fa-caret-right"></i></a>
                      <a class="togglediv cursor-pointer toggledown pt-1" ctoggle="<?=$rs["fullidx"]?>[<?=$rs["idx"]?>]" style="display:none" onclick="ftoggle('<?=$rs["fullidx"]?>[<?=$rs["idx"]?>]')"><i class="fas fa-caret-down"></i></a>
                        <?php $tmp_ctoggle=$rs["fullidx"]."[".$rs["idx"]."]";?>
                      </div>
                      <?php } ?>

                  <div style="overflow:hidden;">
                      <?if($list==$rs["list"]){
                        $page_ctoggle=$tmp_ctoggle;
                      }?>

                      <a href="page?<?=$rs["list"]?>"><?=$rs["tabtitle"]?></a>
                  </div>

                        <?if ($rs["qcnt"]>0){ ?>
                        <div class="ms-auto">
                        <span class="mt-1 ct-docs-sidenav-q-badge"><?=$rs["qcnt"]?>문제</span>
                        </div>
                        <?}?>

            </div>
            <?
          }
        }
            ?>

          <?php
          } ///관리자 아닐경우?>
          <div class="pp-sidebardiv nohover"></div>
  <?php } //메뉴1단계 조건?>


</div>




<script>
function ftoggle(g){
    if(g=="hideall"){
      $(".togglediv[cchild='true']").toggle(false);
      $(".togglediv[cchild='true']").removeClass("d-flex");
      return;
    }
    $(".togglediv[ctoggle^='"+g+"']").toggle();
    if($(".togglediv[ctoggle^='"+g+"']").css("display")=="none"){
      //console.log("보임");
      $(".togglediv[ctoggle^='"+g+"']").addClass("d-flex");
      $(".toggleright[ctoggle^='"+g+"']").removeClass("d-flex")
    }else{
      //console.log("숨김");
      $(".togglediv[ctoggle^='"+g+"']").removeClass("d-flex");
    }
}

<?php if($i>20){?>
ftoggle('hideall');
<?php if($page_ctoggle!=""){?>
  ftoggle("<?=$page_ctoggle?>");
  <?php } ?>
<?php } ?>
</script>

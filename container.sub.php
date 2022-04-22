
<div class="container pp-main">

  <?php if($is_admin) { ?>
    <span class="pp-adm-btns">
    <a href="/edit?type=<?=$this_type?>" class="badge btn btn-outline-dark btn-sm shadow-sm text-dark"> + <?=$this_type?> 만들기</a>
    </span>
  <?php } ?>


      <div class="row">
        <div class="col-lg-3">
          <div class="position-sticky pb-lg-5 pb-3 mt-lg-0 mt-5 ps-2">
            <h3><?=$this_menufull?></h3>
            <h6 class="text-secondary font-weight-normal pe-3">
              <?=$this_menudetail?>
            </h6>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="row">

            <?php $sql="select title, subtitle, left(content, 60) as content, code, titleimg, imgpath, is_open
                , (select count(*) from tb_qlist where code=A.code) as qcnt
                from tb_container A where type='$this_type' order by is_open desc, title asc";
            $result=sql_query($sql);
            for($i=0;$row=sql_fetch_array($result);$i++){
              if(   (($row["is_open"]==0)&&($is_admin)) || ($row["is_open"]==1) ) {  ///공개되어 있어나 관리자 일경우
            ?>
                    <div class="col-md-4 mt-md-0 mb-4"  <?php if($row["is_open"]==0){echo("style='opacity:50%'");}?>>
                      <a href="/view?code=<?=$row["code"]?>">
                        <div class="card shadow-lg move-on-hover min-height-150">
                          <?php if($row["is_open"]==0){?> <span class="" ><i class="fas fa-lock position-absolute mt-1"></i></span> <?}?>
                          <?php if($row["titleimg"]!=""){?>
                            <img class="my-auto mx-auto" src="<?=G5_DATA_URL?><?=$row["imgpath"]?><?=$row["titleimg"]?>" style="width:100px;height:100px;object-fit:contain;">
                          <?php }else{ ?>
                            <div class="card-body d-flex">
                              <span class="my-auto mx-auto "><!--bg-light rounded-circle -->
                                <div class="text-center align-middle" style="text-shadow: 2px 2px 2px #efefef;text-align:center;width:100%;height:100%;color:#ccc;font-weight:900;font-size:20px;">
                                  <?=explode(" ",$row["title"])[0]?></div>
                              </span>
                            </div>
                          <?php }?>
                        </div>
                        <div class="mt-2 ms-2">
                          <h6 class="mb-0"><?=$row["title"]?> <?=$row["subtitle"]?></h6>
                          <p class="text-secondary text-sm"><?php if($row["qcnt"]>0){?><?=$row["qcnt"]?>문제<?}?></p>
                        </div>
                      </a>
                    </div>
            <?php
              }
            }
            ?>

          </div>

        </div>
      </div>
      <!--

      -->
</div>


<div class="container">
          <?php //컨테이너에서 type이 this_type(과목)으로 되어 있는 목록을 불러옵니다
          if(isset($is_groupview)){
          ?>
          <div class="d-none d-md-block">
            <div class="text-center mb-3">
              <input type=button value="전체" class=" tcard_dest btn-pp-r1" dest="">
            <?php
              $sqltmp="select title, count(*) as cnt from tb_container where type='$this_type' group by title order by cnt desc, title ";
              $rstmp=sql_query($sqltmp);
              for($i=0;$rs=sql_fetch_array($rstmp);$i++){?>
                <input type=button value="<?=$rs["title"]?> (<?=$rs["cnt"]?>)" class="tcard_dest btn-pp-r1" dest="<?=$rs["title"]?>">
              <?php }?>
            </div>
          </div>
          <div class="d-block d-md-none">
            <div class="text-center mb-3">
              <select class="form-control" id="tcard_select">
              <option value="">전체</option>
            <?php
              $sqltmp="select title, count(*) as cnt from tb_container where type='$this_type' group by title order by cnt desc, title ";
              $rstmp=sql_query($sqltmp);
              for($i=0;$rs=sql_fetch_array($rstmp);$i++){?>
                <option value="<?=$rs["title"]?>"><?=$rs["title"]?> (<?=$rs["cnt"]?>)</option>
            <?php
              }
            ?></select>
            </div>
          </div>

          <script>
            $(".tcard_dest").click(function(){
              var dest=$(this).attr("dest");
                if(dest==""){$(".tcard_target").show('normal');return;}
                $(".tcard_target[target!='"+dest+"']").hide('fast');
                $(".tcard_target[target='"+dest+"']").show('normal');
              });
            $("#tcard_select").bind("change", function(){
              var dest=$(this).val();
              if(dest==""){$(".tcard_target").show('normal');return;}
              $(".tcard_target[target!='"+dest+"']").hide('fast');
              $(".tcard_target[target='"+dest+"']").show('normal');
            });
          </script>
        <?php } ////////////////////////////////////////  그룹뷰 종료 ?>
  <div class="row">

          <?php $sql="select title, subtitle, left(content, 60) as content, code, titleimg, imgpath, is_open
              , (select count(*) from tb_qlist where code=A.code) as qcnt
              from tb_container A where type='$this_type' order by is_open desc, title asc";
          $result=sql_query($sql);
          for($i=0;$row=sql_fetch_array($result);$i++){
            if(   (($row["is_open"]==0)&&($is_admin)) || ($row["is_open"]==1) ) {  ///공개되어 있어나 관리자 일경우
          ?>
                        <!--
                            <div class="col-lg-4 col-md-4 col-sm-6 mb-4 tcard_target cardease" target="<?=$row["title"]?>">
                              <div class="card shadow cursor-pointer <?php if($row["is_open"]==0){?> opacity-50 <?}?>"
                                  onclick="location.href='/view?code=<?=$row["code"]?>'">
                                <div class="card-header">
                                  <?php if($row["is_open"]==0){?> <span class="" ><i class="fas fa-lock"></i></span> <?}?>
                                  <b><?=$row["title"]?></b>
                                </div>
                                <div class="card-body">
                                      <div  style="min-height:90px;">
                                        <?php if($row["titleimg"]!=""){?>
                                          <img src="<?=G5_DATA_URL?><?=$row["imgpath"]?><?=$row["titleimg"]?>" height=90 align="left" class="shadow-sm me-3">
                                        <?php } ?>

                                          <?php if(isset($is_subtitle)){?>
                                              <h6 class="card-title"><?=$row["subtitle"]?></h6>
                                          <? } ?>

                                          <p class="card-text">
                                            <?=cut_str($row["content"], 20, "...")?>
                                          </p>
                                          <?php if($row["qcnt"]>0){?><h6> <?=$row["qcnt"]?>문제 </h6><?}?>
                                        </div>

                                          <div class="text-end"><a href="/view?code=<?=$row["code"]?>" class="btn btn-light shadow-sm btn-sm">  보기  </a></div>

                                </div>
                              </div>
                            </div>
                      -->
          <?php
            }
          }
          ///////if($i==0){echo("$this_type 내용이 아직 없어요");}
          ?>


  </div><!--row-->
</div><!--container-->

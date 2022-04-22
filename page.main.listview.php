

          <section class="row">

            <?php
            //현재 목록의 하부페이지를 불러오는 쿼리
            //
            $sql="select idx, list, lvl, title, titleorder, titleimg, titleimgpath, titleicon, left(content, 60) as content
                  , isopen
                  ,pidx, fullidx
                  ,(select count(*) from tb_page where pidx=A.idx) as ccnt

                  ,(select count(*) from tb_pageq
                    where list in (select list from tb_page where concat(fullidx,'[',idx,']') like concat('%[',A.idx,']%'))
                   ) as qcnt

                  ,(select title from tb_page where idx=A.pidx) as ptitle
                  ,(select titleicon from tb_page where idx=A.pidx) as ptitleicon
                  ,(select titleicon from tb_page where title=A.title and titleicon!='' limit 1) as ntitleicon
                  from tb_page A where pidx=$page_idx
                  order by isopen desc
                    ,concat(ifnull(titleorder,''),title) asc
                  ";  //,(CASE WHEN parent_isdesc=1 THEN title END) DESC, (CASE WHEN parent_isdesc=0 THEN title END) ASC

//                  ,(select count(*) from tb_pageq where list in (select list from tb_page where code=A.code)) as qcnt_code


              //    echo($sql);
            $result=sql_query($sql);
            //echo($page_idx);

            for($i=0;$row=sql_fetch_array($result);$i++){
              if(   (($row["isopen"]==0)&&($is_admin)) || ($row["isopen"]==1) ) {  ///공개되어 있어나 관리자 일경우
            ?>

              <?php if($page_issublist=="card"||$page_issublist==""){?>





                    <div class="col-md-6 mt-md-0 mb-4 draggable " list="<?=$row["list"]?>"  <?php if($row["isopen"]==0){echo(" style='opacity:50%' ");}?>>
                      <a href="/page?<?=$row["list"]?>">
                          <div class="card shadow-lg move-on-hover droppable" list="<?=$row["list"]?>">
                                <?php if($row["isopen"]==0){?> <span class="" ><i class="fas fa-lock position-absolute mt-1"></i></span> <?}?>
                                <div class="card-body p-3">
                                  <div class="d-flex">

                                    <div class="avatar avatar-xl bg-gradient-dark border-radius-md p-2">
                                      <?if($row["titleimg"]!=""){?>
                                        <img width=50 src="<?=G5_DATA_URL?><?=$row["titleimgpath"]?><?=$row["titleimg"]?>">
                                      <?}elseif($row["titleicon"]!=""){?>
                                        <i class="<?=$row["titleicon"]?>"></i>
                                      <?}elseif($row["ptitleicon"]!=""){?>
                                        <i class="<?=$row["ptitleicon"]?>"></i>
                                      <?}elseif($row["ntitleicon"]!=""){?>
                                        <i class="<?=$row["ntitleicon"]?>"></i>
                                      <?}?>
                                    </div>


                                      <span class="ms-2 h5 listtitle"  list="<?=$row["list"]?>" style="letter-spacing:-1px;"><?=$row["title"]?></span>


                                    <div class="ms-1 my-auto">
                                      <?php if( ($row["qcnt"]>0)){?>
                                        <h6 class="mt-1"><?=$row["qcnt"]?>문제</h6>
                                      <?php } ?>
                                      <?php if($is_admin){?>
                                          <span style='font-size:11px'><?=$row["titleorder"]?> : <?=$row["pidx"]?> : <?=$row["fullidx"]?></span>
                                      <?php } ?>

                                      <div class="avatar-group">


                                        <!--
                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-toggle="tooltip" data-original-title="Jessica Rowland">
                                          <img alt="Image placeholder" src="../../assets/img/team-3.jpg" class="">
                                        </a>
                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-toggle="tooltip" data-original-title="Audrey Love">
                                          <img alt="Image placeholder" src="../../assets/img/team-4.jpg" class="rounded-circle">
                                        </a>
                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-toggle="tooltip" data-original-title="Michael Lewis">
                                          <img alt="Image placeholder" src="../../assets/img/team-2.jpg" class="rounded-circle">
                                        </a>
                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-toggle="tooltip" data-original-title="Jessica Rowland">
                                          <img alt="Image placeholder" src="../../assets/img/team-3.jpg" class="">
                                        </a>
                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-toggle="tooltip" data-original-title="Audrey Love">
                                          <img alt="Image placeholder" src="../../assets/img/team-4.jpg" class="rounded-circle">
                                        </a>-->
                                      </div>
                                     </div>
                                                  <div class="ms-auto">
                                                                  <div class="dropdown">
                                                                    <button class="btn btn-link text-secondary ps-0 pe-2" id="navbarDropdownMenuLink"
                                                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                      <i class="fa fa-ellipsis-v text-lg"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu ms-n4" aria-labelledby="navbarDropdownMenuLink">
                                                                      <a class="dropdown-item" href="javascript:;">Action</a>
                                                                      <a class="dropdown-item" href="javascript:;">Another action</a>
                                                                      <a class="dropdown-item" href="javascript:;">Something else here</a>
                                                                    </div>
                                                                  </div>
                                                  </div>
                                  </div>
                                  <hr class="horizontal dark">
                                  <!--

                                        <?php if($row["ccnt"]>0){?>
                                        <div class="row">
                                          <div class="col-6">
                                            <h6 class="text-sm mb-0">내용 : <?=$row["ccnt"]?></h6>
                                          </div>

                                          div class="col-6 text-end">
                                            <h6 class="text-sm mb-0">&nbsp;</h6>
                                          </div
                                        </div>
                                      <?php } ?>
                                      -->
                                </div>
                          </div>
                      </a>
                    </div>









              <?php }elseif($page_issublist=="list"){ ///////////////// 목록 타입?>

                      <!--
                      <div class="mt-2 mb-2">
                        <a href="/page?<?=$row["list"]?>">
                          <span class="mb-0 lead"><?=$row["title"]?> <?=$row["subtitle"]?></span>
                        </a>
                      <div>
                      -->
                    <a href="/page?<?=$row["list"]?>">
                    <table onmouseover="this.style.backgroundColor='#f2f2f2'" onmouseout="this.style.backgroundColor='#fff'"
                    style="<?php if($i==0){?>border-top:2px solid #67748e;<?}?>border-bottom:1px solid #b9bcbf;width:90%;margin:0 auto;">
                      <tr>
                        <td width="60%">
                          <div class="d-flex px-2 py-1">
                            <div style="width:60px;height:60px;padding-top:10px;">

                              <?if($row["titleimg"]!=""){?>
                                <img width=50 src="<?=G5_DATA_URL?><?=$row["titleimgpath"]?><?=$row["titleimg"]?>">
                              <?}elseif($row["titleicon"]!=""){?>
                                <i class="<?=$row["titleicon"]?>"></i>
                              <?}elseif($row["ptitleicon"]!=""){?>
                                <i class="<?=$row["ptitleicon"]?>"></i>
                              <?}elseif($row["ntitleicon"]!=""){?>
                                <i class="<?=$row["ntitleicon"]?>"></i>
                              <?}else{?>
                                  <i class="fas fa-pen"></i>
                              <?}?>
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-md"><?=$row["title"]?></h6>
                              <p class="text-xs text-secondary mb-0"><?=$row["ptitle"]?></p>
                            </div>
                          </div>
                        </td>
                        <td  width="20%">
                          <?php if($row["qcnt"]>0){ ?>
                          <p class="text-xs font-weight-bold mb-0">문제  <?=$row["qcnt"]?></p>
                          <?php } ?>

                          <?php if($is_admin){?>
                              <span style='font-size:11px'><?=$row["pidx"]?> : <?=$row["fullidx"]?></span>
                          <?php } ?>


                          <?php if($row["ccnt"]>0){?><p class="text-xs text-secondary mb-0">내용  <?=$row["ccnt"]?></p><?php } ?>
                        </td>
                        <td  width="20%" class="align-middle text-center">
                          <span class="badge btn text-secondary text-xs font-weight-bold">바로가기</span>
                        </td>
                      </tr>
                    </table>
                    </a>


              <?php }?>

            <?php
              }
            }
            ?>
          </section>

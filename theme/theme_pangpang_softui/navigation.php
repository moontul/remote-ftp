<!-- Navbar -->
<?if($navstyle!="round"){ /////// 라운드가 아닐경우 ?>
<div class="container-fluid fixed-top z-index-sticky top-0"> <!-----position-sticky---->
<?}else{?>
<div class="container fixed-top z-index-sticky top-0"> <!-----position-sticky---->
<?} ?>

  <div class="row">
    <div class="col-12">

      <?if($navstyle!="round"){?>

          <nav class="navbar navbar-expand-md navbar-light bg-white
          top-0 z-index-fixed shadow position-absolute py-2 start-0 end-0">

      <?}else{?>

          <nav class="navbar navbar-expand-md
            top-0 z-index-fixed shadow position-absolute blur blur-rounded  my-3 py-2 start-0 end-0 mx-3">

      <?} ?>
        <div class="container-fluid">

          <button id="toggler-pp-sidebar" class="btn-sm navbar-toggler bg-primary shadow-none ms-2" type="button"
          data-bs-toggle="collapse"
          data-bs-target="#pp-sidebar"
           aria-controls="pp-sidebar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon mt-2">
              <span class="navbar-pp navbar-toggler-bar bar1"></span>
              <span class="navbar-pp navbar-toggler-bar bar2"></span>
              <span class="navbar-pp navbar-toggler-bar bar3"></span>
            </span>
          </button>

          <button class="navbar-toggler bg-dark d-none shadow-none ct-docs-navbar-toggler" type="button"
           aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation"
           data-bs-target="#ct-docs-navbar" data-bs-toggle="collapse">
            <span class="navbar-toggler-icon mt-2">
              <span class="navbar-toggler-bar bar1"></span>
              <span class="navbar-toggler-bar bar2"></span>
              <span class="navbar-toggler-bar bar3"></span>
            </span>
          </button>

          <a class="navbar-brand font-weight-bolder ms-3 text-center" href="/" rel="tooltip"
          title="팡팡" data-placement="bottom">
            <span class="logoimg"><img src="<?=G5_THEME_URL?>/assets/img/pp64.png" width=24 border=0 valign="top"></span>
            <span class="logotxt">ANGPANG</span>
          </a>

          <button class="btn-sm navbar-toggler shadow-none ms-2 navbar-togger-main" type="button" data-bs-toggle="collapse"
          data-bs-target="#navigation"
           aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon mt-2">
              <span class="navbar-toggler-bar bar1"></span>
              <span class="navbar-toggler-bar bar2"></span>
              <span class="navbar-toggler-bar bar3"></span>
            </span>
          </button>

          <div class="collapse navbar-collapse w-100" id="navigation">
            <ul class="navbar-nav navbar-nav-hover w-100 ms-lg-auto ps-lg-1 e-0">

<?php //pp 그누보드에서 설정한 메뉴를 불러옵니다
$sql = " select *
      from {$g5['menu_table']}
      where me_use = '1'
        and length(me_code) = '2'
      order by me_order, me_id ";
$result = sql_query($sql, false);
$gnb_zindex = 999; // gnb_1dli z-index 값 설정용
$menu_datas = array();
for ($i=0; $row=sql_fetch_array($result); $i++) {
  $menu_datas[$i] = $row;

  $sql2 = " select *
        from {$g5['menu_table']}
        where me_use = '1'
          and length(me_code) = '4'
          and substring(me_code, 1, 2) = '{$row['me_code']}'
        order by me_order, me_id ";
  $result2 = sql_query($sql2);
  for ($k=0; $row2=sql_fetch_array($result2); $k++) {
    $menu_datas[$i]['sub'][$k] = $row2;
  }
}
$i = 0;
foreach( $menu_datas as $row ){
if( empty($row) ) continue;
?>
<?php if($row['sub']['0']) { //서브메뉴가 있음 dropdown-hover ?>

<li class="nav-item dropdown mx-1 <?=($i==0)?'ms-lg-auto':''?>" >
    <?php if($this_menu==$row['me_name']){?>
      <a href="<?php echo $row['me_link']; ?>" class="nav-link dropdown-toggle btn btn-sm bg-gradient-primary  btn-round mb-0 me-1 mt-2 mt-md-0 text-light font-weight-bold"
        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
        target="_<?php echo $row['me_target']; ?>"><?php echo $row['me_name'] ?></a>

    <?php }else{ ?>

            <a class="nav-link dropdown-toggle" href="<?php echo $row['me_link']; ?>"
              data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" target="_<?php echo $row['me_target']; ?>">
            <?php echo $row['me_name'] ?>
            </a>
    <?php } ?>

  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
  <?php
  // 하위 분류
  $k = 0;
  foreach( (array) $row['sub'] as $row2 ){
  if( empty($row2) ) continue;
  ?>
    <a class="dropdown-item ks4 f15 fw4" href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>"><?php echo $row2['me_name'] ?></a>
  <?php
  $k++;
  }   //end foreach $row2

  if($k > 0)
  echo '</ul>'.PHP_EOL;
  ?>


<?php }else{ //서브메뉴가 없는 기본메뉴?>
  <li class="nav-item nav-itemone mx-1 <?=($i==0)?'ms-lg-auto':''?>" >
    <?php if($this_menu==$row['me_name']){?>
      <a href="<?php echo $row['me_link']; ?>" class="nav-link btn btn-sm bg-gradient-primary btn-round mb-0 me-1 mt-2 mt-md-0 text-light font-weight-bold"
         target="_<?php echo $row['me_target']; ?>"><?php echo $row['me_name'] ?></a>
    <?php }else{ ?>
      <a href="<?php echo $row['me_link']; ?>" class="nav-link" target="_<?php echo $row['me_target']; ?>"><?php echo $row['me_name'] ?></a>
    <?php } ?>
  </li>
<?php }?>
</li>

<?php
$i++;
}   //end foreach $row
?>

            <li class="nav-item dropdown login">
                <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  			<?php if($is_member) { ?>
                          <?php if($is_admin) { ?>
                            <i class="fas fa-user-cog text-primary"></i>
                          <?php }else{ ?>
                  				<i class="fas fa-user-edit"></i>
                          <?php } ?>
                  			<?php }else{ ?>
                  			   <i class="far fa-user"></i>
                  			<?php } ?>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown" style="z-index:1004;">

                  <?php if($is_admin) { ?>
                    <li><a class="dropdown-item" href="<?php echo G5_URL?>/adm" target="_blank">관리자</a></li>
                    <li><hr class="dropdown-divider"></li>
                  <?php } ?>

                  <?php if($is_member) { ?>
                    <!--<li><a class="dropdown-item" href="<?php echo G5_URL ?>/mychk">오답노트</a></li>-->
                    <li><a class="dropdown-item" href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php">정보수정</a></li>
                    <li><a class="dropdown-item" href="#" onclick="if(confirm('로그아웃 할까요?')){location.href='<?php echo G5_URL?>/bbs/logout.php'}">로그아웃</a></li>
                  <?php }else{ ?>
                    <li><a class="dropdown-item" href="<?php echo G5_URL?>/bbs/login.php">로그인</a></li>
                    <li><a class="dropdown-item" href="<?php echo G5_URL?>/register">회원가입</a></li>
                  <?php } ?>
                </ul>
            </li>
            <li class="nav-item">
              <form class="d-flex" method="get" action="question"><!--search-->
              <div class="row text-center">
                 <div class="input-group">
                   <input class="form-control qsearch" size=10 name="q" placeholder="문제 검색" aria-label="문제 검색" type="text" >
                   <button type=submit class="input-group-text"><i class="fas fa-search" aria-hidden="true"></i></button>
                 </div>
             </div>
             </form>
            </li>
           </ul>


          </div>
        </div>
      </nav>
      <!-- End Navbar -->
    </div>
  </div>
</div>

<?php if($navstyle!="round"){?>
<div class="gap" style="height:60px;"></div>
<?php } ?>

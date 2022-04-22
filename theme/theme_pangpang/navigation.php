<header>
  <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm fixed-top">
    <div class="container">
  	   <a class="navbar-brand" href="<?php echo G5_URL?>" class="logo">
         <i class="fab fa-product-hunt" style="color:#ff00ff;"></i><span class="brandspan">angpang</span>
        </a>
       <button class="navbar-toggler navbar-dark" style="background-color: #ff00ff;"
        type="button"
        data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
        aria-controls="navbarResponsive" aria-expanded="false"
        aria-label="Toggle navigation">
           <span class="navbar-toggler-icon" style="font-size:12px;"></span>
      </button>

     <div class="collapse navbar-collapse" id="navbarResponsive" data-hover="dropdown" data-animations="fadeIn fadeIn fadeInUp fadeInRight">
       <ul class="navbar-nav ms-auto">
            		<?php
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
    			<?php if($row['sub']['0']) { ?>
    				<li class="nav-item dropdown megamenu-li">
    					<a class="nav-link dropdown-toggle f16" href="<?php echo $row['me_link']; ?>" id="navbarDropdownBlog"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" target="_<?php echo $row['me_target']; ?>">
    					<?php echo $row['me_name'] ?>
    					</a>
    						<!-- 서브 -->
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
    			<?php }else{?>
    				<li class="nav-item">
    				<a class="nav-link f16" href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>"><?php echo $row['me_name'] ?></a>
    				</li>
    			<?php }?>
    		</li>

    		<?php
    		$i++;
    		}   //end foreach $row

  		if ($i == 0) {  ?>
  			<li class="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <br><a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.<?php } ?></li>
  		<?php } ?>



        <li class="nav-item dropdown login">
          <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown"
              role="button" data-bs-toggle="dropdown" aria-expanded="false">
            			<?php if($is_member) { ?>
                    <?php if($is_admin) { ?>
                      <i class="fas fa-user-cog" style="color:#ff00ff"></i>
                    <?php }else{ ?>
            				<i class="fas fa-user-edit"></i>
                    <?php } ?>
            			<?php }else{ ?>
            			   <i class="far fa-user"></i>
            			<?php } ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown" style="z-index:2000;">

            <?php if($is_admin) { ?>
              <li><a class="dropdown-item" href="<?php echo G5_URL?>/adm">관리자</a></li>
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
        </ul>
        <form class="d-flex" method="get" action="search">
          <input class="form-control form-control-sm me-1 headersearch" type="text" name="q" placeholder="문제 검색" aria-label="문제 검색">
          <button class="btn btn-pp-outline-pink btn-sm" type="submit"><i class="fas fa-search"></i></button>
        </form>
  	  </div>


    </div>
  </nav>
</header>
<gap><div style="height:57px" class="gap"></div></gap>

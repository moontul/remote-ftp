<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/head.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    define('G5_IS_COMMUNITY_PAGE', true);
    include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
    return;
}
include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');

if($bo_table) {
	$E_bo = sql_fetch("SELECT * FROM g5_board where bo_table ='$bo_table'");
}

// 오늘 새글
function bo_count($bo){
	$cnt = 0;
	foreach (func_get_args() as $bo) {
		$table = "g5_write_".$bo;
		$sql = "select count(*) cnt from $table where wr_datetime >= CURRENT_DATE() and wr_is_comment=0";
		$row = sql_fetch($sql);
		$cnt += $row['cnt'];
	}
	return $cnt;;
}

?>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-------------------------- 네비게이션 -------------------------->
<?php include_once(G5_THEME_PATH.'/navigation.php');?>

<!-- nav와 내용사이 간격 = 내용이 안겹치게 -->
<div class="pangpang-main-space"></div>

<!-------------------------- 게시판 상단 배경 수정하는 곳 -------------------------->
<?php
	if($bo_table){
		include_once(G5_THEME_PATH.'/top_banner.php');
	}
?>
<!-------------------------- ./게시판 상단 배경 수정하는 곳 -------------------------->

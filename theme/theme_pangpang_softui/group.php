<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/group.php');
    return;
}

if(!$is_admin && $group['gr_device'] == 'mobile')
    alert($group['gr_subject'].' 그룹은 모바일에서만 접근할 수 있습니다.');

$g5['title'] = $group['gr_subject'];


$this_menu="커뮤니티";
$this_title="커뮤니티";
include_once(G5_THEME_PATH.'/head.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
?>
<?php include_once("page.wraptop.php");?>
<div class="col-lg-12 col-md-12 col-sm-12 pp-mainpage">

  <div class="ct-docs-page-title">
    <span class="ct-docs-page-h1-title"><?=$this_title?></span>
  </div>
  <hr class="ct-docs-hr">







<div class="d-flex flex-wrap">
<!-- 메인화면 최신글 시작 -->
<?php
//  최신글
$sql = " select bo_table, bo_subject
            from {$g5['board_table']}
            where gr_id = '{$gr_id}'
              and bo_list_level <= '{$member['mb_level']}'
              and bo_device <> 'mobile' ";
if(!$is_admin)
    $sql .= " and bo_use_cert = '' ";
$sql .= " order by bo_order ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $lt_style = "";
    if ($i%3 !== 0) $lt_style = "margin-left:2%";
    else $lt_style = "";
?>
  <div class="col-lg-6 col-md-6 col-12 p-3">
    <div class="card p-4 mb-2 h-100">
    <?php
    // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
    // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
    echo latest('theme/basic', $row['bo_table'], 6, 25);
    ?>
    </div>
  </div>
<?php
}
?>
<!-- 메인화면 최신글 끝 -->
</div>



</div>

<?php include_once("page.wrapbottom.php");?>
<?php
include_once(G5_THEME_PATH.'/tail.php');

<?php
$sub_menu = '600310';
include_once('./_common.php');

/*
if ($w == "u" || $w == "d")
    check_demo();

if ($w == 'd')
    auth_check_menu($auth, $sub_menu, "d");
else
    auth_check_menu($auth, $sub_menu, "w");

check_admin_token();
*/

/*
$co_row = array('co_id'=>'', 'co_include_head'=>'', 'co_include_tail'=>'');

if ($w == "" || $w == "u")
{
    if(isset($_REQUEST['co_id']) && preg_match("/[^a-z0-9_]/i", $_REQUEST['co_id'])) alert("ID 는 영문자, 숫자, _ 만 가능합니다.");

    $sql = " select * from {$g5['content_table']} where co_id = '$co_id' ";
    $co_row = sql_fetch($sql);
}

$co_id = isset($_REQUEST['co_id']) ? preg_replace('/[^a-z0-9_]/i', '', $_REQUEST['co_id']) : '';
$co_subject = isset($_POST['co_subject']) ? strip_tags(clean_xss_attributes($_POST['co_subject'])) : '';
$co_include_head = isset($_POST['co_include_head']) ? preg_replace(array("#[\\\]+$#", "#(<\?php|<\?)#i"), "", substr($_POST['co_include_head'], 0, 255)) : '';
$co_include_tail = isset($_POST['co_include_tail']) ? preg_replace(array("#[\\\]+$#", "#(<\?php|<\?)#i"), "", substr($_POST['co_include_tail'], 0, 255)) : '';
$co_tag_filter_use = isset($_POST['co_tag_filter_use']) ? (int) $_POST['co_tag_filter_use'] : 1;
$co_himg_del = (isset($_POST['co_himg_del']) && $_POST['co_himg_del']) ? 1 : 0;
$co_timg_del = (isset($_POST['co_timg_del']) && $_POST['co_timg_del']) ? 1 : 0;
$co_html = isset($_POST['co_html']) ? (int) $_POST['co_html'] : 0;
$co_content = isset($_POST['co_content']) ? $_POST['co_content'] : '';
$co_mobile_content = isset($_POST['co_mobile_content']) ? $_POST['co_mobile_content'] : '';
$co_skin = isset($_POST['co_skin']) ? clean_xss_tags($_POST['co_skin'], 1, 1) : '';
$co_mobile_skin = isset($_POST['co_mobile_skin']) ? clean_xss_tags($_POST['co_mobile_skin'], 1, 1) : '';
*/
$idx=$_POST["idx"];
$ctype=$_POST["ctype"];
$cmenu=$_POST["cmenu"];
$cmenufull=$_POST["cmenufull"];
$cmenudetail=$_POST["cmenudetail"];


if(strlen($code)==2){
    //고유코드 13중 뒤 6자리
    //$rand = strtoupper(substr(uniqid(sha1()),7));
    //$code= strtoupper($code).date("YmdHis").$rand;
}

// 관리자가 자동등록방지를 사용해야 할 경우
/*
if ((( isset($co_row['co_include_head']) && $co_row['co_include_head'] !== $co_include_head ) || ( isset($co_row['co_include_tail']) && $co_row['co_include_tail'] !== $co_include_tail )) && function_exists('get_admin_captcha_by') && get_admin_captcha_by()){
    include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

    if (!chk_captcha()) {
        alert('자동등록방지 숫자가 틀렸습니다.');
    }
}
*/

/*
@mkdir(G5_DATA_PATH."/content", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/content", G5_DIR_PERMISSION);

if ($co_himg_del)  @unlink(G5_DATA_PATH."/content/{$co_id}_h");
if ($co_timg_del)  @unlink(G5_DATA_PATH."/content/{$co_id}_t");

$error_msg = '';
if( $co_include_head ){

    $file_ext = pathinfo($co_include_head, PATHINFO_EXTENSION);

    if( ! $file_ext || ! in_array($file_ext, array('php', 'htm', 'html')) || ! preg_match('/^.*\.(php|htm|html)$/i', $co_include_head) ) {
        alert('상단 파일 경로의 확장자는 php, htm, html 만 허용합니다.');
    }
}
if( $co_include_tail ){

    $file_ext = pathinfo($co_include_tail, PATHINFO_EXTENSION);

    if( ! $file_ext || ! in_array($file_ext, array('php', 'htm', 'html')) || ! preg_match('/^.*\.(php|htm|html)$/i', $co_include_tail) ) {
        alert('하단 파일 경로의 확장자는 php, htm, html 만 허용합니다.');
    }
}
*/

/*
if( $co_include_head && ! is_include_path_check($co_include_head, 1) ){
    $co_include_head = '';
    $error_msg = '/data/file/ 또는 /data/editor/ 포함된 문자를 상단 파일 경로에 포함시킬수 없습니다.';
}

if( $co_include_tail && ! is_include_path_check($co_include_tail, 1) ){
    $co_include_tail = '';
    $error_msg = '/data/file/ 또는 /data/editor/ 포함된 문자를 하단 파일 경로에 포함시킬수 없습니다.';
}


if( function_exists('filter_input_include_path') ){
    $co_include_head = filter_input_include_path($co_include_head);
    $co_include_tail = filter_input_include_path($co_include_tail);
}

$co_seo_title = exist_seo_title_recursive('content', generate_seo_title($co_subject), $g5['content_table'], $co_id);


$sql_common = " co_include_head     = '$co_include_head',
                co_include_tail     = '$co_include_tail',
                co_html             = '$co_html',
                co_tag_filter_use   = '$co_tag_filter_use',
                co_subject          = '$co_subject',
                co_content          = '$co_content',
                co_mobile_content   = '$co_mobile_content',
                co_seo_title        = '$co_seo_title',
                co_skin             = '$co_skin',
                co_mobile_skin      = '$co_mobile_skin' ";


echo($sql_common);
*/
if ($w == "d"){  ///삭제
//    @unlink(G5_DATA_PATH."/content/{$co_id}_h");
//    @unlink(G5_DATA_PATH."/content/{$co_id}_t");
      $sql = " delete from tb_container_type where idx = '$idx' ";
      echo($sql);
      sql_query($sql);

      //tb_content도 삭제해야함
      //tb_question 연결값 업데이트 해야함

//    sql_query($sql);
}else{

  if ($idx == "")
  {
      $sql = " insert into tb_container_page(ctype, cmenu, cmenufull, cpage,cmenudetail) values('$ctype','$cmenu','$cmenufull','$cpage','$cmenudetail')";
      sql_query($sql);
      $idx = sql_insert_id();
      echo $idx;

  }
  else
  {
      $sql = " update tb_container_page
                set ctype='$ctype', cmenu='$cmenu', cmenufull='$cmenufull', cpage='$cpage', cmenudetail='$cmenudetail'
                where idx = '$idx' ";
      sql_query($sql);
      echo($sql);
  }
}
/*
if(function_exists('get_admin_captcha_by'))
    get_admin_captcha_by('remove');

g5_delete_cache_by_prefix('content-'.$co_id.'-');
*/
if ($w == "" || $w == "u")
{
  /*
    if ($_FILES['co_himg']['name'])
    {
        $dest_path = G5_DATA_PATH."/content/".$co_id."_h";
        @move_uploaded_file($_FILES['co_himg']['tmp_name'], $dest_path);
        @chmod($dest_path, G5_FILE_PERMISSION);
    }
    if ($_FILES['co_timg']['name'])
    {
        $dest_path = G5_DATA_PATH."/content/".$co_id."_t";
        @move_uploaded_file($_FILES['co_timg']['tmp_name'], $dest_path);
        @chmod($dest_path, G5_FILE_PERMISSION);
    }

    if( $error_msg ){
        alert($error_msg, "./contentform.php?w=u&amp;co_id=$co_id");
    } else {
        goto_url("./contentform.php?w=u&amp;co_id=$co_id");
    }
    */
    goto_url("./menu_edit.php?w=u&amp;idx=$idx");

}
else
{
    goto_url("./menu_list.php?idx=$idx");
}

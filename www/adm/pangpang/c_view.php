<?php
$sub_menu = '600100';
include_once('./_common.php');
include_once("./code_sub.php");  //코드 메뉴 설정파일
include_once('_conn.php');

if(substr($code,0,2)=="SJ"){$sub_menu="600300";}
if(substr($code,0,2)=="LC"){$sub_menu="600400";}
if(substr($code,0,2)=="BK"){$sub_menu="600500";}

$unitcode=$_GET["unitcode"];

include_once(G5_EDITOR_LIB);

$html_title = "콘텐츠";
$g5['title'] = $html_title.' 관리';
$readonly = '';

if ($w == "u")
{
    $html_title .= " 수정";
    $readonly = " readonly";

//    $sql = " select * from {$g5['content_table']} where co_id = '$co_id' ";
//    $co = sql_fetch($sql);
//    if (!$co['co_id'])
//        alert('등록된 자료가 없습니다.');
}
else
{
    $html_title .= ' 입력';
}

include_once (G5_ADMIN_PATH.'/admin.head.php');



if($unitcode!=""){

    $sql="select * from tb_content where unitcode='$unitcode'";
    $result = mysqli_query($conn, $sql);
    $row=$result->num_rows;

    foreach($result as $list)
    {
      $title=stripslashes($list["title"]);
      $content=stripslashes($list["content"]);
      $youtube=stripslashes($list["youtube"]);
      $w="u";
    }

}


?>

<form name="frmcontentform" action="./c_save.php" onsubmit="return frmcontentform_check(this);" method="post" enctype="MULTIPART/FORM-DATA" >
<input type="hidden" name="unitcode" value="<?=$unitcode?>">

<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="co_html" value="1">
<input type="hidden" name="token" value="">

<div class="tbl_frm01 tbl_wrap">
<table>
<caption><?php echo $g5['title']; ?> 목록</caption>
<colgroup>
    <col class="grid_4">
    <col>
</colgroup>
<tbody>

<tr>
<th scope="row"><label for="title">제목</label></th>
<td><input type=text name="title" class="frm_input"
value="<?=$title?>" size="90" autocomplete=off></td>
</tr>
<tr>
<th scope="row"><label for="content">내용</label></th>
<td><?php echo editor_html("content", get_text(html_purifier("$content"), 0)); ?>
</td>
</tr>
<tr>
<th scope="row"><label for="youtube">youtube</label></th>
<td><input type=text name="youtube" class="frm_input"
value="<?=$youtube?>" size="90" autocomplete=off></td>
</tr>

<!--
    <tr>
        <th scope="row"><label for="co_subject">제목</label></th>
        <td><input type="text" name="co_subject" value="<?php echo htmlspecialchars2($co['co_subject']); ?>"
           id="co_subject" required class="frm_input required" size="90"></td>
    </tr>
    <tr>
        <th scope="row">내용</th>
        <td><?php echo editor_html('co_content', get_text(html_purifier($co['co_content']), 0)); ?></td>
    </tr>

    <tr>
        <th scope="row"><label for="co_skin">스킨 디렉토리<strong class="sound_only">필수</strong></label></th>
        <td>
            <?php echo get_skin_select('content', 'co_skin', 'co_skin', $co['co_skin'], 'required'); ?>
        </td>
    </tr>


    <tr>
        <th scope="row"><label for="co_include_tail">하단 파일 경로</label></th>
        <td>
            <?php echo help("설정값이 없으면 기본 하단 파일을 사용합니다."); ?>
            <input type="text" name="co_include_tail" value="<?php echo $co['co_include_tail']; ?>" id="co_include_tail" class="frm_input" size="60">
        </td>
    </tr>

    <tr>
        <th scope="row"><label for="co_himg">상단이미지</label></th>
        <td>
            <input type="file" name="co_himg" id="co_himg">
            <?php
            $himg = G5_DATA_PATH.'/content/'.$co['co_id'].'_h';
            $himg_str = '';
            if (file_exists($himg)) {
                $size = @getimagesize($himg);
                if($size[0] && $size[0] > 750)
                    $width = 750;
                else
                    $width = $size[0];

                echo '<input type="checkbox" name="co_himg_del" value="1" id="co_himg_del"> <label for="co_himg_del">삭제</label>';
                $himg_str = '<img src="'.G5_DATA_URL.'/content/'.$co['co_id'].'_h" width="'.$width.'" alt="">';
            }
            if ($himg_str) {
                echo '<div class="banner_or_img">';
                echo $himg_str;
                echo '</div>';
            }
            ?>
        </td>
    </tr>
  -->
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <a href="./code_list.php?code=<?=$code?>" class="btn btn_02">목록</a>
    <input type="submit" value="확인" class="btn btn_submit" accesskey="s">
</div>

</form>

<?php
// [KVE-2018-2089] 취약점 으로 인해 파일 경로 수정시에만 자동등록방지 코드 사용
?>
<script>
var captcha_chk = false;

function use_captcha_check(){
    $.ajax({
        type: "POST",
        url: g5_admin_url+"/ajax.use_captcha.php",
        data: { admin_use_captcha: "1" },
        cache: false,
        async: false,
        dataType: "json",
        success: function(data) {
        }
    });
}

function frm_check_file(){
    var co_include_head = "<?php echo $co['co_include_head']; ?>";
    var co_include_tail = "<?php echo $co['co_include_tail']; ?>";
    var head = jQuery.trim(jQuery("#co_include_head").val());
    var tail = jQuery.trim(jQuery("#co_include_tail").val());

    if(co_include_head !== head || co_include_tail !== tail){
        // 캡챠를 사용합니다.
        jQuery("#admin_captcha_box").show();
        captcha_chk = true;

        use_captcha_check();

        return false;
    } else {
        jQuery("#admin_captcha_box").hide();
    }

    return true;
}

jQuery(function($){
    if( window.self !== window.top ){   // frame 또는 iframe을 사용할 경우 체크
        $("#co_include_head, #co_include_tail").on("change paste keyup", function(e) {
            frm_check_file();
        });

        use_captcha_check();
    }
});

function frmcontentform_check(f)
{
    var errmsg = "";
    var errfld = "";

        <?php echo get_editor_js(content); ?>
        <?php echo chk_editor_js(content); ?>

      //  alert($("#content").val())
    ///////<xxxxx?php echo get_editor_js('co_mobile_content'); ?xxxxx>


  //  check_field(f.co_id, "ID를 입력하세요.");
  //  check_field(f.co_subject, "제목을 입력하세요.");
  //  check_field(f.co_content, "내용을 입력하세요.");

    if (errmsg != "") {
        alert(errmsg);
        errfld.focus();
        return false;
    }

//    if( captcha_chk ) {
//        <xxxxx?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?xxxxx>
//    }

    return true;
}
</script>


<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>

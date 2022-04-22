<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

function editor_html($id, $content, $is_dhtml_editor=true)
{
    global $g5, $config, $w, $board, $write, $bo_table;
    static $js = true;

    if(
        $is_dhtml_editor && $content &&
        (
        (!$w && (isset($board['bo_insert_content']) && !empty($board['bo_insert_content'])))
        || ($w == 'u' && isset($write['wr_option']) && strpos($write['wr_option'], 'html') === false )
        )
    ){       //글쓰기 기본 내용 처리
        if( preg_match('/\r|\n/', $content) && $content === strip_tags($content, '<a><strong><b>') ) {  //textarea로 작성되고, html 내용이 없다면
            $content = nl2br($content);
        }
    }


    $editor_url = G5_EDITOR_URL.'/'.$config['cf_editor'];

    $html = "";
    $html .= "<span class=\"sound_only\">웹에디터 시작</span>";

    $smarteditor_class = $is_dhtml_editor ? "jodit" : "";
    $html .= "\n<textarea id=\"$id\" name=\"$id\" class=\"$smarteditor_class\" maxlength=\"65536\" style=\"width:100%;height:300px\">$content</textarea>";
    if ($is_dhtml_editor && $js) {
        $html .= "\n".'<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.4.25/jodit.min.css">';
        $html .= "\n".'<script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.4.25/jodit.min.js"></script>';
        $html .= "\n".'<script>var '.$id.'_editor = new Jodit("#'.$id.'",{
            uploader: {
                url: "'.$editor_url.'/upload.php?bo_table='.$bo_table.'",
                insertImageAsBase64URI: false,
                imagesExtensions: ["jpg", "png", "jpeg", "gif"],
                process: function (resp) {
                    for(var i=0;i<resp.data.images.length;i++){
                        '.$id.'_editor.setEditorValue('.$id.'_editor.getEditorValue() +"<img src=\'" + resp.data.baseurl + "/" + resp.data.images[i] + "\'>");
                    }
                    return true;
                }
            },
            height:300,
            allowResizeX: true,
            allowResizeY: true,
        });</script>';
        $js = false;
    }
    $html .= "\n<span class=\"sound_only\">웹 에디터 끝</span>";
    return $html;
}


// textarea 로 값을 넘긴다. javascript 반드시 필요
function get_editor_js($id, $is_dhtml_editor=true)
{
    if ($is_dhtml_editor) {
        return "var {$id}_editor_data = {$id}_editor.getEditorValue();";
    } else {
        return "var {$id}_editor = document.getElementById('{$id}');\n";
    }
}


//  textarea 의 값이 비어 있는지 검사
function chk_editor_js($id, $is_dhtml_editor=true)
{
    if ($is_dhtml_editor) {
        return "if (!{$id}_editor_data || jQuery.inArray({$id}_editor_data.toLowerCase(), ['&nbsp;','<p>&nbsp;</p>','<p><br></p>','<p></p>','<br>']) != -1) { alert(\"내용을 입력해 주십시오.\");return false; }\n";
    } else {
        return "if (!{$id}_editor.value) { alert(\"내용을 입력해 주십시오.\"); {$id}_editor.focus(); return false; }\n";
    }
}

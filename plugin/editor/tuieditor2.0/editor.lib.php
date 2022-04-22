<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

function editor_html($id, $content, $is_dhtml_editor=true)
{
    global $g5, $config, $w, $board, $write;
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
    $tuieditor_class = $is_dhtml_editor ? "tuieditor" : "";

    $html = "";
    $html .= "<span class=\"sound_only\">웹에디터 시작</span>";
    if ($is_dhtml_editor && $js) {
        /** 커스텀 플러그인 add */
        $html .= '<link rel="stylesheet" href="'.$editor_url.'/plugins/abcjs/css/abcjs-audio.css">';
        $html .= '<script src="'.$editor_url.'/plugins/abcjs/js/abc.min.js"></script>';

        /**필수 함수 */
        $html .= '<script src="'.$editor_url.'/js/babel.min.js"></script>';
        $html .= '<script src="'.$editor_url.'/js/toastui-editor-all.js"></script>';
        $html .= '<script src="'.$editor_url.'/i18n/ko-kr.js"></script>';
        $html .= '<script src="'.$editor_url.'/js/codemirror.js"></script>';
        $html .= '<script src="'.$editor_url.'/js/toastui-editor-plugin-chart.min.js"></script>';
        $html .= '<script src="'.$editor_url.'/js/toastui-editor-plugin-color-syntax.min.js"></script>';
        $html .= '<script src="'.$editor_url.'/js/toastui-editor-plugin-table-merged-cell.min.js"></script>';
        $html .= '<script src="'.$editor_url.'/js/toastui-editor-plugin-code-syntax-highlight-all.min.js"></script>';
        $html .= '<script src="'.$editor_url.'/js/toastui-editor-plugin-uml.min.js"></script>';
        $html .= '<script src="'.$editor_url.'/js/purify.js"></script>';
        $html .= '<script src="'.$editor_url.'/js/toastui-custom-plugin.js"></script>';
        $html .= '<link rel="stylesheet" href="'.$editor_url.'/css/codemirror.css">';
        $html .= '<link rel="stylesheet" href="'.$editor_url.'/css/toastui-editor.css">';
        $html .= '<link rel="stylesheet" href="'.$editor_url.'/css/tui-chart.min.css">';
        $html .= '<link rel="stylesheet" href="'.$editor_url.'/css/tui-color-picker.min.css">';
        $html .= '<link rel="stylesheet" href="'.$editor_url.'/css/github.min.css">';
        $js = false;
    }
    if($is_dhtml_editor){
        $html .= "<script type='text/babel' class='code-js'>";
        $html .= "var { Editor } = toastui;";
        $html .= "var { chart, codeSyntaxHighlight, colorSyntax, tableMergedCell, uml } = Editor.plugin;";
        $html .= 'var chartOptions = {';
        $html .= '    minWidth: 100,';
        $html .= '    maxWidth: 600,';
        $html .= '    minHeight: 100,';
        $html .= '    maxHeight: 300';
        $html .= '};';
        $html .= 'var colorSyntaxOptions = {';
        $html .= '    preset: ["#181818", "#292929", "#393939"],';
        $html .= '    useCustomSyntax: true';
        $html .= '};';
        $html .= "var tui_{$id} = new toastui.Editor({";
        $html .= "    el: document.querySelector('#tui-{$id}'),";
        $html .= "    initialEditType: 'wysiwyg',";
        //$html .= "    initialEditType: 'markdown',";
        $html .= "    previewStyle: 'vertical',";
        $html .= "    height: '500px',";
        $html .= "    language: 'ko',";
        $html .= "    placeholder: '내용을 입력하세요.',";
        $html .= "    plugins: [[chart, chartOptions], codeSyntaxHighlight, colorSyntax, tableMergedCell, uml, youtubePlugin, abcjsPlugin, PDFjsPlugin],";
        $html .= "    hooks: {";
        $html .= "      addImageBlobHook: function(fileOrBlob, callback, source){";
        $html .= "        console.log(source, callback);";
        $html .= "        sendFile('".$editor_url."', fileOrBlob, callback);";
        $html .= "        return false;";
        $html .= "      }";
        $html .= "    },";
        $html .= "    customHTMLSanitizer: html => {";
        $html .= "      return DOMPurify.sanitize(html);";
        $html .= "    }";
        $html .= "});";
        $html .="tui_{$id}.eventManager.addEventType('youtubeButton');";
        $html .="tui_{$id}.eventManager.listen('youtubeButton', function() {";
        $html .="  tui_{$id}.insertText('\\n```youtube\\n이곳에 유튜브 주소나 아이디를 입력하세요\\n```\\n');";
        $html .="});";
        $html .="tui_{$id}.getUI().getToolbar().insertItem(tui_{$id}.getUI().getToolbar()._items.length - 2, {";
        $html .="  type: 'button',";
        $html .="  options: {";
        $html .="    el : YoutubeButton(),";
        $html .="    event: 'youtubeButton',";
        $html .="    tooltip: '유튜브',";
        $html .="  }";
        $html .="});";
        $html .="function YoutubeButton() {";
        $html .="    const button = document.createElement('button');";
        $html .="    button.innerHTML = `<i class=\"fa fa-youtube\" style='color:#000;'></i>`;";
        $html .="    return button;";
        $html .="}";
        $html .="tui_{$id}.eventManager.addEventType('PDFButton');";
        $html .="tui_{$id}.eventManager.listen('PDFButton', function() {";
        $html .="  PDFupload(tui_{$id});";
        $html .="});";
        $html .="tui_{$id}.getUI().getToolbar().insertItem(tui_{$id}.getUI().getToolbar()._items.length - 2, {";
        $html .="  type: 'button',";
        $html .="  options: {";
        $html .="    el : PDFButton(),";
        $html .="    event: 'PDFButton',";
        $html .="    tooltip: 'PDF 뷰어',";
        $html .="  }";
        $html .="});";
        $html .="function PDFButton() {";
        $html .="    const button = document.createElement('button');";
        $html .="    button.innerHTML = `<i class=\"fa fa-file-pdf-o\" style='color:#000;'></i>`;";
        $html .="    return button;";
        $html .="}";
        $html .= "</script>";
        $html .= "\n"."<div id='tui-{$id}'></div>";
        $html .= "\n"."<textarea id=\"$id\" name=\"$id\" class=\"$tuieditor_class\" maxlength=\"65536\" style='display:none';>".$content."</textarea>";
        //$html .= "\n"."<script type='text/babel' class='code-js'>tui_wr_content.setMarkdown('```youtube\\nXyenY12fzAk\\n```');</script>";
        if($w != '') $html .= "\n"."<script type='text/babel' class='code-js'>tui_{$id}.setMarkdown(document.getElementById('".$id."').value);</script>";
    }
    if(!$is_dhtml_editor)
    {
        $html .= "\n"."<textarea id=\"$id\" name=\"$id\" class=\"$tuieditor_class\" maxlength=\"65536\" style=\"width:100%;min-width:260px;height:300px\">$content</textarea>";
    }
    $html .= "\n<span class=\"sound_only\">웹에디터 끝</span>";
    return $html;
}


// textarea 로 값을 넘긴다. javascript 반드시 필요
function get_editor_js($id, $is_dhtml_editor=true)
{
    if ($is_dhtml_editor) {
        return "var {$id}_editor_data = tui_{$id}.getMarkdown();\ndocument.getElementById('{$id}').value = {$id}_editor_data;\n";
    } else {
        return "var {$id}_editor = document.getElementById('{$id}');\n";
    }
}


//  textarea 의 값이 비어 있는지 검사
function chk_editor_js($id, $is_dhtml_editor=true)
{
    if ($is_dhtml_editor) {
        return "if (!tui_{$id}.getMarkdown()) { alert(\"내용을 입력해 주십시오.\"); return false;}\n";
    } else {
        return "if (!{$id}_editor.value) { alert(\"내용을 입력해 주십시오.\"); {$id}_editor.focus(); return false; }\n";
    }
}
?>

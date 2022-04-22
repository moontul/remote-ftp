function get_editor_wr_content()
{
    return wr_content_editor.getEditorValue();
}

function put_editor_wr_content(content)
{
    wr_content_editor.setEditorValue('')
    wr_content_editor.setEditorValue(content)
    return;
}
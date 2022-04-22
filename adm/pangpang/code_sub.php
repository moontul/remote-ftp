<?
  $code=$_REQUEST["code"];

  if($type=="과목"){
    $code_name="과목";
    $code_table="tb_container";
    $code_code="sjcode";
    $code_col_name=array("과목명","담당"); //목록컬럼
    $code_col=array("subjectname", "prof");

    $code_col_name_all=array("과목명","담당","과목설명"); //모든컬럼 편집용
    $code_col_all=array("subjectname", "prof", "subjectdesc");
    $code_col_type_all=array("text", "text", "textarea");

    $code_unittable="tb_subjectunit";
    $code_unitcode="sjucode";

    $code_unitorder="unitorder";
    $code_unitname="unitname";
    $code_u_idx="sju_idx";
    $code_p_idx="p_u_idx";
    $code_tab="u_tab";

    $sjcode=$code;
  }

  if($type=="강좌"){
    $code_name="강좌";
    $code_table="tb_container";
    $code_code="code";
    $code_col_name=array("과목명","담당"); //목록컬럼
    $code_col=array("title", "prof");

    $code_col_name_all=array("과목명","담당","과목설명"); //모든컬럼 편집용
    $code_col_all=array("subjectname", "prof", "subjectdesc");
    $code_col_type_all=array("text", "text", "textarea");

    $code_unittable="tb_subjectunit";
    $code_unitcode="sjucode";

    $code_unitorder="unitorder";
    $code_unitname="unitname";
    $code_u_idx="sju_idx";
    $code_p_idx="p_u_idx";
    $code_tab="u_tab";

    $sjcode=$code;
  }


  if($type=="도서"){
    $code_name="도서";
    $code_table="tb_container";
    $code_code="code";
    $code_col_name=array("도서명","저자","출판사");
    $code_col=array("title", "author", "publisher");

    $code_col_name_all=array("도서명","저자","출판사", "도서설명");
    $code_col_all=array("title", "author", "publisher", "bookdesc");
    $code_col_type_all=array("text", "text", "text", "textarea");


    $code_unittable="tb_bookunit";
    $code_unitcode="bkucode";

    $code_unitorder="unitorder";
    $code_unitname="unitname";
    $code_u_idx="bku_idx";
    $code_p_idx="p_u_idx";
    $code_tab="u_tab";

    $bkcode=$code;
  }

  if($type=="자격시험"){
    $code_name="자격시험";
    $code_table="tb_container";
    $code_code="code";
    $code_col_name=array("자격시험이름","응시일 회차");
    $code_col=array("title", "subtitle");

    $code_col_name_all=array("자격시험이름","응시일 회차", "자격시험 설명");
    $code_col_all=array("title", "subtitle", "content");
    $code_col_type_all=array("text", "text", "textarea");

    $code_unittable="tb_list";
    $code_unitcode="list";
    $code_u_idx="idx";

    $code_unitorder="listorder";
    $code_unitname="listtitle";
    $code_p_idx="pidx";
    $code_tab="u_tab";

    $lccode=$code;
  }

?>

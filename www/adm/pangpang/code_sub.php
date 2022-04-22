<?
  $code=$_GET["code"];
  if($code==""){$code=$_POST["code"];}


  if( strtoupper(substr($code, 0, 2))=="SJ"){
    $code_name="과목";
    $code_table="tb_subject";
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

  if(strtoupper(substr($code, 0, 2))=="BK"){
    $code_name="도서";
    $code_table="tb_book";
    $code_code="bkcode";
    $code_col_name=array("도서명","저자","출판사");
    $code_col=array("bookname", "author", "publisher");

    $code_col_name_all=array("도서명","저자","출판사", "도서설명");
    $code_col_all=array("bookname", "author", "publisher", "bookdesc");
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

  if(strtoupper(substr($code, 0, 2))=="LC"){
    $code_name="자격시험";
    $code_table="tb_license";
    $code_code="lccode";
    $code_col_name=array("자격시험이름","응시일 회차");
    $code_col=array("licensename", "licensedate");

    $code_col_name_all=array("자격시험이름","응시일 회차", "자격시험 설명");
    $code_col_all=array("licensename", "licensedate", "licensedesc");
    $code_col_type_all=array("text", "text", "textarea");

    $code_unittable="tb_licenseunit";
    $code_unitcode="lcucode";
    $code_u_idx="lcu_idx";

    $code_unitorder="unitorder";
    $code_unitname="unitname";
    $code_p_idx="p_u_idx";
    $code_tab="u_tab";

    $lccode=$code;
  }

?>

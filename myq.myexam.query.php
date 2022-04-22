<?php
if($this_mb_id==""){$this_mb_id=$member['mb_id'];}
$sqlq="
select code, list
, (select title from tb_container where code=Y.code) as title
, (select listtitle from tb_list where list=Y.list) as listtitle
, examcondition, examopen, examopentime, examclose, examclosetime, examlimit, is_test, is_cbt
, my_code, my_id, my_group
, (select count(*) from tb_answerlog where mb_id='".$this_mb_id."' and code=Y.code and list=Y.list and fromcbt=1 ) as my_cnt
from (
    select code, list
    , examopen, examopentime, examclose, examclosetime, examlimit, is_test, is_cbt
    , examcondition, max(my_code) as my_code, max(my_id) as my_id, max(my_group) as my_group

    from
    (
    select A.code, A.list, A.examcondition, A.examopen, A.examopentime, A.examclose, A.examclosetime, A.examlimit, A.is_test, A.is_cbt,
    B.mb_code as my_code, null as my_id, null as my_group
    from tb_exam A left outer join  tb_exam_codes B
    on A.code=B.code and A.list=B.list and A.is_cbt=1
    and B.mb_code = (select mb_3 from g5_member where mb_id='".$this_mb_id."')
";
if($this_code!=""){ $sqlq.=" and A.code='$this_code'";}
if($this_list!=""){ $sqlq.=" and A.list='$this_list'";}
$sqlq.="
    union all

    select A.code, A.list, A.examcondition, A.examopen, A.examopentime, A.examclose, A.examclosetime, A.examlimit, A.is_test, A.is_cbt,
    null as my_code, B.mb_id as my_id, null as my_group
    from tb_exam A left outer join  tb_exam_ids B
    on A.code=B.code and A.list=B.list and A.is_cbt=1
    and B.mb_id = (select mb_id from g5_member where mb_id='".$this_mb_id."')
";
if($this_code!=""){ $sqlq.=" and A.code='$this_code'";}
if($this_list!=""){ $sqlq.=" and A.list='$this_list'";}
$sqlq.="
    union all

    select A.code, A.list, A.examcondition, A.examopen, A.examopentime, A.examclose, A.examclosetime, A.examlimit, A.is_test, A.is_cbt,
    null as my_code, null as my_id, B.mb_group as my_group
    from tb_exam A left outer join  tb_exam_groups B
    on A.code=B.code and A.list=B.list and A.is_cbt=1
    and B.mb_group = (select mb_1 from g5_member where mb_id='".$this_mb_id."')
";
if($this_code!=""){ $sqlq.=" and A.code='$this_code'";}
if($this_list!=""){ $sqlq.=" and A.list='$this_list'";}
$sqlq.="

    ) X
    group by code, list
) Y
where (my_code is not null) or (my_id is not null) or (my_group is not null)
order by title, listtitle
";
?>

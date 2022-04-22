<?php
$sub_menu = "600710";
include_once("./_common.php");
$g5['title'] = "응시 결과";
include_once(G5_ADMIN_PATH.'/admin.head.php');
$sql = "
select count(*) as cnt
from (
	select idx
	from tb_answerlog
	group by code, list, mb_id
) A
";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

// 페이징 구현 --------------------------------------------------------
$page=$_GET["page"];
if($page==""){$page=1;}

$sql = "SELECT * FROM tb_answerlog";
$result = sql_query($sql);
$total_record=$total_count;
$list_record = 30; // 한 페이지에 보여줄 게시물 개수
$block_cnt = 5; // 하단에 표시할 블록 당 페이지 개수
$block_num = ceil($page / $block_cnt); // 현재 페이지 블록
$block_start = (($block_num - 1) * $block_cnt) + 1; // 블록의 시작 번호
$block_end = $block_start + $block_cnt - 1; // 블록의 마지막 번호
$total_page = ceil($total_record / $list_record); // 페이징한 페이지 수
if($block_end > $total_page){$block_end = $total_page;}// 블록 마지막 번호가 총 페이지 수보다 크면 마지막 페이지 번호를 총 페이지 수로 지정함
$total_block = ceil($total_page / $block_cnt); // 블록의 총 개수
$page_start = ($page - 1) * $list_record; // 페이지의 시작 (SQL문에서 LIMIT 조건 걸 때 사용)

$sql="select in_date, code, list, mb_id, count(*) as qcnt, sum(counttrue) as sumtrue ";
$sql=$sql . ",(select concat(title, subtitle) from tb_container where code=A.code) as title ";
$sql=$sql . ",(select listtitle from tb_list where list=A.list) as listtitle ";
$sql=$sql . " from tb_answerlog A where 1=1 ";
$sql=$sql . " group by code, list, mb_id";
$sql=$sql . " order by in_date desc";
$sql=$sql . " LIMIT $page_start, $list_record ";
$result = sql_query($sql);

//echo($sql);
$hrefsrc="a_list.php?qcode=$qcode&bkcode=$bkcode&bkucode=$bkucode";
?>

<div class="local_ov01 local_ov">
    <?php if ($page > 1) {?><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">처음으로</a><?php } ?>
    <span class="btn_ov01"><span class="ov_txt">전체 내용</span><span class="ov_num"> <?php echo $total_count; ?>건</span></span>
</div>

<div class="btn_fixed_top">
    <a href="./q_edit.php" class="btn btn_01">문제 추가</a>
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">일시</th>
        <th scope="col">시험</th>
        <th scope="col">아이디</th>
        <th scope="col">문제수</th>
        <th scope="col">결과</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i=0; $row=sql_fetch_array($result); $i++) {
        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_id"><?php echo $row['in_date']; ?></td>
        <td class="td_id"><?=$row['title']?><?=$row['listtitle']?></td>
        <td class="td_id"><?php echo $row['mb_id']; ?></td>

        <td class="td_left"><?=$row['qcnt']?></td>
        <td class="td_id"><?=$row['sumtrue']?></td>
        <td class="td_mng td_mng_l">
            <a href="./q_edit.php?w=u&amp;qcode=<?php echo $row['qcode']; ?>" class="btn btn_03"><span class="sound_only"><?php echo htmlspecialchars2($row['co_subject']); ?> </span>수정</a>
            <a href="" class="btn btn_02">보기</a>
            <input type=button value="삭제" onclick="if(confirm('이 응시결과를 정말 삭제할까요?')){location.href='./a_list_cbt_logdel.php?fromcbt=1&code=<?=$row["code"]?>&list=<?=$row["list"]?>&mb_id=<?=$row["mb_id"]?>'}" class="btn btn_02">
        </td>
    </tr>
    <?php
    }
    if ($i == 0) {
        echo '<tr><td colspan="3" class="empty_table">자료가 한건도 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>



<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>

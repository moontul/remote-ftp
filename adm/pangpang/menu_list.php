<?php
$sub_menu = "600310";
include_once("./_common.php");

$g5['title'] = "메뉴 페이지";

include_once(G5_ADMIN_PATH.'/admin.head.php');
?>

<?php
    $sql="select count(*) cnt from tb_container_page";
    $result = sql_fetch($sql);
    //$result = sql_query($sql);
    $total_count=$result["cnt"];

    $sql="select * from tb_container_page order by ctype";
?>
      <div class="local_ov01 local_ov">
          <?php if ($page > 1) {?><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">처음으로</a><?php } ?>
          <span class="btn_ov01"><span class="ov_txt">전체 내용</span><span class="ov_num"> <?php echo $total_count; ?>건</span></span>
      </div>

      <div class="btn_fixed_top">
          <a href="menu_edit.php?code=<?=$code?>" class="btn btn_01"><?=$code_name?> 만들기</a>
      </div>

      <div class="tbl_head01 tbl_wrap">
          <table>
          <caption><?php echo $g5['title']; ?> 목록</caption>
          <thead>
          <tr>

              <th scope="col" nowrap style="width:5%">No</th>
      				<th scope="col" nowrap>페이지</th>
              <th scope="col" nowrap>메뉴 이름</th>
              <th scope="col" nowrap>메뉴 전체이름</th>
              <th scope="col" nowrap>콘텐츠 타입</th>
              <th scope="col" nowrap>작업</th>

          </tr>
          </thead>
          <tbody>
          <?$result=sql_query($sql)?>
          <?php for($i=0;$row=sql_fetch_array($result);$i++){?>
          <?php
              $bg = 'bg'.($i%2);
          ?>
          <tr class="<?php echo $bg; ?>">
          <td  class="td_id"><input type="checkbox" name="idx" value="<?=$row['idx']?>"></td>
          <td class="td_left"><?=$row['cpage']?></td>
          <td class="td_left"><?=$row['cmenu']?></td>
          <td class="td_left"><?=$row['cmenufull']?></td>
          <td class="td_left"><?=$row['ctype']?></td>

          <td class="td_mng td_mng_l">
              <a href="./menu_edit.php?w=u&amp;idx=<?=$row['idx']?>" class="btn btn_03"><span class="sound_only"><?php echo htmlspecialchars2($row['co_subject']); ?> </span>수정</a>
              <a href="./menu_save.php?w=d&amp;idx=<?=$row['idx']?>" onclick="return delete_confirm(this);" class="btn btn_02"><span class="sound_only"><?php echo htmlspecialchars2($row['co_subject']); ?> </span>삭제</a>
          </td>
          </tr>




          <?php
          }
          if ($i == 0) {
              echo "<tr><td colspan='6' class='empty_table'>자료가 한건도 없습니다.</td></tr>";
          }
          ?>
          </tbody>
          </table>
      </div>

















<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>

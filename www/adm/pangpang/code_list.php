<?php
$sub_menu = "600100";
include_once("./_common.php");
include_once("./code_sub.php");

if(substr($code,0,2)=="SJ"){$sub_menu="600300";}
if(substr($code,0,2)=="LC"){$sub_menu="600400";}
if(substr($code,0,2)=="BK"){$sub_menu="600500";}

$g5['title'] = $code_name ." 목록";


include_once(G5_ADMIN_PATH.'/admin.head.php');
?>

<?php
    $sql="select * from ".$code_table." ";
    $result = mysqli_query($conn, $sql);
    //$result = sql_query($sql);
    $total_count=$result->num_rows;
?>
      <div class="local_ov01 local_ov">
          <?php if ($page > 1) {?><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">처음으로</a><?php } ?>
          <span class="btn_ov01"><span class="ov_txt">전체 내용</span><span class="ov_num"> <?php echo $total_count; ?>건</span></span>
      </div>

      <div class="btn_fixed_top">
          <a href="code_edit.php?code=<?=$code?>" class="btn btn_01"><?=$code_name?> 만들기</a>
      </div>

      <div class="tbl_head01 tbl_wrap">
          <table>
          <caption><?php echo $g5['title']; ?> 목록</caption>
          <thead>
          <tr>

              <th scope="col" nowrap style="width:5%">No</th>

              <? for($i=0;$i<count($code_col_name);$i++) {?>
      				<th scope="col" nowrap><?=$code_col_name[$i]?></th>
              <? } ?>

      				<th scope="col" nowrap>단원관리</th>
              <th scope="col" nowrap>작업</th>

          </tr>
          </thead>
          <tbody>
          <?php foreach($result as $i => $row){?>
          <?php
              $bg = 'bg'.($i%2);
          ?>
          <tr class="<?php echo $bg; ?>">
          <td  class="td_id"><input type="checkbox" name="" value="<?=$row[$code_code]?>"></td>
              <? for($x=0;$x<count($code_col);$x++) {?>
                      <? if($x==0){?>
                      <td class="td_left"><a href="code_view.php?code=<?=$row[$code_code]?>"><?=$row[$code_col[$x]]?></a></td>
                      <? }else{ ?>
                      <td class="td_left"><?=$row[$code_col[$x]]?></td>
                      <? }?>
              <? } ?>
          <td><a href="codeunit_list.php?code=<?=$row[$code_code]?>">단원관리</a></td>
          <td class="td_mng td_mng_l">
              <a href="./code_edit.php?w=u&amp;code=<?=$row[$code_code]?>" class="btn btn_03"><span class="sound_only"><?php echo htmlspecialchars2($row['co_subject']); ?> </span>수정</a>
              <a href="./code_view.php?code=<?=$row[$code_code]?>" class="btn btn_02"><span class="sound_only"><?php echo htmlspecialchars2($row['co_subject']); ?> </span> 보기</a>
              <a href="./code_save.php?w=d&amp;code=<?=$row[$code_code]?>" onclick="return delete_confirm(this);" class="btn btn_02"><span class="sound_only"><?php echo htmlspecialchars2($row['co_subject']); ?> </span>삭제</a>
          </td>
          </tr>




          <?php
          }
          if ($i == 0) {
              echo "<tr><td colspan='".(count($code_col_name)+3)."' class='empty_table'>자료가 한건도 없습니다.</td></tr>";
          }
          ?>
          </tbody>
          </table>
      </div>

















<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>

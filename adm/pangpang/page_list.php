<?php
$sub_menu = "600100";
include_once("./_common.php");
include_once("./code_sub.php");

$sub_menu="600300";

$g5['title'] = " 목록";

include_once(G5_ADMIN_PATH.'/admin.head.php');
?>

<?php
    $s_title=$_REQUEST["s_title"];
    $s_type=$_REQUEST["s_type"];
    $s_code=$_REQUEST["s_code"];
    $s_pidx=$_REQUEST["s_pidx"];

    $sql="select count(*) cnt from tb_page";
    $result = sql_fetch($sql);
    //$result = sql_query($sql);
    $total_count=$result["cnt"];

    $sql="select * from tb_page where 1=1 ";
    if($s_title!=""){$sql.=" and title like '%".$s_title."%' ";}
    if($s_type!=""){$sql.=" and type like '%".$s_type."%' ";}
    if($s_code!=""){$sql.=" and code like '%".$s_code."%' ";}
    if($s_pidx!=""){$sql.=" and pidx = '".$s_pidx."' ";}
    if($s_lvl!=""){$sql.=" and lvl = '".$s_lvl."' ";}

    $sql.="order by fullidx, title";
?>
      <div class="local_ov01 local_ov">
          <?php if ($page > 1) {?><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">처음으로</a><?php } ?>
          <span class="btn_ov01"><span class="ov_txt">전체 내용</span><span class="ov_num"> <?php echo $total_count; ?>건</span></span>
      </div>

      <div class="btn_fixed_top">

        <input type=button value="전체저장" class="btn btn_01" onclick="document.f.action='page_save.php';document.f.submit()">

          <a href="code_edit.php?code=<?=$code?>" class="btn btn_01"><?=$code_name?> 만들기</a>

      </div>

      <form name="f" method="post" action="?">
        이름 <input type=text size=25 name="s_title" value="<?=$s_title?>">
        type <input type=text size=25 name="s_type" value="<?=$s_type?>">
        code <input type=text size=25 name="s_code" value="<?=$s_code?>">
        pidx <input type=text size=5 name="s_pidx" value="<?=$s_pidx?>">
        lvl <input type=text size=5 name="s_lvl" value="<?=$s_lvl?>">

        <input type=button value="검색" onclick="document.f.action='?';document.f.submit()">


      <div class="tbl_head01 tbl_wrap">
          <table>
          <caption><?php echo $g5['title']; ?> 목록</caption>
          <thead>
          <tr>
              <th scope="col" nowrap style="width:5%">No</th>
      				<th scope="col" nowrap>이름</th>
      				<th scope="col" nowrap>type</th>
              <th scope="col" nowrap>code</th>
              <th scope="col" nowrap>idx</th>
              <th scope="col" nowrap>pidx</th>
              <th scope="col" nowrap>lvl</th>
              <th scope="col" nowrap>fullidx</th>
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
          <td  class="td_id"><input type="checkbox" name="" value="<?=$row['idx']?>">
            <input type=text size=2 name="idx_a[]" value="<?=$row['idx']?>">
          </td>
          <td class="td_left"><?=$row["title"]?></td>
          <td class="td_left"><?=$row["type"]?></td>
          <td class="td_left"><input type=text name="code_a[]" value="<?=$row["code"]?>" style="border:0;border-bottom:1px solid gray;"></td>
          <td class="td_left"><?=$row["idx"]?></td>
          <td class="td_left"><?=$row["pidx"]?></td>
          <td class="td_left"><?=$row["lvl"]?></td>
          <td class="td_left"><input type=text name="fullidx_a[]" value="<?=$row['fullidx']?>" style="border:0;border-bottom:1px solid gray;"></td>

          <td class="td_mng td_mng_l">
              <a href="./code_edit.php?w=u&amp;code=<?=$row['idx']?>" class="btn btn_03"><span class="sound_only"><?php echo htmlspecialchars2($row['co_subject']); ?> </span>수정</a>
              <a href="./code_view.php?code=<?=$row[$code_code]?>" class="btn btn_02"><span class="sound_only"><?php echo htmlspecialchars2($row['co_subject']); ?> </span> 보기</a>
              <a href="./code_save.php?w=d&amp;code=<?=$row[$code_code]?>" onclick="return delete_confirm(this);" class="btn btn_02"><span class="sound_only"><?php echo htmlspecialchars2($row['co_subject']); ?> </span>삭제</a>
          </td>
          </tr>

          <?php
          }
          if ($i == 0) {
              echo "<tr><td colspan='3' class='empty_table'>자료가 한건도 없습니다.</td></tr>";
          }
          ?>
          </tbody>
          </table>
      </div>

      </form>















<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>

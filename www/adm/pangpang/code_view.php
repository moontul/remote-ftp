<?php
$sub_menu = "600100";
include_once("./_common.php");
include_once("./code_sub.php");
include_once('_conn.php');

if(substr($code,0,2)=="SJ"){$sub_menu="600300";}
if(substr($code,0,2)=="LC"){$sub_menu="600400";}
if(substr($code,0,2)=="BK"){$sub_menu="600500";}

$g5['title'] = $code_name . " 보기";
include_once(G5_ADMIN_PATH.'/admin.head.php');
?>

<style>
.wrapper {
    font-family:'NanumSquare';
    display: flex;
    align-items: stretch;
}

#sidebar {
    min-width: 250px;
    max-width: 250px;

    min-height: 600px;
    font-family: "NanumSquare";
    font-size:16px;
    border-right:1px solid darkgray;
}
.sidebardiv{
  height:35px;
  padding-top:12px;
  padding-bottom:12px;
  overflow:hidden;
}

#sidebar.active {
    margin-left: -250px;
}
</style>
<style>
.tbl_nav {font-size:12px;}
</style>


<div class="container" style="margin-top:-20px;margin-left:-20px;">
  <!-- Wrapper -->
  <div class="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar">

                <?php
                if($code!=""){
                    $sql="select * , (select count(*) from tb_question where $code_unitcode=A.$code_unitcode) as qcnt from $code_unittable A where $code_code='$code' order by unitorder";
                    $result = mysqli_query($conn, $sql);
                  //  $row=$result->num_rows;
                  //echo($sql);
                ?>
                <div class="tbl_frm01 tbl_wrap tbl_nav">
                	<table>
                	<thead>
                	<tr>
                	<th nowrap width=80%>단원</th>
                  <th nowrap width=10%>편집</th>
                  <th nowrap width=10%>문제</th>
                	</tr>
                	</thead>
                	<tbody>
                <?php
                foreach($result as $list)
                {
                ?>
          				<tr>
                  <td width=70%><?for($i=0;$i<=$list['u_tab'];$i++){?> &nbsp;  &nbsp; <?}?>
                    <a href="c_view.php?unitcode=<?=$list[$code_unitcode]?>"><?=$list['unitname']?></a>
                  </td>
                  <td>
                    <a href="c_edit.php?unitcode=<?=$list[$code_unitcode]?>">편집</a>
                  </td>
                  <td>
                    <a href="q_edit.php?<?=$code_code?>=<?=$code?>&<?=$code_unitcode?>=<?=$list[$code_unitcode]?>">문제[<?=$list['qcnt']?>]</a>
                  </td>
          				</tr>
                <?php } ?>

                  </table>
                </div>
                <?php } ?>


    </nav>

    <!-- Page Content -->
    <div id="content" style="width:100%;margin:10px;">



          <h6>
          <br>
          <?php
          if($code!=""){
              $sql="select * from ".$code_table." where ".$code_code."='".$code."'";
              $result = mysqli_query($conn, $sql);
              $row=$result->num_rows;
              foreach($result as $list)
              {
                for($i=0;$i<count($code_col_all);$i++){
          ?>
          <b><?=$code_col_name_all[$i]?> : </b>

          <?=stripslashes($list[$code_col_all[$i]]);?>

          <br><br>
          <?    }
              }
          }
          ?>
          </h6>

          <?php
          if($code!=""){
              $sql="select * , (select count(*) from tb_question where $code_unitcode=A.$code_unitcode) as qcnt from $code_unittable A where $code_code='$code' order by unitorder";
              $result = mysqli_query($conn, $sql);
            //  $row=$result->num_rows;
            //echo($sql);
          ?>
          <hr>
          <!-- Page Heading -->
          <h5 class="h5 text-gray-900">단원 정보</h5>

          <div class="tbl_frm01 tbl_wrap">
          	<table>
          	<thead>
          	<tr>
          	<th nowrap width=70%>단원</th>
            <th nowrap width=10%>내용등록</th>
            <th nowrap width=10%>문제등록</th>
            <th nowrap width=10%>등록수</th>
          	</tr>
          	</thead>
          	<tfoot>
          	</tfoot>
          	<tbody>
          <?php
          foreach($result as $list)
          {
          ?>
          				<tr>
                  <td width=70%><?for($i=0;$i<=$list['u_tab'];$i++){?> &nbsp;  &nbsp; <?}?><?=$list['unitname']?></td>
                  <td>
                    <a href="c_edit.php?unitcode=<?=$list[$code_unitcode]?>">내용</a>
                  </td>
                  <td>
                    <a href="q_edit.php?<?=$code_code?>=<?=$code?>&<?=$code_unitcode?>=<?=$list[$code_unitcode]?>">등록</a>
                  </td>
                  <td>
                    <a href="q_list.php?bkcode=<?=$bkcode?>&<?=$code_unitcode?>=<?=$list[$code_unitcode]?>"><?=$list['qcnt']?></a></td>
          				</tr>
          <?php } ?>

          </table>
          </div>

          <hr>
          <?php } ?>

          <br><br>


          <div class="btn_fixed_top">
              <a href="./code_list.php?code=<?=$code?>" class="btn btn_02">목록</a>
              <a href="./code_edit.php?code=<?=$code?>" class="btn btn_submit">수정</a>
          </div>

          <!--
          <a href="code_edit.php?code=<?=$code?>" class="btn btn-primary btn-sm"><?=$code_name?> 정보 수정</a>
          <a href="codeunit_list.php?code=<?=$code?>" class="btn btn-primary btn-sm">단원 정보 수정</a>
          <a href="code_list.php?code=<?=$code?>" class="btn btn-secondary btn-sm"><?=$code_name?> 목록</a>
          &nbsp;
          <input type="button" value="<?=$code_name?> 삭제" class="btn btn-secondary btn-sm" onclick="isDel()">
          <form name=fdel method=post action="code_del.php"><input type=hidden name=code value="<?=$code?>"></form>

          <script>
          function isDel()
          {
            if(confirm("정말 삭제할까요?\n(<?=$code_name?>정보와 단원정보 모두 삭제되며 복구할 수 없습니다!)"))
            {
              document.fdel.submit();
            }
          }
          </script>
          -->
          </form>








        </div><!--page-->
      </div><!--wrapper-->
    </div><!--container-->










<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>

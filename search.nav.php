<?php ?>
<?php //@include_once("sidebar.sub.php");?>

<form name=fsearchsidebar method=post action="search">
<div class="ct-docs-sidebar-col">
<nav class="ct-docs-sidebar-collapse-links">
  <div class="pp-sidebardiv">
    <strong>문제 검색</strong>
  </div>

  <div class="pp-sidebardiv">
    검색어 <input type="text" name=q value="<?=$q?>" size=5>
  </div>

  <div class="">

    검색범위
    <?php
    ?>
    <div style="height:300px;overflow:auto;">

      <div>필터 : <input type="text"></div>

    <?php $sql="
    WITH RECURSIVE tmp1 AS
    (
        SELECT list, idx, title, pidx,
        title AS path, 1 AS lvl
        ,content, fullidx
        FROM tb_page WHERE lvl=0  and code='0'

        UNION ALL

        SELECT e.list, e.idx, e.title, e.pidx,
        CONCAT(t.path,' > ',e.title) AS path, t.lvl+1 AS lvl
        ,e.content, e.fullidx
        FROM tmp1 t JOIN (select * from tb_page) e
        ON t.idx=e.pidx
    )

    SELECT list, idx, title, pidx, path, lvl
    ,content, fullidx
    ,CONCAT(REPEAT('&nbsp;', (lvl-1)*4), title) tabtitle
    FROM tmp1 A
    ORDER BY path; ";

    //echo($sql);
    $result=sql_query($sql);
    for($i=0;$rs=sql_fetch_array($result);$i++){
    ?>
    <div class="listdiv" idx="<?=$rs['idx']?>" fullidx="<?=$rs['fullidx']?>"><!--style="<?if($rs["lvl"]>1){echo('display:none;');}?>"-->
      <input type="checkbox" class="listchk" fullidx="<?=$rs['fullidx']?>"  idx="<?=$rs["idx"]?>" name="list[]"
        <?if(strpos($liststr, $rs["list"])){ echo("checked"); }?>
        value="<?=$rs["list"]?>">
        <a href="page?<?=$rs["list"]?>"><?=$rs["tabtitle"]?></a>
    </div>
    <?
    }
    ?>
    </div>

    <script>
    $(".listchk").click(function(g){

      var idx=$(this).attr("idx");
//      $(".listdiv[fullidx*=',"+idx+"']").toggle(  $(this).prop("checked")   );
//      $(".listchk[fullidx*=',"+idx+"']").prop("checked",  $(this).prop("checked")   );

      return;
    })

    </script>

  </div>

  <div class="pp-sidebardiv">
    결과수 <input name="qlimits" type="text" size=5 value="<?=$qlimits?>">
  </div>

  <div class="pp-sidebardiv">
    뷰타입
    <input type="radio" value="card">카드
    <input type="radio" value="list">목록
  </div>

  <div class="pp-sidebardiv">
    순서
    <input type="radio" value="" <?if($qorder!="rand"){echo("checked");}?>>기본
    <input type="radio" value="rand" <?if($qorder=="rand"){echo("checked");}?>>랜덤
  </div>

  <div class="pp-sidebardiv nohover">
    <input type="submit" class="btn btn-sm btn-primary" value="검색">
  </div>

</nav>
</div>
</form>

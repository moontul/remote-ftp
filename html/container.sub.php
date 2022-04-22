<div class="margin-top-50"></div>
<div class="container-fluid">
  <div class="container">

    <?php if($is_admin) { ?>
      <div class="float-right">
      <a href="/edit?type=<?=$this_type?>" class="btn btn-secondary btn-pp"> + <?=$this_type?> 만들기</a>
      </div>
    <?php } ?>


    <div class="row">

    <?php //컨테이너에서 type이 this_type(과목)으로 되어 있는 목록을 불러옵니다 ?>
    <?php
    $sql="select *, (select count(*) from tb_qlist where code=A.code) as qcnt from tb_container A where type='$this_type'";
    $result=sql_query($sql);
    for($i=0;$row=sql_fetch_array($result);$i++){
    ?>

    <div class="col-sm-6 margin-bottom-20">
      <div class="card w-75">
        <div class="card-body">
          <h5 class="card-title">
            <?=$row["title"]?>

            <?php if(isset($is_subtitle)){?>
              <?=$row["subtitle"]?>
            <? } ?>
          </h5>
          <p class="card-text"><?=$row["content"]?></p>
          [<?=$row["qcnt"]?>]
          <a href="/view?code=<?=$row["code"]?>" class="btn btn-primary">보기</a>
        </div>
      </div>
    </div>
    <?php
    }
    if($i==0){echo("내용이 없어요");}
    ?>




    </div>
  </div>
</div>


<div class="collapse pp-sidebar show col-lg-3 col-md-3 col-0"
  id="pp-sidebar" style="background-image:url('<?=G5_THEME_URL?>/assets/img/notebg2.jpg');">

  <div class="position-sticky pb-1 mt-lg-0 mt-2 ps-2">

          <div class="pp-sidebardiv nohover" style="margin-top:14px;height:44px;padding-top:12px;">
            <strong>오답노트</strong>
          </div>
          <div class="pp-sidebardiv" style="height:44px;padding-top:12px;">
            &nbsp; &nbsp; <a href="/mynote">타임라인</a>
          </div>
        <!--
          <div class="pp-sidebardiv"  style="height:44px;padding-top:12px;">
            &nbsp; &nbsp; <a href="/myq?today">오늘 틀린 문제</a>
          </div>
        -->
          <div class="pp-sidebardiv"  style="height:44px;padding-top:12px;">
            &nbsp; &nbsp; <a href="/mynote?bad">자꾸 틀리는 문제</a>
          </div>
          <div class="pp-sidebardiv"  style="height:44px;padding-top:12px;">
            &nbsp; &nbsp; <a href="/mynote?star">중요표시문제</a>
          </div>

          <div class="pp-sidebardiv"  style="height:44px;padding-top:12px;">
            &nbsp; &nbsp; <a href="/mynote?chart">취약분석</a>
          </div>
          
          <!--
          <div class="pp-sidebardiv nohover"  style="height:44px;padding-top:12px;">
            <strong>내가 풀어야할 CBT</strong>
          </div>

          <?php
            include_once("myq.myexam.query.php");

            $result=sql_query($sqlq);
            //echo($sql);
            for($i=0;$rs=sql_fetch_array($result);$i++){
          ?>

            <div class="pp-sidebardiv p-1">
              &nbsp; &nbsp;
              <a href="view?code=<?=$rs["code"]?>&list=<?=$rs["list"]?>">
                [<?=$rs["title"]?>] <?=$rs["listtitle"]?> (<?=$rs["my_cnt"]?>)
              </a>
            </div>

          <? } ?>
        -->

          <div class="pp-sidebardiv nohover" style="height:44px;padding-top:12px;">
            <strong>내가 본 CBT결과</strong>
          </div>

            <?php
            //내가 푼 문제중 cbt가 있는지 검사
            $sqltmp="select page_list, count(*) as cnt, max(in_date) as in_date
            ,(select title from tb_page where list=A.page_list) as title
            from tb_answerlog A
            where A.mb_id='".$member["mb_id"]."' and A.fromcbt=1
            group by A.page_list
            ";
            //echo($sqltmp);
            $resulttmp=sql_query($sqltmp);
            for($i=0;$rstmp=sql_fetch_array($resulttmp);$i++){
            ?>
            <div class="pp-sidebardiv" style="height:44px;padding-top:12px;">
              &nbsp; &nbsp; <a href="/mycbt?list=<?=$rstmp["page_list"]?>"><?=$rstmp["title"]?> <?=date("m.d", strtotime($rstmp["in_date"]))?></a>
            </div>
            <?php
            }
            ?>


            <div class="pp-sidebardiv nohover"></div>
</div>
</div>

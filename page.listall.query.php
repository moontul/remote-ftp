<?php
$sql_listall="
WITH RECURSIVE tmp1 AS
(
   SELECT list, idx, title, pidx,
   title AS path, 1 AS lvl
   ,content
   FROM tb_page WHERE lvl=1

   UNION ALL

   SELECT e.list, e.idx, e.title, e.pidx,
   CONCAT(t.path,' > ',e.title) AS path, t.lvl+1 AS lvl
   ,e.content
   FROM tmp1 t JOIN (select * from tb_page ) e
   ON t.idx=e.pidx
)

SELECT list, idx, title, pidx, path, lvl
,content
,CONCAT(REPEAT('&nbsp;', (lvl-1)*4), title) tabtitle
FROM tmp1 A
ORDER BY path; ";
?>

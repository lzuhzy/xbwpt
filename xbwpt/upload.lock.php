<?php
require_once("include/bittorrent.php");
dbconn();
loggedinorreturn();
parked();

stdhead($lang_upload['head_upload']);
printf("<font color=red size=5>本站进入寒假特殊运行期，禁止发布种子，详情请查看相关公告</font>");
?>

<?php
stdfoot();
?>

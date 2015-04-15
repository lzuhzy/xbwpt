<?php
/*Amanda add 2011-12-25 删除搜索关键字*/
require "include/bittorrent.php";
dbconn();
loggedinorreturn();
require_once(get_langfile_path());
if (get_user_class() < UC_ADMINISTRATOR)
stderr("Error", "Access denied.");
if ($_POST['delsubmit'] != "")
{
	if ($_POST["keywords"] == "")
		stderr("Error","请输入要删除的关键词!");
	$keywords = $_POST["keywords"];
	
	$res = sql_query("SELECT count(*) FROM suggest WHERE keywords='$keywords'");
	$arr = mysql_fetch_row($res);
	if ($arr['0'] > 0)
		sql_query("DELETE FROM suggest WHERE keywords='".$keywords."'");
	else
		stderr("Error","关键词 \"".$keywords."\" 不存在!");
	
	stderr("ok","关键词 \"".$keywords."\" 已成功删除!");
	die;
}
stdhead("Add user");

?>
<h1><?php echo $lang_adduser['head_keywords']?></h1>
<form method=post action=delkeywords.php>
<table border=1 cellspacing=0 cellpadding=5>
<tr><td class=rowhead><?php echo $lang_adduser['text_keywords']?></td><td><input type=text name=keywords size=40></td></tr>
<tr><td colspan=2 align=center><input type=submit value="<?php echo $lang_adduser['submit_del_keywords']?>" name="delsubmit" class=btn></td></tr>
</table>
</form>
<?php stdfoot();


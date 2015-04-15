<?php
/*Amanda add 2011-12-25 附件管理*/
require "include/bittorrent.php";
dbconn();
loggedinorreturn();
require_once(get_langfile_path());
if (get_user_class() < UC_SYSOP)
	permissiondenied();

$shownotice=false;
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if ($_POST['sure'])
	{
//		$res=sql_query("DELETE FROM users WHERE enabled='no'");
		sql_query("UPDATE attachments SET inuse = 0") or sqlerr(__FILE__, __LINE__);
		$res = sql_query("SELECT descr FROM torrents") or sqlerr(__FILE__, __LINE__);
		$atts = array();
		while($row = mysql_fetch_array($res)){
			$attstemp = array();
			preg_match_all('/\[attach\](.*?)\[\/attach\]/',$row[0],$attstemp);
			$atts = array_merge($atts,$attstemp[1]);
		}
		$res = sql_query("SELECT body FROM posts") or sqlerr(__FILE__, __LINE__);
		while($row = mysql_fetch_array($res)){
			$attstemp = array();
			preg_match_all('/\[attach\](.*?)\[\/attach\]/',$row[0],$attstemp);
			$atts = array_merge($atts,$attstemp[1]);
		}
		$res = sql_query("SELECT descr FROM offers") or sqlerr(__FILE__, __LINE__);
		while($row = mysql_fetch_array($res)){
			$attstemp = array();
			preg_match_all('/\[attach\](.*?)\[\/attach\]/',$row[0],$attstemp);
			$atts = array_merge($atts,$attstemp[1]);
		}
		sql_query("UPDATE attachments SET inuse = 1 WHERE dlkey='".join("' OR dlkey='", $atts)."'") or sqlerr(__FILE__, __LINE__);
	}
	if($_POST['suredel']){
		$filepath = dirname(__FILE__)."/attachments/";
		$res = sql_query("SELECT location FROM attachments WHERE inuse = 0") or sqlerr(__FILE__, __LINE__);
		while($row = mysql_fetch_array($res)){
			if(file_exists($filepath.$row[0])){
				unlink($filepath.$row[0]);
			}
			if(file_exists($filepath.$row[0].".thumb.jpg")){
				unlink($filepath.$row[0].".thumb.jpg");
			}
		}
		sql_query("DELETE FROM attachments WHERE inuse = 0") or sqlerr(__FILE__, __LINE__);
		$shownotice=true;
	}
}
		$res=sql_query("SELECT count(*) FROM attachments WHERE inuse = 0") or sqlerr(__FILE__, __LINE__);
		$row = mysql_fetch_array($res);
		$deletecount=$row[0];
stdhead($lang_deletedisabled['head_delete_diasabled']);
begin_main_frame();
?>
<h1 align="center"><?php echo $lang_deletedisabled['text_delete_diasabled']?></h1>
<?php
if ($shownotice)
{
?>
<div style="text-align: center;"><?php echo $lang_deletedisabled['text_users_are_disabled']?></div>
<?php
}else{
?>
<div style="text-align: center;"><?php echo $lang_deletedisabled['text_delete_check_note']?></div>
<div style="text-align: center; margin-top: 10px;">
<form method="post" action="?">
<input type="hidden" name="sure" value="1" />
<input type="submit" value="<?php echo $lang_deletedisabled['submit_delete_check']?>" />
</form>
</div>
<p></p>
<div style="text-align: center;"><?php echo $lang_deletedisabled['text_delete_disabled_note']?></div>
<div style="text-align: center; margin-top: 10px;">
<form method="post" action="?">
<input type="hidden" name="suredel" value="1" />
<input type="submit" value="<?php echo $lang_deletedisabled['submit_delete_all_disabled_users']?>" />
<?php echo "<br />".$deletecount.$lang_deletedisabled['text_files_are_disabled']?>
</form>
</div>
<?php
}
end_main_frame();
stdfoot();
?>


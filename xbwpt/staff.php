<?php
require "include/bittorrent.php";
dbconn();
require_once(get_langfile_path());
//loggedinorreturn(true);
stdhead($lang_staff['head_staff']);

$Cache->new_page('staff_page', 900, true);
if (!$Cache->get_page()){
$Cache->add_whole_row();
begin_main_frame();
$secs = 900;
$dt = TIMENOW - $secs;
$onlineimg = "<img class=\"button_online\" src=\"pic/trans.gif\" /> <font color=red><b>当前在线</font>";
$offlineimg = "<img class=\"button_offline\" src=\"pic/trans.gif\" /> 当前离线";
$sendpmimg = "<img class=\"button_pm\" src=\"pic/trans.gif\" /> <font color=blue>发短消息</font>";

//----------删除了上面的一键客服、批评家、论坛版主，禹弟 20101230---------//
//--------------------- general staff section ---------------------------//
unset($ppl);
$res = sql_query("SELECT * FROM users WHERE class > ".UC_VIP." AND status='confirmed' ORDER BY class DESC, username") or sqlerr();
while ($arr = mysql_fetch_assoc($res))
{
	if($curr_class != $arr['class'])
	{
		$curr_class = $arr['class'];
		if ($ppl != "")
			$ppl .= "<tr height=15><td class=embedded colspan=5 align=right>&nbsp;</td></tr>";
		$ppl .= "<tr height=15><td class=embedded colspan=5 align=right>" . get_user_class_name($arr["class"],false,true,true) . "</td></tr>";
		$ppl .= "<tr>" . 
		"<td class=embedded><b>" . $lang_staff['text_username'] . "</b></td>".
		"<td class=embedded align=center><b>" . $lang_staff['text_country'] . "</b></td>".
		"<td class=embedded align=center><b>" . $lang_staff['text_online_or_offline'] . "</b></td>".
		"<td class=embedded align=center><b>" . $lang_staff['text_contact'] . "</b></td>".
		"<td class=embedded><b>" . $lang_staff['text_duties'] . "</b></td>".
		"</tr>";
		$ppl .= "<tr height=15><td class=embedded colspan=5><hr color=\"#4040c0\"></td></tr>";
	}
	$countryrow = get_country_row($arr['country']);
	$ppl .= "<tr><td class=embedded>". get_username($arr['id']) ."</td><td class=embedded ><img width=24 height=15 src=\"pic/flag/".$countryrow['flagpic']."\" title=\"".$countryrow['name']."\" style=\"padding-bottom:1px;\"></td>
 <td class=embedded> ".(strtotime($arr['last_access']) > $dt ? $onlineimg : $offlineimg)."</td>".
 "<td class=embedded><a href=sendmessage.php?receiver=".$arr['id']." title=\"".$lang_staff['title_send_pm']."\">".$sendpmimg."</a></td>".
 "<td class=embedded>".$arr['stafffor']."</td></tr>\n";
}

begin_frame($lang_staff['text_general_staff']."<font class=small> - [<a class=altlink href=contactstaff.php><b>".$lang_staff['text_apply_for_it']."</b></a>]</font>");
?>
<?php echo $lang_staff['text_general_staff_note'] ?>
<br /><br />
<table width=100% cellspacing=0 align=center>
	<?php echo $ppl?>
</table>
<?php
end_frame();

//--------------------- general staff section ---------------------------//


//--------------------- VIP section ---------------------------//

unset($ppl);
$res = sql_query("SELECT * FROM users WHERE class=".UC_VIP." AND status='confirmed' ORDER BY username") or sqlerr();
while ($arr = mysql_fetch_assoc($res))
{
	$countryrow = get_country_row($arr['country']);
	$ppl .= "<tr><td class=embedded>". get_username($arr['id']) ."</td><td class=embedded><img width=24 height=15 src=\"pic/flag/".$countryrow['flagpic']."\" title=\"".$countryrow['name']."\" style=\"padding-bottom:1px;\"></td>
 <td class=embedded> ".(strtotime($arr['last_access']) > $dt ? $onlineimg : $offlineimg)."</td>".
 "<td class=embedded><a href=sendmessage.php?receiver=".$arr['id']." title=\"".$lang_staff['title_send_pm']."\">".$sendpmimg."</a></td>".
 "<td class=embedded>".$arr['stafffor']."</td></tr>\n";
}

begin_frame($lang_staff['text_vip']);
?>
<?php echo $lang_staff['text_vip_note'] ?>
<br /><br />
<table width=100% cellspacing=0 align=center>
	<tr>
		<td class=embedded><b><?php echo $lang_staff['text_username'] ?></b></td>
		<td class=embedded><b><?php echo $lang_staff['text_country'] ?></b></td>
		<td class=embedded><b><?php echo $lang_staff['text_online_or_offline'] ?></b></td>
		<td class=embedded><b><?php echo $lang_staff['text_contact'] ?></b></td>
		<td class=embedded><b><?php echo $lang_staff['text_reason'] ?></b></td>
	</tr>
	<tr>
		<td class=embedded colspan=5>
			<hr color="#4040c0">
		</td>
	</tr>
	<?php echo $ppl?>
</table>
<?php
end_frame();

//--------------------- VIP section ---------------------------//
end_main_frame();
	$Cache->end_whole_row();
	$Cache->cache_page();
}
echo $Cache->next_row();
stdfoot();

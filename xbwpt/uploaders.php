<?php
require "include/bittorrent.php";
dbconn();
require_once(get_langfile_path());
loggedinorreturn();

if (get_user_class() < UC_UPLOADER)
    permissiondenied();

		$standardsize = 50;//单位为GB
		$standardcount = 15;
		$overcount = 25;
		$oversize = 85;//GB
		$salary = 10000;//工资
		$extrasalary = 0;
		if ($_GET['moderator']==1) $uploader = UC_MODERATOR;
		else $uploader = UC_UPLOADER;
	function extrasalary($torrentsize,$torrentcount)
	{
		global $standardsize;global $standardcount;global $overcount;global $oversize;global $salary;
		$torrentsize = mksize($torrentsize) -1;
		$extrasalary = $salary * rand(3,12) *0.1 * (log(($torrentsize/$standardsize))/log(10) + log(($torrentcount/$standardcount))/log(10) );
		if ($extrasalary < 10000) return false;
		 return (int)($extrasalary + $salary);
	}
	function checkout($torrentsize,$torrentcount)
	{	
		global $standardsize;global $standardcount;global $overcount;global $oversize;
		if($torrentsize < 1073741824) return false;
		if($torrentcount >= $overcount) return true;
		elseif(mksize($torrentsize) >= $oversize) return true;
		elseif(mksize($torrentsize) >= $standardsize && $torrentcount >= $standardcount) return true;
		else return false;
	}
$year=0+$_GET['year'];
if (!$year || $year < 2000)
$year=date('Y');
$month=0+$_GET['month'];
if (!$month || $month<=0 || $month>12)
$month=date('m');
$order=$_GET['order'];
if (!in_array($order, array('username', 'torrent_size', 'torrent_count')))
	$order='username';
if ($order=='username')
	$order .=' ASC';
else $order .= ' DESC';
stdhead($lang_uploaders['head_uploaders']);
begin_main_frame();
?>
<div style="width: 940px">
<?php
$year2 = substr($datefounded, 0, 4);
$yearfounded = ($year2 ? $year2 : 2007);
$yearnow=date("Y");

$timestart=strtotime($year."-".$month."-01 00:00:00");
$sqlstarttime=date("Y-m-d H:i:s", $timestart);
$timeend=strtotime("+1 month", $timestart);
$sqlendtime=date("Y-m-d H:i:s", $timeend);

print("<h1 align=\"center\">".$lang_uploaders['text_uploaders']." - ".date("Y-m",$timestart)."月 - 考核情况</h1>");
$date = date("Y-m",$timestart);

$yearselection="<select name=\"year\">";
for($i=$yearfounded; $i<=$yearnow; $i++)
	$yearselection .= "<option value=\"".$i."\"".($i==$year ? " selected=\"selected\"" : "").">".$i."</option>";
$yearselection.="</select>";

$monthselection="<select name=\"month\">";
for($i=1; $i<=12; $i++)
	$monthselection .= "<option value=\"".$i."\"".($i==$month ? " selected=\"selected\"" : "").">".$i."</option>";
$monthselection.="</select>";

?>
<div>
<form method="get" action="?">
<span>
<?php echo $lang_uploaders['text_select_month']?><?php echo $yearselection?>&nbsp;&nbsp;<?php echo $monthselection?>&nbsp;&nbsp;<input type="submit" value="<?php echo $lang_uploaders['submit_go']?>" />
</span>
</form>
</div>

<?php
$numres = sql_query("SELECT COUNT(users.id) FROM users WHERE class = ".$uploader) or sqlerr(__FILE__, __LINE__);
$numrow = mysql_fetch_array($numres);
$num=$numrow[0];
if (!$num)
	print("<p align=\"center\">".$lang_uploaders['text_no_uploaders_yet']."</p>");
else{
?>
<div style="margin-top: 8px; margin-bottom: 8px;">
<span id="order" onclick="dropmenu(this);"><span style="cursor: pointer;" class="big"><b><?php echo $lang_uploaders['text_order_by']?></b></span>
<span id="orderlist" class="dropmenu" style="display: none"><ul>
<li><a href="?year=<?php echo $year?>&amp;month=<?php echo $month?>&amp;order=username"><?php echo $lang_uploaders['text_username']?></a></li>
<li><a href="?year=<?php echo $year?>&amp;month=<?php echo $month?>&amp;order=torrent_size"><?php echo $lang_uploaders['text_torrent_size']?></a></li>
<li><a href="?year=<?php echo $year?>&amp;month=<?php echo $month?>&amp;order=torrent_count"><?php echo $lang_uploaders['text_torrent_num']?></a></li>
</ul>
</span>
</span>
<?php
echo "<span style=\"color:blue;font-size:22px;   \"> <br/>现行考核标准为：</span><br/>每月发布种子大小 >= <b>".$standardsize."GB</b>，<b style=\"color:red\">且</b>发布种子数量 >= <b>".$standardcount."</b>个。则视为合格<br/>如果发布种子大小 >= <b>".$oversize."GB</b>，<b style=\"color:red\">或</b>发布种子数量 >= <b>".$overcount."</b>个，则无视另一项数据，视为合格。<br/>拥有免流量账号的发布员考核标准为上述数字乘以2。人工判断是否合格。<br/><br/>发布员发布资源不得使用非法手段，不得发布违禁资源；<br/>发布员不得为了完成任务月末突击，一经发现，PASS!；<br/>发布员之间不得为抢发某一资源，产生争执或者交易；<br/>新加入的发布员根据加入的时间，上旬和中旬加入按满月考核，下旬加入本月免考核，无奖励。<span style=\"color:blue;font-size:20px;   \"> <br/>现行奖励标准为：每月通过考核奖励魔力值<b style=\"color:red\">$salary</b> ，数据给力则酌情增加(计算规则：<font size='2'>".'额外工资 = 基本工资 * rand(3,12) *0.1 * (log(上传大小/要求大小)/log(10) + log(发布种子数量/要求数量)/log(10) )，如果此数值小于(基本工资/2)，则发基本工资，否则发（额外工资+基本工资）。rand(3,12)为获取3到12之间的随机整数。</font>没有通过考核则没有奖励</span><br/>种子管理员考核不与发布员一同进行，标准待定。';
?>
</div>
<div style="margin-top: 8px">
<?php
	print("<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\" align=\"center\" width=\"940\"><tr>");
	print("<td class=\"colhead\">".$lang_uploaders['col_username']."</td>");
	print("<td class=\"colhead\">".$lang_uploaders['col_torrents_size']."</td>");
	print("<td class=\"colhead\">".$lang_uploaders['col_torrents_num']."</td>");
	print("<td class=\"colhead\">".$lang_uploaders['col_last_upload_time']."</td>");
	//print("<td class=\"colhead\">".$lang_uploaders['col_last_upload']."</td>");
	print("<td class=\"colhead\">是否合格</td>");
	if (get_user_class() >= UC_SYSOP)
	print("<td class=\"colhead\">发工资</td>");
	print("</tr>");
	$res = sql_query("SELECT users.id AS userid, users.username AS username, COUNT(torrents.id) AS torrent_count, SUM(torrents.size) AS torrent_size FROM torrents LEFT JOIN users ON torrents.owner=users.id WHERE users.class = ".$uploader." AND torrents.added > ".sqlesc($sqlstarttime)." AND torrents.added < ".sqlesc($sqlendtime)." GROUP BY userid ORDER BY ".$order);
	$hasupuserid=array();
	$usernameall = null;
	$unpasseduser = null;
	while($row = mysql_fetch_array($res))
	{
		$res2 = sql_query("SELECT torrents.id, torrents.name, torrents.added FROM torrents WHERE owner=".$row['userid']." ORDER BY id DESC LIMIT 1");
		$row2 = mysql_fetch_array($res2);
		print("<tr>");
		print("<td class=\"colfollow\">".get_username($row['userid'], false, true, true, false, false, true)."</td>");
		print("<td class=\"colfollow\">".($row['torrent_size'] ? mksize($row['torrent_size']) : "0")."</td>");
		print("<td class=\"colfollow\">".$row['torrent_count']."</td>");
		print("<td class=\"colfollow\">".($row2['added'] ? gettime($row2['added']) : $lang_uploaders['text_not_available'])."</td>");
		//print("<td class=\"colfollow\">".($row2['name'] ? "<a href=\"details.php?id=".$row2['id']."\">".htmlspecialchars($row2['name'])."</a>" : $lang_uploaders['text_not_available'])."</td>");
		print("<td class=\"colfollow\">".(checkout($row['torrent_size'],$row['torrent_count'])?"<b style=\"color:green\">合格</b>":"<b style=\"color:red\">不合格</b>"));
		if (get_user_class() >= UC_SYSOP){
		$username = get_username($row['userid'], false,false, false, false, false, false, false, false, true);
		if (checkout($row['torrent_size'],$row['torrent_count'])){
		if ($extrasalary = extrasalary($row['torrent_size'],$row['torrent_count']))
		{
		print("<td class=\"colfollow\"><form method=\"post\" action=\"amountbonus.php\" ><input type='text' value=$extrasalary name='seedbonus'/><input type='hidden' value='$username' name='username'/><br/><input type='text' value='$date 月发种非常给力，感谢贡献~额外奖励奉上' name='reason_1'/><br/><input type=\"submit\" value=\"单独给他发工资\" class=\"btn\"/></form></td>");}
		else {
		print("<td calss=\"colfollow\">最后统一发</td>");
		$usernameall .= $username.",";}
		}
		else {print("<td class=\"colfollow\">不给他发工资</td>");$unpassuser .= $username.",";}}
		print("</tr>");
		$hasupuserid[]=$row['userid'];
		unset($row2);
	}
	$res3=sql_query("SELECT users.id AS userid, users.username AS username, 0 AS torrent_count, 0 AS torrent_size FROM users WHERE class = ".$uploader.(count($hasupuserid) ? " AND users.id NOT IN (".implode(",",$hasupuserid).")" : "")." ORDER BY username ASC") or sqlerr(__FILE__, __LINE__);
	while($row = mysql_fetch_array($res3))
	{
		$res2 = sql_query("SELECT torrents.id, torrents.name, torrents.added FROM torrents WHERE owner=".$row['userid']." ORDER BY id DESC LIMIT 1");
		$row2 = mysql_fetch_array($res2);
		print("<tr>");
		print("<td class=\"colfollow\">".get_username($row['userid'], false, true, true, false, false, true)."</td>");
		print("<td class=\"colfollow\">".($row['torrent_size'] ? mksize($row['torrent_size']) : "0")."</td>");
		print("<td class=\"colfollow\">".$row['torrent_count']."</td>");
		print("<td class=\"colfollow\">".($row2['added'] ? gettime($row2['added']) : $lang_uploaders['text_not_available'])."</td>");
		//print("<td class=\"colfollow\">".($row2['name'] ? "<a href=\"details.php?id=".$row2['id']."\">".htmlspecialchars($row2['name'])."</a>" : $lang_uploaders['text_not_available'])."</td>");
		print("<td class=\"colfollow\">".(checkout($row['torrent_size'],$row['torrent_count'])?"<b style=\"color:green\">合格</b>":"<b style=\"color:red\">不合格</b>"));
		if (get_user_class() >= UC_SYSOP){
		$username = get_username($row['userid'], false,false, false, false, false, false, false, false, true);
		if (checkout($row['torrent_size'],$row['torrent_count'])){
		if ($extrasalary = extrasalary($row['torrent_size'],$row['torrent_count']))
		{
		print("<td class=\"colfollow\"><form method=\"post\" action=\"amountbonus.php\" ><input type='text' value=$extrasalary name='seedbonus'/><input type='hidden' value='$username' name='username'/><br/><input type='text' value='$date  月发种非常给力，感谢贡献~额外奖励奉上~工资计算公式非常好玩哦' name='reason_1'/><br/><input type=\"submit\" value=\"单独给他发工资\" class=\"btn\"/></form></td>");}
		else {
		print("<td calss=\"colfollow\">最后统一发</td>");
		$usernameall .= $username.",";}
		}
		else {print("<td class=\"colfollow\">不给他发工资</td>");$unpassuser .= $username.",";}}
		print("</tr>");
		
		
		$count++;
		unset($row2);
	}
	if (get_user_class() >= UC_SYSOP){
		$usernameall = rtrim($usernameall,",");
		$unpassuser = rtrim($unpassuser,",");
		print("<tr><td></td><td></td><td></td><td class=\"colfollow\"><form method=\"post\" action=\"amountbonus.php\" ><input type='text' value=5000 name='seedbonus'/><br/><input type='text' value='$unpassuser' name='username'/><br/><input type='text' value='很遗憾$date 月发布员考核没有通过，下月加油，连续不能通过考核将取消发布员资格' name='reason_1'/><br/><input type=\"submit\" value=\"给他们发工资\" class=\"btn\"/></form></td><td></td><td class=\"colfollow\"><form method=\"post\" action=\"amountbonus.php\" ><input type='text' value=$salary name='seedbonus'/><br/><input type='text' value='$usernameall' name='username'/><br/><input type='text' value='恭喜$date 月发布员考核通过，工资奉上' name='reason_1'/><br/><input type=\"submit\" value=\"给他们发工资\" class=\"btn\"/></form></td></tr>");
		}
	print("</table>");
?>
</div>

<?php
}
?>
</div>
<?php
end_main_frame();
stdfoot();
?>


<?php

function torrenttable2($res) {
	global $Cache;
	global $lang_functions;
	global $CURUSER, $waitsystem;
	global $showextinfo;
	global $torrentmanage_class, $smalldescription_main, $enabletooltip_tweak;
	global $CURLANGDIR;
?>
<table class="torrents" cellspacing="0" cellpadding="5" width="100%">
<tr>
<?php
$count_get = 0;

foreach ($_GET as $get_name => $get_value) {
	$get_name = mysql_real_escape_string(strip_tags(str_replace(array("\"","'"),array("",""),$get_name)));
	$get_value = mysql_real_escape_string(strip_tags(str_replace(array("\"","'"),array("",""),$get_value)));
}
?>
<td class="colhead" style="padding: 0px"><?php echo $lang_functions['col_type'] ?></td>
<td class="colhead"><?php echo $lang_functions['col_name'] ?></td>
<td class="colhead"><img class="time" src="pic/trans.gif" alt="time" title="<?php echo ($CURUSER['timetype'] != 'timealive' ? $lang_functions['title_time_added'] : $lang_functions['title_time_alive'])?>" /></td>
<td class="colhead"><img class="size" src="pic/trans.gif" alt="size" title="<?php echo $lang_functions['title_size'] ?>" /></td>
<td class="colhead"><img class="seeders" src="pic/trans.gif" alt="seeders" title="<?php echo $lang_functions['title_number_of_seeders'] ?>" /></td>
<td class="colhead"><img class="leechers" src="pic/trans.gif" alt="leechers" title="<?php echo $lang_functions['title_number_of_leechers'] ?>" /></td>
<td class="colhead"><img class="snatched" src="pic/trans.gif" alt="snatched" title="<?php echo $lang_functions['title_number_of_snatched']?>" /></td>
<td class="colhead">竞价者</td>
<td class="colhead">出价</td>
<td class="colhead">期限</td>
</tr>
<?php

$counter = 0;
if ($smalldescription_main == 'no' || $CURUSER['showsmalldescr'] == 'no')
	$displaysmalldescr = false;
else $displaysmalldescr = true;
while ($row = mysql_fetch_assoc($res))
{
	$id = $row["id"];
	$sphighlight =($row["seeders"]>0?" class='halfdown_bg'":"");
	print("<tr" . $sphighlight . ">\n");

	print("<td class=\"rowfollow nowrap\" valign=\"middle\" style='padding: 0px'>");
	if (isset($row["category"])) {
		print(return_category_image($row["category"]));
	}
	else
		print("-");
	print("</td>");

	//torrent name
	$dispname = trim($row["name"]);
	$count_dispname=mb_strlen($dispname,"gb2312");
	if (!$displaysmalldescr || $row["small_descr"] == "")// maximum length of torrent name
		$max_length_of_torrent_name = 120;
	elseif ($CURUSER['fontsize'] == 'large')
		$max_length_of_torrent_name = 70;
	elseif ($CURUSER['fontsize'] == 'small')
		$max_length_of_torrent_name = 90;
	else $max_length_of_torrent_name = 80;

	if($count_dispname > $max_length_of_torrent_name)
		$dispname=mb_strcut($dispname, 0, ($max_length_of_torrent_name*3/2),"UTF-8") . "..";
	
	print("<td class=\"rowfollow\" width=\"100%\" align=\"left\" style='padding-top:0;padding-bottom: 0px;'><table " . $sphighlight . " width=\"100%\"><tr" . $sphighlight . "><td class=\"embedded\"><a  href=\"details.php?id=".$id."&amp;hit=1\"><b>".htmlspecialchars($dispname)."</b></a>");

	if ($displaysmalldescr){
		//small descr
		$dissmall_descr = trim($row["small_descr"]);
		$count_dissmall_descr=mb_strlen($dissmall_descr,"gb2312");
		$max_lenght_of_small_descr=$max_length_of_torrent_name; // maximum length
		if($count_dissmall_descr > $max_lenght_of_small_descr)
		{
			$dissmall_descr=mb_strcut($dissmall_descr, 0, $max_lenght_of_small_descr+20,"UTF-8") . "..";
		}
		print($dissmall_descr == "" ? "" : "<br />".htmlspecialchars($dissmall_descr));
		
	}
	print("</td>");
	print("</tr></table></td>");

        $time = $row["added"];
        $time = gettime($time,false,false);

        print("<td class=\"rowfollow\" width=\"65px\">". $time. "</td>");
	print("<td class=\"rowfollow nowrap\">" . mksize($row["size"])."</td>");

	if ($row["seeders"]) {
		$ratio = ($row["leechers"] ? ($row["seeders"] / $row["leechers"]) : 1);
		$ratiocolor = get_slr_color($ratio);
		print("<td class=\"rowfollow\" align=\"center\"><b><a href=\"details.php?id=".$id."&amp;hit=1&amp;dllist=1#seeders\">".($ratiocolor ? "<font color=\"". $ratiocolor . "\">" . number_format($row["seeders"]) . "</font>" : number_format($row["seeders"]))."</a></b></td>");
	}
	else
		print("<td class=\"rowfollow\"><span class=\"" . linkcolor($row["seeders"]) . "\">" . number_format($row["seeders"]) . "</span></td>");

        if ($row["leechers"]) {
                print("<td class=\"rowfollow\"><b><a href=\"details.php?id=".$id."&amp;hit=1&amp;dllist=1#leechers\">" .number_format($row["leechers"]) . "</a></b></td>");
        }
        else
                print("<td class=\"rowfollow\">0</td>");

	if ($row["times_completed"] >=1)
	print("<td class=\"rowfollow\"><a href=\"viewsnatches.php?id=".$row[id]."\"><b>" . number_format($row["times_completed"]) . "</b></a></td>");
	else
	print("<td class=\"rowfollow\">" . number_format($row["times_completed"]) . "</td>");

	print("<td class=\"rowfollow\" align=\"center\" >".(isset($row["owner"]) ?  get_username($row["owner"])  : "<i>".$lang_functions['text_orphaned']."</i>") .($row["times"]>0 ?  "(".$row["times"].")"  :""). "</td>\n");

	print("<td class=\"rowfollow\" >".$row["money"]."</td>\n");
	
	$timeout=gettime(date("Y-m-d H:i:s", strtotime($row["until"])), false, false, true, false, true);
	print("<td class=\"rowfollow nowrap\">" .$timeout."</td>");
	PRINT("</tr>");
	$counter++;
}
print("</table>");

}

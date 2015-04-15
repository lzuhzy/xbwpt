<?php
//$_NO_COMPRESS = true; //== For pdq's improvements mods
//ob_start("ob_gzhandler");
require_once "include/bittorrent.php";

dbconn(false);
loggedinorreturn();

//$lang = array_merge( load_language('global') );

/*if ($CURUSER['class'] < UC_USER)
{
        stderr("对不起...", "你必须达到 Power User 或者以上等级才能玩21点。");
        exit;
}
*/
function begin_table2($fullwidth = false, $padding = 5)
{
	$width = "";

	if ($fullwidth)
	$width .= " width=50%";
	return ("<table class=\"main".$width."\" border=\"1\" cellspacing=\"0\" cellpadding=\"".$padding."\">");
}

function end_table2()
{
	return ("</table>\n");
}


function begin_frame2($caption = "", $center = false, $padding = 10, $width="100%", $caption_center="left")
{
	$tdextra = "";

	if ($center)
	$tdextra .= " align=\"center\"";

	return(($caption ? "<h2 align=\"".$caption_center."\">".$caption."</h2>" : "") . "<table width=\"".$width."\" border=\"1\" cellspacing=\"0\" cellpadding=\"".$padding."\">" . "<tr><td class=\"text\" $tdextra>\n");

}

function end_frame2()
{
	return("</td></tr></table>\n");
}



function bjtable($res, $frame_caption)
{
        $htmlout='';
        $htmlout .= begin_frame2($frame_caption, true);
        $htmlout .= begin_table2();
        $htmlout .="<tr>
        <td class='colhead'>排名</td>
        <td class='colhead' align='left'>用户</td>
        <td class='colhead' align='right'>赢</td>
        <td class='colhead' align='right'>输</td>
        <td class='colhead' align='right'>游戏</td>
        <td class='colhead' align='right'>胜率</td>
        <td class='colhead' align='right'>赢/输</td>
        </tr>";

        $num = 0;
        while ($a = mysql_fetch_assoc($res))
        {
                ++$num;
                //==Calculate Win %
                $win_perc = number_format(($a['wins'] / $a['games']) * 100, 1);
                //==Add a user's +/- statistic
                $plus_minus = $a['wins'] - $a['losses'];
                if ($plus_minus >= 0)
                {
                $plus_minus = ($a['wins'] * 250 * 0.95 - $a['losses'] * 250);
                }
                else
                {
                        $plus_minus = "-";
                        $plus_minus .= ($a['losses'] * 250 - $a['wins'] * 250 * 0.95);
                }
                
                $htmlout .="<tr><td>$num</td><td align='left'>".
                "<b><a href='userdetails.php?id=".$a['id']."'>".get_username($a["id"])."</a></b></td>".
                "<td align='right'>".number_format($a['wins'], 0)."</td>".
                "<td align='right'>".number_format($a['losses'], 0)."</td>".
                "<td align='right'>".number_format($a['games'], 0)."</td>".
                "<td align='right'>$win_perc%</td>".
                "<td align='right'>$plus_minus</td>".
                "</tr>\n";
        }
        $htmlout .= end_table2();
        $htmlout .= end_frame2();
        return $htmlout;
}



     $cachefile = "cache/bjstats.txt";
     $cachetime = 60 * 30; // 30 minutes
     //$cachetime = 10 * 3;
$Cache->new_page('bjstats', $cachetime, true);
	if (!$Cache->get_page()){
	$Cache->add_whole_row();
     
$mingames = 50;
$HTMLOUT='';
$HTMLOUT .="<h1>21 点游戏统计</h1>";
$HTMLOUT .="<p>统计结果每三十分钟会被缓存一次，您必须玩够 100 次才会被统计。</p>";
$HTMLOUT .="<br />";
//==Most Games Played
$res = sql_query("SELECT id, username, bjwins AS wins, bjlosses AS losses, bjwins + bjlosses AS games FROM users WHERE bjwins + bjlosses > $mingames ORDER BY games DESC LIMIT 10") or sqlerr(__FILE__, __LINE__);
$HTMLOUT .= bjtable($res, "玩次数最多的","Users");
$HTMLOUT .="<br /><br />";
//==Most Games Played
//==Highest Win %
$res = sql_query("SELECT id, username, bjwins AS wins, bjlosses AS losses, bjwins + bjlosses AS games, bjwins / (bjwins + bjlosses) AS winperc FROM users WHERE bjwins + bjlosses > $mingames ORDER BY winperc DESC LIMIT 10") or sqlerr(__FILE__, __LINE__);
$HTMLOUT .= bjtable($res, "胜率最高的","Users");
$HTMLOUT .="<br /><br />";
//==Highest Win %
//==Most Credit Won
$res = sql_query("SELECT id, username, bjwins AS wins, bjlosses AS losses, bjwins + bjlosses AS games, bjwins * 0.95 - bjlosses AS winnings FROM users WHERE bjwins + bjlosses > $mingames ORDER BY winnings DESC LIMIT 10") or sqlerr(__FILE__, __LINE__);
$HTMLOUT .= bjtable($res, "赢了最多的","Users");
$HTMLOUT .="<br /><br />";
//==Most Credit Won
//==Most Credit Lost
$res = sql_query("SELECT id, username, bjwins AS wins, bjlosses AS losses, bjwins + bjlosses AS games, bjlosses - bjwins * 0.95 AS losings FROM users WHERE bjwins + bjlosses > $mingames ORDER BY losings DESC LIMIT 10") or sqlerr(__FILE__, __LINE__);
$HTMLOUT .= bjtable($res, "输了最多的","Users");
//==Most Credit Lost
$HTMLOUT .="<br /><br />";
//==飘香娘魔力值
//$res = sql_query("SELECT SUM(bjwins) AS wins FROM users ") or sqlerr(__FILE__, __LINE__);
//$arr=mysql_fetch_array($res);
//$HTMLOUT .= " <tr><td class='colhead'>飘香娘所收魔力值  : ".($arr[wins]*5)."</td></tr>";

//==Most Credit Lost
$HTMLOUT .="<br /><br />";
;
print  $HTMLOUT ;


	$Cache->end_whole_row();
	$Cache->cache_page();
	}
	
	
	stdhead('Blackjack Stats'); 
	echo $Cache->next_row();
	stdfoot();
?>

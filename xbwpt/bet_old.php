<?php
require "include/bittorrent.php";
 
dbconn();
loggedinorreturn();
 
$HTMLOUT ="";

$HTMLOUT .="<a href='./bet.php'><img src='betting.png' alt='Bet' title='Betting' width='500' height='100' /></a>
<h1>博彩频道</h1>
<table class='main' cellspacing='0' cellpadding='5' border='0'>
<tr>

<td align='center' class='navigation'><a href='/bet.php'>当前竞猜</a></td>
<td align='center' class='navigation'><a href='/bet_old.php'><font color='#999999'>闭盘竞猜</font></a></td>
";
if( $CURUSER['class'] >= UC_MODERATOR )
{
$HTMLOUT .= "<td align='center' class='navigation'><a href='/bet_admin.php'>管理竞猜</a></td>";
}
$HTMLOUT .="
<td align='center' class='navigation'><a href='/bet_coupon.php'>我的押注</a></td>
<td align='center' class='navigation'><a href='/bet_bonustop.php'>用户排名</a></td>
<td align='center' class='navigation'><a href='/bet_info.php'>系统帮助</a></td>
<td align='center' class='navigation'><a href='/forums.php?action=viewforum&forumid=11'><font color=red>博彩论坛</font></a></td>
</tr></table><br />";

$tid = time();

sql_query("UPDATE betgames set active = 0 WHERE endtime < $tid") or sqlerr(__FILE__, __LINE__);

$res = sql_query("SELECT * FROM betgames WHERE endtime < $tid and  fix = 0 ORDER BY endtime ASC") or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($res) == 0)
{
$HTMLOUT .= "<i>暂无项目</i>";
}


while($a = mysql_fetch_assoc($res))
{
if($a['sort']==0)
$sort = "odds ASC";
elseif($a['sort']==1)
$sort = "id ASC";

$res2 = sql_query("SELECT * from betoptions where gameid =".sqlesc($a["id"])." ORDER BY $sort") or sqlerr(__FILE__, __LINE__);
$HTMLOUT .= "<table width='40%' cellpadding='5'>
<tr><td colspan='2' class='colhead'><a href='./bet_gameinfo.php?showgames={$a["id"]}'>".htmlspecialchars($a["heading"])."(<i>".htmlspecialchars($a["undertext"])."</i>)</a>";
$HTMLOUT .= "</td></tr>";

while($b = mysql_fetch_assoc($res2))
{
$odds = $b['odds'];

switch(strlen($odds))
{
case 1:
$odds = $odds.".00";
break;
case 3:
$odds = $odds."0";
break;
}

$HTMLOUT .="<tr><td class='noflagclear' width='40%'>".htmlspecialchars($b['text'])."</td><td class='noflagclear'>".htmlspecialchars($odds)."</td></tr>";
}
$HTMLOUT .="<tr><td class='noflagclear' colspan='2' width='40%'><font size='1'>关闭下注时间: <b>". date('Y-m-d H:i:s', $a['endtime'])."</b>. 剩余时间: <b>".mkprettytime(($a['endtime']) - time())."</b></font></td></tr>";
$HTMLOUT .="</table></br>";
}

stdhead('Betting');print  $HTMLOUT ; stdfoot();
?>

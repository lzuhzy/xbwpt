<?php
require "include/bittorrent.php";
 
dbconn();
loggedinorreturn();

$HTMLOUT ="";
 
$HTMLOUT .="<a href='./bet.php'><img src='betting.png' alt='Bet' title='Betting' width='500' height='100' /></a>
<h1>博彩频道</h1>
<table class='main' cellspacing='0' cellpadding='5' border='0'>
<tr>
<td align='center' class='navigation'><a href='./bet.php'>当前竞猜</a></td>
<td align='center' class='navigation'><a href='/bet_history.php'>历史竞猜</a></td>
<td align='center' class='navigation'><a href='./bet_coupon.php'>我的押注</a></td>
<td align='center' class='navigation'><a href='./bet_bonustop.php'>用户排名</font></a></td>
<td align='center' class='navigation'><a href='./bet_info.php'>系统帮助</a></td>";
if( $CURUSER['class'] >= UC_POWER_USER)//if( $CURUSER['class'] >= UC_MODERATOR ||get_bet_moderators_is())
{
$HTMLOUT .= "<td align='center' class='navigation'><a href='/bet_admin.php'>管理竞猜</a></td>";
}
$HTMLOUT .="<td align='center' class='navigation'><a href='/forums.php?action=viewforum&forumid=11'><font color=red>博彩论坛</font></a></td>";
$HTMLOUT .="</tr></table><br />";

if(isset($_GET['showgames'])){
$gameid = 0+$_GET['showgames'];

$c=@mysql_fetch_assoc(sql_query("SELECT betgames.*, text, thisright FROM betgames LEFT JOIN betoptions ON gameid = betgames.id WHERE betgames.id =".sqlesc($gameid)." ORDER BY thisright DESC LIMIT 1"));

if($c['sort']==1)
$sort = " order by betoptions.id ASC";
else
$sort = " order by odds desc";

$a = sql_query("SELECT text, count(*) AS num, SUM(bonus) AS sum,odds FROM bets LEFT JOIN betoptions ON optionid = betoptions.id WHERE bets.gameid = ".sqlesc($gameid)." GROUP BY text $sort") or sqlerr(__FILE__, __LINE__);

while($b = mysql_fetch_array($a)){
$data['text'][] ="'".$b['text']."'";
$data['asum'] += $data['sum'][] =$b['sum'];
$data['anum'] += $data['num'][] =$b['num'];
$data['odds'][]=$b['odds'];
}
}

stdhead('Betting');
print  $HTMLOUT;
if($c){
if($c['fix'] == 1)
	$thisstat= "已结盘,正确选项是&nbsp;[".$c['text']."]";
elseif ($c["endtime"]<time())
	$thisstat= '等待结盘';
elseif (!$c['active'])
	$thisstat= '等待开盘';
else
	$thisstat= '剩余时间:'.mkprettytime(($c['endtime']) - time());

?>
<table align='center' cellpadding='5'>
<h1><?php echo $c['heading']; ?></h1>
<tr><td><b>获胜条件</b></td><td><?php echo $c['undertext'];?></td></tr>
<tr><td><b>当前状态</b></td><td><?php echo $thisstat; ?></td></tr>
<tr><td><b>参加押注选项</b></td><td><?php echo $data['text']?implode(',', $data['text']):''; ?></td></tr>
<tr><td><b>总下注数</b></td><td><?php echo $data['anum']; ?></td></tr>
<tr><td><b>总魔力值</b></td><td><?php echo 0+$data['asum']; ?></td></tr>
<tr><td><b>各选项下注数</b></td><td><?php echo $data['num']?implode(',', $data['num']):''; ?></td></tr>
<tr><td><b>选项投注总额</b></td><td><?php echo $data['sum']?implode(',', $data['sum']):''; ?></td></tr>
<tr><td><b>选项赔率比例</b></td><td><?php echo $data['odds']?implode(',', $data['odds']):''; ?></td></tr>
</table><br />

<?php }
print "<h1><a href='/bet_coupong.php?id=".$c["id"]."'>".htmlspecialchars(" < 下注情况 > ")."</a>".($c['active']?"<a href='/bet_odds.php?id=".$c["id"]."'>".htmlspecialchars(" < 点击下注 > ")."</a>":"").($c['fix']?"<a href='/forums.php?action=viewtopic&topicid=".$c["topicid"]."'>".htmlspecialchars(" < 论坛讨论 > ")."</a>":"")."</h1>";


stdfoot();
?>

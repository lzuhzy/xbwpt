<?php
require "include/bittorrent.php";
dbconn ();
require_once (get_langfile_path ());
loggedinorreturn ();
parked ();
stdhead("用户历史记录");
if (! $_GET[id])
		$_GET[id] = $CURUSER[id];
if (! $_GET[type])
		$_GET[type] = 'account';

if ($CURUSER[id] == $_GET[id]||get_user_class()>= $viewhistory_class)
	{
	$res=sql_query("SELECT * FROM users  WHERE id=".$_GET[id]);
	$row = mysql_fetch_array($res);
	if ($row)
	{	
	
	$acc_his = $row[modcomment];
	$bo_his = $row[bonuscomment];
	foreach ($lang_myhistory as $key=> $value)
	{
		$acc_his = str_replace($key,$value,$acc_his);
		$bo_his = str_replace($key,$value,$bo_his);
	}
	
	if ($_GET[type]==account)
	{
		$form_acc = preg_replace('/(\d\d\d\d)-(\d\d)-(\d\d) /','</td></tr><tr><td class="rowfollow" align="center">\\1年\\2月\\3日</td><td class="rowfollow" align="center">',$acc_his);
		print '<table class="main" width="940" border="0" cellspacing="0" cellpadding="0"><tbody><tr><td class="embedded"><div id="lognav"><ul id="logmenu" class="menu"><li class="selected"><a href="?id='.$_GET[id].'&type=account">账&nbsp;&nbsp;户</a></li><li><a href="?id='.$_GET[id].'&type=bonus">魔力值</a></li></ul></div></td></tr></tbody></table><br/>';
		print get_username($_GET[id], true,false).'的账户历史<br/><br/>';
		if($acc_his)
		{
		print '<table class="main" border="1" cellspacing="0" cellpadding="5"><tbody><tr><td class="colhead" align="center">时间</td><td class="colhead" align="center">事件'.$form_acc;
		print '</table>';
	}
	else print '暂无数据';
	}
	elseif ($_GET[type]==bonus)
	{
		$form_bo = preg_replace('/(\d\d\d\d)-(\d\d)-(\d\d) /','</td></tr><tr><td class="rowfollow" align="center">\\1年\\2月\\3日</td><td class="rowfollow" align="center">',$bo_his);
		print '<table class="main" width="940" border="0" cellspacing="0" cellpadding="0"><tbody><tr><td class="embedded"><div id="lognav"><ul id="logmenu" class="menu"><li><a href="?id='.$_GET[id].'&type=account">账&nbsp;&nbsp;户</a></li><li  class="selected"><a href="?id='.$_GET[id].'&type=bonus">魔力值</a></li></ul></div></td></tr></tbody></table><br/>';
		print get_username($_GET[id], true,false).'的魔力值历史<br/><br/>';
		if($bo_his)
		{
		print '<table class="main" border="1" cellspacing="0" cellpadding="5"><tbody><tr><td class="colhead" align="center">时间</td><td class="colhead" align="center">事件'.$form_bo;
		print '</table>';
		}
		else print '暂无数据';
	}
	else 
	echo('<b>你没有权限查看其他用户的历史记录。</b>');
	}
	else
	print '<table class="main" width="940" border="0" cellspacing="0" cellpadding="0"><tbody><tr><td class="embedded"><div id="lognav"><ul id="logmenu" class="menu"><li class="selected"><a href="?type=account">账&nbsp;&nbsp;户</a></li><li><a href="?type=bonus">魔力值</a></li></ul></div></td></tr></tbody></table><br/>你搞错了吧，没有id为'.$_GET[id].'的用户诶。';
	}
	else
	echo('<b>你没有权限查看其他用户的历史记录。</b>');
	stdfoot();
	?>

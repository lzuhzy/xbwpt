<?php 
require "include/bittorrent.php";

dbconn();
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
permissiondenied();

function curl_download($url, $dir) {
	$ch = curl_init($url);
	$fp = fopen($dir, "wb");
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$res=curl_exec($ch);
	curl_close($ch);
	fclose($fp);
	return $res;
}

$utid = $_GET["utid"];
$res = sql_query("SELECT * from torrents WHERE id = $utid LIMIT 1") or sqlerr();

$row = mysql_fetch_array($res);
if (!$row) 
	stderr("Sorry", "种子 $utid 不存在");

$file = "/xbwpt/transmission/transmission_watch/".$utid.".torrent.added";
if(file_exists($file))
        stderr("Sorry", "种子 $utid 已经自动做种，如果自动做种列表里面不存在，请打开自动做种页面手动上传。<a href=\"getusertorrentlist.php?userid=148317&type=seeding\">点击查看自动做种列表</a>",0);

if(!curl_download('http://pt.xbwbbs.com/download.php?id='.$utid.'&passkey=a975cd5466469bdb2baa6ca7c4e5430e','/xbwpt/transmission/transmission_watch/'.$utid.'.torrent'))

stderr("Sorry", "下载失败，请联系技术人员或打开自动做种页面手动上传");

else

stderr("成功", "种子 $utid 自动做种成功");

?>

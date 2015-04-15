<?php
require_once("include/bittorrent.php");
dbconn();
$res = sql_query("SELECT * from users;");
while($row = mysql_fetch_array($res))
{
echo $row[username]."<br>";
$sql= "UPDATE users SET username=\"".strtolower($row[username])."\" WHERE username=\"".$row[username]."\"";
#echo sql_query($sql)."<br>";
echo $sql;
}
?>

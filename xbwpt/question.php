<?php 
require "include/bittorrent.php";
dbconn();
loggedinorreturn();

$showdlnoticef=2;//起始$CURUSER['showdlnotice']
$showdlnoticel=1;//终止$CURUSER['showdlnotice']
$addbouns=3000;//答题奖励
$LIMIT=10;//最大答题数

$questinguser = mysql_fetch_assoc(sql_query("SELECT questionid FROM freshmananswer where userid=".sqlesc($CURUSER['id'])));

if($CURUSER['showdlnotice']==$showdlnoticef&&!$questinguser)//未抽题
{
	$res = sql_query("SELECT id FROM freshman  ORDER BY RAND() LIMIT $LIMIT");//抽题
	while ($row = mysql_fetch_assoc($res))$id[] = $row[id];
		$questinguser['questionid']=join("+",$id)."+0";
		sql_query("INSERT INTO freshmananswer (userid,questionid) VALUES (".sqlesc($CURUSER['id']).",".sqlesc($questinguser['questionid']).")");
}

if($_POST['questionid']&&$_POST["choice"]){//验证答案
	$questioncheck = mysql_fetch_assoc(sql_query("SELECT answer FROM  freshman  where id=".sqlesc(0+$_POST[questionid])));
	if($questioncheck){
		if(is_array($_POST["choice"]))
			$answersum=array_sum($_POST["choice"]);
		else $answersum=0+$_POST["choice"];
		$thisisright=((array_sum(explode('+',$questioncheck['answer']))==$answersum)?true:false);
		if($thisisright){
			$questinguser['questionid']=preg_replace('/(?<!\d)'.(0+$_POST[questionid]).'\+/','',$questinguser['questionid']);
			sql_query("UPDATE   freshmananswer  SET   questionid  =  ".sqlesc($questinguser['questionid'])." WHERE  userid=".sqlesc($CURUSER['id']));
			$notice=array('colour' =>"green",'text' =>"回答正确,请继续");
		}else $notice=array('colour' =>"red",'text' =>"回答错误,请再接再厉");
	}
}

$questionallid=(strpos($questinguser['questionid'],'+') ? explode('+',preg_replace("/\+0$/","",$questinguser['questionid'])) : $questinguser['questionid']);

if(!is_array($questionallid)){//答题完毕
	sql_query("Delete from freshmananswer where userid=".sqlesc($CURUSER['id']));
	sql_query("UPDATE users SET showdlnotice= $showdlnoticel WHERE id = ".$CURUSER["id"]);
	header('Refresh: 2; url=torrents.php'); 
	if($CURUSER['showdlnotice']==$showdlnoticef){
		KPS("+",$addbouns,$CURUSER['id']);
		stderr("答题完毕","获得 $addbouns 魔力值,可以进行下载了");}
	else stderr("答题完毕","可以进行下载了");
}

	shuffle($questionallid);

$questionid=$questionallid[0];//当前题目
$questing=@mysql_fetch_assoc(sql_query( "SELECT * FROM freshman WHERE id= $questionid "));//根据随机数取出题目
if(!$questing){
	sql_query("delete from freshmananswer where userid=".sqlesc($CURUSER['id']));
	stderr("题目出错","请刷新页面重新抽题");
}
stdhead("新手考试系统");

$type=strpos(preg_replace("/^0\+/","",$questing['answer']),'+')?"checkbox":"radio";//确定题目类型

for ($i=1; $i<=8; $i*=2)
	if($questing["answer".$i])$choices[]="<input type='".$type."' name='choice[]' value='".$i."' >".$questing["answer".$i]."<br />";//将选项存入数组
	shuffle($choices); //乱序排列
	//$notice=array('colour' =>"red",'text' =>"cew");
if($notice){
	print("<p><table border=\"0\" cellspacing=\"0\" cellpadding=\"10\" style='background: transparent;'><tr><td style='box-shadow: 2px 2px 5px gray;border-radius: 3px;border: none; padding: 10px; background: ".$notice[colour]."'>\n");
	print("<b><font color=\"white\">".$notice[text]."</font></b>");
	print("</td></tr></table></p><br />");

}

if($LIMIT==count($questionallid))
	print "<h1>新手考试系统</h1>";
else
	print "<h1>还剩余".count($questionallid)."道题目</h1>";
?>

<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
	<table width="60%" border="1" cellspacing="0" cellpadding="10" style="background-position: right bottom;background-repeat: no-repeat;">
	<tr><td class="text"  align="left" width="100%"><?php print ($type=='checkbox'?'[多选]':'[单选]');?> 请问：<?php echo $questing["question"]; ?></td></tr>
	<tr><td class="text"  align="left" width="100%">
		<input type="hidden" name="questionid" value="<?php echo $questionid ?>" /><?php echo $choices[0].$choices[1].$choices[2].$choices[3];?>
	</td></tr>
	<tr><td class="text"  align="center" width="100%"><input type="submit" name="submit" value="提交" /></tr>
	</table>
</form>
<?php 

stdfoot();


<?php
//	作者：cide
//	时间：2011-11-17
ob_start(); //Do not delete this line
require_once("include/bittorrent.php");
dbconn();
require_once(get_langfile_path());
loggedinorreturn();
stdhead($lang_index['head_home']);
$now0time=(string)(date('Y-m-d',time()));
?>
<?php
		//这里存放function；
		function check_admins($flag=true,$usertypes=""){ //$flag=false 表示是否为论坛版主，否则为各等级管理员;
			global $lang_signin;
			global $CURUSER;
			if($flag){
				if (get_user_class() < 12){
					stderr($lang_signin['std_sorry'],$lang_signin['std_permission_denied_only'].get_user_class_name(12,false,true,true).$lang_signin['std_or_above_can_view'],false,false,true,true);
				}
			}elseif($usertypes=="admin"){
					if (get_user_class() < 14){
						stderr($lang_signin['std_sorry'],$lang_signin['std_permission_denied_onlyadmin'].get_user_class_name(14,false,true,true).$lang_signin['std_or_admin_can_view'],false,false,true,true);
					}
					return true;//不是管理员
				}elseif($usertypes=="forumman"){  //以下内容不在等级系统中
					$mysql="SELECT * FROM forummods WHERE forummods.userid = '".$CURUSER['id']."'";
					$res=mysql_query($mysql);
					if (""==mysql_fetch_array($res)){
						return false;//bu是论坛版主
					}
					return true; //确实是论坛版主
				}elseif($usertypes=="picker"){
					$mysql="SELECT * FROM users WHERE users.id = '".$CURUSER['id']."' and users.picker = 'yes'";
					$res=mysql_query($mysql);
					if (""==mysql_fetch_array($res)){
						return false;//不是保种员
					}
					return true; //确实是保种员
				}elseif($usertypes=="support"){
					$mysql="SELECT * FROM users WHERE users.id = '".$CURUSER['id']."' and users.support = 'yes'";
					$res=mysql_query($mysql);
					if (""==mysql_fetch_array($res)){
						return false;//不是保种员
					}
					return true; //确实是保种员
				}
		}
		
		function get_signin($classtext="",$type=""){
			$mysql= "SELECT * FROM users WHERE users.".$type."='yes' AND users.status='confirmed' ORDER BY users.username";
			echoout($mysql,$classtext,"id");
		}
    
        function get_signin2($classtext="",$type=""){
	    	$mysql="SELECT forummods.userid AS userid, users.last_access FROM forummods LEFT JOIN users ON forummods.userid = users.id GROUP BY userid ORDER BY forummods.forumid, forummods.userid";
			echoout($mysql,$classtext,"userid");
    	}
    	
    	function get_signin3($classtext="",$type=""){
			$mysql= "SELECT * FROM users WHERE class ".$type." AND status='confirmed' ORDER BY class DESC, username";
			echoout($mysql,$classtext,"id");
		}
		function get_signin_history(){
			$mysql="select * from signin order by signindate desc,id";
			$res=mysql_query($mysql);
			while($rows=mysql_fetch_array($res)){
				echo "<tr>";
		        echo "<td>".get_username($rows[userid])."</td>";
		        echo "<td>".$rows[signindate]."</td>";
		        echo "<td>".($rows[signinleave]=='yes'?"<div align=\"center\"><img src=\"pic/signin/bing.gif\"/></div>":"否")."</td>";
		        echo "<td>".$rows[note]."</td>";
		        echo "</tr>"; 
				}
			
		}
    
    function echoout($mysqltext="",$classtext,$idtype){
	$res=mysql_query($mysqltext);
    	echo "<tr><td colspan='8'><font size='4' color='white'><b>&nbsp;&nbsp;".$classtext."</b></font></td></tr>";
    	global $lang_signin;
    	global $onlineimg;
    	global $offlineimg;
    	global $sendpmimg;
    	global $dt;
    	while($rows=mysql_fetch_array($res)){
	        echo "<tr>";
	        echo "<td>".get_username($rows[$idtype])."</td>";
	        echo "<td><div align=\"center\"><img src=\"pic/signin/".(signin_check($rows[$idtype])?"wb.gif":"dk.gif")."\"/></div></td>";
	        echo "<td> ".(strtotime($rows['last_access']) > $dt ? $onlineimg : $offlineimg)."</td>";
	        echo "<td><div align=\"center\"><a href=sendmessage.php?receiver=".$rows[$idtype]." title=\"".$lang_signin['title_send_pm']."\">".$sendpmimg."</a></div></td>";
	        echo "<td>".(leave_check($rows[$idtype])?"<div align=\"center\"><img src=\"pic/signin/bing.gif\"/></div>":"<div align=\"center\">否</div>")."</td>";
	        echo "<td>".$rows[note]."</td>";
	        echo "</tr>"; 
    	}
    }
	function signin_check($userid){
		global $now0time;//当前日期;
		$tmp=mysql_query("select signindate from signin where signin.userid='".$userid."' and signin.signindate = '".$now0time."'");
		$res=mysql_fetch_array($tmp);
		return ("" != $res)?true : false;
	}
	function leave_check($userid){ //检查当日是否请假
		global $now0time;//当前日期;
		$tmp=mysql_query("select signinleave from signin where signin.userid='".$userid."' and signin.signinleave= 'yes' and signin.signindate = '".$now0time."'");
		$res=mysql_fetch_array($tmp);
		return $res ? true : false;
	}
	//到这里function结束；
?>
<?php
	if(!(check_admins(false,"forumman")||check_admins(false,"picker")||check_admins(false,"support"))){
		check_admins();
	}
	
	if(isset($_GET[leavedays]) && $_GET[username]!= "" && $_GET[leavedays]!= "" && $_GET[leavedate] != ""){
		check_admins(false,"admin");
		$tmp=mysql_query("select id from users where username = '".$_GET[username]."'");
		$tmp=mysql_fetch_array($tmp);
		$uid=$tmp[id];
		$tmp=mysql_query("select * from signin where userid = '".$uid."' and signindate >= '".$_GET[leavedate]."'");
		$tmp=mysql_fetch_array($tmp);
		if($tmp !=""){
			stderr($lang_signin['std_error'],$_GET[leavedate]."  ".$lang_signin['text_record_exist_1'].get_username($uid).$lang_signin['text_record_exist_2'],false,false,true,true);
		}
		for($i=0;$i<(int)$_GET[leavedays];$i++){
			$finaldate=date("Y-m-d",strtotime($_GET[leavedate])+24*3600*$i);
			$leave = "yes";
			$Xsql="insert into signin (userid, signinleave, note, signindate) values(". $uid .", '". $leave ."', '" . $_GET[note] ." ' , '" . $finaldate ."')";
			if(!mysql_query($Xsql)){
				stderr($lang_signin['std_error'],$lang_signin['text_error'],false,false,true,true);
			}else{
				$info.= $lang_signin['text_permit_leave_one'] . $finaldate .$lang_signin['text_leave_one']."<br>" ;
			}

		}
		stderr($lang_signin['text_permit'],$info.$lang_signin['text_permit'],false,false,true,true);
	}
	if(isset($_GET[signin])){
		if($_GET[signin]=='yes'){
			if(!signin_check($CURUSER[id])){
				if(mysql_query("insert into signin (userid,signindate) values ($CURUSER[id], '". $now0time ."')")){
					echo "<script language='javascript'>alert('签到成功！');window.location.href='signin.php';</script>";
				}else{
					echo "<script language='javascript'>alert('签到失败！');window.location.href='signin.php';</script>";
				}
			}else{
					echo "<script language='javascript'>alert('你已经签到过了！');window.location.href='signin.php';</script>";
			}
		}elseif($_GET[signin]=='history'){
			$tmp=mysql_query("select * from signin order by signindate asc");
			while($res=mysql_fetch_array($tmp)){
				begin_table(true,5);
				?>
	<caption><font face='黑体'size='6' color='blue'><?=$lang_signin['title_history']?></font></caption>
	<tr><td colspan='4'><a href='signin.php'><?=$lang_signin['title_return_signin']?></a></td></tr>
	<tr>
         <td></td>
         <td><?=$lang_signin['title_signin_time']?></td>
         <td><?=$lang_signin['title_leave']?></td>
         <td><?=$lang_signin['title_note']?></td>
    </tr>
				<?php
				get_signin_history();
				echo "<tr><td colspan=4><div align='right'>注:按时间顺序,如有失误，与huangzy0138无关</div></td></tr>";
				end_table();
				die();
			}
			
		}elseif($_GET[signin]=='admin'){
						  check_admins(false,"admin");
				?>
返回 <a href="signin.php" title="返回 今日签到">今日签到</a>	
<form name="permitleave" method="get" id="permitleave" action="" style="text-align:left;">
<label for="username">用&nbsp;户&nbsp;名&nbsp;：</label><input id="username" name="username" value=""/>例如：sysop<br/>
<label for="leavedate">开始日期：</label><input id="leavedate" name="leavedate" value="<?php echo $now0time ?>"/>例如：2015-04-06<br/>
<label for="leavedays">请假天数：</label><input id="leavedays" name="leavedays" value=""/>例如：7<br/>
<label for="note">备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：</label><input id="note" name="note" value=""/>例如：不开心，所以不工作<br/>
<input name="submit" type="submit" value="批准"><input name="reset" type="reset" value="重填"><br>注意格式，我这里没写格式检查 = =！
</form>
			<?php
				die();
			}else{
			echo "<script language='javascript'>window.location.href='signin.php';</script>";
		}
			
		}
	
$Cache->new_page('signin_page', 10, true);
if (!$Cache->get_page()){
$Cache->add_whole_row();
begin_main_frame();
$secs = 90;
$dt = TIMENOW - $secs;

	$onlineimg = "<img class=\"button_online\" src=\"pic/trans.gif\" alt=\"online\" title=\"".$lang_signin['title_online']."\" />";
	$offlineimg = "<img class=\"button_offline\" src=\"pic/trans.gif\" alt=\"offline\" title=\"".$lang_signin['title_offline']."\" />";
	$sendpmimg = "<img class=\"button_pm\" src=\"pic/trans.gif\" alt=\"pm\" />";


?>

<?php
	//begin_main_frame("");
	begin_frame($lang_signin['title_signin'],true,5,"100%","center");
	echo "<p align=\"center\" ><font size='6' face=\"黑体\">".$lang_signin['title_signin2']."</font></p>";
	begin_table(true,5);
	echo "<tr><td colspan=\"5\"><a href=\"?signin=history\" title=\"".$lang_signin['title_history']."\">".$lang_signin['title_history']."</a></td><td align=\"right\">".( signin_check($CURUSER[id]) ? "<img class=\"ksdk\" src=\"pic/signin/wb.gif\"" : "<a href=\"?signin=yes\"><img class=\"ksdk\" src=\"pic/signin/ksdk.gif\"" ) ." alt=\"Quicksignin\" title=\"快速打卡\" /></a></td></tr>";

?>


	<tr>
         <td></td>
         <td><?=$lang_signin['title_todaySignin']?></td>
         <td><?=$lang_signin['title_online']?></td>
         <td><?=$lang_signin['title_contact']?></td>
         <td><?=$lang_signin['title_leave']?></td>
         <td><?=$lang_signin['title_note']?></td>
    </tr>
<?php
	//end_main_frame();	
?>

<?php
	//get_signin($lang_signin['text_firstline_support'],"support");
	//get_signin2($lang_signin['text_forum_moderators'],"support");
	//get_signin($lang_signin['text_movie_critics'],"picker");
	get_signin3($lang_signin['text_staff'],"> 11");//去除养老
	//get_signin3($lang_signin['text_vip'],"= 10");//去除VIP
?>


<?php
	end_table();
	end_frame();

/**
 * 这部分是分离出来的快速留言部分
 * print("<br /><br />");
 * print ("<table style='border:1px solid #000000;'><tr><td class=\"text\" align=\"center\"><b>".$lang_details['text_quick_comment']."</b><br /><br /><form id=\"compose\" name=\"comment\" method=\"post\" action=\"".htmlspecialchars("comment.php?action=add&type=torrent")."\" onsubmit=\"return postvalid(this);\"><input type=\"hidden\" name=\"pid\" value=\"".$id."\" /><br />");
 * quickreply('comment', 'body', $lang_details['submit_add_comment']);
 * print("</form></td></tr></table>");
 */
 end_main_frame();
	$Cache->end_whole_row();
	$Cache->cache_page();
}
echo $Cache->next_row();
 
stdfoot();
?>


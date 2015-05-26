<?php 
require "include/bittorrent.php";
dbconn();
loggedinorreturn();
if (get_user_class() < UC_MODERATOR)
	permissiondenied();

if($_POST["question"])
	sql_query("INSERT INTO  freshman  (question,answer1,answer2,answer4,answer8,answer) VALUES (".sqlesc($_POST['question'])." , ".sqlesc($_POST['question1'])." , ". sqlesc($_POST['question2'])." , ". sqlesc($_POST['question4'])." , ".sqlesc($_POST['question8']).",".sqlesc("0+".join("+",$_POST["answer"])).")");

elseif($_GET['delquestion'])
	sql_query("delete from freshman where id = ".sqlesc(0+$_GET['delquestion']));


stdhead("新手任务");
?>
 <h1>添加新手任务</h1>
<?php
begin_main_frame("",false);
?>
<table width="100%"><tr>
<td class="text" align="left"> 
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
题目<input type="text" name="question" size="100"><br />
选项<input type="text" name="question1" size="90"><input type="checkbox" name="answer[]" value="1">对<br />
选项<input type="text" name="question2" size="90"><input type="checkbox" name="answer[]" value="2">对<br />
选项<input type="text" name="question4" size="90"><input type="checkbox" name="answer[]" value="4">对<br />
选项<input type="text" name="question8" size="90"><input type="checkbox" name="answer[]" value="8">对<br /><input type="submit"  value="添加" /></form>
</td> </tr></table>
<?php
end_main_frame();
$res = sql_query("SELECT * FROM freshman ORDER BY  id  DESC");
?><h1>题目<?php PRINT mysql_num_rows($res)?>条</h1>

<?php
begin_main_frame("",false);
print("<table width='100%'>");
print("<tr><td class='colhead' align='center'>ID</td><td class='colhead' align='center'>题目</td><td class='colhead' align='center'>选项</td><td class='colhead' align='center'>答案</td><td class='colhead' align='center'>删除</td></tr>");

while ($row = mysql_fetch_assoc($res))
print("<tr>
<td class='rowfollow nowrap' align='center'>".$row[id]."</td>
<td class='rowfollow nowrap' align='center'>".$row[question]."</td>
<td class='rowfollow nowrap' align='left'>1:".$row[answer1]."<br />2:".$row[answer2]."<br />4:".$row[answer4]."<br />8:".$row[answer8]."</td>
<td class='rowfollow nowrap' align='center'>".$row[answer]."</td>
<td class='rowfollow nowrap' align='center'><a href='".$_SERVER['PHP_SELF']."?delquestion=".$row[id]."'><b>删除</b></a></td>
</tr>");


print("</table>");
end_main_frame();
 
stdfoot();
?>

 
  
 

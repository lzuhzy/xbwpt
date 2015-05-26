<?php
require "include/bittorrent.php";
dbconn();
//require_once(get_langfile_path());
loggedinorreturn();
function union()
{
	if(isset($_POST['union']))
	{
		$res1=sql_query("DELETE FROM `ktxp_detail` WHERE `subid`=".sqlesc($_POST['id'])) or sqlerr(__FILE__,__LINE__);
		$res2=sql_query("UPDATE `ktxp` SET `series_nums`= 0 WHERE `id`=".sqlesc($_POST['id'])) or sqlerr(__FILE__,__LINE__);
		if($res1 && $res2)
		{
			stderr("仍需进一步操作完成合集","<a href=AnimeList.php>返回后点击【点击此处更新剧集】，集数输入99，完成操作。</a>",FALSE);
		}
	}
}
function k_delete()
{
	if(isset($_POST['delete']))
	{
		$res1=sql_query("DELETE FROM `ktxp` WHERE `id`=".sqlesc($_POST['id'])) or sqlerr(__FILE__,__LINE__);
		$res2=sql_query("DELETE FROM `ktxp_detail` WHERE `subid`=".sqlesc($_POST['id'])) or sqlerr(__FILE__,__LINE__);
		if($res1 && $res2)
			stderr("恭喜","<a href='AnimeList.php'>删除成功,点击返回</a>",false);
		else
			stderr("错误","<a href='AnimeList.php'>所删番不存在,点击返回</a>",false);
	}
	}
function   getDay()   { 
    $y=date("Y");
    $m=date("m");
    $d=date("d");
    if($m==1   ||   $m==2)   { 
        $m   +=   12; 
        $y--; 
    } 
    //$t   =   $d+2*$m+bcdiv(3*($m+1),5,0)+$y+bcdiv($y,4,0)-bcdiv($y,100,0)+bcdiv($y,400,0); 
    $t   =   $d+2*$m+(3*($m+1)/5)+$y+($y/4)-($y/100)+($y/400); 
    return   ($t+1)%7; 
} 
function get_summary($douban)
{
    $file="./imdb/cache/".$douban.".xml";
    if(file_exists($file))
        $douban_imdb_xml= file_get_contents($file);
    else 
        return FALSE;
    $xmlparser=xml_parser_create();
    xml_parse_into_struct($xmlparser,$douban_imdb_xml,$dbarray);
    foreach($dbarray as $db)
    {
        if($db['tag']=="SUMMARY")
            return $db['value'];
    }
    /*preg_match_all("/(<summary>)(.*)(<\/summary>)/",$douban_imdb_xml,$summary,PREG_SET_ORDER);
    var_dump($summary);
    print "adgd";*/
}
function get_day_cartoon($i)  //i=0,1,2,3...
{
    $sql="SELECT * FROM `ktxp` WHERE `week` = ".$i;
    $res_ktxp=sql_query($sql)or sqlerr(__FILE__,__LINE__);;
    $row_ktxp=array();
    if($res_ktxp)
        while($temp_ktxp=mysql_fetch_assoc($res_ktxp))
        {
            $row_ktxp[]=$temp_ktxp;
        }
    return $row_ktxp;
}
function update_series()
{
	if(isset($_POST['up_torrent']))
	{ 
		$res=sql_query("SELECT `id` FROM `ktxp_detail` WHERE `subid`=".sqlesc($_POST['subid'])." AND `series`=".sqlesc($_POST['series']));
		$res_ktxp=sql_query("SELECT `series_nums` FROM `ktxp` WHERE `id`=".sqlesc($_POST['subid']));
		$row_ktxp=mysql_fetch_assoc($res_ktxp);
		if($_POST['subid']==NULL || $_POST['series']==NULL || $_POST['torrent_id']==NULL)
			stderr("ERROR","<a href=\"AnimeList.php\">SOMETHING IMPORTANT MISSED!</a>",FALSE);
		if($_POST['series']!=99)
		{
			if($row_ktxp['series_nums']==0)
				stderr("ERROR","<a href=\"AnimeList.php\">请先更新总集数</a>",FALSE);
			if($_POST['series'] > $row_ktxp['series_nums']+1)
				stderr("ERROR","<a href='AnimeList.php'>更新集数不能超过总集数</a>",false);
		}
		if(mysql_num_rows($res)==1)
		{
			$row=mysql_fetch_assoc($res);
			$id=$row['id'];
			sql_query("UPDATE `ktxp_detail` SET `torrent_id`=".sqlesc($_POST['torrent_id'])." WHERE `id`=".sqlesc($id)) or sqlerr(__FILE__,__LINE__);
		}
		else if(mysql_num_rows($res)==0){ 
			sql_query("INSERT INTO  `ktxp_detail`  (`subid`,`series`,`torrent_id`) VALUES ({$_POST['subid']},{$_POST['series']},{$_POST['torrent_id']})") or sqlerr(__FILE__,__LINE__);
		}
		else 
			stderr("ERROR","DATA STORAGE ERROR");
	}
}
function update_ktxp()
{
    if(isset($_POST['update']))
    {
        settype($_POST['douban_id'],"string");
        sql_query("UPDATE `ktxp` SET `series_nums`=".sqlesc($_POST['series_nums']).",`douban_id`=\"".sqlesc($_POST['douban_id'])."\" WHERE `id`=".$_POST['id']) or sqlerr(__FILE__,__LINE__);
    }
}
function update_picture($douban_id,$name)
{
    if(file_exists("./imdb/images/".$douban_id.".jpg"))
        print "<img src=\"./imdb/images/".$douban_id.".jpg\" alt=\"".$name."\" width=\"120px\" height=\"173px\" onclick=\"Previewurl('./imdb/images/".$douban_id.".jpg')\"/>";
    else
        print "<img src=\"./pic/btgirlwid130.jpg\" alt=\"".$name."\" width=\"120px\" onclick=\"Previewurl('./pic/btgirlwid130.jpg')\"/>";
}
function half_series($subid)
{
    print "<li style=\"margin:5px 0px 0px 0px\">";
    $res=sql_query("SELECT * FROM `ktxp_detail` WHERE `series`!=floor(`series`) AND `subid`=".$subid);
    if(mysql_num_rows($res)!=0)
    while($halves=mysql_fetch_assoc($res))
        $half_series[]=$halves;
    if($half_series==0)
       return 0;
    foreach($half_series as $half)
    {
        $torrent_id=$half['torrent_id'];
        $m=$half['series'];
        print "<a href=\"details.php?id=".$torrent_id."\" style=\"padding:0px;border:1px solid;background-color:#0a0;margin:2px\"> ".$m." </a>";
	}
}
function zero_series($subid)
{
	$res=sql_query("SELECT * FROM `ktxp_detail` WHERE `series`='0' AND `subid`=".$subid." LIMIT 1");
	while($zero=mysql_fetch_array($res)){
		$torrent_id=$zero['torrent_id'];
		print "<a href=\"details.php?id=".$torrent_id."\" style=\"padding:0px;border:1px solid;background-color:#0a0;margin:2px\">00</a>";
	}
}
if(in_array($CURUSER['id'],array(143281,84652,47792,51767,146,136253,51466,146309,86761,140562)))
    $admin=TRUE;
else $admin=FALSE;
$res=sql_query("SELECT *  FROM `ktxp_detail` WHERE 1") or sqlerr(__FILE__,__LINE__);
if($res)
    while($row_series=mysql_fetch_assoc($res))
    {
        //var_dump($row_series);
        //  print "</br>";
        $temp_subid=$row_series['subid'];
        $temp_series=$row_series['series'];
        $rowarray_series[$temp_subid][$temp_series]=$row_series['torrent_id'];
         $updated_series[$temp_subid][]=$temp_series+0;
    }
//var_dump($rowarray_series);
//var_dump($updated_series);
union();
k_delete();
update_ktxp();
update_series();
stdhead();
$weekday=getDay();
$dday =(int)( isset($_POST['day'])?$_POST['day']:(isset($_GET['day'])?$_GET['day']:-1));
?>

<style type="text/css">
 #tag{ overflow:hidden;padding-left:170px;padding-top:5px;border-bottom:1px solid #66ccff;  }
 #tag li{list-style:none; float:left; text-align:center; margin:0px 5px; color:white; padding:5px 20px; cursor: pointer;}
 #tag li:hover {background-color:#66ccff; color:#000;list-style:none; float:left; text-align:center; margin:0px 5px; color:white; padding:5px 20px; cursor: pointer;}
 #tag .current{ background-color:#66ccff; color:#000; }
</style>
<script type="text/javascript">
$(function(){
    $(".tab").eq(<?php if($dday!=-1){echo (int)$dday;}else {echo $weekday-1;} ?>).show().siblings().hide();
    $("#tag li").click(
        function(){
            $(this).addClass("current").siblings().removeClass("current");
            index = $("#tag li").index(this);
            $(".tab").eq(index).show().siblings().hide();
        } 
    );
    $("#upda").submit(
        function(){
            index = $(".current").index();
	    $(this).append("<input type=\"hidden\" value=\""+index+"\" name=\"day\"/ >");
	    return true;
	}
    );
    $("#upser").submit(
        function(){
            index = $(".current").index();
	    $(this).append("<input type=\"hidden\" value=\""+index+"\" name=\"day\"/ >");
	    return true;
	}
    );
});
</script>
<?php
print "<h3>动漫新番表</h3>";
//$name=get_day_cartoon(1);
//var_dump($name);
$week=array("星期一","星期二","星期三","星期四","星期五","星期六","星期日");
print("<ul id=\"tag\">");
$weekday = ($dday!=-1)?((int)$dday+1):$weekday;
for($i = 1; $i < 8 ;$i++){
    ?> <li <?php if($weekday == $i%7) echo "class=\"current\""; ?>> <?php echo $week[$i-1]; ?> </li> 
    <?php 
}
print("</ul><div id=\"tagContent\">");
for($i=1;$i<8;$i++)
{
    print "<ul class=\"tab\"  style=\"list-style-type:none;text-align:left;padding:0px 5px;\">";
    $name=get_day_cartoon($i);
    foreach($name as $a)
    {
        if($admin)$ID="";else $ID="";
        settype($a['id'],"string");
        print "<li style=\"background-color:#C6E3C6;margin-top:15px;margin-left:0px;padding:0px\">";
        print "<div align=\"left\" style=\"height:173px;width:120px;padding:0px;margin:5px;float:left\">";
        update_picture($a['douban_id'],$a['name']);
        print "</div>";
        //print "<div style=\"height:173px;width:600px;padding:0px;margin:0px 0px 0px 20px;float:left;position:relative;left:0px;top:0px\"></div>";
        print("<div  align=\"\" style=\"height:173px;width:600px;padding:0px;margin:0px 0px 0px 20px;float:left;\"><ul style=\"list-style-type:none;margin:0px;padding:0px\"><li style=\"margin:0px\"><h1>".$a['name'].$ID."</h1></li>");
        $summary=get_summary($a['douban_id']);
        $summary=substr($summary,0,250);
        $summary=$summary."......";
        print ("<li style=\"margin:-10px 0px 0px 0px\"><h4>简介：</h4><p style=\"font:12px 宋体;margin:-10px 0px 0px 0px;text-indent:26px\">");
        print ($summary);
        print ("</p></li>");
        print "<li style=\"margin:-15px 0px 0px 0px \"><h4>剧集列表:</h4>";
        print "</li><li style=\" margin:-10px 0px 0px 0px\">";
        if($a['series_nums']!=0)
            for($m=1;$m<=$a['series_nums'];$m++)
            {
                $torrent_id=$rowarray_series[$a['id']][$m];
                /*$mm=$updated_series[$a['id']];
                if($mm
                    in_array($m,$mm); 
                //数组越界？
                 */
                $res_confirm=sql_query("SELECT COUNT(*) FROM `ktxp_detail` WHERE `subid`=".$a['id']." AND `series`=".$m);
                $array_confirm=mysql_fetch_assoc($res_confirm);
                $confirm=($array_confirm['COUNT(*)']==0)?FALSE:TRUE;
                $m=sprintf("%02d",$m);
                if($confirm)
                    print "<a href=\"details.php?id=".$torrent_id."\" style=\"padding:0px;border:1px solid;background-color:#0a0;margin:2px\"> ".$m." </a>";
                else 
                    print "<font style=\"padding:0px;border:1px solid;background-color:grey;margin:2px\"> ".$m." </font>";
            }
		else{
			$res_99=sql_query("SELECT * FROM `ktxp_detail` WHERE `subid`=".$a['id']." AND `series`=99") or sqlerr(__FILE__,__LINE__);
			while($row_99=mysql_fetch_assoc($res_99))
			{
				print "<a href=\"details.php?id=".$row_99['torrent_id']."\" style=\"padding:0px;border:1px solid;background-color:#0a0;margin:2px\"> 合集 </a>";
			}
			
		}
       	print "</li>"; 
		half_series($a['id']);
		zero_series($a['id']);
		print "</li>";
		print "</ul></div>";
        if($admin){
	    $ii = $i -1;
            print("<div  align=\"\" style=\"width:150px;height:173px;background-color:;float:right;maigin:5px 0px;padding:5px 0px;\"><form method='POST' id=\"upda\" action='".$_SERVER['SCRIPT_NAME']."?day=$ii'>豆瓣ID:<input type=\"text\" name=\"douban_id\" value=\"".$a['douban_id']."\"></br>总集数:<input type=\"text\" name=\"series_nums\" value=\"".$a['series_nums']."\"><input type=\"submit\" name=\"update\" value=\"更新\"><input type=\"submit\" name=\"delete\" value=\"删除\" onclick=\"return checkKtxp();\"><input type=\"submit\" name=\"union\" value=\"合集\"><input type=\"hidden\" name=\"id\" value=\"".$a['id']."\"></form></br>");
            print "<span style=\"cursor:pointer\"onclick=\"zOpenInner('{$a['id']}','{$a['name']}');\">*****************</br><font style=\"align:center\">点击此处更新更新剧集</font></br>*****************</span></div>";
        }
        print "<div style=\"clear:both\"></div></li>";
    }
    print "</ul>";
}
print "</div>";
stdfoot();
?>
<script type="text/javascript">
	function checkKtxp()
	{
		if(confirm("确认要删除该番吗？")==true)   
			    return true;
		  else  
			      return false;
	}
	function isHidden(oDiv)
	{
		var vDiv=document.getElementById(oDiv);
		vDiv.style.display=(vDiv.style.display=='none')?'block':'none';
		var week=new Array("div1","div2","div3","div4","div5","div6","div7");
		for(i=0;i<week.length;i++)
		{
			if(week[i]==oDiv)
				continue;
			else{
			var div=document.getElementById(week[i]);
			div.style.display='none';
			}
		}
	}
function zOpenInner(a,b)
{
    var a = eval(a);
    var index = $(".current").index();
    var content="<font>请正确填写信息</font><li style=\"list-style-type:none;text-align:center\"><form method=\"POST\"  action=\"?day="+index+"\" >名称:"+b+"<input type=\"hidden\" name=\"subid\" value=\""+a+"\"></br>第几集:<input type=\"text\" name=\"series\"></br>种子ID:<input type=\"text\" name=\"torrent_id\"></br><input type=\"submit\" name=\"up_torrent\" value=\"update\"></form></li>";
    MIZA.box.open(content,{
        height:199,
            time:0,
            title:'更新动漫番数和豆瓣ID', 
            width:290
    })
}
function Previewurl(url) {
	if (!is_ie || is_ie >= 7){
	$('#lightbox').append("<a onclick=\"Return();\"><img src=\"" + url + "\" /></a>");
	$('#lightbox').attr("onclick","Return()");
	$('#curtain').show();
	$('#lightbox').show();
	}
	else{
	window.open(url);
	}
}
 
</script>

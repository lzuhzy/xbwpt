<?
class douban {
    var $doubanxml,$dbarray;
    var $dbinfo;
    var $cachepath = "",$siteurl = "",$apikey = "";
    function __construct() {
        $this->cachepath = "./imdb/cache/";
        $this->imagepath = "./imdb/images/";
       }
    function setid($imdb_id = 0,$type = "imdb"){
        if($type == "imdb")
            $this->siteurl = "http://api.douban.com/v2/movie/subject/imdb/tt";
        else if($type == "douban")
            $this->siteurl = "http://api.douban.com/v2/movie/subject/";  
        $orijson = file_get_contents($this->siteurl.$imdb_id);
        $jsonobj = json_decode($orijson);
        $jsonobj_true = json_decode($orijson,true);
        $page = $page."<b>资源类型：</b>".$jsonobj ->{'subtype'}."<br />";
        $page = $page."<b>原名：</b>".$jsonobj ->{'original_title'}."<br />";
        $page = $page."<b>中文名：</b>".$jsonobj ->{'title'}."<br />";
        
        $page = $page."<b>别名：</b>";
        foreach ($jsonobj ->{'aka'} as $jsonaka)
        {$page = $page.$jsonaka."&nbsp;/&nbsp;";}
        $page=$page."<br />";
        
        $page = $page."<b>主演：</b>";
        foreach ($jsonobj_true[casts] as $key=>$castsval)
       {$strcastsname= $castsval[name];$strcastsalt= $castsval[alt];
        $page = $page."<a href=\"".$strcastsalt."\">".$strcastsname."</a>&nbsp;/&nbsp;";}
        $page=$page."<br />";
        
        $page = $page."<b>类型：</b>";
        foreach ($jsonobj ->{'genres'} as $jsongenres)
        {$page = $page.$jsongenres."&nbsp;/&nbsp;";}
        $page=$page."<br />";
 /*
        $page = $page."<b>电影/电视剧语言：</b>";
        foreach ($jsonobj ->{'languages'} as $jsonlanguages)
        {$page = $page.$jsonlanguages."&nbsp;/&nbsp;";}
        $page=$page."<br />";
*/     
        $page = $page."<b>国家/地区：</b>";
        foreach ($jsonobj ->{'countries'} as $jsoncountries)
        {$page = $page.$jsoncountries."&nbsp;/&nbsp;";}
        $page=$page."<br />";
        
        $page = $page."<b>导演：</b>";
        foreach ($jsonobj_true[directors] as $key=>$directorsval)
       {$strdirectorsname= $directorsval[name];
        $page = $page.$strdirectorsname."&nbsp;/&nbsp;";}
        $page=$page."<br />";
      /*  
        $page = $page."<b>编剧：</b>";
        foreach ($jsonobj_true[writers] as $key=>$writersval)
       {$strwritersname= $writersval[name];
        $page = $page.$strwritersname."&nbsp;/&nbsp;";}
        $page=$page."<br />";
      */
        $page = $page."<b>年份：</b>".$jsonobj ->{'year'}."<br />";
        
        //以下三项豆瓣吹的，没接口
        /*$page = $page."<b>上映/首播时间：</b>";
        foreach ($jsonobj ->{'pubdates'} as $jsonpubdates)
        {$page = $page.$jsonpubdates."&nbsp;/&nbsp;";}
        $page=$page."<br />";
        
        $page = $page."（大陆）上映/首播时间：</b>";
        foreach ($jsonobj ->{'mainland_pubdate'} as $jsonmainland)
        {$page = $page.$jsonmainland."&nbsp;/&nbsp;";}
        $page=$page."<br />";
        
        $page = $page."电影/电视剧时长：</b>";
        foreach ($jsonobj ->{'durations'} as $jsondurations)
        {$page = $page.$jsondurations."&nbsp;/&nbsp;";}
        $page=$page."<br />";*/
        $page = $page."<b>豆瓣链接：</b><a href=\"".$jsonobj ->{'alt'}."\">".$jsonobj ->{'alt'}."</a><br />";
        $page = $page."<b>豆瓣评分：</b><font color=\"red\">最高:".$jsonobj_true[rating][max]."</font>&nbsp;&nbsp;<font color=\"purple\">平均:".$jsonobj_true[rating][average]."</font></font>&nbsp;&nbsp;最低:".$jsonobj_true[rating][min]."&nbsp;&nbsp;<font color=\"blue\">星级<img class=\"star\" src=\"pic/trans.gif\"/>：".$jsonobj_true[rating][stars]."</font><br />";
        $page = $page."<b>简介：</b>".$jsonobj ->{'summary'}."<br />";
        file_put_contents($this->cachepath.$imdb_id.".page",$page );
        @ copy($jsonobj_true[images][medium],$this->imagepath.$imdb_id.".jpg");
    }
   

   
}
?>

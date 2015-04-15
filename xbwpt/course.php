<?php
require "include/bittorrent.php";
require_once(get_langfile_path());
dbconn();
stdhead($lang_course['head_course']);

begin_frame($lang_course['text_course']."");
?>
<table width=100% cellspacing=0 align=left>
	<?php echo $lang_course['text_course1'] ?><br>
	<?php echo $lang_course['text_course2'] ?><br>
	<?php echo $lang_course['text_course3'] ?>
	<?php echo $lang_course['text_course4'] ?><br>
	<?php echo $lang_course['pic_course'] ?><br>
	<?php echo $lang_course['text_course5'] ?><br>
	<?php echo $lang_course['pic_course1'] ?><br>
	<?php echo $lang_course['text_course6'] ?><br>
	<?php echo $lang_course['pic_course2'] ?><br>
	<?php echo $lang_course['text_course7'] ?><br>
	<?php echo $lang_course['pic_course3'] ?><br>
	<?php echo $lang_course['text_course8'] ?><br>
	<?php echo $lang_course['pic_course4'] ?><br>
	<?php echo $lang_course['text_course9'] ?><br>
	<?php echo $lang_course['pic_course5'] ?><br>
	<?php echo $lang_course['text_course10'] ?><br>
	<?php echo $lang_course['pic_course6'] ?><br>
	<?php echo $lang_course['text_course11'] ?><br>
	<?php echo $lang_course['pic_course7'] ?><br>
	<?php echo $lang_course['pic_course8'] ?><br>
	<?php echo $lang_course['pic_course9'] ?><br>
	<?php echo $lang_course['text_course12'] ?>
</table>
<?php
end_main_frame();

stdfoot();

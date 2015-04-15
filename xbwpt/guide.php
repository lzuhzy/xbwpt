<?php
require "include/bittorrent.php";
require_once(get_langfile_path());
dbconn();
stdhead($lang_guide['head_guide']);

begin_frame($lang_guide['text_guide']);
?>
<table width=100% cellspacing=0 align=left>
	<?php echo $lang_guide['text_guide1'] ?>
</table>
<?php
end_main_frame();

stdfoot();

<?php
define("PT_KEY","lzu~home#feiyuan^longth:pt_20110108");
require_once("include/bittorrent.php");
header("Content-Type: text/html; charset=utf-8");
if (!mkglobal("code"))
{
	die();
}

// added longth, 20110108, for autologin with XBW.
// change Amanda 20120929, login for IE,old file is takelogin_xbw.php

else
{
        $code = base64_decode($code);
        $decode = base64_decode($code);
        if($decode == "")
                die();
        parse_str($decode, $codearray);
	$kbsret=$codearray["kbsret"];
	$username=$codearray["username"];
	$password=$codearray["password"];
	$login_imagehash=$codearray['imagehash'];
	$login_imagestring=$codearray['imagestring'];
	$ip_securelogin=$codearray["securelogin"];
	$logout=$codearray["logout"];
	$login_gender=htmlspecialchars($codearray["gender"]);
	$login_email=htmlspecialchars(trim($codearray["email"]));
	if(trim($codearray["returnto"])<>"")
		$login_returnto=$codearray["returnto"];
	if(trim($codearray["ssl"])<>"")
		$login_ssl=$codearray["ssl"];
	if(trim($codearray["trackerssl"])<>"")
		$login_trackerssl=$codearray["trackerssl"];
	//syslog(LOG_WARNING, $login_gender);
}

//added end
//
dbconn();
require_once(get_langfile_path("", false, get_langfolder_cookie()));
if($kbsret<>1)//ksb认证失败,用户名密码错误，则直接记录错误地址退出
login_failedlogins();
failedloginscheck ();
cur_user_check () ;

function bark($text = "")
{
  global $lang_takelogin;
  $text =  ($text == "" ? $lang_takelogin['std_login_fail_note'] : $text);
  stderr($lang_takelogin['std_login_fail'], $text,false);
}
if ($iv == "yes")
	check_code($_POST['imagehash'], $_POST['imagestring'],'login.php',true);
$res = sql_query("SELECT id, passhash, secret, enabled, status FROM users WHERE username = " . sqlesc($username));
//if ($row["passhash"] != md5($row["secret"] . $password . $row["secret"]))
$row = mysql_fetch_array($res);

if (!$row) {
	if ( $kbsret<>1 ) {
		login_failedlogins();
	} else {
		registration_check("auto");
		$login_email = safe_email($login_email);
		if (!check_email($login_email))
		    bark($lang_takelogin['std_invalid_email_address']);
		if(EmailBanned($login_email))
		    bark($lang_takelogin['std_email_address_banned']);
		if(!EmailAllowed($login_email))
		    bark($lang_takelogin['std_wrong_email_address_domains'].allowedemails());
		if(emailcount($login_email)>=1)
		     bark($lang_takelogin['std_wrong_email_address_count']);
		$country = 8;
		int_check($country);

		$allowed_genders = array("Male","Female","male","female");

		if (!in_array($login_gender, $allowed_genders, true))
			bark($lang_takelogin['std_invalid_gender']);
		if (empty($username) || empty($password) || empty($login_email) || empty($country) || empty($login_gender))
			bark($lang_takelogin['std_blank_field']);
		
		if (!validemail($login_email))
			bark($lang_takelogin['std_wrong_email_address_format']);

		$secret = mksecret();
		$passhash = md5($secret . $password . $secret);
		$editsecret = ($verification == 'admin' ? '' : $secret);
		$username = sqlesc($username);
		$passhash = sqlesc($passhash);
		$secret = sqlesc($secret);
		$editsecret = sqlesc($editsecret);
		$login_email = sqlesc($login_email);
		$country = sqlesc($country);
		$login_gender = sqlesc($login_gender);
		$sitelangid = sqlesc(get_langid_from_langcookie());

		$ret = sql_query("INSERT INTO users (username, passhash, secret, editsecret, email, country, gender, status, class, invites, ".($type == 'invite' ? "invited_by," : "")." added, last_access, lang, stylesheet".($showschool == 'yes' ? ", school" : "").", uploaded) VALUES (" . $username . "," . $passhash . "," . $secret . "," . $editsecret . "," . $login_email . "," . $country . "," . $login_gender . ", 'confirmed', ".$defaultclass_class.",". $invite_count .", ".($type == 'invite' ? "'$inviter'," : "") ." '". date("Y-m-d H:i:s") ."' , " . " '". date("Y-m-d H:i:s") ."' , ".$sitelangid . ",".$defcss.($showschool == 'yes' ? ",".$school : "").",".($iniupload_main > 0 ? $iniupload_main : 0).")") or sqlerr(__FILE__, __LINE__);
		
		$id = mysql_insert_id();

		$passkey = md5($username.date("Y-m-d H:i:s").$passhash);

		$ret = sql_query("update users set passkey='$passkey' where username = '$username'");

		$res = sql_query("SELECT id, passhash, secret, enabled, status FROM users WHERE username = '" . $username ."'");

		$row = mysql_fetch_array($res);
		
		if(!$row) {

		}
		
		if ($ip_securelogin == "yes") {
			$securelogin_indentity_cookie = true;
			$passh = md5($row["passhash"].$_SERVER["REMOTE_ADDR"]);
		} else {
			$securelogin_indentity_cookie = false;
			$passh = md5($row["passhash"]);
		}
		if ($securelogin=='yes' || $login_ssl == "yes") {
			$pprefix = "https://";
			$ssl = true;
		} else {
			$pprefix = "http://";
			$ssl = false;
		}
		if ($securetracker=='yes' || $login_trackerssl == "yes") {
			$trackerssl = true;
		} else {
			$trackerssl = false;
		}
		if ($logout == "yes") {
			logincookie($row["id"], $passh,1,900,$securelogin_indentity_cookie, $ssl, $trackerssl);
			//sessioncookie($row["id"], $passh,true);
		} else {
			logincookie($row["id"], $passh,1,0x7fffffff,$securelogin_indentity_cookie, $ssl, $trackerssl);
			//sessioncookie($row["id"], $passh,false);
		}
		if (isset($login_returnto)) {
			header("Location: " . $pprefix . "$BASEURL/$login_returnto");
		} else {
			header("Location: " . $pprefix . "$BASEURL/index.php");
		}
	}
} else {//kbs认证成功	

if ($row['status'] == 'pending')
	failedlogins($lang_takelogin['std_user_account_unconfirmed']);

/*
if ($row["passhash"] != md5($row["secret"] . $password . $row["secret"]))
{//原密码不对了，自动同步修改 Amanda change 2012-9-29
	syslog(LOG_WARNING, "pt: user ".$username." changed bbs password!");
	$sec = mksecret();
	$passhash = md5($sec . $password . $sec);
	$ret = sql_query("update users set passhash = ".sqlesc($passhash).",secret = ".sqlesc($sec)." where username = " . sqlesc($username) );
	$res = sql_query("SELECT id, passhash, secret, enabled, status FROM users WHERE username = " . sqlesc($username) );
	$row = mysql_fetch_array($res);
	syslog(LOG_WARNING, $row["id"]." passhash".$row["passhash"]);
*/
}

if ($row["passhash"] != gen_pass($username, $password) ) {
	//$test= "<script> alert(\" $username $password ". gen_pass($username, $password). $row["passhash"]."\");</script>";
// $fp=fopen("/tmp/test1.txt",'w+');
// fwrite($fp, $row["passhash"]);
// fclose($fp);
// $fp=fopen("/tmp/test2.txt",'w+');
// fwrite($fp, gen_pass($username, $password));
// fclose($fp);
	login_failedlogins();
}

if ($row["enabled"] == "no")
	bark($lang_takelogin['std_account_disabled']);

if ($ip_securelogin == "yes") {
	$securelogin_indentity_cookie = true;
	$passh = md5($row["passhash"].$_SERVER["REMOTE_ADDR"]);
} else {
	$securelogin_indentity_cookie = false;
	$passh = md5($row["passhash"]);
}

if ($securelogin=='yes' || $login_ssl == "yes") {
	$pprefix = "https://";
	$ssl = true;
} else {
	$pprefix = "http://";
	$ssl = false;
}
if ($securetracker=='yes' || $login_trackerssl == "yes") {
	$trackerssl = true;
} else {
	$trackerssl = false;
}
if ($logout == "yes") {
	logincookie($row["id"], $passh,1,900,$securelogin_indentity_cookie, $ssl, $trackerssl);
	//sessioncookie($row["id"], $passh,true);
} else {
	logincookie($row["id"], $passh,1,0x7fffffff,$securelogin_indentity_cookie, $ssl, $trackerssl);
	//sessioncookie($row["id"], $passh,false);
}

if (isset($login_returnto))
	header("Location: " . $pprefix . "$BASEURL/$_POST[returnto]");
else
	header("Location: " . $pprefix . "$BASEURL/index.php");
?>

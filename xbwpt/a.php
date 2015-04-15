<?php
define("PT_KEY","lzu~home#feiyuan^longth:pt_20110108 ");
$code = 'OGI4ZU1Cd3VzUG56aThSQ05mb2tGVFBET1RzMFQvZE1VYVlDOUIvZUhmZnNjd0kxbGxBRVM2RktlMFJrWEUvRWlDcnJ2bndtRjRhT09HQTVQV1d4ZWthMWFWM0xiRGE1OURidXN5R3FWdnBMVzRzRld6Uk1nRUU4ZTFFeVk5d2FmOFRnNGpsT0VVNC95TkwwMlZ6WjA5c3plS3FNNVRrTFUrR0doRlRYTDRONEhTVVc2UENtTHNTSENMbnFpRFdhVUdCZ01vSGxkMkpheHVKY3Zua3JpNGRsVU4vSUxXRkhvWnlveStIbFk1UQ==';
function uc_authcode($string, $operation = 'DECODE', $key = '', $expiry = 6000) {

        $ckey_length = 4;

        $key = md5($key ? $key : UC_KEY);
        $keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	print $key;
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for($i = 0; $i <= 255; $i++) {
                $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for($j = $i = 0; $i < 256; $i++) {
                $j = ($j + $box[$i] + $rndkey[$i]) % 256;
                $tmp = $box[$i];
                $box[$i] = $box[$j];
                $box[$j] = $tmp;
        }

        for($a = $j = $i = 0; $i < $string_length; $i++) {
                $a = ($a + 1) % 256;
                $j = ($j + $box[$a]) % 256;
                $tmp = $box[$a];
                $box[$a] = $box[$j];
                $box[$j] = $tmp;
                $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
	print 'daa';
	if($operation == 'DECODE') {
		print 'd';
                print $keyc.str_replace('=', '', base64_encode($result));
        }
}
print "fuck";
$decode = uc_authcode($code, 'DECODE', PT_KEY, -1);
print $decode;
print "who";

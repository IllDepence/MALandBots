<?php

function getSite($HOST, $PATH="") {
	// perform request
	$status = array();
	$answer = "";
	$fp = fsockopen($HOST, 80, $errorno, $errstr, 30);
	if(!fp) echo $errstr." (".$errno.") <br />";
	else {
		$out = "GET /".$PATH." HTTP/1.1\r\n";
		$out .= "Host: ".$HOST."\r\n";
		$out .= "Connection: Close\r\n\r\n";
		fwrite($fp, $out);
		for($i = 0; !feof($fp); $i++) {
			if($i<2) $status[$i] = fgets($fp, 128);
			else $answer .= fgets($fp, 128);
			}
		fclose($fp);
		}
	// follow redirect if occured
	if(strstr($status[0], "HTTP/1.1 302 Found")) {
		preg_match("/http:\/\/[^\/]*/", $status[1], $hostmatch);
		preg_match("/http:\/\/.*/", $status[1], $urlmatch);
		$newhost = substr($hostmatch[0], 7);
		$newpath = substr($urlmatch[0], strlen($hostmatch[0])+1);
		$answer = getSite($newhost, $newpath);
		}
	// return answer
	return $answer;
	}

?>

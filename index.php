<!DOCTYPE HTML>

<!-- - - - - - - - - - - - - - - - - <html> - - - - - - - - - - - - - - - - -->
<html>

<!-- - - - - - - - - - - - - - - - - <head> - - - - - - - - - - - - - - - - -->
<head>

<link rel="SHORTCUT ICON" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- - - - - - - - - - - - - - - - - <style> - - - - - - - - - - - - - - - - -->
<style type="text/css">
* {
margin: 0px;
}

p {
margin: 1px 0px 0px 0px;
font-size: 12px;
}

strong {
font-size: 14px;
}
</style>
<!-- - - - - - - - - - - - - - - - - </style> - - - - - - - - - - - - - - - - -->

</head>
<!-- - - - - - - - - - - - - - - - - </head> - - - - - - - - - - - - - - - - -->


<!-- - - - - - - - - - - - - - - - - <body> - - - - - - - - - - - - - - - - -->
<body>

<div style="padding: 10px 0px 5px 15px;">
<?php

include('functions.php');

$entries_json = file_get_contents('entries.json');
$entries = json_decode($entries_json);

$urls = array();
foreach($entries as $e) {
	if(!in_array($e->url, $urls)) $urls[] = $e->url;
	}

$packlists = array();
foreach($urls as $u) {
	$packlists[$u] = getSite($u);
	}

foreach($entries as $e) {
	$matches = array();
	$pattern = '/(?<=\n).+\['.$e->group.'][^\n]+'.$e->packlist_title.'[^\n]+/';
	preg_match_all($pattern, $packlists[$e->url], $matches);
	echo '<p><strong>'.$e->mal_title.'</strong></p>';
	foreach($matches[0] as $m) {
		echo '<p>'.$m.'</p>';
	}
	echo '<br />';
}

?>
</div>

</body>
<!-- - - - - - - - - - - - - - - - - </body> - - - - - - - - - - - - - - - - -->

</html>
<!-- - - - - - - - - - - - - - - - - </html> - - - - - - - - - - - - - - - - -->

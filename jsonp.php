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
	$matches = array();
	$host = '';
	$path = '';
	preg_match('/^.+?\//', $u, $matches);
	$host = substr($matches[0], 0, -1);
	$path = substr($u, strlen($host));
	$packlists[$u] = getSite($host, $path);
	}

$series = array();
foreach($entries as $key => $e) {
	$matches = array();
	$pattern = '/(?<=\n).+\['.$e->group.'][^\n]+'.$e->packlist_title.'[^\n]+/';
	preg_match_all($pattern, $packlists[$e->url], $matches);
	$series[$key] = new StdClass();
	$series[$key]->packlist_title = $e->packlist_title;
	$series[$key]->mal_title = $e->mal_title;
	$lastEp = 0;
	foreach($matches[0] as $m) {
		$mtch_ep = array();
		$ptrn_ep = '/'.$e->packlist_title.'.+?[0-9]{2}/';
		preg_match($ptrn_ep, $m, $mtch_ep);
		$ep_pre = substr($mtch_ep[0], -2);
		$ep = (substr($ep_pre, 0, 1) == '0' ? substr($ep_pre, 1) : $ep_pre);
		$lastEp = ($ep > $lastEp ? $ep : $lastEp);

		$mtch_nr = array();
		$ptrn_nr = '/(?<=^#)\d+/';
		preg_match($ptrn_nr, $m, $mtch_nr);
		$lastNr = $mtch_nr[0];
	}
	$series[$key]->ep = $lastEp;
	$series[$key]->nr = $lastNr;
}

echo 'processJSONP([';
foreach($series as $key => $s) {
	echo ($key ? ',' : '').'{"mal_title":"'.$s->mal_title.'","ep":"'.$s->ep.'","nr":"'.$s->nr.'"}';
	}
echo ']);';

?>

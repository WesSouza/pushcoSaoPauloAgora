<?php

include "classes/CURL.php";
include "classes/RSS.php";
include "classes/Push.php";
include "classes/Weather.php";
include "classes/Traffic.php";
include "classes/Woodpecker.php";

$__config = array
(
	'sao-paulo' => array
	(
		'temperatureUnit' => 'C',
		'weather' => array
		(
			'cityId' => '3448439',
		),
		'news' => array
		(
			'feedUrl' => 'http://g1.globo.com/dynamo/sao-paulo/rss2.xml',
		),
		'traffic' => array
		(
			'mode' => 'radar-g1',
			'apiUrl' => 'http://radar.g1.globo.com/DataRequests/GetMaplink.aspx?method=getAll&city=S%C3%A3o%20Paulo&state=SP',
		),
		'push' => array
		(
			'apiKey' => 'PUSH_API_KEY',
			'apiSecret' => 'PUSH_API_SECRET',
		),
	),
);

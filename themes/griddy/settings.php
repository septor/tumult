<?php
/*
 * Tumult; get more information at:  http://tumultget.xyz/
 * For contributions, copyrights, and more view the `docs` folder.
 */
$THEMEINFO = [
	'name' => 'griddy',
	'author' => 'septor',
];

$LOAD = [
	'css' => [
		'style.css',
	],
	'header' => '',
	'footer' => '',
];

define('POST_STYLE', '
	<div>
		{CONTENT}
	</div>
');

define('STATIC_STYLE', '
	<div>
		{CONTENT}
	</div>
');

define('TWITTER_STYLE', '
	<div>
		@{USERNAME}<br />
		{TWEETS}
	</div>
');

define('TWITTER_TWEET_STYLE', '
	<hr />
	<p>
		{DATESTAMP}<br />
		{STATUS}<br />
		{REPLY} - {RETWEET} - {FAVORITE}
	</p>
');

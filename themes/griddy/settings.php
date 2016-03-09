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
		'grid.css',
		'style.css',
	],
	'header' => '',
	'footer' => '',
];

define('POST_STYLE', '
	<div class="block">
		{CONTENT}
	</div>
');

define('STATIC_STYLE', '
	<div class="block">
		{CONTENT}
	</div>
');

define('TWITTER_STYLE', '
	<div class="block">
		<h2>Twitter</h2>
		<p>
			@{USERNAME}<br />
			{TWEETS}
		</p>
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

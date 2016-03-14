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
		{{content}}
		<br /><br />
		last modified: {{date}}
	</div>
');

define('STATIC_STYLE', '
	<div class="block">
		{{content}}
	</div>
');

define('TWITTER_STYLE', '
	<div class="block">
		<h2>Twitter</h2>
		<p>
			@{{username}}<br />
			{{tweets}}
		</p>
	</div>
');

define('TWITTER_TWEET_STYLE', '
	<hr />
	<p>
		{{datestamp}}<br />
		{{status}}<br />
		{{reply}} - {{retweet}} - {{favorite}}
	</p>
');

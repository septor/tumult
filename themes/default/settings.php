<?php
/*
 * Tumult; get more information at:  http://tumultget.xyz/
 * For contributions, copyrights, and more view the `docs` folder.
 */
$THEMEINFO = [
	'name' => 'default',
	'author' => 'septor',
];

$LOAD = [
	'css' => [
		'style.css',
	],
	'header' => '<!-- custom header code -->',
	'footer' => '<!-- custom footer code -->',
];

define('POST_STYLE', '
	<div>
		{{content}}
	</div>
');

define('STATIC_STYLE', '
	<div>
		{{content}}
	</div>
');

define('TWITTER_STYLE', '
	<div>
		@{{username}}<br />
		{{tweets}}
	</div>
');

define('TWITTER_TWEET_STYLE', '
	<hr />
	<p>
		{{datestamp}}<br />
		{{status}}<br />
		{{reply} - {{retweet}} - {{favorite}}
	</p>
');

define('LASTFM_STYLE', '
	<div class="block">
		<h2>Last.fm</h2>
		<p>
			{{username}} has scrobbled {{playcount}} tracks! Here\'s the latest:
			<ul>
				{{recent_tracks}}
			</ul>
		</p>
	</div>
');

define('LASTFM_RECENTTRACK_STYLE', '
	<li>{{track_name}} by {{track_artist}}</li>
');

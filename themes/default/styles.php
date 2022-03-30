<?php
/*
 * Tumult; get more information at:  https://github.com/septor/tumult
 * For contributions, copyrights, and more view the `docs` folder.
 */
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

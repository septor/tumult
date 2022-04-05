<?php
/*
 * Tumult; get more information at:  https://github.com/septor/tumult
 * For contributions, copyrights, and more view the `docs` folder.
 */
define('POST_STYLE', '
	<div class="block">
		{{content}}
		<br><br>
		created on: {{created}}<br>
		last modified: {{updated}}
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
			@{{username}}<br>
			{{tweets}}
		</p>
	</div>
');

define('TWITTER_TWEET_STYLE', '
	<hr />
	<p>
		{{datestamp}}<br>
		{{status}}<br><br>
		{{reply}} - {{retweet}} - {{favorite}}
	</p>
');

define('LASTFM_STYLE', '
	<div class="block">
		<h2>Last.fm</h2>
		<p style="text-align:center;">
			<img src="{{random_large_artwork}}" />
		</p>
		<p>
			{{username}} has scrobbled {{playcount}} tracks! Here\'s the latest:<br>
			<ul>
				{{recent_tracks}}
			</ul>
		</p>
	</div>
');

define('LASTFM_RECENTTRACK_STYLE', '
	<li><img src="{{small_artwork}}"> {{track_name}} by {{track_artist}}</li>
');

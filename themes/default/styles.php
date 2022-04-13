<?php
/*
 * Tumult; get more information at:  https://github.com/septor/tumult
 * For contributions, copyrights, and more view the `docs` folder.
 */
define('POST_STYLE', '
	<div class="block">
		<h2>{{title}}</h2>
		<h6>{{description}}</h6>
		{{content}}
		<br><br>
		Created on: {{created}}<br>
		Modified: {{updated}}
	</div>
');

define('STATIC_STYLE', '
	<div class="block">
		{{content}}
	</div>
');

define('STEAM_STYLE', '
	<div class="block">
		<h2>Steam</h2>
		<p>
			<ul>
				{{recent_plays}}
			</ul>
		</p>
	</div>
');

define('STEAM_RECENTPLAYS_STYLE', '
	<li>{{gameicon}} {{name}} played {{forever}} hours total ({{twoweeks}} hours last two weeks)</li>
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
			{{random_large_artwork}}
		</p>
		<p>
			{{username}} has scrobbled {{playcount}} tracks! Here\'s the latest:<br>
			<ul>
				{{recent_tracks}}
			</ul>
		</p>
		<p>
			{{lovedcount}} songs have been loved, here\'s the top:<br>
			<ul>
				{{loved_tracks}}
			</ul>
	</div>
');

define('LASTFM_RECENTTRACK_STYLE', '
	<li>{{small_artwork}} {{track_name}} by {{track_artist}}</li>
');

define('LASTFM_LOVEDTRACK_STYLE', '
	<li>{{small_artwork}} {{track_name}} by {{track_artist}}</li>
');

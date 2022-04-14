<?php
/*
 * Tumult; get more information at:  https://github.com/septor/tumult
 * For contributions, copyrights, and more view the `docs` folder.
 */

// Geneal site information.
define('TUMULT_SITENAME', 'Tumult');
define('TUMULT_SITEOWNER', 'septor');

// Socal Network usernames.
const TUMULT_SOCIALDRINKS = [
	'twitter' => 'septor',
	'lastfm' => 'septor',
	'steam' => '76561197981854963',
];

// Decide which services should be loaded.
// To inactivate a service, simply remove it from the array. Or comment it out if you're a barbarian.
const TUMULT_SERVICES = [
	'twitter',
	'lastfm',
	'steam'
];

// Theme you wish to use.
// Defaults to 'default' if your theme isn't found or this isn't configured.
define('TUMULT_THEME', 'default');

// Default cache time, in minutes.
define('TUMULT_CACHETIME', 60);

// Sort type for static pages. Sorted by filename.
// 'asc'	= A, B, C, D, E
// 'desc'	= E, D, C, B, A
define('TUMULT_STATICS_SORT', 'asc');

// The location of your blog posts.
// Use `_posts` to use posts stored along side this script.
// Use `githubusername/reponame` to use a Github repo (see the wiki for more info)
// Notice, if you create a local post and your post location is NOT local, it will still exist. It just won't be stored remotely.
define('TUMULT_POSTLOCATION', '_posts');

// Date format to display the date of blog posts.
// Format accepts parameters used in the PHP date() function.
// See http://php.net/manual/en/function.date.php for more information.
define('TUMULT_POST_DATEFORMAT', 'F jS, Y');

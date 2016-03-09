<?php
/*
 * Tumult; get more information at:  http://tumultget.xyz/
 * For contributions, copyrights, and more view the `docs` folder.
 */

// Geneal site information.
define('TUMULT_SITENAME',		'Tumult');
define('TUMULT_SITEOWNER',		'septor');

// Socal Network usernames.
// Note: define() is not used here because that requires PHP7+.
// The below method only requires PHP5.6+ 
const TUMULT_SOCIALDRINKS = [
	'twitter' => 'septor',
	'lastfm' => 'septor',
];

// Theme you wish to use.
// Defaults to 'griddy' if your theme isn't found or this isn't configured.
define('TUMULT_THEME',			'griddy');

// Sort type for static pages. Sorted by filename.
// 'asc'	= A, B, C, D, E
// 'desc'	= E, D, C, B, A
define('TUMULT_STATICS_SORT',	'asc');

// The location of your blog posts.
// Use `_posts` to use posts stored along side this script.
// Use `githubusername/reponame` to use a Github repo (see the wiki for more info)
define('TUMULT_POSTLOCATION',	'_posts');

// Date format to display the date of blog posts.
// Format accepts parameters used in the PHP date() function.
// See http://php.net/manual/en/function.date.php for more information.
define('TUMULT_POST_DATEFORMAT', 'F jS, Y');

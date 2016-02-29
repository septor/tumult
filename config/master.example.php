<?php
/*
 * Tumult; get more information at:  http://tumultget.xyz/
 * For contributions, copyrights, and more view the `docs` folder.
 */

// Geneal site information.
define('TUMULT_SITENAME',	'Tumult');
define('TUMULT_SITEOWNER',	'septor');

// Theme you wish to use.
// Defaults to 'default' if your theme isn't found or this isn't configured.
define('TUMULT_THEME',		'default');

// The location of your blog posts.
// Use `_posts` to use posts stored along side this script.
// Use `githubusername/reponame` to use a Github repo (see the wiki for more info)
define('TUMULT_BLOGFEED',	'_posts');

$columnOrders = [
	'blog' => 'desc',
	'services' => '',
	'statics' => 'intro,about',
],

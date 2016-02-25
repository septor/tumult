<?php
/*
 * Tumult; get more information at:  http://tumultget.xyz/
 * For contributions, copyrights, and more view the `docs` folder.
 */
if(!file_exists('config/master.php')
{
	die('You need to configure and rename master.example.php to master.php for Tumult to function.');
}
include('_libs.php');
$cp = new Statics();
$te = new Theme(TUMULT_THEME);

echo '<html>
	<head>
		<title>'.TUMULT_NAME.'title>
		<link rel="stylesheet" href="themes/'.TUMULT_THEME.'/style.css">
	</head>
	<body>';

$te->parseSc('themes/'.TUMULT_THEME.'/template.html');

echo '
	</body>
</html>';

echo $cp->content('statics/about.md');

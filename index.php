<?php
/*
 * Tumult; get more information at:  http://tumultget.xyz/
 * For contributions, copyrights, and more view the `docs` folder.
 */
if(!file_exists('config/master.php'))
	die('You need to configure and rename master.example.php to master.php for Tumult to function.');

include('_libs.php');

if(defined(TUMULT_THEME))
	$theme = (file_exists('themes/'.TUMULT_THEME) ? TUMULT_THEME : 'default');
else
	$theme = 'default';

$te = new Theme($theme);

echo '<html>
	<head>
		<title>'.TUMULT_SITENAME.'</title>
		<link rel="stylesheet" href="themes/'.TUMULT_THEME.'/style.css">
	</head>
	<body>
		'.$te->displayContent().'
	</body>
</html>';

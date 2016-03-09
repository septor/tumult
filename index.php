<?php
/*
 * Tumult; get more information at:  http://tumultget.xyz/
 * For contributions, copyrights, and more view the `docs` folder.
 */
if(!file_exists('config/master.php'))
	die('You need to configure and rename master.example.php to master.php for Tumult to function.');

include('_libs.php');

if(defined('TUMULT_THEME'))
	$theme = (file_exists('themes/'.TUMULT_THEME) ? TUMULT_THEME : 'griddy');
else
	$theme = 'griddy';

$te = new Theme($theme);

foreach($LOAD['css'] as $cssToLoad)
	@$css .= '<link rel="stylesheet" href="themes/'.TUMULT_THEME.'/'.$cssToLoad.'">';

echo '<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF=8">
		<title>'.TUMULT_SITENAME.'</title>
		'.$css.'
		'.$LOAD['header'].'
	</head>
	<body>
		'.$te->displayContent().'
	</body>
	'.$LOAD['footer'].'
</html>';

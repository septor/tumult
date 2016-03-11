<?php
/*
 * Tumult; get more information at:  http://tumultget.xyz/
 * For contributions, copyrights, and more view the `docs` folder.
 */
if(!file_exists('config/master.php'))
	die('You need to configure and rename master.example.php to master.php for Tumult to function.');

include('_libs.php');

$te = new Tumult();

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
		'.$te->loadContent().'
	</body>
	'.$LOAD['footer'].'
</html>';

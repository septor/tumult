<?php
/*
 * Tumult; get more information at:  https://github.com/septor/tumult
 * For contributions, copyrights, and more view the `docs` folder.
 */
if(!file_exists('config/master.php'))
	die('You need to configure and rename master.example.php to master.php for Tumult to function.');

include('_libs.php');

$tumult = new Tumult();

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
		'.$tumult->loadContent().'
	</body>
	'.$LOAD['footer'].'
</html>';

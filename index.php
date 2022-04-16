<?php
/*
 * Tumult; get more information at:  https://github.com/septor/tumult
 * For contributions, copyrights, and more view the `docs` folder.
 */

if(!file_exists('config/master.php'))
	die('You need to configure and rename master.example.php to master.php for Tumult to function.');

if(!file_exists('config/keys.php'))
	die('You need to rename your keys file, even if you do not plan to use any services.');
	
include('_libs.php');

$tumult = new Tumult();

foreach($LOAD['css'] as $cssToLoad)
	@$css .= '<link rel="stylesheet" href="themes/'.TUMULT_THEME.'/'.$cssToLoad.'">';

echo '<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF=8">
		'.(defined(TUMULT_META_DESCRIPTION ? '<meta name="description" content="'.TUMULT_META_DESCRIPTION.'">' : '').'
        '.(defined(TUMULT_META_KEYWORDS ? '<meta name="keywords" content="'.TUMULT_META_KEYWORDS.'">' : '').'
        '.(defined(TUMULT_META_AUTHOR ? '<meta name="author" content="'.TUMULT_META_AUTHOR.'">' : '').'
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>'.TUMULT_SITENAME.'</title>
		'.$css.'
		'.$LOAD['header'].'
	</head>
	<body>
		'.$tumult->loadContent().'
	</body>
	'.$LOAD['footer'].'
</html>';

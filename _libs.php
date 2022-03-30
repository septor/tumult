<?php
/*
 * Tumult; get more information at:  https://github.com/septor/tumult
 * For contributions, copyrights, and more view the `docs` folder.
 */

// Load all the third-party scripts first.
include('libs/thirdparty/Parsedown.php');
include('libs/thirdparty/Mustache/Autoloader.php');
Mustache_Autoloader::register();

// Now, we need the configuration file for the constants.
include('config/master.php');

// Now we need the core lib file, since some of the other libs extend onto it.
include('libs/tumult.php');

// Load the theme files.
include('themes/'.TUMULT_THEME.'/settings.php');
include('themes/'.TUMULT_THEME.'/styles.php');

// Load in the services _core.php and key.php files.
foreach(glob('services/*', GLOB_ONLYDIR) as $service)
{
	include($service.'/_core.php');
	include($service.'/keys.php');
}

// Load in the remaining lib files.
include('libs/services.php');
include('libs/statics.php');
include('libs/posts.php');

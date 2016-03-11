<?php
/*
 * Tumult; get more information at:  http://tumultget.xyz/
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

// Now we need everything else!
include('themes/'.TUMULT_THEME.'/settings.php');

foreach(glob('services/*', GLOB_ONLYDIR) as $service)
	include($service.'/_core.php');

include('libs/services.php');
include('libs/statics.php');
include('libs/posts.php');

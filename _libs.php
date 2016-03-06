<?php
/*
 * Tumult; get more information at:  http://tumultget.xyz/
 * For contributions, copyrights, and more view the `docs` folder.
 */
include('libs/thirdparty/Parsedown.php');
include('config/master.php');
include('themes/'.TUMULT_THEME.'/settings.php');

foreach(glob('services/*', GLOB_ONLYDIR) as $service)
	include($service.'/_core.php');

include('libs/services.php');
include('libs/statics.php');
include('libs/posts.php');
include('libs/theme.php');

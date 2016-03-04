<?php
/*
 * Tumult; get more information at:  http://tumultget.xyz/
 * For contributions, copyrights, and more view the `docs` folder.
 */
class Services
{
	function __construct()
	{
	}

	function loadConfig($service)
	{
		if(file_exists('config/'.$service.'.php')
			$output = 'config/'.$service.'.php';
		else
			$output = 'services/'.$service.'/config.php';

		return $output;
	}
}	

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

	function hasConfig($service)
	{
		if(file_exists('config/'.$service.'.php')
			$output = true;
		else
			$output = false;

		return $output;
	}
}

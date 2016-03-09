<?php
/*
 * Tumult; get more information at:  http://tumultget.xyz/
 * For contributions, copyrights, and more view the `docs` folder.
 */
class Services
{
	function hasConfig($service)
	{
		if(file_exists('config/'.$service.'.php'))
			$output = true;
		else
			$output = false;

		return $output;
	}

	function loadService($service)
	{
		switch($service)
		{
			case 'twitter':
				$load = new Twitter();
				return $load->display();
				break;
			case 'lastfm':
				$load = new Lastfm();
				return $load->display();
				break;
		}
	}
}

<?php
/*
 * Tumult; get more information at:  https://github.com/septor/tumult
 * For contributions, copyrights, and more view the `docs` folder.
 */
class Services
{
	function hasConfig($service)
	{
		if(file_exists('config/'.$service.'.php'))
			return true;
		else
			return false;
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

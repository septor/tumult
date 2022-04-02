<?php
/*
 * Tumult; get more information at:  https://github.com/septor/tumult
 * For contributions, copyrights, and more view the `docs` folder.
 */
class Tumult
{
	function __construct()
	{
		$this->mustache = new Mustache_Engine([
			'escape' => function($value)
			{
				return $value;
			}
		]);

		if(defined('TUMULT_THEME'))
			$this->theme = (file_exists('themes/'.TUMULT_THEME) ? TUMULT_THEME : 'default');
		else
			$this->theme = 'default';

		$this->template = file_get_contents('themes/'.$this->theme.'/template.html');
		$this->bp = new Posts();
		$this->sd = new Statics();
		$this->sp = new Services();
	}

	function curlFetch($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Tumult Punch/1.0');
		$data = curl_exec($ch);

		return $data;
	}

	function loadContent()
	{
		$posts = $this->bp->fetchPosts((TUMULT_POSTLOCATION == '_posts' ? 'local' : 'remote'));
		$services = glob('services/*', GLOB_ONLYDIR);

		if(count($services) > 0)
		{
			foreach($services as $service)
			{
				$service = str_replace('services/', '', $service);
				if(in_array($service, TUMULT_SERVICES))
				{
					@$loadServices .= $this->sp->loadService($service);
				}
			}
		}
		else
		{
			$loadServices = '';
		}

		$output = $this->mustache->render($this->template, [
			'sitename' => TUMULT_SITENAME,
			'blog_column' => $posts,
			'services_column' => $loadServices,
			'statics_column' => $this->sd->fetch(TUMULT_STATICS_SORT),
			'copyright' => 'Copyright '.date('Y').' '.TUMULT_SITEOWNER,
			'poweredby' => 'Powered by <a href="https://github.com/septor/tumult">Tumult</a>',
		]);

		return $output;
	}
}

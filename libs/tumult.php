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
		$this->posts = new Posts();
		$this->statics = new Statics();
		$this->services = new Services();
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
		$posts = $this->posts->fetchPosts((TUMULT_POSTLOCATION == '_posts' ? 'local' : 'remote'));
		$services = glob('services/*', GLOB_ONLYDIR);
		$servicesArray = [];

		if(count($services) > 0)
		{
			foreach($services as $service)
			{
				$service = str_replace('services/', '', $service);
				if(in_array($service, TUMULT_SERVICES))
				{
					@$loadServices .= $this->services->loadService($service);
					$servicesArray[$service.'_service'] = $this->services->loadService($service);
				}
			}
		}
		else
		{
			$loadServices = '';
		}

		$render = [
			'sitename' => TUMULT_SITENAME,
			'blog_column' => $posts,
			'services_column' => $loadServices,
			'statics_column' => $this->statics->fetch(TUMULT_STATICS_SORT),
			'copyright' => 'Copyright '.date('Y').' '.TUMULT_SITEOWNER,
			'poweredby' => 'Powered by <a href="https://github.com/septor/tumult">Tumult</a>',
		];

		foreach($servicesArray as $service => $content)
		{
			$render[$service] = $content;
		}

		$output = $this->mustache->render($this->template, $render);

		return $output;
	}
}

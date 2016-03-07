<?php
/*
 * Tumult; get more information at:  http://tumultget.xyz/
 * For contributions, copyrights, and more view the `docs` folder.
 */
class Theme
{
	public $theme;

	function __construct($name='default')
	{
		$this->theme = $name;
		$this->sp = new Statics();
		$this->bp = new Posts();
		$this->sd = new Services();
	}

	function displayContent()
	{
		if(TUMULT_POSTLOCATION == '_posts')
			$posts = $this->bp->fetchLocal();
		else
			$posts = $this->bp->fetchRemote();

		$services = glob('services/*', GLOB_ONLYDIR);
		$loadServices = '';

		foreach($services as $service)
		{
			$service = str_replace('services/', '', $service);
			$loadServices .= $this->sd->loadService($service);
		}

		$output = str_replace(
			[
				'{SITENAME}',
				'{BLOG_COLUMN}',
				'{SERVICES_COLUMN}',
				'{STATICS_COLUMN}',
				'{COPYRIGHT}',
			],
			[
				TUMULT_SITENAME,
				$posts,
				$loadServices,
				$this->sp->fetch(TUMULT_STATICS_SORT),
				'Copyright '.date('Y').' '.TUMULT_SITEOWNER,
			],
			file_get_contents('themes/'.$this->theme.'/template.html'));

		return $output;
	}
}

<?php
/*
 * Tumult; get more information at:  http://tumultget.xyz/
 * For contributions, copyrights, and more view the `docs` folder.
 */
class Theme
{
	public $theme;
	public $staticOrder;

	function __construct($name='default')
	{
		$this->theme = $name;
		$this->staticOrder = ['intro', 'about']
		$this->mdp = new Parsedown();
	}

	function displayContent()
	{
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
				'BLOG COLUMN',
				'SERVICES COLUMN',
				$this->fetchStatics(),
				'Copyright '.date('Y').' '.TUMULT_SITEOWNER,
			],
			file_get_contents('themes/'.$this->theme.'/template.html'));

		return $output;
	}

	function fetchStatics()
	{
		$statics = "";
		foreach($this->staticOrder as $static)
		{
			$statics .= $this->mdp->text(file_get_contents('statics/'.$static.'.md'));
		}

		return $statics;
	}
}

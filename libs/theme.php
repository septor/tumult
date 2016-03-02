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
				$this->sp->fetchPosts(TUMULT_POSTLOCATION),
				'SERVICES COLUMN',
				$this->sp->fetchStatics(),
				'Copyright '.date('Y').' '.TUMULT_SITEOWNER,
			],
			file_get_contents('themes/'.$this->theme.'/template.html'));

		return $output;
	}
}

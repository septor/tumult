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
	}

	function displayContent()
	{
		$input = file_get_contents('themes/'.$this->theme.'/template.html');
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
				'STATICS COLUMN',
				'Copyright '.date('Y').' '.TUMULT_SITEOWNER,
			],
		$input);

		return $output;
	}
}

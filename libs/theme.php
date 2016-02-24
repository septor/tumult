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

	function parseSc($input)
	{
		// There's probably a better way. Researching...
		preg_match_all('/{(.*?)}/', $input, $matches);


		print_r(array_map('intval',$matches[1]));
	}
}

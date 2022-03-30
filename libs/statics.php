<?php
/*
 * Tumult; get more information at:  https://github.com/septor/tumult
 * For contributions, copyrights, and more view the `docs` folder.
 */
class Statics
{
	public $mdp;

	function __construct()
	{
		$this->mdp = new Parsedown();
		$this->mustache = new Mustache_Engine([
			'escape' => function($value)
			{
				return $value;
			}
		]);
	}

	function content($file)
	{
		if(file_exists($file))
			return $this->mdp->text(file_get_contents($file));
	}

	function fetch($sort)
	{
		$files = glob('statics/*.{markdown,mdown,mkdn,mkd,md}', GLOB_BRACE);
		if($sort == 'asc')
			asort($files);
		else if($sort == 'desc')
			arsort($files);

		foreach($files as $static)
		{
			@$statics .=  $this->mustache->render(STATIC_STYLE, [
				'content' => $this->content($statixc),
			]);
		}

		return $statics;
	}
}

<?php
/*
 * Tumult; get more information at:  http://tumultget.xyz/
 * For contributions, copyrights, and more view the `docs` folder.
 */
class Statics
{
	public $mdp;

	function __construct()
	{
		$this->mdp = new Parsedown();
		$this->blockstyle = STATIC_STYLE;
	}

	function content($file)
	{
		if(file_exists($file))
			return $this->mdp->text(file_get_contents($file));
	}

	function fetch($sort)
	{
		$statics = '';
		$files = glob('statics/*.md');
		if($sort == 'asc')
			asort($files);
		else if($sort == 'desc')
			arsort($files);

		foreach($files as $static)
			$statics .= str_replace('{CONTENT}', $this->content($static), $this->blockstyle);

		return $statics;
	}
}

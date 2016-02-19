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
	}

	function content($file)
	{
		if(file_exists($file))
			return $this->mdp->text(file_get_contents($file));
	}

	function post($file)
	{
	}
}

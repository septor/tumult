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
		if(file_exists($file))
		{
			// Read the file into an array.
			$lines = file($file);

			// Split off the first 4 lines and assign them as our post config.
			$content = array_splice($lines, 4);
			$configLines = $lines;

			// Now cycle through the remaining lines and parse them.
			$post = '';
			foreach($content as $line)
				$post .= $this->mdp->text($line);

			// Assign the array parts, then return it.
			// TODO: More effecient title/desc plucking.
			$output = [
				'title' => str_replace('title=', '', $configLines[1]),
				'description' => str_replace('description=', '', $configLines[2]),
				'content' => $post,
			];

			return $output;
		}
	}
}

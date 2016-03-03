<?php
/*
 * Tumult; get more information at:  http://tumultget.xyz/
 * For contributions, copyrights, and more view the `docs` folder.
 */
class Posts
{
	public $mdp;

	function __construct()
	{
		$this->mdp = new Parsedown();
	}

	function process($file)
	{
		if(file_exists($file))
		{
			$lines = file($file);
			$content = array_splice($lines, 4);
			$configLines = $lines;

			$post ='';
			foreach($content as $line)
				$post .= $this->mdp->text($line);

			//TODO: Better config plucking
			$output = [
				'title' => str_replace('title=', '', $configLines[1]),
				'description' => str_replace('description=', '', $configLines[2]),
				'content' => $post,
			];

		return $output;
		}
	}

	function fetchLocal()
	{
		$posts = '';

		foreach(glob(TUMULT_POSTLOCATION.'/*.md') as $post)
		{
			$newPost = $this->process($post);
			$posts .= $newPost['content'];
		}

		return $posts;
	}

	function fetchRemote()
	{
	}
}

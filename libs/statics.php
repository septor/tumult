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

	function fetchStatics()
	{
		$statics = '';
		foreach(glob('statics/*.md') as $static)
			$statics .= $this->content($static);

		return $statics;
	}

	function fetchPosts($location)
	{
		$posts = '';

		if($location == '_posts')
		{
			foreach(glob($location.'/*.md') as $post)
			{
				$newPost = $this->post($post);
				$posts .= $newPost['content'];
			}
		}
		//TODO: fetch remote repo posts

		return $posts;
	}
}

<?php
/*
 * Tumult; get more information at:  http://tumultget.xyz/
 * For contributions, copyrights, and more view the `docs` folder.
 */
class Posts extends Tumult
{
	public $mdp;

	function __construct()
	{
		$this->mdp = new Parsedown();
	}

	function process($file)
	{
		$lines = file($file);

		$content = array_splice($lines, 6);
		$configLines = $lines;

		foreach($content as $line)
			@$post .= $this->mdp->text($line);

		$output = [
			'title' => $this->gatherConfig($configLines[2]),
			'description' => $this->gatherConfig($configLines[3]),
			'content' => $post,
			'date' => $file,
		];

		return $output;
	}

	function gatherConfig($config)
	{
		if(preg_match('/"([^"]+)"/', $config, $matches))
			return $matches[1];
		else
			return '';
	}

	function fetchLocal()
	{
		foreach(glob(TUMULT_POSTLOCATION.'/*.{markdown,mdown,mkdn,mkd,md}', GLOB_BRACE) as $post)
		{
			$newPost = $this->process($post);
			@$posts .= str_replace(
				[
					'{TITLE}',
					'{DESCRIPTION}',
					'{CONTENT}',
					'{DATE}',
				],
				[
					$newPost['title'],
					$newPost['description'],
					htmlspecialchars_decode($newPost['content']),
					date(TUMULT_POST_DATEFORMAT, $newPost['date']),
				],
				POST_STYLE);
		}

		return $posts;
	}

	function fetchRemote()
	{
		$data = parent::curlFetch('https://api.github.com/repos/'.TUMULT_POSTLOCATION.'/contents/_posts');
		$data = json_decode($data);

		foreach($data as $post)
		{
			$newPost = $this->process($post->download_url);
			@$posts .= str_replace(
				[
					'{TITLE}',
					'{DESCRIPTION}',
					'{CONTENT}',
					'{DATE}',
				],
				[
					$newPost['title'],
					$newPost['description'],
					$newPost['content'],
					date(TUMULT_POST_DATEFORMAT, $newPost['date']),
				],
				POST_STYLE);
		}

		return $posts;
	}
}

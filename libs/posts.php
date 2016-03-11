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
		$lines = file($file);

		$content = array_splice($lines, 6);
		$configLines = $lines;

		foreach($content as $line)
			@$post .= $this->mdp->text($line);

		$output = [
			'title' => $this->gatherConfig($configLines[2]),
			'description' => $this->gatherConfig($configLines[3]),
			'content' => $post,
			'date' => filectime($file),
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
					$newPost['content'],
					date(TUMULT_POST_DATEFORMAT, $newPost['date']),
				],
				POST_STYLE);
		}

		return $posts;
	}

	function fetchRemote()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/repos/'.TUMULT_POSTLOCATION.'/contents/_posts');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Tumult Punch/1.0');
		$data = curl_exec($ch);
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

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
		$this->blockstyle = POST_STYLE;
	}

	function process($file)
	{
		$lines = file($file);

		$content = array_splice($lines, 4);
		$configLines = $lines;

		$post = '';
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

	function fetchLocal()
	{
		$posts = '';

		foreach(glob(TUMULT_POSTLOCATION.'/*.md') as $post)
		{
			$newPost = $this->process($post);
			$posts .= str_replace(
				[
					'{TITLE}',
					'{DESCRIPTION}',
					'{CONTENT}',
				],
				[
					$newPost['title'],
					$newPost['description'],
					$newPost['content'],
				],
				$this->blockstyle);
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

		$posts = '';
		foreach($data as $post)
		{
			$newPost = $this->process($post->download_url);
			$posts .= str_replace(
				[
					'{TITLE}',
					'{DESCRIPTION}',
					'{CONTENT}',
				],
				[
					$newPost['title'],
					$newPost['description'],
					$newPost['content'],
				],
				$this->blockstyle);
		}

		return $posts;
	}
}

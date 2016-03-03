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


	function curlFetch($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Tumult Punch/1.0');
		$data = curl_exec($ch);

		return $data;
	}

	function fetchRemote()
	{
		$posts = '';
		$data = $this->curlFetch('https://api.github.com/repos/'.TUMULT_POSTLOCATION.'/contents/_posts');
		$data = json_decode($data);

		foreach($data as $post)
		{
			$newPost = $this->process(file_get_contents($post->download_url));
			$posts .= $newPost['content'];
		}

		return $posts;
	}
}

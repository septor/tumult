<?php
/*
 * Tumult; get more information at:  https://github.com/septor/tumult
 * For contributions, copyrights, and more view the `docs` folder.
 */
class Posts extends Tumult
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

	function process($file)
	{
		$lines = file($file);

		$content = array_splice($lines, 6);
		$configLines = $lines;
		$filetime = explode('_', str_replace("_posts/", "", $file));

		foreach($content as $line)
			@$post .= $this->mdp->text($line);

		$output = [
			'title' => $this->gatherConfig($configLines[2]),
			'description' => $this->gatherConfig($configLines[3]),
			'content' => $post,
			'created' => $filetime[0],
			'updated' => stat($file),
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

	function fetchPosts($loc)
	{
		if($loc == 'local')
		{
			$data = glob(TUMULT_POSTLOCATION.'/*.{markdown,mdown,mkdn,mkd,md}', GLOB_BRACE);
		}
		else
		{
			$data = parent::curlFetch('https://api.github.com/repos/'.TUMULT_POSTLOCATION.'/contents/_posts');
			$data = json_decode($data);
		}
			
		if($data)
		{
			foreach($data as $post)
			{
				if($loc == 'local')
					$newPost = $this->process($post);
				else
					$newPost = $this->process($post->download_url);

				@$posts .= $this->mustache->render(POST_STYLE, [
					'title' => $newPost['title'],
					'description' => $newPost['description'],
					'content' => $newPost['content'],
					'created' => date(TUMULT_POST_DATEFORMAT, strtotime($newPost['created'])),
					'updated' => date(TUMULT_POST_DATEFORMAT, $newPost['updated']['mtime']),
				]);
			}
			return $posts;
		}
		else
		{
			return "";
		}
	}
}

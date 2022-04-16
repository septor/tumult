<?php
/*
 * Tumult; get more information at:  https://github.com/septor/tumult
 * For contributions, copyrights, and more view the `docs` folder.
 */
class Posts extends Tumult
{
	public $markdown;

	function __construct()
	{
		$this->markdown = new Parsedown();
		$this->cache = (defined('TUMULT_CACHETIME') ? TUMULT_CACHETIME * 60 : 3600);

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
			@$post .= $this->markdown->text($line);

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
		if($loc != "local") {
			$response = json_decode(parent::curlFetch('https://api.github.com/repos/'.TUMULT_POSTLOCATION.'/contents/_posts'), true);
			foreach($response as $remotePost)
			{
				$filename = '_posts/'.$remotePost['name'];
				if(!(file_exists($filename)) || time() - filemtime($filename) > $this->cache)
				{
					file_put_contents($filename, file_get_contents($remotePost['download_url']));
				}
			}
		}

		$data = glob('_posts/*.{markdown,mdown,mkdn,mkd,md}', GLOB_BRACE);
			
		if($data)
		{
			foreach($data as $post)
			{
				$newPost = $this->process($post);

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

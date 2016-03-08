<?php
/*
 * Tumult; get more information at:  http://tumultget.xyz/
 * For contributions, copyrights, and more view the `docs` folder.
 */
require_once('keys.php');
require_once('TwitterAPIExchange.php');

class Twitter
{
	function __construct()
	{
		$this->sd = new Services();
		$this->settings = [
			'oauth_access_token' => TWITTER_ACCESS_TOKEN,
			'oauth_access_token_secret' => TWITTER_ACCESS_SECRET,
			'consumer_key' => TWITTER_CONSUMER_KEY,
			'consumer_secret' => TWITTER_CONSUMER_SECRET,
		];

		if($this->sd->hasConfig('twitter'))
		{
			$this->tweets = TWITTER_TWEETS;
			$this->replies = TWITTER_REPLIES;
			$this->retweets = TWITTER_RETWEETS;
			$this->cache = TWITTER_CACHE * 60;
			$this->dateformat = TWITTER_DATEFORMAT;
		}
		else
		{
			$this->tweets = 1;
			$this->replies = true;
			$this->retweets = false;
			$this->cache = 3600;
			$this->dateformat = 'F jS, Y - g:i A';
		}

		$this->username = TUMULT_SOCIALDRINKS['twitter'];
		$this->twitter = new TwitterAPIExchange($this->settings);
	}

	function gatherTweets()
	{
		if(!(file_exists('tweets.json')) || time() - filemtime('tweets.json') > $this->cache)
		{
			$response = $this->twitter->setGetfield('?screen_name='.$this->username.'&include_rts='.$this->retweets)
				->buildOauth('https://api.twitter.com/1.1/statuses/user_timeline.json', 'GET')
				->performRequest();
			file_put_contents('tweets.json', $response);
		}

		$output = json_decode(file_get_contents('tweets.json'));

		return $output;
	}

	function parseTweet($tweet)
	{
		$tweet = strip_tags($tweet);
		$tweet = preg_replace("/(https?:\/\/[^\s\)]+)/", "<a href='\\1'>\\1</a>", $tweet);
		$tweet = preg_replace("/\#([^\s\ \:\.\;\-\,\!\)\(\"]+)/", "<a href='http://search.twitter.com/search?q=%23\\1'>#\\1</a>", $tweet);
		$tweet = preg_replace("/\@([^\s\ \:\.\;\-\,\!\)\(\"]+)/", "<a href='http://twitter.com/\\1'>@\\1</a>", $tweet);

		return $tweet;
	}


	function display()
	{
		$sid = array();
		$data = $this->gatherTweets();
		$user = '<a href="http://twitter.com/'.$this->username.'">'.$this->username.'</a>';

		if($this->replies)
		{
			$a = 0;
			foreach($data as $status)
			{
				$a++;
				if(empty($status->in_reply_to_user_id))
					array_push($sid, ($a-1));
			}
		}
		else
		{
			for($i = 0; $i <= ($this->tweets - 1); $i++)
				array_push($sid, $i);
		}

		$b = 1;
		foreach($sid as $id)
		{
			if($b <= $this->tweets)
			{
				$tweetDate = new DateTime($data[$id]->created_at);
				@$all_tweets .= str_replace(
					[
						'{USERNAME}',
						'{DATESTAMP}',
						'{STATUS}',
						'{RETWEET}',
						'{REPLY}',
						'{FAVORITE}',
					],
					[
						$user,
						$tweetDate->format($this->dateformat),
						$this->parseTweet($data[$id]->text),
						'<a href="javascript:;" onClick="window.open(\'https://twitter.com/intent/retweet?tweet_id='.$data[$id]->id.'\',\'retweet\',\'scrollbars=yes,width=600,height=375\');">Retweet</a>',
						'<a href="javascript:;" onClick="window.open(\'https://twitter.com/intent/tweet?in_reply_to='.$data[$id]->id.'\',\'tweet\',\'scrollbars=yes,width=600,height=375\');">Reply</a>',
						'<a href="javascript:;" onClick="window.open(\'https://twitter.com/intent/favorite?tweet_id='.$data[$id]->id.'\',\'favorite\',\'scrollbars=yes,width=600,height=375\');">Favorite</a>',
					],
					TWITTER_TWEET_STYLE);
			}
			$b++;
		}

		$output = str_replace(
			[
				'{USERNAME}',
				'{TWEETS}',
			],
			[
				$user,
				$all_tweets,
			],
			TWITTER_STYLE);

		return $output;
	}
}

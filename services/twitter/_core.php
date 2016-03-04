<?php
/*
 * Tumult; get more information at:  http://tumultget.xyz/
 * For contributions, copyrights, and more view the `docs` folder.
 */
require_once('keys.php');
require_once('TwitterAPIExchange.php');

class Twitter extends Services
{
	function __construct()
	{
		$this->settings = [
			'oauth_access_token' => TWITTER_ACCESS_TOKEN,
			'oauth_access_token_secret' => TWITTER_ACCESS_SECRET,
			'consumer_key' => TWITTER_CONSUMER_KEY,
			'consumer_secret' => TWITTER_CONSUMER_SECRET,
		];

		if(parent::hasConfig('twitter'))
		{
			$this->tweets = TWITTER_TWEETS;
			$this->replies = TWITTER_REPLIES;
			$this->retweets = TWITTER_RETWEETS;
			$this->cache = TWITTER_CACHE * 60;
		}
		else
		{
			$this->tweets = 1;
			$this->replies = true;
			$this->retweets = false;
			$this->cache = 3600;
		}

		$this->twitter = new TwitterAPIExchange($this->settings);
	}

	function gatherTweets()
	{
		if(!(file_exists('tweets.json')) || time() - filemtime('tweets.json') > $this->cache)
		{
			$response = $this->twitter->setGetfield('?screen_name='.$this->user.'&include_rts='.$this->retweets)
				->buildOauth('https://api.twitter.com/1.1/statuses/user_timeline.json', 'GET')
				->performRequest();
			file_put_contents('tweets.json', $response);
		}

		$output = json_decode(file_get_contents('tweets.json'));

		return $output;
	}
}

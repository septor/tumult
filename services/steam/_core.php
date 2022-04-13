<?php
/*
 * Tumult; get more information at:  https://github.com/septor/tumult
 * For contributions, copyrights, and more view the `docs` folder.
 */
class Steam extends Tumult
{
	function __construct()
	{
        $this->services = new Services();
		$this->key = STEAM_APIKEY;
		$this->user = TUMULT_SOCIALDRINKS['steam'];
        $this->cache = (defined(TUMULT_CACHETIME) ? TUMULT_CACHETIME * 60 : 3600);

        if($this->services->hasConfig('steam'))
		{
			$this->dateformat = (defined(STEAM_DATEFORMAT) ? STEAM_DATEFORMAT : 'F jS, Y');
		}
		else
		{
			$this->dateformat = 'F jS, Y';
		}

		$this->mustache = new Mustache_Engine([
			'escape' => function($value)
			{
				return $value;
			}
		]);
	}

    function fetchData($data)
	{
        if($data == "GetPlayerSummaries")
        {
            $urlModifier = "ISteamUser/GetPlayerSummaries/v0002";
            $idModifier = "steamids=".$this->user;
        }
        else if($data == "GetFriendList")
        {
            $urlModifier = "ISteamUser/GetFriendList/v0001";
            $idModifier = "steamid=".$this->user."&relationship=friend";
        }
        else if($data == "GetPlayerAchievements")
        {
            $urlModifier = "ISteamUserStats/GetPlayerAchievements/v0001";
            $idModifier = "steamid=".$this->user;
        }
        else if($data == "GetOwnedGames")
        {
            $urlModifier = "IPlayerService/GetOwnedGames/v0001";
            $idModifier = "steamid=".$this->user;
        }
        else if($data == "GetRecentlyPlayedGames")
        {
            $urlModifier = "IPlayerService/GetRecentlyPlayedGames/v0001";
            $idModifier = "steamid=".$this->user;
        }
        else
        {
            die('Set a datapoint. [steam_service]');
        }

		return parent::curlFetch('http://api.steampowered.com/'.$urlModifier.'/?key='.$this->key.'&'.$idModifier.'&format=json');
	}

	function retrieve($call, $filename)
	{
		if(!(file_exists('cache/'.$filename)) || time() - filemtime('cache/'.$filename) > $this->cache)
		{
			$response = $this->fetchData($call);
			file_put_contents('cache/'.$filename, $response);
		}

		return json_decode(file_get_contents('cache/'.$filename), true);
	}

    function display()
    {
        foreach($this->getRecentlyPlayed() as $game)
		{
			@$recent_plays .= $this->mustache->render(STEAM_RECENTPLAYS_STYLE, [
				'name' => $game['name'],
				'gameicon' => $game['gameicon'],
				'forever' => $game['forever'],
				'twoweeks' => $game['twoweeks'],
			]);
		}

        $output = $this->mustache->render(STEAM_STYLE, [
            'realname' => $this->getInfo()['realname'],
            'displayname' => $this->getInfo()['displayname'],
            'url' => $this->getInfo()['url'],
            'laston' => $this->getInfo()['lastlogoff'],
            'created' => $this->getInfo()['created'],
			'recent_plays' => $recent_plays,
            'small_avatar' => '<img style="width: 34px; height: 34px;" src="'.$this->getInfo()['avatar'].'">',
			'medium_avatar' => '<img style="width: 64px; height: 64px;" src="'.$this->getInfo()['avatar'].'">',
			'large_avatar' => '<img style="width: 174px; height: 174px;" src="'.$this->getInfo()['avatar'].'">',
			'extralarge_avatar' => '<img style="width: 300px; height: 300px;" src="'.$this->getInfo()['avatar'].'">',
		]);

		return $output;
    }

    function getInfo()
    {
        $data = $this->retrieve('GetPlayerSummaries', 'steam_userinfo.json');
        $user = $data['response']['players'][0];

        $output = [
            'steamid' => $user['steamid'],
            'displayname' => $user['personaname'],
            'url' => $user['profileurl'],
            'avatar' => $user['avatarfull'],
            'lastlogoff' => date($this->dateformat, $user['lastlogoff']),
            'realname' => $user['realname'],
            'clanid' => $user['primaryclanid'],
            'created' => date($this->dateformat, $user['timecreated']),
            'countrycode' => $user['loccountrycode'],
        ];

        return $output;
    }

    function getRecentlyPlayed()
    {
        $data = $this->retrieve('GetRecentlyPlayedGames', 'steam_recentplays.json');
        $games = $data['response']['games'];

		foreach($games as $game)
		{
			$output[] = [
				'gameicon' => '<img src="http://media.steampowered.com/steamcommunity/public/images/apps/'.$game['appid'].'/'.$game['img_icon_url'].'.jpg" />',
                'name' => $game['name'],
                'forever' => round($game['playtime_forever'] / 60),
                'twoweeks' => round($game['playtime_2weeks'] / 60),
			];
		}

		return $output;
    }
}
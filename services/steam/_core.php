<?php
/*
 * Tumult; get more information at:  https://github.com/septor/tumult
 * For contributions, copyrights, and more view the `docs` folder.
 */
class Steam extends Tumult
{
	function __construct()
	{
		$this->key = STEAM_APIKEY;
		$this->user = TUMULT_SOCIALDRINKS['steam'];

		$this->mustache = new Mustache_Engine([
			'escape' => function($value)
			{
				return $value;
			}
		]);
	}

    function retrieve($data)
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
		$result = parent::curlFetch('http://api.steampowered.com/'.$urlModifier.'/?key='.$this->key.'&'.$idModifier.'&format=json');
		return json_decode($result, true);
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
			'recent_plays' => $recent_plays,
		]);

		return $output;
    }

    function getRecentlyPlayed()
    {
        $data = $this->retrieve('GetRecentlyPlayedGames');
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
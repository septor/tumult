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
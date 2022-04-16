<?php
/*
 * Tumult; get more information at:  https://github.com/septor/tumult
 * For contributions, copyrights, and more view the `docs` folder.
 */
class Lastfm extends Tumult
{
	function __construct()
	{
		$this->services = new Services();
		$this->key = LASTFM_APIKEY;
		$this->user = TUMULT_SOCIALDRINKS['lastfm'];
		$this->cache = (defined('TUMULT_CACHETIME') ? TUMULT_CACHETIME * 60 : 3600);

		$defaultCount = 5;

		if($this->services->hasConfig('lastfm'))
		{
			$this->recent_count = (defined('LASTFM_RECENTTRACKCOUNT') ? LASTFM_RECENTTRACKCOUNT : $defaultCount);
			$this->loved_count = (defined('LASTFM_LOVEDTRACKCOUNT') ? LASTFM_LOVEDTRACKCOUNT : $defaultCount);
		}
		else
		{
			$this->recent_count = $defaultCount;
			$this->loved_count = $defaultCount;
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
		return parent::curlFetch('http://ws.audioscrobbler.com/2.0/?method='.$data.'&api_key='.$this->key);
	}

	function retrieve($call, $filename)
	{
		if(!(file_exists('cache/'.$filename)) || time() - filemtime('cache/'.$filename) > $this->cache)
		{
			$response = $this->fetchData($call);
			file_put_contents('cache/'.$filename, $response);
		}

		return simplexml_load_string(file_get_contents('cache/'.$filename));
	}

	function display()
	{
		$recent_artworks = [];
		foreach($this->getRecentTracks('limit='.$this->recent_count) as $track)
		{
			@$recent_tracks .= $this->mustache->render(LASTFM_RECENTTRACK_STYLE, [
				'track_name' => $track['name'],
				'track_artist' => $track['artist'],
				'track_album' => $track['album'],
				'small_artwork' => '<img style="width: 34px; height: 34px;" src="'.$track['artwork'].'">',
				'medium_artwork' => '<img style="width: 64px; height: 64px;" src="'.$track['artwork'].'">',
				'large_artwork' => '<img style="width: 174px; height: 174px;" src="'.$track['artwork'].'">',
				'extralarge_artwork' => '<img style="width: 300px; height: 300px;" src="'.$track['artwork'].'">',
			]);

			array_push($recent_artworks, $track['artwork']);
		}

		foreach($this->getLovedTracks('limit='.$this->loved_count) as $track)
		{
			@$loved_tracks .= $this->mustache->render(LASTFM_LOVEDTRACK_STYLE, [
				'track_name' => $track['name'],
				'track_artist' => $track['artist'],
				'small_artwork' => '<img style="width: 34px; height: 34px;" src="'.$track['artwork'].'">',
				'medium_artwork' => '<img style="width: 64px; height: 64px;" src="'.$track['artwork'].'">',
				'large_artwork' => '<img style="width: 174px; height: 174px;" src="'.$track['artwork'].'">',
				'extralarge_artwork' => '<img style="width: 300px; height: 300px;" src="'.$track['artwork'].'">',
			]);
		}
		
		$randomArtwork = $recent_artworks[rand(0, count($recent_artworks) - 1)];

		$output = $this->mustache->render(LASTFM_STYLE, [
			'username' => $this->getInfo()['name'],
			'realname' => $this->getInfo()['realname'],
			'playcount' => $this->getInfo()['playcount'],
			'lovedcount' => $this->retrieve('user.getLovedTracks&user='.$this->user, 'lastfm_lovedtracks.xml')->lovedtracks['total'],
			'recent_tracks' => $recent_tracks,
			'loved_tracks' => $loved_tracks,
			'random_small_artwork' => '<img style="width: 34px; height: 34px;" src="'.$randomArtwork.'">',
			'random_medium_artwork' => '<img style="width: 64px; height: 64px;" src="'.$randomArtwork.'">',
			'random_large_artwork' => '<img style="width: 174px; height: 174px;" src="'.$randomArtwork.'">',
			'random_extralarge_artwork' => '<img style="width: 300px; height: 300px;" src="'.$randomArtwork.'">',
		]);

		return $output;
	}

	function getInfo()
	{
		$data = $this->retrieve('user.getInfo&user='.$this->user, 'lastfm_userinfo.xml');
		$user = $data->user;

		$output = [
			'name' => $user->name,
			'realname' => $user->realname,
			'url' => $user->url,
			'image' => $user->image[3],
			'country' => $user->country,
			'age' => $user->age,
			'gender' => $user->gender,
			'subscriber' => $user->subscriber,
			'playcount' => $user->playcount,
			'playlists' => $user->playlists,
			'registered' => $user->registered['unixtime'],
		];

		return $output;
	}

	function getShouts($type='shouts', $options='')
	{
		$options = (empty($options) ? '' : '&'.$options);
		$data = $this->retrieve('user.getShouts&user='.$this->user.$options, 'lastfm_shouts.xml');

		if($type == 'shouts')
		{
			$shouts = $data->shouts->shout;

			foreach($shouts as $shout)
			{
				$output[] = [
					'author' => $shout->author,
					'body' => $shout->body,
					'date' => strtotime($shout->date),
				];
			}
		}
		elseif($type == 'count')
		{
			$output = $data->shouts['count'];
		}

		return $output;
	}

	function getRecentTracks($options='')
	{
		$options = (empty($options) ? '' : '&'.$options);
		$data = $this->retrieve('user.getRecentTracks&user='.$this->user.$options, 'lastfm_recenttracks.xml');
		$tracks = $data->recenttracks->track;

		foreach($tracks as $track)
		{
			$output[] = [
				'artist' => $track->artist,
				'name' => $track->name,
				'album' => $track->album,
				'url' => $track->url,
				'artwork' => $track->image[3],
				'date' => $track->date['uts'],
				'streamable' => $track->streamable,
			];
		}

		return $output;
	}

	function getLovedTracks($options='')
	{
		$options = (empty($options) ? '' : '&'.$options);
		$data = $this->retrieve('user.getLovedTracks&user='.$this->user.$options, 'lastfm_lovedtracks.xml');
		$tracks = $data->lovedtracks->track;

		foreach($tracks as $track)
		{
			$output[] = [
				'mbid' => $track->mbid,
				'artist' => $track->artist->name,
				'artist_url' => $track->artist->url,
				'artist_mbid' => $track->artist->mbid,
				'artwork' => $track->image[3],
				'name' => $track->name,
				'url' => $track->url,
				'date' => $track->date['uts'],
			];
		}

		return $output;
	}

	function getArtistTracks($artist, $options='')
	{
		$options = (empty($options) ? '' : '&'.$options);
		if(!empty($artist))
		{
			$fileArtist = str_replace(' ', '', strtolower($artist));
			$data = $this->retrieve('user.getArtistTracks&user='.$this->user.$options.'&artist='.$artist, 'lastfm_artisttracks_'.$fileArtist.'.xml');
			$artistTracks = $data->artisttracks->track;

			foreach($artistTracks as $track)
			{
				$output[] = [
					'artist' => $track->artist->name,
					'artist_mbid' => $track->artist->mbid,
					'artist_url' => 'http://www.last.fm/music/'.urlencode($track->artist),
					'name' => $track->name,
					'streamable' => $track->streamable,
					'mbid' => $track->mbid,
					'album_name' => $track->album,
					'album_mbid' => $track->album['mbid'],
					'url' => $track->url,
					'artwork' => $track->image[3],
					'date' => $track->date['uts'],
				];
			}
		}
		else
		{
			$output = null;
		}

		return $output;
	}

	function getTopArtists($options='')
	{
		$options = (empty($options) ? '' : '&'.$options);
		$data = $this->retrieve('user.getTopArtists&user='.$this->user.$options, 'lastfm_topartists.xml');
		$topArtists = $data->topartists->artist;

		foreach($topArtists as $artist)
		{
			$output[$artist['rank']] = [
				'name' => $artist->name,
				'playcount' => $artist->playcount,
				'mbid' => $artist->mbid,
				'url' => $artist->url,
				'streamable' => $artist->streamable,
				'artwork' => $track->image[3],
			];
		}

		return $output;
	}

	function getTopTracks($options='')
	{
		$options = (empty($options_) ? '' : '&'.$options);
		$data = $this->retrieve('user.getTopTracks&user='.$this->user.$options, 'lastfm_toptracks.xml');
		$topTracks = $data->toptracks->track;

		foreach($topTracks as $track)
		{
			$output[$track['rank']] = [
				'name' => $track->name,
				'playcount' => $track->playcount,
				'mbid' => $track->mbid,
				'url' => $track->url,
				'artist' => $track->artist->name,
				'artist_mbid' => $track->artist->mbid,
				'artist_url' => 'http://www.last.fm/music/'.urlencode($track->artist),
				'artwork' => $track->image[3],
			];
		}

		return $output;
	}

	function getTopAlbums($options='')
	{
		$options = (empty($options_) ? '' : '&'.$options);
		$data = $this->retrieve('user.getTopAlbums&user='.$this->user.$options, 'lastfm_topalbums.xml');
		$topAlbums = $data->topalbums->album;

		foreach($topAlbums as $album)
		{
			$output[$album['rank']] = [
				'name' => $album->name,
				'playcount' => $album->playcount,
				'mbid' => $album->mbid,
				'url' => $album->url,
				'artist' => $track->artist->name,
				'artist_mbid' => $track->artist->mbid,
				'artist_url' => 'http://www.last.fm/music/'.urlencode($track->artist),
				'artwork' => $track->image[3],
			];
		}

		return $output;
	}

	function getTopTags($options='')
	{
		$options = (empty($options_) ? '' : '&'.$options);
		$data = $this->retrieve('user.getTopTags&user='.$this->user.$options, 'lastfm_toptags.xml');
		$data = $this->fetchData('user.getTopTags&user='.$this->user);
		$topTags = $data->toptags->tag;

		foreach($topTags as $tag)
		{
			$output[] = [
				'name' => $tag->name,
				'count' => $tag->count,
				'url' => $tag->url,
			];
		}

		return $output;
	}

	function getLibraryArtists($options='')
	{
		$options = (empty($options_) ? '' : '&'.$options);
		$data = $this->retrieve('library.getArtists&user='.$this->user.$options, 'lastfm_libraryartists.xml');
		$getArtists = $data->artists->artist;

		foreach($getArtists as $artist)
		{
			$output[] = [
				'name' => $artist->name,
				'playcount' => $artist->playcount,
				'tagcount' => $artist->tagcount,
				'mbid' => $artist->mbid,
				'url' => $artist->url,
				'artwork' => $artist->image[3],
			];
		}

		return $output;
	}
}

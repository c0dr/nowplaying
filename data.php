<?php
include('lib.php');

$username = ''; // The last.lm Username

//The url to grab the data from
$scrobbler_url = "http://ws.audioscrobbler.com/2.0/user/" . $username . "/recenttracks";

//let's load the data first
if ($scrobbler_xml = file_get_contents($scrobbler_url)) {
   
    //Start parsing the data
    $scrobbler_data = simplexml_load_string($scrobbler_xml);
    //Select the latest track
    $track          = $scrobbler_data->{'track'}[0];
    
    //create array
    $data = array();
    
    if (isset($track['nowplaying'])) {
        $data["type"] = "nowplaying";
    } else {
        $data["type"] = "lastplayed";
    }
    
    
    //echo the artist and track name  
    $data["artist"] = $track->artist;
    $data["title"] = $track->name;  
    //$data["cover"] = $track->image[3];
        
    
    //Search for the track on spotify    
    $strack = Spotify::searchTrack($track->name . ' - ' . $track->artist);
    
    // Receive the Spotify URI for the first track
    // Please note, that this is not 100% accurate
    $uri = Spotify::getUri($strack);
    $data["spotify"] = $uri;
        
    //If last.fm has no cover, ask deezer    
	if(strpos($data["cover"], 'http://') === false) {
    	$deezer = file_get_contents("http://api.deezer.com/search?q=".urlencode($track->artist." - ".$track->album));
	  	$cover = json_decode($deezer);
		$data["cover"] = $cover->data[0]->album->cover;
	}

    echo json_encode($data);
    
 }

?>
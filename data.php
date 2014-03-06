<?php
include('lib.php');

$username = 'DerNomis'; // The last.lm Username

//The url to grab the data from
$url = "http://ws.audioscrobbler.com/2.0/user/" . $username . "/recenttracks?limit=1";


// Load the data with Curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch);

$scrobble_data = simplexml_load_string($result);



//Select the latest track
$track = $scrobble_data->track[0];

//create array
$data = array();

if (isset($track['nowplaying'])) {
    $data['type'] = 'nowplaying';
} else {
    $data['type'] = 'lastplayed';
}


//Add artist and title to array  
$data['artist'] = (string) $track->artist;
$data['title']  = (string) $track->name;



//Hardcoded cover position to reduce overhead. In case of API changes, this might need to be changed to use XPath.
$data['cover'] = (string) $track->image[3];


header('Content-Type: application/json');
echo json_encode($data);
?>
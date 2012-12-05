<?php
require_once 'Net/MPD.php';
$playback = Net_MPD::factory('Playback', 'localhost', 1234);

$song = $playback->getCurrentSong();
// foreach ($song as $i => $value)
// {
// 	echo $i." ";
// 	echo $value."<br />";
// }

if(isset($song['Title']) && isset($song['Artist']))
{
	echo $song['Artist']." - ".$song['Title'];
}
else
	echo $song['file'];

// $MPD_DB = Net_MPD::factory('Database');
// $dump = $MPD_DB->find(array('Filename' => $song['file']));

?>

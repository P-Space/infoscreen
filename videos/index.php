<?php

$host     = $_SERVER['HTTP_HOST'];
 
$currentUrl = 'http://';

if ($_SERVER["SERVER_PORT"] != "80")
{
	$currentUrl .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
}
else
{
	$currentUrl .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}

$files = glob( './*.m4v' );
$exclude_files = array('.', '..');
if (!in_array($files, $exclude_files)) {
// Sort files by modified time, latest to earliest
// Use SORT_ASC in place of SORT_DESC for earliest to latest
array_multisort(
array_map( 'filemtime', $files ),
SORT_NUMERIC,
SORT_DESC,
$files
);
}

$files_resp=array();
shuffle($files);
foreach($files as $file)
{
	$files_resp[] = array("title" => str_replace(".m4v", "", $file), "m4v" => $currentUrl."/".$file);
}

echo json_encode($files_resp);

?>

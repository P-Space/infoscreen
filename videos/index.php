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

//path to directory to scan
$directory = "";
 
//get all image files with a .m4v extension.
$dir = opendir(getcwd());
$files = array();
while($filename = readdir($dir))
{
	//echo $filename;
	//echo strrpos($filename, ".m4v");
	//echo strlen($filename);
	if(strrpos($filename, ".m4v") == strlen($filename) - 4)
		$files[] = array("title" => str_replace(".m4v", "", $filename), "m4v" => $currentUrl."/".$filename);
}
closedir($dir);
echo json_encode($files);
?>

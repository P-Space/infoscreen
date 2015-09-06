<!--Upload videos to Infoscreen using this page-->
<html>
<head>
	<title>P-Space Infoscreen Video Uploader </title>
	<meta http-equiv="Content-Type" content="text/html; charset= UTF-8">
</head>

<body>
	<p style="text-align:center">P-Space Infoscreen</p>
	<p style="text-align:center">Video Upload</p>
	<br>
	<form name="video" action="http://192.168.1.5/infoscreen/upload.php" method="post">
		<p style="text-align:center">
			YouTube Video Link: <input type="text" name="link" value="">
		</p>
		<p style="text-align:center"><input type="submit" value="Submit"></p>
	</form>
	<?php
		$vidlink=$_REQUEST["link"];
		$cmd='youtube-dl -f "mp4/[height<720]" '.escapeshellarg($vidlink).' -o "/home/space/Projects/infoscreen/videos/%(id)s.m4v"';
		echo "<br>";
		if ($vidlink!=null)
		{
			$res=shell_exec($cmd);
			echo "<pre style=\"text-align:center\">".$res."</pre>";
		}
	?>
</body>
</html>

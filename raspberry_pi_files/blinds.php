<?php

/*
General Info:
In a clean Raspbian setup, you'll need to install apache, and php:
sudo apt-get install -y apache2 php5

You'll also need to either copy this file in /var/www/, or create a symlink to it
In the second case:
sudo ln -s /var/www/blinds.php /path/to/blinds/file/blinds.php

Lastly, in order for apache to access the tvservice and control the HDMI port, you'll
need to give it permissions. I am too lazy to find the proper way to do it, and our RasPis
don't store any sensitive info anyway, so I just set up Apache to run as the local user (pi)

See: http://ubuntuforums.org/showthread.php?t=927142

After changing the config, I also had to change the owner of /var/lock/apache2,
sudo chown -R pi /var/lock/apache2

That's all, folks. Consider this file under WTFPL & BeerWare license (cause I do like beers).

Tzikis, 2014

*/

echo "Aloha <br/>\n";

if(isset($_GET["lights"]))
{
	echo "Thy will be done<br />\n";
	if($_GET["lights"] == "on")
	{
		echo "Turning Lights On<br />\n";
		shell_exec("/usr/bin/vcgencmd display_power 1");
	}
	else if($_GET["lights"] == "off")
	{
		echo "Turning Lights Off <br/>\n";
		shell_exec("/usr/bin/vcgencmd display_power 0");
	}
}

echo "Aloha <br/>\n";

?>

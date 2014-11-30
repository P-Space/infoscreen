#!/bin/bash

function cleanup()
{
  rm videos videos.json
  return $?
}

function control_c()
# run if user hits control-c
{
  echo -en "\n*** Ouch! Exiting ***\n"
  cleanup
  exit $?
}

# trap keyboard interrupt (control-c)
trap control_c SIGINT

while :
do
	cleanup
	if pgrep "epiphany" ; then
        	echo browser runing
	else
		echo "`date "+%d/%m/%Y %T"` : Starting work" >> infovideos.log 2>&1
		#midori -e Fullscreen -a http://192.168.1.5/tools/infoscreen/index2.html >> infovideos.log 2>&1&
		epiphany --private-instance http://192.168.1.5/tools/infoscreen/index.html >> infovideos.log 2>&1&
		#for epiphany-browser
		#
		sleep 20 # give it time to start
		echo "going fullscreen" >> infovideos.log 2>&1&
		echo key F11 | xte >> infovideos.log 2>&1&
	fi
	curl http://192.168.1.5/tools/infoscreen/videos/ | python -mjson.tool | grep m4v |\
		sed 's/ /%20/g' | awk -v k="http" '{n=split($0,a,"\""); print a[4]}' > videos.json
	while IFS= read -r LINE; do 
	  echo "omxplayer $LINE >> /home/pi/omxp.log " >> videos
	done < videos.json
	echo "starting videos" >> /home/pi/omxp.log 
	bash videos
	echo "finished playing videos" >> /home/pi/omxp.log
done

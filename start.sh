#!/bin/bash
DIR="$(cd -P "$( dirname "${BASH_SOURCE[0]}" )" && pwd)"
cd "$DIR"

while getopts "p:f:l" OPTION 2> /dev/null; do
	case ${OPTION} in
		p)
			PHP_BINARY="$OPTARG"
			;;
		f)
			MCPP_FILE="$OPTARG"
			;;
		l)
			DO_LOOP="yes"
			;;
		\?)
			break
			;;
	esac
done

if [ "$PHP_BINARY" == "" ]; then
	if [ -f ./bin/php7/bin/php ]; then
		export PHPRC=""
		PHP_BINARY="./bin/php7/bin/php"
	elif [[ ! -z $(type php) ]]; then
		PHP_BINARY=$(type -p php)
	else
		echo "Couldn't find a working PHP 7 binary, please use the installer."
		exit 1
	fi
fi

if [ "$MCPP_FILE" == "" ]; then
	if [ -f ./mcpp.phar ]; then
		MCPP_FILE="./mcpp.phar"
	elif [ -f ./src/mcpp/Main.php ]; then
		MCPP_FILE="./src/mcpp/Main.php"
    else
		echo "mcpp.phar not found"
		echo "Downloads can be found at https://github.com/ShadowicTeam/mcpp/releases"
		exit 1
	fi
fi 

LOOPS=0

set +e

if [ "$DO_LOOP" == "yes" ]; then
	while true; do
		if [ ${LOOPS} -gt 0 ]; then
			echo "Restarted $LOOPS times"
		fi
		"$PHP_BINARY" "$MCPP_FILE" $@
		echo "To escape the loop, press CTRL+C now. Otherwise, wait 5 seconds for the server to restart."
		echo ""
		sleep 5
		((LOOPS++))
	done
else
	exec "$PHP_BINARY" "$MCPP_FILE" $@
fi

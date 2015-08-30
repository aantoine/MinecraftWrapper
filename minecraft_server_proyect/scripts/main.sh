#!/bin/bash

# version 0.4.0 2015-04-20 (YYYY-MM-DD)
#
### BEGIN INIT INFO
# Required-Start: $local_fs $remote_fs screen-cleanup
# Required-Stop:  $local_fs $remote_fs
# Should-Start:   $network
# Should-Stop:    $network
# Default-Start:  2 3 4 5
# Default-Stop:   0 1 6
# Short-Description:    Minecraft server
# Description:    Starts the minecraft server
### END INIT INFO

#Settings
SERVICENAME='minecraft_'
#JAR='minecraft_server.1.8.4.jar'
SERVICEPATH='../../jars/'
OPTIONS='nogui'
#SCREENNAME='minecraft_server1'
#MCPATH='/home/agustinantoine/minecraft-servers/servers/server1'
#LOGPATH='/home/agustinantoine/minecraft-servers/servers/server1/logs'
#BACKUPPATH='/home/agustinantoine/minecraft-servers/backups/server1'
#MAXHEAP=2048
#MINHEAP=1024
INVOCATION="java -Xmx${MAXHEAP}M -Xms${MINHEAP}M \
-jar $SERVICEPATH$JAR $OPTIONS" 
SERVERS='/servers/'

ME=`whoami`
as_user() {
  if [ "$ME" = "$USERNAME" ] ; then
    bash -c "$1"
  else
    bash -c "$1"
  fi
}
 
mc_start() {
  if  pgrep -f $SERVICENAME$2 > /dev/null
  then
    echo "warning"
  else
    local PLACE=$1$SERVERS$2
    local SERVICE=$SERVICENAME$2
    local MAXHEAP=$5
    local MINHEAP=$4
    local JAR=$3

    local INVOCATION="java -Xmx${MAXHEAP}M -Xms${MINHEAP}M -jar $SERVICEPATH$JAR $OPTIONS"
    #echo "cd $PLACE && screen -dmS ${SERVICE} $INVOCATION"
    as_user "cd $PLACE && screen -dmS ${SERVICE} $INVOCATION"
    sleep 7
    if pgrep -f $SERVICENAME$2 > /dev/null
    then
      echo "success"
    else
      echo "error"
    fi
  fi
}

mc_stop() {
  local SERVICE=$SERVICENAME$1

  if pgrep -f $SERVICE > /dev/null
  then
    as_user "screen -S ${SERVICE} -X eval 'stuff \"save-all\"\015'"
    if [ "$2" == "1" ] ; then
      as_user "screen -S ${SERVICE} -X eval 'stuff \"say FAST SHUTTDOWN. Saving map...\"\015'"
    else
      as_user "screen -S ${SERVICE} -X eval 'stuff \"say SERVER SHUTTING DOWN IN 10 SECONDS. Saving map...\"\015'"
      sleep 10
    fi
    #as_user "screen -S ${SCREENNAME} -X quit"
    as_user "screen -S ${SERVICE} -X eval 'stuff \"stop\"\015'"
    sleep 5

    if pgrep -f $SERVICE > /dev/null
    then
      echo "error"
    else
      echo "success"
      fi

  else
    echo "warning"
  fi
} 

mc_command() {
  local SERVICE=$SERVICENAME$1
  if pgrep -f $SERVICE > /dev/null
  then
    command="$2";
    as_user "screen -S ${SERVICE} -X eval 'stuff \"$command\"\015'"
    echo "success"
  else
    echo "error"
  fi
}

mc_log() {
  as_user "cd $LOGPATH && cat latest.log"
}

#Start-Stop here
case "$1" in
  start)
    #echo "Start!"
    mc_start $2 $3 $4 $5 $6
    ;;
  stop)
    mc_stop $2 $3
    ;;
  restart)
    mc_stop $3
    mc_start $2 $3 $4 $5 $6
    ;;
  status)
    #echo $SERVICENAME$3
    if pgrep -f $SERVICENAME$2 > /dev/null
    then
      echo "$2 online"
    else
      echo "$2 offline"
    fi
    ;;
  command)
    if [ $# -gt 1 ]; then
      shift
      SERVER="$1"
      shift
      mc_command $SERVER "$*"
    else
      echo "Must specify server command (try 'help'?)"
    fi
    ;;

  *)
  echo "Usage: $0 {start|stop|backup|status|data|restart|command \"server command\"}"
  exit 1
  ;;
esac

exit 0

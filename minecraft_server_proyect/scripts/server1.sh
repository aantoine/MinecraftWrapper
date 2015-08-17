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
SERVICE='minecraft_server1'
JAR='minecraft_server.1.8.4.jar'
SERVICEPATH='../../jars/minecraft_server.1.8.4.jar'
OPTIONS='nogui'
WORLD='world'
SCREENNAME='minecraft_server1'
MCPATH='/home/agustinantoine/minecraft-servers/servers/server1'
LOGPATH='/home/agustinantoine/minecraft-servers/servers/server1/logs'
BACKUPPATH='/home/agustinantoine/minecraft-servers/backups/server1'
MAXHEAP=2048
MINHEAP=1024
INVOCATION="java -Xmx${MAXHEAP}M -Xms${MINHEAP}M \
-jar $SERVICEPATH $OPTIONS" 

ME=`whoami`
as_user() {
  if [ "$ME" = "$USERNAME" ] ; then
    bash -c "$1"
  else
    bash -c "$1"
  fi
}
 
mc_start() {
  if  pgrep -f $SERVICE > /dev/null
  then
    echo "warning"
  else
    cd $MCPATH
    as_user "cd $MCPATH && screen -dmS ${SCREENNAME} $INVOCATION"
    sleep 7
    if pgrep -f $SERVICE > /dev/null
    then
      echo "success"
    else
      echo "error"
    fi
  fi
}
 
mc_saveoff() {
  if pgrep -f $SERVICE > /dev/null
  then
    echo "$SERVICE is running... suspending saves"
    as_user "$SCREEN -S ${SCREENNAME} -X eval 'stuff \"say SERVER BACKUP STARTING. Server going readonly...\"\015'"
    as_user "$SCREEN -S ${SCREENNAME} -X eval 'stuff \"save-off\"\015'"
    as_user "$SCREEN -S ${SCREENNAME} -X eval 'stuff \"save-all\"\015'"
    sync
    sleep 10
  else
    echo "$SERVICE is not running. Not suspending saves."
  fi
}

mc_saveon() {
  if pgrep -f $SERVICE > /dev/null
  then
    echo "$SERVICE is running... re-enabling saves"
    as_user "$SCREEN -S ${SCREENNAME} -X eval 'stuff \"save-on\"\015'"
    as_user "$SCREEN -S ${SCREENNAME}$ -X eval 'stuff \"say SERVER BACKUP ENDED. Server going read-write...\"\015'"
  else
    echo "$SERVICE is not running. Not resuming saves."
  fi
}

mc_stop() {
  if pgrep -f $SERVICE > /dev/null
  then
    as_user "screen -S ${SCREENNAME} -X eval 'stuff \"say SERVER SHUTTING DOWN IN 10 SECONDS. Saving map...\"\015'"
    as_user "screen -S ${SCREENNAME} -X eval 'stuff \"save-all\"\015'"
    sleep 10
    #as_user "screen -S ${SCREENNAME} -X quit"
    as_user "screen -S ${SCREENNAME} -X eval 'stuff \"stop\"\015'"
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

mc_backup() {
   mc_saveoff
   
   NOW=`date "+%Y-%m-%d_%Hh%M"`
   BACKUP_FILE="$BACKUPPATH/${WORLD}_${NOW}.tar"
   echo "Backing up minecraft world..."
   #as_user "cd $MCPATH && cp -r $WORLD $BACKUPPATH/${WORLD}_`date "+%Y.%m.%d_%H.%M"`"
   as_user "tar -C \"$MCPATH\" -cf \"$BACKUP_FILE\" $WORLD"

   echo "Backing up $SERVICE"
   as_user "tar -C \"$MCPATH\" -rf \"$BACKUP_FILE\" $SERVICE"
   #as_user "cp \"$MCPATH/$SERVICE\" \"$BACKUPPATH/minecraft_server_${NOW}.jar\""

   mc_saveon

   echo "Compressing backup..."
   as_user "gzip -f \"$BACKUP_FILE\""
   echo "Done."
}

mc_command() {
  command="$1";
  if pgrep -f $SERVICE > /dev/null
  then
    pre_log_len=`wc -l "$MCPATH/logs/latest.log" | awk '{print $1}'`
    echo "$SERVICE is running... executing command"
    as_user "screen -S ${SCREENNAME} -X eval 'stuff \"$command\"\015'"
    sleep .1 # assumes that the command will run and print to the log file in less than .1 seconds
    # print output
    # tail -n $[`wc -l "$MCPATH/logs/latest.log" | awk '{print $1}'`-$pre_log_len] "$MCPATH/logs/latest.log"
  fi
}

mc_log() {
  as_user "cd $LOGPATH && cat latest.log"
}

#Start-Stop here
case "$1" in
  start)
    #echo "Start!"
    mc_start
    ;;
  stop)
    mc_stop
    ;;
  restart)
    mc_stop
    mc_start
    ;;
  backup)
    #mc_backup
    ;;
  data)
    echo "$JAR $MINHEAP $MAXHEAP"
    ;;
  log)
    mc_log
    ;;
  status)
    if pgrep -f $SERVICE > /dev/null
    then
      echo "$SERVICE online"
    else
      echo "$SERVICE offline"
    fi
    ;;
  command)
    if [ $# -gt 1 ]; then
      shift
      mc_command "$*"
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

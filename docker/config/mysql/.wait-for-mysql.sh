#!/bin/sh

CONTAINER="delio-app-mysql"
USERNAME="delio_usr"
PASSWORD="delio_pw"
while ! docker exec $CONTAINER mysql --user=$USERNAME --password=$PASSWORD -e "SELECT 1" >/dev/null 2>&1; do
    sleep 1
done

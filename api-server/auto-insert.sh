#!/bin/bash
while [ true ]; do
  if [ $(expr $(date +%s) % 60) -eq 0 ]; then
    /api-server/insert.php
  fi;
  sleep 1;
done
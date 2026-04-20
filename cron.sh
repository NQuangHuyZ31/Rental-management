#!/bin/sh

while true
do
  echo "Run queue worker: $(date)"
  php queue-worker.php
done
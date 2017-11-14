#!/bin/bash
BASEDIR=$(dirname "$0")
cd $BASEDIR

rsync --delete-after -ravze 'ssh -p4365 -o StrictHostKeyChecking=no' * toolbox@store3-01.oi.tb.007ac9.net:/home/www/store0.oi.sistrix.de/htdocs/
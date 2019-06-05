#!/usr/bin/env bash

find var/ -type d -exec chmod 0777 {} + && find var -type f -print0 | xargs -0 chmod og+rwx

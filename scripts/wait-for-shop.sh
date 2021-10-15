#!/bin/bash

# entrypoint of shop now puts 'ready' in a file after installation of
# wordpress, woocommerce and plugin
# docker exec woocommerce touch /tmp/shop.log
# docker exec woocommerce cat /tmp/shop.log
# docker exec woocommerce cat /tmp/debug.log
# timeout 15m docker exec woocommerce tail -f /tmp/shop.log | sed '/^ready/ q'

function read_log() {
  docker exec woocommerce cat /tmp/shop.log
  #docker exec -it woocommerce "tail -f /path/to/file.log | sed '/^ready/ q'"
}

LOG_CONTENT=$(read_log)
echo "Waiting for Shop Setup to finish"
while [[ -z $(read_log | grep ready) ]]; do
  sleep 1;
done

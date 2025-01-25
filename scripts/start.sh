   #!/bin/bash

   # Start PHP-FPM
   php-fpm &

   # Start Nginx
   nginx -g "daemon off;"
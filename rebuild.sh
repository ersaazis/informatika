# REQ
# sudo apt update
# sudo apt install -y php-curl php-imagick php-mbstring php-gd poppler-utils
# sudo sed -i 's/<policy domain="coder" rights="none" pattern="PDF" \/>/<policy domain="coder" rights="read|write" pattern="PDF" \/>/g' /etc/ImageMagick-6/policy.xml
#!/bin/bash
curl https://getcomposer.org/installer > composer-setup.php
#export HOME=/home/username && ea-php72 -c php.ini composer-setup.php
ea-php72 -c php.ini composer-setup.php
ea-php72 -r "unlink('composer-setup.php');"
ea-php72 -c php.ini composer.phar install
ea-php72 -r "unlink('composer.phar');"
mv app/Http/Controllers app/Http/Controllersx
ea-php72 artisan crud:rebuild
mv app/Http/Controllersx app/Http/Controllers
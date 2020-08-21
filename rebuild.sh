#!/bin/bash
# REQ
sudo apt update
sudo apt install -y git zip ocrmypdf php php-mysql php-curl php-imagick php-mbstring php-gd php-xml poppler-utils
sudo sed -i 's/<policy domain="coder" rights="none" pattern="PDF" \/>/<policy domain="coder" rights="read|write" pattern="PDF" \/>/g' /etc/ImageMagick-6/policy.xml
curl https://getcomposer.org/installer > composer-setup.php
#export HOME=/home/username && php -c php.ini composer-setup.php
mv app/Http/Controllers app/Http/Controllersx
php -c php.ini composer-setup.php
php -r "unlink('composer-setup.php');"
php -c php.ini composer.phar install
php artisan migrate
php -c php.ini composer.phar update
php artisan crud:seed
mv app/Http/Controllersx app/Http/Controllers
php -r "unlink('composer.phar');"
php artisan package:discover --ansi
php artisan queue:work database --queue=dataDosen,dataDokumen

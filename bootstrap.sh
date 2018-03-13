#!/usr/bin/env bash

## set not interactive, or mysql server install will be skipped since we're not entering a password for root
export DEBIAN_FRONTEND=noninteractive

## setup blackfire repo
#wget -O - https://packagecloud.io/gpg.key | apt-key add -
#echo "deb http://packages.blackfire.io/debian any main" | sudo tee /etc/apt/sources.list.d/blackfire.list

apt-get update

### install software
## install all packages using mysql as the db
apt-get install -yf apache2 php5-dev libapache2-mod-php5 mysql-server-5.5 git php5-mysql php5-cli php5-gd php5-curl curl
## install blackfire
#apt-get install -yf blackfire-agent blackfire-php

## setup blackfire
## need to figure out how to create the config
## /etc/init.d/blackfire-agent restart

## install composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
mkdir /home/vagrant/.composer
chown -R vagrant:vagrant /home/vagrant/.composer

## install phpunit 4.8
if [ ! -f /usr/local/bin/phpunit ]; then
  wget --quiet https://phar.phpunit.de/phpunit-old.phar
  mv phpunit-old.phar phpunit.phar
  chmod +x phpunit.phar
  mv phpunit.phar /usr/local/bin/phpunit
fi

## setup DB
mysql -u root -e "CREATE DATABASE IF NOT EXISTS cms DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;"
mysql -u root -e "GRANT ALL PRIVILEGES ON cms.* TO 'cms'@'localhost' IDENTIFIED BY 'cms';"
service mysql restart
sleep 5

## install db tables & type data
cd /vagrant/
php app/console doctrine:schema:create --no-interaction
## install assets
sudo -u www-data php app/console --env=dev assets:install --no-interaction
sudo -u www-data php app/console --env=dev assetic:dump --no-interaction


## setup apache
#if [ ! -f /etc/apache2/sites-available/apache22.conf ]; then
#  rm -rf /var/www
#  ln -fs /vagrant/web /var/www
#  cp /vagrant/apache22.conf /etc/apache2/sites-available/apache22.conf
#  a2enmod headers
#  a2enmod rewrite
#  a2dissite 000-default
#  a2ensite apache22.conf

#fi

## setup apache
if [ ! -f /etc/apache2/sites-available/apache24.conf ]; then

rm -rf /var/www
ln -fs /vagrant/web /var/www
cp /vagrant/apache24.conf /etc/apache2/sites-available/apache24.conf
a2enmod headers
a2enmod rewrite
a2dissite 000-default.conf
a2ensite apache24.conf

fi

service apache2 restart

if [ ! -f /var/swap.1 ]; then
  # update swap settings to allow composer to run better on the vm
  /bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=2048
fi
  /sbin/mkswap /var/swap.1
  /sbin/swapon /var/swap.1
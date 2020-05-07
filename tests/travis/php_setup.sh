#!/bin/sh

set -e


echo "**************************"
echo "Setting up PHP Extensions."
echo "**************************"
echo ""
echo "PHP Version: $TRAVIS_PHP_VERSION"
echo ""
echo "Update Pecl"
pecl channel-update pecl.php.net

echo ""
echo "******************************"
echo "Installing memcached extension"
echo "******************************"
set +e
echo "Installing libmemcached-dev"
sudo apt-get -y install libmemcached-dev
git clone https://github.com/php-memcached-dev/php-memcached.git
cd php-memcached
git checkout php7
phpize
./configure --disable-memcached-sasl
make
sudo make install
cd ..
rm -Rf php-memcached
set -e
echo "Finished installing memcached extension."


echo ""
echo "******************************"
echo "Installing phpredis extension."
echo "******************************"
echo ""
echo ""
echo "Downloading..."
git clone git://github.com/phpredis/phpredis.git
echo "Configuring..."
cd phpredis
phpize
./configure
echo "Installing..."
make
make install
cd ..
rm -Rf phpredis
echo "Finished installing phpredis extension."


echo ""
echo "******************************"
echo "Installing uopz extension."
echo "******************************"
set +e
pecl install uopz
set -e
echo "Finished installing uopz extension."


if [ -f "tests/travis/php_extensions.ini" ]
then
  echo ""
  echo "*********************"
  echo "Updating php.ini file"
  echo "*********************"
  echo ""
  echo ""
  phpenv config-add "tests/travis/php_extensions.ini"
fi

PHP_EXTENSION_DIR=$(php -r "print(PHP_EXTENSION_DIR);")
cd /tmp
git clone --depth 1 --branch 3.1.5 https://github.com/xdebug/xdebug.git
cd xdebug
phpize
./configure
make
cp modules/xdebug.so $PHP_EXTENSION_DIR

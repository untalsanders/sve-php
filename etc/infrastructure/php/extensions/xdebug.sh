cd /tmp
git clone --depth 1 --branch 3.1.5 https://github.com/xdebug/xdebug.git
cd xdebug
phpize
./configure
make
cp modules/xdebug.so /usr/local/Cellar/php/8.1.10_1/lib/php/20210902

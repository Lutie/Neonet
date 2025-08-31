# Restart project (dev)

> Install php 7.4, since this project is not php 8 ready
> Below php stands for any php call you have installed on your PC
> On windows you can DL php in a folder and call it like so F:\PHP\php-7.4.33\php.exe (just an example)
> Be aware that you need to configure php.ini a bit

php bin\console cache:clear
php bin\console doctrine:database:create
php bin\console doctrine:migrations:migrate
php -S 127.0.0.1:8000 -t public <= this will be needed if you have to use a different php version than your local one

# Notes

php bin\console doctrine:migrations:execute --up 20250830225823 <= this one needs to be applied next

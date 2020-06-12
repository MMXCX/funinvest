#VirtualBox настраиваем сеть как сетевой мост

#install ubuntu 20.04
#user: MMXCX
#pass: 985******

#установить root password
sudo passwd
#user: root
#pass: Roo********

#установить gcc
sudo apt install build-essential
gcc --version

#VirtualBox подключить образ дополнений
reboot

#Установка Apache2
apt install apache2

#Узнать ip адресс
ip address show

#VirtualBox добавляем папку и называем ее host1.loc
#В файле
nano /etc/fstab
#добавить строку
host1.loc    /var/www/host1.loc  vboxsf  defaults    0   0

#В файле
nano /etc/modules
#добавить строку
vboxsf

#Ставим MySQL
apt install mysql-server

#Ставим php
apt install php libapache2-mod-php php-cli php-fpm php-json php-pdo php-mysql php-zip php-gd php-mbstring php-curl php-xml php-pear php-bcmath php-imagick php-intl php-gmagick

#Включаем мод Rewrite
sudo a2enmod rewrite

#Редактируем файл
nano /etc/apache2/apache2.conf
#И в блоке
#<Directory /var/www/>
#Options Indexes FollowSymLinks
#AllowOverride None
#Require all granted
#</Directory>
#пишем AllowOwerride All

#создаем файлы /etc/apache2/sites-available/host1.loc.conf с текстом
#и ссылки на них в /etc/apache2/sites-enabled/host1.loc.conf коммандой ln -s 'original' 'link file'
<VirtualHost *:80>
        ServerName host1.loc

        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/host1.loc

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>


service apache2 restart

#Запускаем для настройки MySQL
mysql_secure_installation
#И ставим пароль для root
mysql> SELECT user,authentication_string,plugin,host FROM mysql.user;
mysql> ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'Roo********';
mysql> FLUSH PRIVILEGES;

#создаем нового пользователя для уваленки
mysql> CREATE USER 'remote'@'localhost' IDENTIFIED BY 'password';
mysql> CREATE USER 'remote'@'%' IDENTIFIED BY 'password';

#даем доступ к БД remote
mysql> GRANT ALL PRIVILEGES ON remote.* TO 'remote'@'localhost';
mysql> GRANT ALL PRIVILEGES ON remote.* TO 'remote'@'%';

#прописать в /etc/mysql/my.cnf для разрешения
#удоленного доступа для всех адресов
[mysqld]
bind-address = 0.0.0.0






#
#########
####



git remote add origin https://github.com/MMXCX/pattern.git
git add . && git commit -m "first commit" && git push -u origin master












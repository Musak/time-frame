# Instalation guide

After the first checkout update dependencies with composer

```bash
php composer.phar update
```

Create a mysql database named `time_frame`

Configure permissions

```bash
sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs
sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs
sudo setfacl -m u:www-data:rwx -m u:`whoami`:rwx app/config/parameters.yml
```

Set apache virtual host

```
<VirtualHost *:80>
  ServerName time_frame
  DocumentRoot /path/to/time-frame/web
  <Directory /path/to/time-frame/web>
    AllowOverride All
    Options Indexes FollowSymLinks 
  </Directory>
  ErrorLog ${APACHE_LOG_DIR}/time-frame.error.log

  LogLevel warn
  CustomLog ${APACHE_LOG_DIR}/time-frame.access.log combined
</VirtualHost>
```

Install less from the project root directory

```bash
sudo apt-get install nodejs npm
npm install less
```

After running those commands, if no file `/usr/bin/nodejs` exists, then create a symlink to `/usr/bin/node`

```bash
sudo ln -s /usr/bin/node /usr/bin/nodejs
```


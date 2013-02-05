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


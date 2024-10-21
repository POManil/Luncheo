# Luncheo Backend

This is the API for the Luncheo's plateform.

## Getting started [FOR LINUX USERS]
### Install system requirements
* php 8.2
* [Symfony CLI](https://symfony.com/download)
* [Composer](https://getcomposer.org/download/)
* [Docker engine](https://docs.docker.com/engine/install/ubuntu/)

### Install dependencies
```bash
composer install
```

### Create the .env.local file
```bash
cp .env .env.local
```

### Install php posgtresql driver
**Install the driver**
```bash
sudo apt install php-pgsql
```

**Enable the driver into php.ini file**
Locate the php.ini file
```bash
php --ini | grep "Configuration File (php.ini) Path"
```

Find the line ";extension=pgsql" and remove the ";" character
```bash
sudo nano <path_to_your_php_ini_file>
```

### Deploy the dockers
```bash
docker compose up -d
```

### Start the developpement server
```bash
symfony server:start
```

## Test the API
You can test if the application run well by calling the following route:
```
http://localhost:8000/hello-world
```

If you receive the following answer:
```json
{
    "message": "Hello, world!"
}
```

Mazel tov, your API is running well

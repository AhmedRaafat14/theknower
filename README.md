# PHPFunctions

How many times you have searching for same function over & over & over again!
the purpose from this project is to help you
find this functions in one place organized and well
written waiting for you to copy it or learn it.
Not just that the project will grow to even
give you snippets or functions that based
or relates to common PHP frameworks.

**Requirements:**

* Docker

**Used Stack:**

* PHP >= 7.3
* Symfony 4

**Run:**

1. Copy the `.env.dist` to `.env` file and update the details:

2. move to the project folder and run:
```cmd
$ docker-compose up -d --build
```

3. Run the composer install/update command to install required dependencies:
```cmd
$ docker-compose exec php composer install
```

4. When it is done make sure to update your hosts file:
```cmd
$ sudo vim /etc/hosts
```
then add this line to the file `127.0.0.1   phpfunctions.local`

5. Run the following command as a step to improve you app load performance:
```cmd
$ docker-compose exec php composer dump-autoload --no-dev --classmap-authoritative
```

6. Run the DB migration:
```cmd
$ docker-compose exec php bin/console doctrine:migrations:migrate
```
After it is done you can find the project at http://phpfunctions.local

**Useful Commands:**

* Clearing the cache:
```cmd
$ docker-compose exec php bin/console cache:clear -e prod
$ docker-compose exec php chmod 777 -R var/cache
```

* Install package or install composer packages:
```cmd
$ docker-compose exec php composer require symfony/maker-bundle --dev
$ docker-compose exec php composer install
```

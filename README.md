# TheKnower

> #### From the community to the community.

How many times you have searching for same function over & over & over again!
or even a class or you wrote some function or class 
that you think it can be helpful for some other developers
like you!

That is who I created this project a place you can find
popular PHP functions/classes or whatever related that is
shared by the PHP community to help other PHP developers.

You will not only find people sharing native PHP code
experience & Knowledge but also frameworks related stuff
will be there. It is all in your hands you decide what to
put there, what code you want to tell other developers
how awesome you are in building it and everyone else can use it.

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
then add this line to the file `127.0.0.1   theknower.local`

5. Run the following command as a step to improve you app load performance:
```cmd
$ docker-compose exec php composer dump-autoload --no-dev --classmap-authoritative
```
After it is done you can find the project at http://theknower.local


**Useful Commands:**

* Run the DB migration:

```cmd
$ docker-compose exec php bin/console doctrine:migrations:migrate
```

* Whenever you want to use any frontend library look
for it on https://yarnpkg.com/, then install it using
this command:
```cmd
$ docker-compose exec php yarn add highlight.js --dev
```
After you done that you have to import it in [app.css](app/assets/css/app.css) or [app.js](app/assets/js/app.js)
in the same way as the other imported there.

**Please, check [webpack encore docs](https://symfony.com/doc/current/frontend.html)
to learn more about how to work with the frontend side.**

> This is also useful tutorials: [Webpack Encore: Frontend like a Pro!](https://symfonycasts.com/screencast/webpack-encore), make sure to give it a try if you are new.

* Whenever you do a change to the frontend (css, js) you need to run the yarn build command, 
I recommend you always keep the following command running in the background to watch your files:
```cmd
$ docker-compose exec php yarn watch
```

* To remove frontend package:
```cmd
$ docker-compose exec php yarn remove highlight.js --dev
```

* To remove composer package:
```cmd
$ docker-compose exec php composer remove xxxxx/yyyyyyy
```

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

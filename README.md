# TheKnower

#### Disclaimer:
Don't expect too much advanced things here. This project and this repository
are made mainly for starters or for anyone who wants to see a good example of Symfony,
Docker and Webpack Encore working together in one project. So don't
expect too much or too little if you are a starter or interested in this code.

**What you can expect:**
* You can find [screenshots here](images) if you want to see samples before running it locally.

________________________

> #### From the community to the community.
> The Knower: is someone who has the knowledge of everything about everything in a specific domain.

How many times have you been searching for something over & over & over again?!
Or have you got to know something cool you think it can be helpful for other people?!

That is why I created this platform a place you can find
a lot of shared things or whatever related that is
shared by the other people to help you.

That is why I call it it is from community to community.

**Requirements:**

* Docker

**Application Stack:**

* PHP >= 7.3
* Symfony 4.4.*
* Webpack Encore 1.7.*
* Bootstrap 4

**Run it locally:**

1. Clone this repo, then move to the cloned folder.

2. Copy the `.env.dist` to `.env` file and update the values.

3. Then run to bring the containers up, make sure docker is running first:
```cmd
$ docker-compose up -d --build
```

4. This step it will be performed using [docker](docker-containers/php-fpm/Dockerfile#L37) so you can ignore it or do 
it as caution step just to be sure, run the composer install/update command to install required dependencies:
```cmd
$ docker-compose exec php composer install
```

5. This step same as the 4th one, but still you can do it manually:
```cmd
$ docker-compose exec php yarn install
```

6. When it is done make sure to update your hosts file:
```cmd
$ sudo vim /etc/hosts
```
then add this line to the file `127.0.0.1   theknower.local`

7. Run the following command as a step to improve your app load performance:
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

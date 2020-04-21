FROM nginx:latest

RUN apt-get update -y \
    && apt-get upgrade -y \
    && apt-get install -y vim

WORKDIR /var/www/theknower

CMD ["nginx"]

EXPOSE 80 443
FROM php:7.4-cli
COPY . /usr/src/myapp
WORKDIR /usr/src/myapp

#RUN  --mount=type=cache,id=composer,target=/root/.composer composer update -v --no-dev && rm -rf .git
RUN  -composer composer update -v --no-dev && rm -rf .git

CMD [ "php", "./public/index.php" ]

# Realforce coding test
Coding test for Realforce.

## Build
```bash
docker run --rm -v $PWD:/src -w /src php:7.3 bash -c "apt-get update && apt-get install -y unzip && curl https://getcomposer.org/download/1.9.0/composer.phar --output composer.phar && php composer.phar i" 
```

## Test
```bash
docker run --rm -v $PWD:/src -w /src php:7.3 bash -c "php composer.phar run test"
```

## Run
```bash
docker run --rm -it -v $PWD:/src -w /src php:7.3 bash -c "chmod +x ./cli && ./cli calculate-salary"
```
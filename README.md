# Delio App

A prototype app, following https://github.com/deliowales/php-technical-test

It allows a user to compare the current price of 10 AAPL and 10 MSFT shares with their previous day's closing price.

## Description ##

There are two [routes](#endpoints), one to populate the quote data from the api, and one to retrieve a summary for collection of shares.

To allow a summary to be generated, I have modelled out a portfolio for a user, which can be seeded to allow the scenario to run against the get endpoint.

The API Service is abstracted to allow a different endpoint, or http client to be used. 

As is usual, there is much more that could be done, and improvements made to the way some aspects are written. See [Limitations](#limitations-further-work) at the end of the readme.

The way the data is populated and stored may mean that the data is not current when the user returns their quote. There may also not be data yet for the day the quote is requested for. For this, I tried to follow the requirements, but there is potential to request the data from the api when the quote request is made, if the data is not present, or stale. 

As such, I just return the last retrieved quote, if present.

## Endpoints ##

 1. PUT quote/{symbol}

Retrieve and Store the Quote Data from the Third Party API

```
curl -v -X PUT quote/AAPL
```

Response 201: Created

 2. GET: /portfolio/{portfolio_id}/quote

Retrieve a quote from the latest quote data for a portfolio

 * 200 Response / json

```
[
   {
      "symbol":"AAPL",
      "current_value":"1,653.30",
      "closing_price_value":"1,650.20",
      "changed_in_value":"3.10"
   },
   {  
      "symbol":"MSFT",
      "current_value":"2,817.70",
      "closing_price_value":"2,857.60",
      "changed_in_value":"-39.90"
   }
]
```

## Local Installation with Docker ##

1. Build and tag the docker images
   * docker compose build
   * **Note**: On first run, this will pull down the initial images required

2. Start the docker containers
   * docker compose up

3. Install package dependencies
   * docker compose exec delio-app-php-fpm composer install

4. Configure site
   * cp .env.docker .env
   * Add Finhubb API key to .env
     * https://finnhub.io/docs/api/introduction
   * docker compose exec delio-app-php-fpm php artisan key:generate
   * Add the following line to /etc/hosts, to create an alias to the site:
       * `127.0.0.1        delio.app`

5. Create Database
   * docker compose exec delio-app-php-fpm php artisan migrate:install
   * docker compose exec delio-app-php-fpm php artisan migrate
   * docker compose exec delio-app-php-fpm php artisan db:seed

**Notes**
 - Uses PHP v8, Laravel 9 and MySQL v8

## Running Locally ##

1. Start the docker containers (detached, so run in the background)
   * docker compose up -d

2. View the docker logs 
   * docker compose logs -f

4. Using the containers
   * The code can be edited in an ide, the directory is mapped into the php and nginx directories
     * http://delio.app:8881
   * Run the php unit tests
      * docker compose exec delio-app-php-fpm php artisan test
   * Access the db via cli
      * docker compose exec delio-app-mysql mysql -u delio_usr -pdelio_pw delio_dev
      * The db volume is mapped to ./docker/volumes/mysql so it persists
   * Interacting with artisan
     * docker compose exec delio-app-php-fpm php artisan {command here}
   * Using Terminal within Container
     * docker exec -ti {container-name} /bin/sh   

4. Stop the running containers
   * docker compose down --remove-orphans

## Limitations Further Work ##
 
 * The [finnhub package](https://github.com/Finnhub-Stock-API/finnhub-php) is not compatible with guzzle ^6 which is standard for laravel 9.
   * Rather than unpick, I chose to use the endpoint using guzzle.
 * There is little in the way of exception handling for the api not being available, or no quote for a supplied symbol. 
 * The timestamps for the quote may be improved to use the time returned from the API.
 * The populate route is limited to the symbols in the spec, to allow for minimal validation.
 * In time, I would create an openspec document for the API.
 * Normalize the Quote Model fields for repeated daily requests.
 * While I made the store a PUT request, this may be better as a command.
 * The response summary object could be improved.
 * More tests...

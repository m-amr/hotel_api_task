# Hotel API (PHP 7.1 and Symfony Framework)

## How do I get set up?

* Run `docker-compose up --build` to create docker container.
* Open this url in the browser http://your-docker-machine-ip:8080/web/app_dev.php/api/v1/hotels
* Run `docker exec -it hotelapitask_php_apache_1  vendor/bin/phpunit` to run unit tests.

## Architecture

* `HotelAPI` is resposible for fetching hotels data and return an array of `Hotel` objects. It is an implementation of `template method design pattern` https://en.wikipedia.org/wiki/Template_method_pattern where `AbstractHotelAPI` have `fetchData` template method and  `HotelAPI` extends it and implements these methods `getAPIURL` and `convertJSONToObject` which are called in the `fetchData` so if whole API change all we need to do is to implements these methods `getAPIURL` and `convertJSONToObject`.

* `HotelService` is resposible for retrieving hotel data and filter it by `name`, `price`, `city` and `availability` and also sort the the data by `name` or `price`.

## API documenation

*  http://your-docker-machine-ip:8080/web/app_dev.php/api/v1/hotels will return all the available.

* Only `name`, `city`, `price_from`, `price_to`, `available_from`, `available_to` and `sort_by` options are valid to be provided in the URL query if anything else is provided the API will return error JSON

```javascript
{
  isSuccess: false,
  errorMessage: "ERROR: This form should not contain extra fields. ",
  data: [ ]
}
```

* Filter by `name` http://your-docker-machine-ip:8080/web/app_dev.php/api/v1/hotels?name=Rotana%20Hotel will return Rotana Hotel
* Filter by `city` http://your-docker-machine-ip:8080/web/app_dev.php/api/v1/hotels?city=dubai will return Media One Hotel
* Filter by `price` range using `price_from` and `price_to`
http://your-docker-machine-ip:8080/web/app_dev.php/api/v1/hotels?price_from=80&price_to=90 will return hotels in this range
please not the you must provide both of `price_from` and `price_to` if one of them is missing the API will return this JSON

```javascript
{
  isSuccess: false,
  errorMessage: "price_from: ERROR: price_from is missing. ",
  data: [ ]
}
```

Also if `price_from` is greater then or equal `price_to` the API will return this JSON

```javascript
{
  isSuccess: false,
  errorMessage: "price_from: ERROR: price_from must be less than price_to ",
  data: [ ]
}
```

Also if `price` is not a number the API will return this JSON
```javascript
{
  isSuccess: false,
  errorMessage: "price_to: ERROR: This value should be of type numeric. ",
  data: [ ]
}
```

* Filter by availability range using `available_from` and `available_to` date must be supplied in the following format d-m-Y for example 1-3-2018.http://your-docker-machine-ip:8080/web/app_dev.php/api/v1/hotels?available_from=10-10-2020&available_to=20-10-2020

As the `price` range the `availability` range  must be provide both of `available_from` and `available_to`
The API will vaildate the data and will return error JSON if one of them is not found or if data format is wrong or if `available_from` is later than `available_to`

* Sorting by `name` or `price` by providing `sort_by=name` or  `sort_by=price`
http://your-docker-machine-ip:8080/web/app_dev.php/api/v1/hotels?sort_by=name and
http://your-docker-machine-ip:8080/web/app_dev.php/api/v1/hotels?sort_by=price

Only available options to sort_by are `price` and `name` if anything else is provided it will return this error JSON
```javascript
{
  isSuccess: false,
  errorMessage: "sort_by: ERROR: Only name and price are valid for sort_by ",
  data: [ ]
}
```


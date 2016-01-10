#Install

    cd RespApify
    composer install



## Run:

    php -S localhost:8080 -t ./src/public/

## Visit:

    http://localhost:8080/api/v1/table?match[name][]=john&match[email][]=any@email.com&order[name]=ASC&page=2

## RoadMap:

    - in SourceSimpleAll return data from connection insted of SQL

## How work?

- Middleware ParseQuery try find especific interpreter for the "table"
    - default use Interpreter\SimpleQuery
    - all interpreter should be return a query where "repository/source" can call
- After interpreter make a query, app pass to next middleware, until run the route.
- The route call 'middleware RetrieveData':
    - first "retrieveData" try find aproprieate "repository/source" for the "table"
        - default source is "repository\SourceSimpleAll"
        - source is call and retrieve data using query interpreted
- after source return data and assign response, all middleware will be reactivated to process the data received
    - you can create a middleware where remove sensiveData, or save on cache....


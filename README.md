#Install
    git clone https://github.com/stvkoch/RepApify.git
    cd RespApify
    composer install



## Run:

    php -S localhost:8080 -t ./src/public/

## Visit:

http://localhost:8080/api/v1/data/customers?like[name]=mare&or_like[name]=j&left[addresses]&fields=customers.*,addresses.address

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



--
-- File generated with SQLiteStudio v3.0.1 on Mon Jan 18 00:33:40 2016
--
-- Text encoding used: UTF-8
--
PRAGMA foreign_keys = off;
BEGIN TRANSACTION;

-- Table: addresses
CREATE TABLE addresses (idCustomer INTEGER REFERENCES customers (idCustomer) ON DELETE CASCADE, address VARCHAR (255), email VARCHAR (255))
INSERT INTO addresses (idCustomer, address, email) VALUES (1, 'rua X', 'testeete');

-- Table: customers
CREATE TABLE customers (idCustomer INTEGER PRIMARY KEY, name VARCHAR (255) NOT NULL, email VARCHAR (255) NOT NULL)
INSERT INTO customers (idCustomer, name, email) VALUES (1, 'Mare Willins', 'marewilli@mail.com');
INSERT INTO customers (idCustomer, name, email) VALUES (2, 'John Wets', 'johnwtes@mail.com');
INSERT INTO customers (idCustomer, name, email) VALUES (3, 'Marc Leoye', 'marc@mail.com');

COMMIT TRANSACTION;


Install

cd RespApify
composer install



Run:

php -S localhost:8080 -t ./src/public/

Visit:
http://localhost:8080/api/v1/table?match[name][]=john&match[email][]=any@email.com&order[name]=ASC&page=2

RoadMap:
    - in SourceSimpleAll return data from connection insted of SQL


# ReactPHP Routes with RedbeanPHP Restful Server
Rest server in ReactPHP with RedbeanPHP ORM and React Restify.<br>
Special thanks for RedBeanPHP to create a dinamic tables and fields to us.

## Thanks goes to...
ReactPHP (https://reactphp.org)<br>
RedBeanPHP (https://redbeanphp.com)<br>
ReactRestify (https://github.com/CapMousse/React-Restify/)

### How to use
You can use HHVM ou PHP7.1+ CLI to start this server like described below

- hhvm -f Server.php opt=value opt1=value1 opt2=value2...

*or*

- php -f Server.php opt=value opt1=value1 opt2=value2...

### Options to start this server
- timezone<br>
	Set a timezone application for database specs<br>
    *timezone=America/Sao_Paulo*
- environment<br>
	Needs to treat PHP Errors<br>
    *environment=[development / testing / production]*	
- sign<br>
	Set the name to your server<br>
    *sign=PauloSouza.Server*
- host<br>
	Set IP address to run this server<br>
    *host=0.0.0.1*
- port<br>
	Set port to run this server<br>
    *port=3000*
- cors<br>
	Set CORS domain to access this server<br>
    *cors=https://paulosouza.info*
- dsn<br>
	Set DSN to your database. If don't set this, the server create a SQLite database to you.<br>
    *dsn=mysql:host=127.0.0.1:3306\\\;dbname=test*
- user<br>
	Set the user can access your database<br>
    *user=root*
- pass<br>
	Set the user password to your database<br>
    *pass=123456*
- freeze<br>
	If set like TRUE, this server preserves your schemas and cannot create a new tables or change schemas anymore<br>
    *freeze=true*
- preserve<br>
	Preserve specific tables to schema changes<br>
    *preserve=user,products,payments*

### HTTP methods and Routes
*Preflight for browsers applications*
- OPTIONS /*

*Inspect tables and schemas*
- GET /database/tables
- GET /database/table/{collection}

*Execute queries directly*
- GET /query/any
- GET /query/exec
- GET /query/row
- GET /query/col
- GET /query/cell

*CRUD*
- GET /{collection}/{id}
- GET /{collection}
- POST /{collection}
- PUT /{collection}/{id}
- DELETE /{collection}/{id}
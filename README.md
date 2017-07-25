#  MySQL Handler For Monolog
Monolog handler to log in mysql ldatabase

##### How to install
Use below code to install via composer

```
composer require bhavik/monolog-mysql
```

##### How to use

First create monolog logger instance as you always do
```
$log = new Monolog\Logger('channel_name');
```

Create instance of handler as shown below

```
$handler = new MonologHandler\MySQLHandler($db, 'logs');
```
Where $db can be instance of any of these 
  * PDO
  * MySQLi
  * Doctrine DBAL

Now push handler with the help of logger instance.

```
$log->pushHandler($handler);
```

##### Last Point
Use Logger as you always do.

# Instructions -- TODO

## Prerequisites

You need to install the following:
* Mysql
* Apache
* PHP


## Initalise database
Set up mysql account
```
CREATE USER 'new_username'@'localhost' IDENTIFIED BY 'new_password';
GRANT ALL PRIVILEGES ON your_database_name.* TO 'new_username'@'localhost';
FLUSH PRIVILEGES;
```

Use the following command to setup database with sample data.
```
mysql -u mysql -p < db_init.sql
```


### Exercise 2
The script for exercise2 can be runned like this
```
php exercises/exercise2.php
```

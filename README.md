# Instructions 

## Prerequisites

You need to install the following:
* Mysql
* Apache
* PHP


## Initalise database
Set up mysql account
```
CREATE USER 'mysql'@'localhost' IDENTIFIED BY 'new_password';

GRANT ALL PRIVILEGES ON hospital.* TO 'mysql'@'localhost';

FLUSH PRIVILEGES;
```

### Exercise 1

Use the following command to setup database with sample data.
```
mysql -u mysql -p < db_init.sql
```


### Exercise 2
The script for exercise2 can be runned like this
```
php exercises/exercise2.php
```

### Exercise 3
The script for exercise3 can be runned like this
```
php exercises/exercise3.php

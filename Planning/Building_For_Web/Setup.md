To install the required software on a Debian based system, run
```bash
sudo apt-get install mysql-server apache2
```

To setup the user for the database:

Run

```bash
sudo systemctl start mysql
mysql -u root
```

To start and login to mysql

```bash
Welcome to the MariaDB monitor.  Commands end with ; or \g.
Your MariaDB connection id is 13
Server version: 10.11.4-MariaDB-1 Debian 12

Copyright (c) 2000, 2018, Oracle, MariaDB Corporation Ab and others.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

MariaDB [(none)]> CREATE USER 'www-data'@'localhost' IDENTIFIED BY '<INSERT_PASSWORD>'

```

Then make add the credentials to `config.php`.

Once setup, login again as root and import the database config by running
```bash
mysql -u root -p < /path/to/rentmybike.sql
```

Then login again, and grant the www-data user the required privileges over the database.
```bash
MariaDB [rentmybike]> GRANT ALL PRIVILEGES ON rentmybike.* TO 'www-data'@'localhost' WITH GRANT OPTION;
Query OK, 0 rows affected (0.010 sec)

MariaDB [rentmybike]> FLUSH PRIVILEGES;
Query OK, 0 rows affected (0.001 sec)

```
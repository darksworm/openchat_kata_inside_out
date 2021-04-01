CREATE DATABASE IF NOT EXISTS openchat;
CREATE DATABASE IF NOT EXISTS openchat_test;

CREATE USER 'foo'@'%' IDENTIFIED WITH mysql_native_password BY 'bar';
GRANT ALL ON *.* to foo@'%' WITH GRANT OPTION;

FLUSH PRIVILEGES;
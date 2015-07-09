# Online ordering

## Install
- composer install
- copy `misc/ordering.conf` to your apache configuration and change it according to your server set up
- create a database called `ordering` accessible by user `ordering` password `ordering` or choose better credentials and change the file `app/config.php`
- import the db dump you can find in `misc/db.sql`

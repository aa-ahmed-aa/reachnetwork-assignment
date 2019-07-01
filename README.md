### Technologies
Mongodb - File(I/O)Caching - mongodb driver for php

##### Take care
-install `php-mongodb` using `sudo apt-get install php-mongodb`<br>
-for mongo configuration in .env file do not forget to set the port to your local mongodb port(Default:27017) also by default username and password are empty<br>
-to reset the weekly and monthly count i used task scheduler so you need to add this line to your cron job`* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`<br>


#### Capturing Response Time
```
/users
    before using cache & chuncing data: 8 to 9 seconds
    after : 156 Millesecond
    
```

#### Helper commands
`php artisan migrate:fresh --seed` => seeding the database with 50k users and 1M visit/user
`composer install` => to install the required packages

Reachnetwork Backend Web Development Assignment 
===========================
Start by forking this repo, solving the descriped below problem and pass the tests.

Open a PR against the original reachnetworkco/reachnetwork-assignment repo when you're finished.


## Description
Write a simple program that has implementations for user analytics service that record a new visit/view for each api call.
create 2 APIs for view all users and getting user details.
* /api/v1/users         getting 15 users per page ordered by user weekly visits and record new view for each user.
* /api/v1/users/{id}    getting user by id and record new visit for this user.

#### Feature Test
* make sure to that your code pass tests in UserTest.php

#### Performance test
* seed the database tables with 50K users and 1M views and benchmark the 2 APIs average response time.



#####Take care
-install php-mongodb using `sudo apt-get install php-mongodb`<br>
-for mongo configuration in .env file do not forget to set the port to your local mongodb port(Default:27017) also by default username and password are empty<br>
-to reset the weekly and monthly count i used task scheduler so you need to add this line to your cron job`* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`<br>

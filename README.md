THIS IS THE BACK-END OF A BLOG CREATED WITH ANGULAR AND LARAVEL. HERE YOU CAN CLONE THE LARAVEL PROJECT

YOU CAN SEE THE PROJECT ONLINE AT http://webnub.org/

1. CLONE THE PROJECT
2. CREATE A  MYSQL DDBB
3. MIGRATE DE TABLES - php artisan migrate
4. SEED - php artisan db:seed
5. GO TO https://github.com/ivanmingot/blog-angular TO CLONE THE FRONT-END

You can do some test. To do this is better to create a new DDBB for testing.

This application will automatically import posts from a REST-API every minute. Has been created a cron job in "App / Console / Commands / autoLoad.php"
To get it going you can do 'php artisan schedule:run' for just one run, or you can do 'php artisan schedule:work'  to be constantly running while you have the console operating.
To do it without the console you must create a cron jon locally or on your server



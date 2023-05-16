
# REST Api Demo

This is a REST API Demo using Laravel 10


## Documentation

To set up the project you need docker to be installed and running on your system 

1) Clone the repo and cd into the created directory.
2) Run "composer install"
3) Once its done, to bring up the containers run "./vendor/bin/sail up -d"
4) The next step is to run the setup command "/vendor/bin/sail artisan setup" which will do the following: 
- Creare a laravel app key if one doesnt exist
- Run migrations, 
- Create sample data, i.e post, post categories and demo users 
- Create a demo user 
- Generate a sanctum API token. 
5) You can now connect using postman to test the API. 




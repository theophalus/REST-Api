
# REST Api Demo

This is a REST API Demo using Laravel 10


## Documentation

To set up the project you need docker to be installed and running on your system 

1) Clone the repo and cd into the created directory.
2) Run "composer install"
3) Once its done, to bring up the containers run "./vendor/bin/sail up -d"
4) Generate a Laravel App key by running the following "./vendor/bin/sail artisan key:generate"
5) The next step is to run the setup command which will run migrations, create sample data, create a demo user and generate an API token. 
"/vendor/bin/sail artisan setup"
6) You can now connect using postman to test the API. 




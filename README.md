
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
5) You can now connect using postman to test the API. URL 127.0.0.1/api/ and Bearer Token that was generated during setup. 


## Endpoints

- GET /user: Retrieves the authenticated user.
- GET /posts: Retrieves all posts.
- GET /posts/{id}: Retrieves a specific post.
- POST /posts: Creates a new post.
- PUT /posts/{id}: Updates a specific post.
- DELETE /posts/{id}: Deletes a specific post.
- GET /comments: Retrieves all comments.
- GET /comments/{id}: Retrieves a specific comment.
- POST /comments: Creates a new comment.
- PUT /comments/{id}: Updates a specific comment.
- DELETE /comments/{id}: Deletes a specific comment.
- GET /categories: Retrieves all categories.
- GET /categories/{id}: Retrieves a specific category.
- POST /categories: Creates a new category.
- PUT /categories/{id}: Updates a specific category.
- DELETE /categories/{id}: Deletes a specific category.
- POST /login: Logs in a user using credentials that you entered.


## Aditional Information

1) Request and response made to the API will be logged using the Laravel logging system. You can check the logs in the storage/logs directory.
2) To run a test run the following command ./vendor/bin/sail artisan test


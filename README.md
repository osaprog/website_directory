## Set up

- After cloning the project

- Make sure to rename the .env.example to .env and set the database connection values.

#### Run the following
```console
composer install
```
- Spin up meilisearch search engine docker container (Import step before running migrate command)
```console
docker run -it --rm -p 7700:7700 getmeili/meilisearch
```

- Run migration, seeds, import Website model to search engine
```console
php artisan migrate
php artisan db:seed
```

- Import Model to Search Engine
```console
php artisan scout:import "App\Models\Website"
```
- Delete Model from Search Engine
```console
php artisan scout:flush "App\Models\Website"
```
- Index Model in Search Engine
```console
php artisan scout:index "App\Models\Website"
```

#### Testing
- create database testing_database;
- Run tests
```console
php artisan test
```

#### Run endpints in Postman

- import the postman collection from 

storage/app/postman/2024_06_21_231019_laravel_collection.json.postman_collection.json

- Access search without login

- To vote/unvote or submit a website login as a user using any email and the password 'password' 
generated by seeds and call vote/unvote post website endpoints with the genrated
bearer token in auth.

- To delete a website login as admin and use the bearer token in auth


# Backend Code Test for Shed Collective

## Installation

1. Clone the repo

`git clone git@github.com:nikita-fedorov/test-shed.git`

2. Grab dependencies

`composer install`

3. Create and setup the config file

`php -r "copy('.env.example', '.env');"`
`php artisan key:generate`

4. Create token for JWT authorization

`php artisan jwt:secret`

5. Configure the `.env` file to provide correct database connection variables

6. Run migrations

`php artisan migrate`

7. The API is ready

## Setting up tests

1. Create a separate testing .env file

`php -r "copy('.env.testing.example', '.env.testing');"`

2. Edit .env.testing to provide correct database connection variables. Here you'd better create a new database, specifically for testing needs.

3. Create a JWT token for testing enviroment

`php artisan jwt:secret --env=testing`

4. Run the test suite

`./vendor/bin/phpunit`

## Testing with Postman

1. Grab the Postman collection from

`test-shed.postman_collection.json`

2. Import the Collection, go to Edit->Variables tab and edit "base_url" to match the url where you deployed the app.

3. Run the Auth->Registration request. This will create a user and return JWT token.

4. Go to Edit->Variables and insert this token into "token" variable.

5. Make requests from Users folder
-   User Management Docs

1. Open terminal
2. Run `git clone https://github.com/karlebh/api-laravel.git`
3. cd into the application with `cd api-laravel`
4. Run `composer i`
5. Make sure you are have php and any sql client install, i'd suggest xampp or laragon
6. Open the sql client and create a database, say, `api_laravel`
7. Copy the database name to your .env file like so `DB_DATABASE=api_laravel`. Then the username and password can be left like so `DB_USERNAME=root`, `DB_PASSWORD=`.
8. Run `php artisan api:prepare`. This is an artisan command that prepares your app by running the migration, seeding the database and starting the server.

-   Test Runing

1. Run `php artisan test` to run the test.

```xml
<!-- <env name="DB_CONNECTION" value="sqlite"/> -->
<!-- <env name="DB_DATABASE" value=":memory:"/> -->
```

You can uncomment those two lines in `phpunit.xml` to run the test on an sqlite databse, different from the application's database.

-   API Routes

```json
[
    {
        "domain": null,
        "method": "POST",
        "uri": "api/login",
        "name": null,
        "action": "App\\Http\\Controllers\\Auth\\LoginUserController@store",
        "middleware": [
            "api",
            "App\\Http\\Middleware\\RedirectIfAuthenticated:api"
        ]
    },
    {
        "domain": null,
        "method": "POST",
        "uri": "api/logout",
        "name": null,
        "action": "App\\Http\\Controllers\\Auth\\LoginUserController@destroy",
        "middleware": ["api", "App\\Http\\Middleware\\Authenticate:api"]
    },
    {
        "domain": null,
        "method": "POST",
        "uri": "api/register",
        "name": null,
        "action": "App\\Http\\Controllers\\Auth\\RegisterUserController@store",
        "middleware": [
            "api",
            "App\\Http\\Middleware\\RedirectIfAuthenticated:api"
        ]
    },
    {
        "domain": null,
        "method": "GET|HEAD",
        "uri": "api/user",
        "name": "user.index",
        "action": "App\\Http\\Controllers\\UserController@index",
        "middleware": ["api", "App\\Http\\Middleware\\Authenticate:api"]
    },
    {
        "domain": null,
        "method": "POST",
        "uri": "api/user",
        "name": "user.store",
        "action": "App\\Http\\Controllers\\UserController@store",
        "middleware": ["api", "App\\Http\\Middleware\\Authenticate:api"]
    },
    {
        "domain": null,
        "method": "GET|HEAD",
        "uri": "api/user/{user}",
        "name": "user.show",
        "action": "App\\Http\\Controllers\\UserController@show",
        "middleware": ["api", "App\\Http\\Middleware\\Authenticate:api"]
    },
    {
        "domain": null,
        "method": "PUT|PATCH",
        "uri": "api/user/{user}",
        "name": "user.update",
        "action": "App\\Http\\Controllers\\UserController@update",
        "middleware": ["api", "App\\Http\\Middleware\\Authenticate:api"]
    },
    {
        "domain": null,
        "method": "DELETE",
        "uri": "api/user/{user}",
        "name": "user.destroy",
        "action": "App\\Http\\Controllers\\UserController@destroy",
        "middleware": ["api", "App\\Http\\Middleware\\Authenticate:api"]
    }
]
```

`\api\login` requires `email` and `password`. `\api\register` requires `name`, `password`, `email`, `password` and `password_confirmation`.
